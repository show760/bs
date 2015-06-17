<?php
class buy
{
    private $db;
    private $db_name = 'u9933109';
    public function __construct()
    {
        $this->db = new db();
        $this->db->create_connection();
    }
    public function get_buy($buy_id)
    {
        $sql = "SELECT * FROM `buyList` WHERE `buy_id` = '{$buy_id}'";
        $this->db->execute_sql($this->db_name,$sql);
        $result = $this->db->get_result();
        if($result) {
            return $result;
        }
        return null;
    }
    public function buyList()
    {
        $sql = "SELECT * FROM `buyList`";
        $this->db->execute_sql($this->db_name,$sql);
        return $this->db->get_result_array();
    }
    public function buyAdd($buy,$num,$context,$price)
    {
        $check = $this->get_buy($buy);
        if($check) {
            return "商品重複";
        }
        $sql = "INSERT INTO `buyList`(`buy_name`, `num`, `context`, `price`) VALUES('{$buy}', '{$num}', '{$context}', '{$price}')";
        $this->db->execute_sql($this->db_name,$sql);
        //取得最後一筆insert的id
        $result = $this->get_buy(mysql_insert_id());
        if ($result) {
            return $result;
        }
        return false;
    }
    public function buyModify($buy_id,$buy,$num,$context,$price)
    {
        $check = $this->get_buy($buy_id);
        if(!$check) {
            return "查無商品";
        }
        $sql = "UPDATE `buyList` SET `num` = '{$num}',`context` = '{$context}',`price` = '{$price}' WHERE `buy_name` = '{$buy}'";
        $this->db->execute_sql($this->db_name,$sql);
        $result = $this->get_buy($buy_id);
        if ($result) {
            return $result;
        }
    }
    public function buyDelete($buy_id)
    {
        $check = $this->get_buy($buy_id);
        if(!$check){
            return "該商品不存在";
        }
        $sql = "DELETE FROM `buyList` WHERE `buy_id` = '{$buy_id}'";
        $this->db->execute_sql($this->db_name,$sql);
        $result = $this->get_buy($buy_id);
        if (empty($result)){
            return "刪除帳號成功";
        }
    }
}

//$test = new buy();
//$t = $test->buyAdd('戰鬥陀螺','10','超好玩戰鬥陀螺','100');
//var_dump($t);
//$all = $test->buyList();
//var_dump($all);
//$t = $test->buyModify($t['buy_id'],'戰鬥陀螺','20','超好玩','200');
//var_dump($t);
//$t = $test->buyDelete($t['buy_id']);
//var_dump($t);
?>