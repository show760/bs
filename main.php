<?php
session_start();
include "adminview.php";
include "view.php";
include "buy.php";
include "user.php";
include "db.php";
include "order.php";
function alert($string="")
{
    $content=
<<<CONTENT
		<script language="JavaScript">
		alert("{$string}");
		</script>
CONTENT;
    return $content;
}
function over_page($goto)
{
    return "<script>window.location.replace('{$goto}')</script>";
}
//$t = login('user3','1234');

if ( isset($_SESSION['user_id'])) {
    if ($_SESSION['power'] == '99'){
        $toolbar =
<<<LOG
    <a class="toolbar" href="{$_SERVER['PHP_SELF']}?op=user_manage">會員管理</a>
    <a class="toolbar" href="{$_SERVER['PHP_SELF']}?op=buy_manage">商品管理</a>
    <a class="toolbar" href="{$_SERVER['PHP_SELF']}?op=logout">登出</a>
LOG;
        switch($_REQUEST['op'])
        {
            case "logout":
                logout();
                header("location:{$_SERVER['PHP_SELF']}");
                break;
            case "user_manage":
                $main = user_manage();
                break;
            case "buy_manage":
                $main = buy_manage();
                break;
            case "modifybuy":
                $main = modifybuy($_POST['buy_id'],$_POST['num']);
                break;
            case "delete_buy":
                $main = delete_buy($_GET['buy_id']);
                break;
            case "add_buy_form":
                $main = add_buy_form();
                break;
            case "add_buy":
                $main = add_buy($_POST['buy']);
                break;
            case "order_manage":
                $main = order_manage($_GET['buyid']);
                break;
            case "change_power":
                $main = change_power($_GET['userid'],$_GET['power']);
                break;
            case "modify_user":
                $main = modify_user($_POST['userid'],$_POST['money']);
                break;
			case "deleteorder":
                $main = deleteorder($_POST['orderid']);
                break;
        }
    } else if ($_SESSION['power'] == '1') {
        $toolbar =
<<<LOG
    <a class="toolbar" href="{$_SERVER['PHP_SELF']}?op=user">會員</a>
    <a class="toolbar" href="{$_SERVER['PHP_SELF']}?op=buy">商品</a>
    <a class="toolbar" href="{$_SERVER['PHP_SELF']}?op=order">訂單</a>
    <a class="toolbar" href="{$_SERVER['PHP_SELF']}?op=logout">登出</a>
LOG;
        switch($_REQUEST['op'])
        {
            //登出
            case "logout":
                logout();
                header("location:{$_SERVER['PHP_SELF']}");
                break;
            //會員資料
            case "user":
                $main = user($_SESSION['user_id']);
                break;
            //修改密碼
            case "modifypwd":
                $main = modifypwd($_SESSION['user_id'],$_POST['user']);
                break;
            //商品資料
            case "buy":
                $main = buy();
                break;
            //購買商品
            case "bs":
                $main = bs($_SESSION['user_id'],$_POST['buyid'],$_POST['num']);
                break;
            //訂單資料
            case "order":
                $main = order();
                break;
            //修改訂單
            case "modifyorder":
                $main = modifyorder($_POST['orderid'],$_POST['num']);
                break;
            //刪除訂單
            case "deleteorder":
                $main = deleteorder($_POST['orderid']);
                break;
			default:
				$main = buy();
        }
    } else {
      alert('你被停權').over_page($_SERVER['PHP_SELF']);
    }
}else {
    $toolbar =
<<<LOG
	<a class="toolbar" href="{$_SERVER['PHP_SELF']}?op=buy">商品</a>
    <a class="toolbar" href="{$_SERVER['PHP_SELF']}?op=register_form">註冊</a>
    <a class="toolbar" href="{$_SERVER['PHP_SELF']}?op=login_form">登入</a>
LOG;
    switch($_REQUEST['op'])
    {
        case "register_form":
            $main = register_form();
            break;
        case "register":
            $main = register($_POST['user']);
            break;
        case "login_form":
            $main = login_form();
            break;
        case "login":
            $main = login($_POST['un'],$_POST['pd']);
            break;
		case "buy":
			$main = buy();
			break;
		default:
			$main = buy();
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> BuySomething </title>
<link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.4/cerulean/bootstrap.min.css" rel="stylesheet">
<script language="javascript">
</script>
</head>
<body background="wrapper-bg.jpg">
<div class="container">
    <table align='right' border='0'>
        <tr>
            <td>
                <div class="log"><?php echo $toolbar ?></div>
            </td>
        </tr>
    </table>
    <br />
    <br />
    <hr />
    <div align="center"><?php echo $main; ?></div>
    <br />
    <hr />
    <br />
    <br />
</div>
</body>
</html>