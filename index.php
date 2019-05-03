<?php

session_start();


/**
 * 预定义 数据库连接的 基本信息
 */
define('DB_HOST', 'localhost');
define('DB_NAME', 'zhongw_test');
define('DB_USER', "root");
define('DB_PASS', "root");
define('DB_PORT', '');

define('CUSTOMER', '0439B34CF50E0CEE9C884D90E407A2DA');
define('KEY', 'jGKCrWOG1586');

// 60s*60min*24h , 每个包裹需要间隔24小时才再次调用API 查询信息
define('TIME_LIMIT', 86400);

/*
* 定义结束状态的判定
* 包括0在途中、1已揽收、2疑难、3已签收、4退签、5同城派送中、6退回、7转单等7个状态
*/
$finishStatus = array(1, 3, 4, 7);

#######
## API 调用
########
/**
 * @param string $company 快递公司名称代码
 * 
 * @param Stirng $cnPacketId  快递公司单号
 */

function getDataFromKuaidi100($company, $cnPacketId){
    $key = KEY;
    $customer = CUSTOMER;


    $param = array (
		'com' => $company,			//快递公司编码
		'num' => $cnPacketId,	//快递单号
		'phone' => '',				//手机号
		'from' => '',				//出发地城市
		'to' => '',					//目的地城市
		'resultv2' => '1'			//开启行政区域解析
	);
	
	//请求参数
    $post_data = array();
    $post_data["customer"] = $customer;
    $post_data["param"] = json_encode($param);
    $sign = md5($post_data["param"].$key.$post_data["customer"]);
    $post_data["sign"] = strtoupper($sign);
	
    $url = 'http://poll.kuaidi100.com/poll/query.do';	//实时查询请求地址
    
	$params = "";
    foreach ($post_data as $k=>$v) {
        $params .= "$k=".urlencode($v)."&";		//默认UTF-8编码格式
    }
    $post_data = substr($params, 0, -1);
    //echo '请求参数<br/>'.$post_data;
	
	//发送post请求
    $ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	$data = str_replace("\"", '"', $result );
    return $data = json_decode($data);
}

/**
 * @return json 返回测试函数测试
 */
function getTestData($cnPacketId){

    $json_string = file_get_contents('kuaidi100.json'); 
    //$data = json_decode($json_string, true);  
    //return array
    return $json_string;
}

/**
 * @param String $cnPacketId 根据单号返回多个相似度高的公司名称，但是不能保证准确
 * 暂时没有使用借口
 */

function getTestCom($cnPacketId){
    return "yuantong";
}


########
##API 结束
#####

/**
 * 数据库连接
 */
$connect= mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (mysqli_connect_errno()){
	printf("connection to database error with : %s\n", mysqli_connect_error());
	exit();
}

$htmlOfHeader='
<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    <div align="center">
        <a href="?seite=home">订单情况查看</a>
        <a href="?seite=input">添加新物流订单</a>
    </div>
    <br>
    <br>
    <hr>
    <br>
';

$htmlOfInput = '
    <div class="input-form" align="center"> 
        <form action="" method="POST">
            <div>
                <label for="logis_num"> 选择订单种类</label>
                <input type="radio" name="logis_num" value="logis_one" checked>单件快发
                <input type="radio" name="logis_num" value="logis_more">等件齐发
            </div>

            <div>
                <label for="cn_log_id_1"> 国内订单号 1</label>
                <input type="text" name="cn_packet_id[]" required>                
            </div>
            <div>
                <label for="cn_log_id_2"> 国内订单号 2</label>
                <input type="text" name="cn_packet_id[]" required>                
            </div>
            <br>
            <div>
                <input type="submit" name="submit_booking" value="生成物流订单">
            </div>
                
        </form>
 
    </div>        
';

$htmlOfOutput = '
    <div class="output-form" align="center"> 
        <form action="" method="POST">
            <div>
                <label for="goods_id"> goods_id </label>
                <input type="text" name="goods_id" required>                
            </div>
            <br>
            <div>
                <input type="submit" name="submit_search" value="查询">
            </div>
                
        </form>
 
    </div>        
';

$htmlOfFooter ='
</body>
</html>            
';


########################### 
###  数据库操作----开始
###########
/**
 * zw_test_logis_cn表
 *
 * @param int $goodsID, 物流订单
 * 
 * @param String $cnPacketId, 国内包裹单号
 * 
 * @param json $cnLog, 取过来的数据直接以JSON格式存在表中
 * 
 * @param timestamp $cnTime
 * 
 * @param int $cnStatus，状态码，目前暂时以 0 ， 为开始， 1 为结束
 * 
 * @param String $cnCompany 公司代码
 */
function insertToCn($goodsId, $cnPacketId, $cnLog,  $cnStatus, $cnCompany ){

    global $connect;

    $sql = "INSERT INTO zws_test_logis_cn (goods_id, cn_packet_id, cn_log, cn_status, cn_company)
            VALUES ('$goodsId', '$cnPacketId', '$cnLog', '$cnStatus', '$cnCompany')
            ";

    mysqli_query($connect, $sql);

    if($connect->errno){
        echo $connect->error;
        die();
    }
    echo "insert ok";
}

/**
 * zws_test_logis_cn 根据goods id 查询获得全部相关数据
 * 
 * @param int $goodsId  物流商品号
 * 
 * @return Array 返回带有key 的数组，包含全部信息
 */
function getAllByGoodsid($goodsId){
    global $connect;
    $sql = "SELECT * FROM zws_test_logis_cn WHERE goods_id = '$goodsId'";

    $result= mysqli_query($connect, $sql);
    $data = mysqli_fetch_all($result,  MYSQLI_ASSOC);
    return $data;
}

/**
 * zw_test_logis_cn表
 * @param String $cnPacketId 国内包裹号
 * 
 * @param String $cnLog JSON数据
 * 
 * @param int $cnStatus ， 1代表结束， 0 代表未结束
 */
function updateByPacketid($cnPacketId, $cnLog, $cnStatus){

    global $connect;
    $sql = "UPDATE zws_test_logis_cn 
    SET cn_log ='$cnLog', cn_status = '$cnStatus'
    WHERE cn_packet_id = $cnPacketId
    ";
    mysqli_query($connect, $sql);
}


 // order_id, goods_id 不清楚，只能自己随机产生，两个理论上是等同的
 function getOrderId(){
    return str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
}

function getGoodsId(){
    return getOrderId();
}



########################### 
###  数据库操作----结束
###########



/**
 * 给页面一个缺省值， 5.3版本只能使用 if
 */
//$seite = $_GET['seite'] ?? "home";
if(isset($_GET['seite'])){
    $seite = $_GET['seite'];
}else{
    $seite = "home";;
}

echo $htmlOfHeader;

switch($seite){
    case "home":
        echo "65265";
        echo $htmlOfOutput;
        
        if(isset($_POST["submit_search"])){
           // var_dump($_POST);
            $goodsId = $_POST["goods_id"];

            //获得现在的信息
            $datas = getAllByGoodsid($goodsId);
            $currentTime = time();

            //根据状态位，和时间决定，是不是调用 API，如果不需要调用，就返回现有数据，
            // 如果需要，就调用调用api 返回数据，
            // 返回数据后，进行比较，看看是不是一样，如果不一样就新数据 覆盖旧数据
            //如果数据一样，那么查看是不是 时间 已经超过24小时，如果是， 将时间戳
            foreach($datas as $data){
                //var_dump($data);
                $cnTime = strtotime($data["cn_time"]);

                if(($data["cn_status"] == 0) && ($currentTime - $cnTime > TIME_LIMIT)) {
                    
                    //目前取测试数据， 真实应该使用下面取 API接口数据
                    $json_string= getTestData($cnPacketId);
                    //$json_string= getDataFromKuaidi100($company, $cnPacketId)
             
                    //JSON md5 比较，不等，表示有变化， 新数据 update 到表中
                    //否则，什么都不做
                    if(md5($json_string) != md5($data["cn_log"])){
                        $data["cn_log"]= $json_string;

                        $newStatus = json_decode($json_string, true)["state"]; 
                        if(in_array($newStatus, $finishStatus)){
                            $newStatus= 1;
                        }else{
                            $newStatus= 0;
                        }

                        updateByPacketid($data["cn_packet_id"], $json_string, $newStatus);
                    }
                }

                //拼接 HTML 数据
                $cnPackId= $data["cn_packet_id"];
    
                $out .= " <div>
                            <h3>" .$cnPackId."</h3> 
                        <ul> " ;
                
                $cnPackInfos = json_decode($data["cn_log"], true)["data"];
                
                foreach($cnPackInfos as $cnPackInfo){
                    //var_dump($cnPackInfo);
                    $out .= "<li>".$cnPackInfo["time"]." ".$cnPackInfo["context"]."</li>";
                }
                $out .="</ul> </div>";
            }
            //输入 out, 这里也可以输入 html string 到 一个指定地方
            echo $out;
            
        }
        break;

    case "input":
        echo $htmlOfInput;

        if(isset($_POST["submit_booking"])){
            if($_POST["logis_num"] == "logis_one"){
                // 客人选择单件到就发的状况，考虑到是货到欧洲后才向客人收钱
                // 那么这里处理的方式是，为每个国内订单 生成一个欧洲订单，有多个欧洲订单
                //var_dump($_POST);
                foreach($_POST["cn_packet_id"] as $cnPacketId){

                    /**
                     * 这里都是测试数据，真实数据 goodsid 从ecshop里面获得， 
                     * JSON 和公司名 数据从快递100 获得
                     */
                    $orderId = getOrderId();
                    $goodsId = getGoodsId();
                    $cnLog = getTestData($cnPacketId);
                    $cnCompany = getTestCom($cnPacketId);
                    //var_dump($cnLog);
                
                    $cnStatus = 0;
                    insertToCn($goodsId, $cnPacketId, $cnLog, $cnStatus, $cnCompany);
                            
                }
            }elseif($_POST["logis_num"] == "logis_more"){
                //如果客人选择到齐后再发货，那么就是所有商品生成一个欧洲订单
                //只有一个欧洲订单
                $orderId = getOrderId();
                $goodsId = getGoodsId();

                foreach($_POST["cn_packet_id"] as $cnPacketId){
                    $cnLog = getTestData($cnPacketId);
                    $cnCompany = getTestCom($cnPacketId);

                    $cnStatus = 0;
                    insertToCn($goodsId, $cnPacketId, $cnLog, $cnStatus, $cnCompany);
                }
            }
        }
        break;
}


echo $htmlOfFooter;
/**
 * 关闭数据连接
 */

mysqli_close($connect);


