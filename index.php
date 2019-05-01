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


/**
 * 数据库连接
 */
$connect= mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (mysqli_connect_errno()){
	printf("connection to database error with : %s\n", mysqli_connect_error());
	exit();
}

?>


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

<?php
################
##  页面控制 部分， 类似于 routes ---开始
################

/**
 * 给页面一个缺省值， 5.3版本只能使用 if
 */
//$seite = $_GET['seite'] ?? "home";
if(isset($_GET['seite'])){
    $seite = $_GET['seite'];
}else{
    $seite = "home";;
}

switch($seite){
    case "home":

        echo "home";
        
        break;
    case "input":
        if(isset($_POST["submit_booking"])){

            //var_dump($_POST);
            //die();

            if($_POST["logis_num"] == "logis_one"){

                // 客人选择单件到就发的状况，考虑到是货到欧洲后才向客人收钱
                // 那么这里处理的方式是，为每个国内订单 生成一个欧洲订单，有多个欧洲订单
                //var_dump($_POST)

                foreach($_POST["cn_packet_id"] as $cnPacketId){
                    $orderId = getOrderId();
                    $goodsId = getGoodsId();

                    insertToLogisCn($connect, $goodsId, $cnPacketId);

                    insertToOrderLogis($connect, $orderId, $goodsId);
                       
                }
                                        
            }elseif($_POST["logis_num"] == "logis_more"){
                //如果客人选择到齐后再发货，那么就是所有商品生成一个欧洲订单
                //只有一个欧洲订单
                $orderId = getOrderId();
                $goodsId = getGoodsId();

                foreach($_POST["cn_packet_id"] as $cnPacketId){
                 
                    insertToLogisCn($connect, $goodsId, $cnPacketId);
    
                }

                insertToOrderLogis($connect, $orderId, $goodsId);

            }else{
                ##redirect to 404
                echo "error ";
            }
        

        }else{
            showInputStart();
        }

       
       
        break;
}

################
##  页面控制 部分---结束
################


###############
###  子页面显示部分 ---开始
#################

// 输入国内订单号，并生成物流订单号的初始页面
function showInputStart(){
    $inputToHtml= '
    <br>
    <br>
    <hr>
    <br>
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
    echo $inputToHtml;
}

###############
###  子页面显示部分 ---结束
#################



##############
## 获得数据 和 逻辑判断操作---开始
#############
/**
 *  将cn各个包裹目前的log数据，显示全部相关信息，组成一个新的 log信息，
 *  然后将所有信息，生成一个HMTL 文件存在 主表里面的logo
 * 
 * 
 * @param String $goods_id
 * 
 * @return JSON 所有国内包裹单的data数组
 */
function getCnlogByGoodsid($goods_id){
    
    
    $packetid_arr  = getCnpacketidByGoodsid($goods_id);

    $info = array();
    for($i = 0; $i <count($packetid_arr);$i++){
        $cnPacketId = $packetid_arr[$i][0];

        //拿到test_logisc_cn_log 表里面的 国内单号的 json数据
        $json_string= getCnlogByCnpacketid($cnPacketId);

        $data = json_decode($json_string, true);  

        #####
        #没有测试， 这里也可以考虑直接就是 JSON 数据组合
        //数组合并，这里需要再测试一下，
        $info = array_merge($info, $data);
    }

    //返回一个数组的 JSON 形式数据，便于存储
    return json_encode($info);
}







/**
 * 取数据（快递100），目前看到的应该是一次API请求，只能返回一个包裹的数据
 * 这个方法
 * @param String $cnPacketId 国内订单号码
 * @param String ??货运公司的名称，是不是需要，不确定
 * @return Array 返回一个包裹的数据
 */
function getKuaidi100ByPacketID($cnPacketId){
   
    //模拟数据处理
    $json_string = file_get_contents('kuaidi100.json'); 
 
    //return array
    return $data;
}

/**
 * 将一个或者多个数组数据组成一个总的 数据返回
 * 
 * @param Array 单个包裹的数据
 * @return Array 所有包裹的数据
 */
function getCnlogByGoodsid($goodsId){

    //获得$goods_id 下对应的 所有包裹ID，针对所有ID 做操作
    $packetIdArr = getCnpacketidByGoodsid($goodsId);

    $data = array();

    //根据包裹ID 从kuaidi100取数据
    foreach($packetIdArr as $key =>$packetId){
        //根据包裹ID， 取出status（这个包裹是否状态结束，如果结束
        //就不从api 取数据了）从数据库中取数据
        $status = getStatusByPacketId($packetId);

        $cnPacketLog = getCnlogByCnpacketid($packetId);
        //目前设置 3 表示签收，可能情况，status 需要放到一个 array 里面
        //完成的状态可能有多种
        if($status != 3){
            //结束，不再从API 取数据， 
            $json_string = getKuaidi100ByPacketID($packetId);

            compareJsonKuaidi100($json_string, $cnPacketLog);
        }
    }
    
    //根据包裹ID， 从数据库中取数据
    //比较包裹ID数据是否有变动，如果有变动，就操作
        // 操作-1 update 数据（也许根本就不需要这一步，
        //还是需要存，如果客户很短时间内多次申请，最好是存
        //调用接口都是用钱的）

}

/**
 * @param Array JSON 数据结构数组，生成一个 HTML String
 * @return String 带有HMTL TAG 的String
 */

function outputToHtml($arr){

}


/**
 *  比较两个的md5 值，只比较，update方法放到别的地方去
 *  
 * @param JSON $json_string, 从快递100 取过来的，新的 JSON数据
 * 
 * @param JSON $cn_log, 旧的JSON
 * 
 * @return Boolean 
 * 
 */
function compareJsonKuaidi100($json_string, $cn_log){
    if(md5($json_string) !== md5($cn_log)){
        //updateCnlog($json_string);
        return false;
    }else {
        return true;
    }
}


/**
 * 获取 快递100 里面的数据，进行逻辑判断
 * @param JSON  
 * 
 */
function parseJsonKuaidi100($json_string){
    /*
    * state	快递单当前签收状态，包括0在途中、1已揽收、2疑难、3已签收、4退签、5同城派送中、6退回、7转单等7个状态
    */
    // 把JSON字符串强制转成PHP数组  
    $data = json_decode($json_string1, true);

}

// order_id, goods_id 不清楚，只能自己随机产生，两个理论上是等同的
function getOrderId(){
    mt_srand((double) microtime() * 1000000);
    return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
}

function getGoodsId(){
    return getOrderId();
}

function getCnParketId(){
    return 'g43434';
}
##############
## 获得数据 和 逻辑判断操作---结束
##############


########################### 
###  数据库操作----开始
###########

/**
 *  返回status的值，用于判断此项目是否结束，zw_test_logis_cn_blog
* @param mysqli_connect $connect
 * @param String $packet_id ，包裹号
 */
function getStatusByPacketId($packet_id){

    global $connect;
    $sql = "SELECT status FROM zws_test_logis_cn_log WHERE $packet_id = '$cn_packet_id'";

    $result= mysqli_query($connect, $sql);
    return  mysqli_fetch_row($result);
}


/**
 *  从zw_test_logis_cn 表中查询，该订单下的全部国内订单号
 * @param mysqli_connect $connect
 * @param String $goods_id, 暂时全部按照字符串存储，实际中可能是数字，
 * 需要时直接转换即可
 * 
 * @return Array 返回所有对应的 国内单号数组
 */
function getCnpacketidByGoodsid($goods_id){

    global $connect;

    $sql = "SELECT cn_packet_id FROM zws_test_logis_cn WHERE goods_id = '$goods_id'";

    $result= mysqli_query($connect, $sql);
    return  mysqli_fetch_all($result);
}



/**
 * test-logis-cn表 插入， 
 * 该表只有三个字段， id- 自动， cn_packet_id-国内包裹单号， goods_id--物流货品ID号
 * 
 * @param mysqli_connect $connect ， 数据库连接
 * 
 * @param String
 * 
 * @param String $cnPacketId, 国内包裹单号
 * 
 */
function insertToLogisCn($goodsId, $cnPacketId){

    global $connect;

    $sql = "INSERT INTO zws_test_logis_cn (goods_id, cn_packet_id)
            VALUES ('$goodsId', '$cnPacketId')
            ";

    mysqli_query($connect, $sql);

    if($connect->errno){
        echo $connect->error;
    }

}

/**
 *  zws_test_order_logis 表插入
 *  zws_test_order_logis表， 几乎跟原有的 zws_test_order_logisitics一模一样
 *  区别只是 将order-id, good-id 暂时按照字符形式记录
 */
function insertToOrderLogis($orderId, $goodsId){
    global $connect;

    $sql = "INSERT INTO zws_test_order_logis (order_id, goods_id)
             VALUES ('$orderId', '$goodsId')
                ";
    mysqli_query($connect, $sql);

}


/**
 * zws_test_logis_cn_log 查询
 * 这个表由于三个属性构成， id-自动数字； cn_packet_id- 字符串，国内包裹单号； cn_log 国内物流信息，数组根式
 * @param mysqli_connect $connect ， 数据库连接
 * 
 * @param String $cnPacketId, 国内包裹单号
 * 
 * @return Arrary 返回一个数据形式存储的，包裹物流log 记录
 * 
 */
function getCnlogByCnpacketid($cnPacketId){

    global $connect;
    $sql = "SELECT cn_log FROM zws_test_logis_cn_log WHERE cn_packet_id = '$cnPacketId'";

    $result= mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row["cn_log"];
}

/**
 * zws_test_logis_cn_log 插入
 * @param mysqli_connect $connect ， 数据库连接
 * 
 * @param String $cnPacketId, 国内包裹单号
 * 
 * @param Array $cnLog， 快递100的JESON 数据 数组转换后，物流信息的Data 部分
 * 
 */

function insertToCnLog($cnPacketId, $cnLog){

    global $connect;
    $sql = "INSERT INTO zws_test_logis_cn_log (cn_packet_id, cn_log)
    VALUES ('$cnPacketId', '$cnLog')
    ";

    mysqli_query($connect, $sql);

    if($connect->errno){
    echo $connect->error;
    }
}


/**
 * zws_test_logis_cn_log 更新操作
 * @param mysqli_connect $connect ， 数据库连接
 * 
 * @param String $cnPacketId, 国内包裹单号
 * 
 * @param Array $cnLog， 快递100的JESON 数据 数组转换后，物流信息的Data 部分发生变更，将新的写入log
 */
function updateCnlog($cnPacketId, $cnLog){

    global $connect;

    $sql = "UPDATE zws_test_logis_cn_log 
    SET cn_log ='$cnLog'
    WHERE cn_packet_id = $cnPacketId
    ";
    $connect->query($sql);
}


##########################
## 数据库操作---结束
#############
?>

    
</body>
</html>

<?php
/**
 * 关系 数据连接
 */

mysqli_close($connect);
?>