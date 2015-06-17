<?php
class user
{
    private $db;
    private $db_name = 'u9933109';
    public function __construct()
    {
        $this->db = new db();
        $this->db->create_connection();
    }
    public function get_user($user_id)
    {
        $sql = "SELECT * FROM `userList` WHERE `user_id` = '{$user_id}'";
        $this->db->execute_sql($this->db_name,$sql);
        $result = $this->db->get_result();
        if($result) {
            return $result;
        }
        return null;
    }
	public function getUserBYName($account)
    {
        $sql = "SELECT * FROM `userList` WHERE `user_name` = '{$account}'";
        $this->db->execute_sql($this->db_name,$sql);
        $result = $this->db->get_result();
        if($result) {
            return $result;
        }
        return null;
    }
    public function userList()
    {
        $sql = "SELECT * FROM `userList` WHERE `power` != '99' ";
        $this->db->execute_sql($this->db_name,$sql);
        return $this->db->get_result_array();
    }
    public function userAdd($account,$password,$repassword,$money = 0)
    {
        if ($password !== $repassword){
            return "密碼前後輸入不一致";
        }
        $checkaccount = $this->getUserBYName($account);
        if($checkaccount) {
            return "帳號重複";
        }
        $sql = "INSERT INTO `userList`(`user_name`, `password`, `power`, `money`) VALUES('{$account}', '{$password}', '1', '{$money}')";
        $this->db->execute_sql($this->db_name,$sql);
        //取得最後一筆insert的id
        $result = $this->get_user(mysql_insert_id());
        if ($result) {
            return $result;
        }
        return false;
    }
    public function userModify($user_id,$account,$password,$money = 0,$power = 0,$newpassword = 0,$renewpassword = 0)
    {
        $checkaccount = $this->get_user($user_id);
        if(!$checkaccount) {
            return "帳號錯誤";
        }
        if($checkaccount['password']!= $password) {
            return "密碼錯誤";
        }
        if ($newpassword !== $renewpassword){
            return "新密碼前後輸入不一致";
        }
        $cpwd = $newpassword!==0 ?  "`password` = '{$newpassword}', " : '';
        $money = $money == 0 ? $checkaccount['money'] : $money;
        $power = $power == 0 ? $checkaccount['power'] : $power;
        $sql = "UPDATE `userList` SET {$cpwd} `money` = '{$money}',`power` = '{$power}' WHERE `user_name` = '{$account}'";
        $this->db->execute_sql($this->db_name,$sql);
        $result = $this->get_user($user_id);
        if ($result) {
            return $result;
        }
    }
    //刪除帳號是將該使用者停權,而不是真的刪除
    public function userDelete($user_id)
    {
        $checkaccount = $this->get_user($user_id);
        if(!$checkaccount){
            return "該帳號不存在";
        }
        $sql = "UPDATE `userList` SET `power` = '2' WHERE `user_id` = '{$user_id}'";
        $this->db->execute_sql($this->db_name,$sql);
        $result = $this->get_user($user_id);
        if ($result['power'] == '2'){
            return "刪除帳號成功";
        }
    }
}

//$test = new user();
//$t = $test->userList();
//var_dump($t);
//$t = $test->userAdd('test','1234','1234',100);
//var_dump($t);
//$t = $test->userModify($t['user_id'],'test','1234','120','1','12345','12345');
//var_dump($t);
?>