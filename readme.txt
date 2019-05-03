zws_test_order_logistics 表结构:
+-----------+-----------------------+------+-----+---------+----------------+
| Field     | Type                  | Null | Key | Default | Extra          |
+-----------+-----------------------+------+-----+---------+----------------+
| id        | mediumint(8) unsigned | NO   | PRI | NULL    | auto_increment |
| order_id  | mediumint(8) unsigned | NO   | MUL | 0       |                |
| goods_id  | mediumint(8) unsigned | NO   | MUL | 0       |                |
| cn_log    | text                  | NO   |     | NULL    |                |
| inter_log | text                  | NO   |     | NULL    |                |
| de_log    | text                  | NO   |     | NULL    |                |
+-----------+-----------------------+------+-----+---------+----------------+

----
逻辑操作
----
(1) 根据 包裹id 从 快递100 上取json 数据
getKuaidi100ByPacketID($cnPacketId)

(2) 根据goods id 物流商品，获得全部 JSON （是不是考虑直接获得 html 数据）
getTotalCnlog($goodsId)

(3) 这个功能就是将 一个 goods id 下的 所有的 包裹id 的JSON数据 连接，并输出成一个html sting ， 存放在 cnLog 一个 
（因为目前不清楚， 国际和德国境内段的 数据是什么格式，暂时这样操作）
outputToHtml($jsonString)

(4) 比较两个 json 数据， 判断是否发生变化， 这里加入了 update table 操作
可以考虑剥离
compareJsonKuaidi100($json_string, $cn_log)

(5) JSON 数据进行分解？ 必要否？
parseJsonKuaidi100($json_string)

(6) 根据goods id 获得 存好的 全部html？？
getCnlogByGoodsid($goods_id)

--------
数据库操作
--------
(8) zw_test_logis_cn 表中查询，该订单下的全部国内包裹 对应关系
getCnpacketidByGoodsid($goods_id)

(9) zw_test_logis_cn， 建立订单 和国内包裹号 的 对应关系
insertToLogisCn($goodsId, $cnPacketId)

(10) zws_test_order_logis表， 几乎跟原有的 zws_test_order_logisitics一模一样
区别只是 将order-id, good-id 暂时按照字符形式记录

insertToOrderLogis($orderId, $goodsId)




(7) zw_test_logis_cn_blog表， 判断 包裹状态，主要是 完成状态无须 调用API
（个人觉得，还是需要加上一个调用时间，这样可以避免在短的时间内频繁调用，比如一天就调用一次）
getStatusByPacketId($packet_id)

(11) zws_test_logis_cn_log 查询，根据包裹号 获得对应 JSON 数据
getCnlogByCnpacketid($cnPacketId)

(12) zws_test_logis_cn_log 插入
将查询的数据存储到 包裹日志 表 （还有两个属性需要加入，一个是上次查询时间，一个是状态）

 insertToCnLog($cnPacketId, $cnLog)

(13) zws_test_logis_cn_log 更新操作

updateCnlog($cnPacketId, $cnLog)


--------------------------
(14)showInputStart()
