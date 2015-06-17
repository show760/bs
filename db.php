<?php
class db
{
    private $link;
    private $result;
    public function create_connection()
    {
        $this->link = mysql_connect("localhost", "U9933109", "u9933109") or die("無法建立資料連接<br><br>" . mysql_error());
        mysql_query("SET NAMES utf8");
        return;
    }
    public function execute_sql($database, $sql)
    {
        unset($this->result);
        if($this->link) {
            $db_selected = mysql_select_db($database, $this->link) or die("開啟資料庫失敗<br><br>" . mysql_error($this->link));
            $this->result = mysql_query($sql, $this->link);
            return $this->result;
        }
    }
    public function close_connection()
    {
        if($this->link) {
            mysql_close($this->link);
            return;
        }
    }
    public function get_result_array()
    {
        $result_array = array();
        if($this->result) {
            while ($row = mysql_fetch_assoc($this->result)) {
                $result_array[] = $row;
            }
            return $result_array;
        }
        return null;
    }
    public function get_result()
    {
        if($this->result) {
            $row = mysql_fetch_assoc($this->result);
            return $row;
        }
        return null;
    }
}
?>