<?php
class order
{
    private $db;
    private $user;
    private $buy;
    private $db_name = 'u9933109';
    public function __construct()
    {
        $this->db = new db();
        $this->db->create_connection();
        $this->user = new user();
        $this->buy = new buy();

    }
    public function get_order($orderid)
    {
        $sql = "SELECT * FROM `orderList` WHERE `order_id` = '{$orderid}'";
        $this->db->execute_sql($this->db_name,$sql);
        $result = $this->db->get_result();
        if($result) {
            return $result;
        }
        return null;
    }
    public function orderListByUser($userid)
    {
        $sql = "SELECT * FROM `orderList` WHERE `user_id` = '{$userid}'";
        $this->db->execute_sql($this->db_name,$sql);
        return $this->db->get_result_array();
    }
    public function orderListByBuy($buyid)
    {
        $sql = "SELECT * FROM `orderList` WHERE `buy_id` = '{$buyid}'";
        $this->db->execute_sql($this->db_name,$sql);
        return $this->db->get_result_array();
    }
    public function orderAdd($userid,$buyid,$num)
    {
        $userdata = $this->user->get_user($userid);
        $buydata = $this->buy->get_buy($buyid);
        if ($buydata['num'] < $num) {
            return "商品數量不足";
        }
        $price = $num * $buydata['price'];
        if ($userdata['money'] < $price) {
            return "餘額不足";
        }

        $sql = "INSERT INTO `orderList`(`user_id`,`buy_id`,`num`,`price`) VALUES ('{$userid}', '{$buyid}', '{$num}', '{$price}')";
        $this->db->execute_sql($this->db_name,$sql);
        //取得最後一筆insert的id
        $result = $this->get_order(mysql_insert_id());
        if ($result) {
            //更新商品數量
            $this->buy->buyModify($buyid, $buydata['buy_name'], $buydata['num']-$num, $buydata['context'], $buydata['price']);
            //更新會員金錢
            $this->user->userModify($userid, $userdata['user_name'], $userdata['password'], $userdata['money']-$price);
            return $result;
        }
    }
    public function orderModify($orderid,$num)
    {
        //訂單資料
        $orderdata = $this->get_order($orderid);
        //會員資料
        $userdata = $this->user->get_user($orderdata['user_id']);
        //商品資料
        $buydata = $this->buy->get_buy($orderdata['buy_id']);
        $price = $num * $buydata['price'];
        if ($buydata['num']+$orderdata['num'] < $num) {
            return "商品數量不足";
        }
        if ($userdata['money']+$orderdata['price'] < $price) {
            return "餘額不足";
        }
        $sql = "UPDATE `orderList` SET `num` = $num, `price` = '{$price}' WHERE `order_id` = '{$orderid}'";
        $this->db->execute_sql($this->db_name,$sql);
        $result = $this->get_order($orderid);
        if ($result) {
            //更新商品及會員資料
            $this->buy->buyModify($orderdata['buy_id'],$buydata['buy_name'],$buydata['num']+$orderdata['num']-$num,$buydata['context'],$buydata['price']);
            $this->user->userModify($orderdata['user_id'],$userdata['user_name'],$userdata['password'],$userdata['money']+$orderdata['price']-$price);
            return $result;
        }
    }
    public function orderDelete($orderid)
    {
        //訂單資料
        $orderdata = $this->get_order($orderid);
        //會員資料
        $userdata = $this->user->get_user($orderdata['user_id']);
        //商品資料
        $buydata = $this->buy->get_buy($orderdata['buy_id']);
        $sql = "DELETE FROM `orderList` WHERE `order_id` = '{$orderid}'";
        $this->db->execute_sql($this->db_name,$sql);
        $result = $this->get_order($orderid);
        if (empty($result)) {
            //更新商品及會員資料
            $this->buy->buyModify($orderdata['buy_id'],$buydata['buy_name'],$buydata['num']+$orderdata['num'],$buydata['context'],$buydata['price']);
            $this->user->userModify($orderdata['user_id'],$userdata['user_name'],$userdata['password'],$userdata['money']+$orderdata['price']);
            return "刪除訂單成功";
        }
    }
}

//$t = new order();
//$t->orderAdd('13', '3' ,'1');
//$test = $t->orderModify('1','2');
//$t->orderDelete('7');
//var_dump($test);
?>