<?php
function login($un =null,$pw =null)
{
	if(empty($un) || empty($pw)) {
		return alert("有欄位未填寫").over_page("{$_SERVER['PHP_SELF']}?op=login_form");
	}
    $db = new db();
    $db->create_connection();
    $sql="SELECT * FROM `userlist` WHERE `user_name` = '{$un}' AND `password` = '{$pw}'";
    $db->execute_sql('u9933109',$sql);
    $user = $db->get_result();
    if ($user) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['power'] = $user['power'];
		            header("location:{$_SERVER['PHP_SELF']}");
		return alert("登入成功").over_page("{$_SERVER['PHP_SELF']}");
    } else {
		return alert("帳號或密碼錯誤").over_page("{$_SERVER['PHP_SELF']}?op=login_form");
	}
}
function logout()
{
    $_SESSION=array();
    session_destroy();
}
function register_form()
{
    $re =
<<<RE
    <form class="form-horizontal" action="{$_SERVER['PHP_SELF']}" method="post" >
		<fieldset>
			<legend><h3>會員註冊</h3></legend>
			<div class="form-group">
				<label for="inputUserName" class="col-sm-4 control-label">帳號</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" id="inputUserName" name="user[un]" placeholder="請輸入帳號" >
					</div>
			</div>
			<div class="form-group">
				<label for="inputPassword" class="col-lg-4 control-label">密碼</label>
				<div class="col-lg-6">
					<input type="password" class="form-control" id="inputPassword" name="user[pd]" placeholder="密碼">
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword" class="col-lg-4 control-label">密碼確認</label>
				<div class="col-lg-6">
					<input type="password" class="form-control" id="inputPassword" name="user[repd]" placeholder="請再輸入一次密碼">
				</div>
			</div>
			<div class="form-group">
			  <div class="col-lg-12">
			          <input type="hidden" name="op" value="register" />
				<button type="reset" class="btn btn-default">Cancel</button>
				<button type="submit" class="btn btn-success">Submit</button>
			  </div>
			</div>
		</fieldset>
	</form>
RE;
    return $re;
}
function register($user=array())
{
	if ( empty($user['un']) || empty($user['pd']) || empty($user['repd'])){
		return alert("有資料未填寫").over_page("{$_SERVER['PHP_SELF']}?op=register_form");
	}
	if ($user['pd'] !== $user['repd']){
		return alert("密碼前後輸入不一致").over_page("{$_SERVER['PHP_SELF']}?op=register_form");
	}
	if (strlen($user['pd'])>10 || strlen($user['un'])) {
		return alert("帳號,密碼長度不得超過10個字元").over_page("{$_SERVER['PHP_SELF']}?op=register_form");
	} 
    $u = new user();
	$users = $u->getUserBYName($user['un']);
	if(!empty($users)){
		return alert("帳號重複").over_page("{$_SERVER['PHP_SELF']}?op=register_form");
	}
    $userdata = $u->userAdd($user['un'],$user['pd'],$user['repd']);
    if(isset($userdata)){
        return alert("註冊成功").over_page("{$_SERVER['PHP_SELF']}");
    }
}
function login_form()
{
    $re =
<<<RE
    <form class="form-horizontal" action="{$_SERVER['PHP_SELF']}" method="post" >
		<fieldset>
			<legend><h3>會員登入</h3></legend>
			<div class="form-group">
				<label for="inputUserName" class="col-sm-4 control-label">帳號</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" id="inputUserName" name="un" placeholder="請輸入帳號" >
					</div>
			</div>
			<div class="form-group">
				<label for="inputPassword" class="col-lg-4 control-label">密碼</label>
				<div class="col-lg-6">
					<input type="password" class="form-control" id="inputPassword" name="pd" placeholder="密碼">
				</div>
			</div>
			<div class="form-group">
			  <div class="col-lg-10">
				  <input type="hidden" name="op" value="login" />
				<button type="reset" class="btn btn-default">Cancel</button>
				<button type="submit" class="btn btn-primary">Submit</button>
			  </div>
			</div>
		</fieldset>
	</form>
RE;
    return $re;
}
function user($userid)
{
    $u = new user();
    $userdata = $u->get_user($userid);
    $re =
<<<RE
    <form class="form-horizontal" action="{$_SERVER['PHP_SELF']}" method="post" >
		<fieldset>
			<legend>會員資料</legend>
			<div class="form-group">
				<label for="inputUserName" class="col-lg-4 control-label">帳號</label>
					<div class="col-lg-6">
						<input type="text" class="form-control" id="inputUserName" placeholder="{$userdata['user_name']}" disabled="">
					</div>
			</div>
			<div class="form-group">
				<label for="inputMoney" class="col-lg-4 control-label">餘額</label>
					<div class="col-lg-6">
						<input type="text" class="form-control" id="inputMoney" placeholder="{$userdata['money']}" disabled="">
					</div>
			</div>
			<div class="form-group">
				<label for="inputPassword" class="col-lg-4 control-label">密碼</label>
				<div class="col-lg-6">
					<input type="password" class="form-control" id="inputPassword" name="user[pd]" placeholder="欲修改密碼請重新輸入密碼">
				</div>
			</div>
			<div class="form-group">
				<label for="inputNewPassword" class="col-lg-4 control-label">新密碼</label>
				<div class="col-lg-6">
					<input type="password" class="form-control" id="inputNewPassword" name="user[npd]" placeholder="請輸入新密碼">
				</div>
			</div>
			<div class="form-group">
				<label for="inputReNewPassword" class="col-lg-4 control-label">新密碼確認</label>
				<div class="col-lg-6">
					<input type="password" class="form-control" id="inputReNewPassword" name="user[nrepd]" placeholder="再輸入一次新密碼">
				</div>
			</div>
			<div class="form-group">
			  <div class="col-lg-10 col-lg-offset-2">
			      <input type="hidden" name="op" value="modifypwd" />
				<button type="reset" class="btn btn-default">Cancel</button>
				<button type="submit" class="btn btn-primary">Submit</button>
			  </div>
			</div>
		</fieldset>
	</form>
RE;
    return $re;
}
function modifypwd($userid,$user=array())
{
    $u = new user();
    $userdata = $u->get_user($userid);
	if ( empty($user['pd']) || empty($user['npd']) || empty($user['nrepd'])) {
		return alert("有資料未填寫請確認").over_page("{$_SERVER['PHP_SELF']}?op=user");
	}
	if ( $user['npd'] !== $user['nrepd']){
		return alert("密碼確認錯誤").over_page("{$_SERVER['PHP_SELF']}?op=user");
	}
    $m = $u->userModify($userid,$userdata['user_name'],$user['pd'],$userdata['money'],$userdata['power'],$user['npd'],$user['nrepd']);
    if (isset($m)) {
        return alert("修改資料成功").over_page("{$_SERVER['PHP_SELF']}?op=user");
    }
}
function buy()
{
	if (isset($_SESSION['user_id'])){
    $b = new buy();
    $buy = $b->buyList();
    $re =
<<<RE
<h4>
    <table class="table table-striped table-hover ">
	<thead>
			<tr class="warning">
			  <th colspan='7'>商品列表</th>
			</tr>
			<tr class="warning">
			  <th width='100px'>產品編號</th>
			  <th width='200px'>產品名稱</th>
			  <th width='100px'>剩餘數量</th>
			  <th width='300px'>介紹</th>
			  <th width='100px'>價錢</th>
			  <th width='100px'>購買數量</th>
			  <th width='100px'></th>
			</tr>
		  </thead>
		  <tbady>
RE;
    foreach ($buy as $key => $val){
    $re.=
<<<RE
    <tr class="warning">
        <form action="{$_SERVER['PHP_SELF']}" method="post">
        <td>{$val['buy_id']}</td><td>{$val['buy_name']}</td><td>{$val['num']}</td><td>{$val['context']}</td><td>{$val['price']}</td>
        <td><input class="form-control input-sm" type="text" name=num id="inputSmall"><input type="hidden" name="buyid" value="{$val['buy_id']}" /></td>
        <td><input type="hidden" name="op" value="bs" /><input class="btn btn-success btn-sm" type="submit" value="購買" /></td>
        </form>
    </tr>
RE;
    }
    $re.=
<<<RE
</tbady>
    </table>
	</h4>
RE;
	} else {
	$b = new buy();
    $buy = $b->buyList();
    $re =
<<<RE
<h4>
    <table class="table table-striped table-hover ">
	<thead>
			<tr class="warning">
			  <th colspan='7'>商品列表</th>
			</tr>
			<tr class="warning">
			  <th width='100px'>產品編號</th>
			  <th width='200px'>產品名稱</th>
			  <th width='100px'>剩餘數量</th>
			  <th width='300px'>介紹</th>
			  <th width='100px'>價錢</th>
			  <th width='100px'>請先登入</th>
			</tr>
		  </thead>
		  <tbady>
RE;
    foreach ($buy as $key => $val){
    $re.=
<<<RE
    <tr class="warning">
        <form action="{$_SERVER['PHP_SELF']}" method="post">
        <td>{$val['buy_id']}</td><td>{$val['buy_name']}</td><td>{$val['num']}</td><td>{$val['context']}</td><td>{$val['price']}</td>
        <td></td>
    </tr>
RE;
    }
    $re.=
<<<RE
</tbady>
    </table>
	</h4>
RE;
	}
    return $re;
}

function bs($userid,$buyid,$num = 0)
{
	if ($num == 0) {
		return alert("請輸入數量").over_page("{$_SERVER['PHP_SELF']}?op=buy");
	}
    $o = new order();
    $order = $o->orderAdd($userid,$buyid,$num);
    if (is_array($order)) {
        return alert("購買成功,請至訂單頁面確認").over_page("{$_SERVER['PHP_SELF']}");
    } else {
        return alert("{$order}").over_page("{$_SERVER['PHP_SELF']}?op=buy");
    }
}
function order()
{
    $userid = $_SESSION['user_id'];
    $o = new order();
    $order = $o->orderListByUser($userid);
    $re =
<<<RE
<h4>
<table class="table table-striped table-hover ">
	<thead>
		<tr class="warning">
		  <th width='100px'>訂單編號</th>
		  <th width='100px'>產品編號</th>
		  <th width='200px'>產品名稱</th>
		  <th width='100px'>訂購數量</th>
		  <th width='100px'>總價格</th>
		  <th width='100px'>修改數量</th>
		  <th>修改數量</th>
		  <th>修改數量</th>
		</tr>
	</thead>
	<tbady>
RE;
    foreach ($order as $key => $val){
        $b = new buy();
        $buy = $b->get_buy($val['buy_id']);
        $re.=
<<<RE
        <tr class="warning">
            <form action="{$_SERVER['PHP_SELF']}" method="post">
            <td>{$val['order_id']}</td><td>{$val['buy_id']}</td><td>{$buy['buy_name']}</td><td>{$val['num']}</td><td>{$val['price']}</td>
            <td><input class="form-control input-sm" type="text" name=num id="inputSmall"><input type="hidden" name="orderid" value="{$val['order_id']}" /></td>
            <td><input type="hidden" name="op" value="modifyorder" /><input class="btn btn-primary btn-sm" type="submit" value="修改" /></td>
            </form>
            <td><form action="{$_SERVER['PHP_SELF']}" method="post">
            <input type="hidden" name="op" value="deleteorder" />
            <input type="hidden" name="orderid" value="{$val['order_id']}" />
            <input class="btn btn-danger btn-sm" type="submit" value="刪除" /></form></td>
        </tr>
RE;
    }
    $re.=
<<<RE
			</tbady>
            </table>
			</h4>
RE;
    return $re;
}
function modifyorder($orderid,$num =0)
{
	if ($num == 0) {
		return alert("請輸入數量").over_page("{$_SERVER['PHP_SELF']}?op=order");
	}
    $o = new order();
    $order = $o->orderModify($orderid,$num);
    if (is_array($order)) {
        return alert("修改訂單成功").over_page("{$_SERVER['PHP_SELF']}?op=order");
    } else {
        return alert("{$order}").over_page("{$_SERVER['PHP_SELF']}?op=order");
    }
}
function deleteorder($orderid)
{
    $o = new order();
    $order = $o->orderDelete($orderid);
    if ($order){
		if($_SESSION['power'] == '99') {
		        return alert("{$order}").over_page("{$_SERVER['PHP_SELF']}?op=buy_manage");
		}
        return alert("{$order}").over_page("{$_SERVER['PHP_SELF']}?op=order");
    }
}
?>