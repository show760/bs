<?php
function user_manage()
{
    $u = new user();
    $user = $u->userList();
    $re=
<<<RE
<h4>
    <table class="table table-striped table-hover ">
		<thead>
			<tr class="warning">
			  <th colspan='7'>會員資料表</th>
			</tr>
			<tr class="warning">
			  <th>會員編號</th>
			  <th>會員名稱</th>
			  <th>權限</th>
			  <th>變更權限</th>
			  <th>會員額度</th>
			  <th>修改額度</th>
			  <th>修改</th>
			</tr>
	    </thead>
	    <tbady>
RE;
    foreach ($user as $key => $val){
        if ($val['power'] == 1) {
            $power=
<<<po
        <a class="toolbar" href="{$_SERVER['PHP_SELF']}?op=change_power&userid={$val['user_id']}&power=1">修改</a>
po;
        } else if ($val['power'] == 2) {
            $power=
<<<po
            <a class="toolbar" href="{$_SERVER['PHP_SELF']}?op=change_power&userid={$val['user_id']}&power=2">修改</a>
po;
        }
        $re.=
<<<RE
        <tr class="warning">
            <td>{$val['user_id']}</td><td>{$val['user_name']}</td><td>{$val['power']}</td>
            <td>{$power}</td>
            <td>{$val['money']}</td>
            <td><form action="{$_SERVER['PHP_SELF']}" method="post"><input type="hidden" name="op" value="modify_user" />
            <input type="hidden" name="userid" value="{$val['user_id']}" />
            <input class="form-control input-sm" type="text" name="money" />
            </td>
            <td><input class="btn btn-info btn-sm" type="submit" value="修改" /></form></td>
        </tr>
RE;
    }
    $re.=
<<<RE
	</tbody>
    </table>
	</h4>
RE;
    return $re;

}
function buy_manage()
{
    $b = new buy();
    $buy = $b->buyList();
    $re=
<<<RE
<h4>
    <table class="table table-striped table-hover ">
		<thead>
			<tr class="info">
			  <th colspan='5'>商品清單</th>
			  <th colspan='3'><a class="btn btn-primary btn-sm" href="{$_SERVER['PHP_SELF']}?op=add_buy_form">新增商品</a></th>
			</tr>
			<tr class="info">
			  <th>商品編號</th>
			  <th>商品名稱</th>
			  <th>剩餘數量</th>
			  <th>價格</th>
			  <th>修改數量</th>
			  <th></th>
			  <th>管理訂單</th>
			  <th>刪除商品</th>
			</tr>
	    </thead>
	    <tbady>
RE;
    foreach($buy as $key => $val) {
        $re.=
<<<RE
        <tr class ="info">
            <td>{$val['buy_id']}</td><td>{$val['buy_name']}</td><td>{$val['num']}</td><td>{$val['price']}</td>
            <td><form action="{$_SERVER['PHP_SELF']}" method="post"><input type="hidden" name="op" value="modifybuy" />
            <input type="hidden" name="buy_id" value="{$val['buy_id']}" />
            <input class="form-control input-sm" type="text" name="num" />
            </td>
            <td><input class="btn btn-info btn-sm" type="submit" value="修改" /></form></td>
            <td><a class="btn btn-warning btn-sm" href="{$_SERVER['PHP_SELF']}?op=order_manage&buyid={$val['buy_id']}">管理</a></td>
            <td><a class="btn btn-danger btn-sm" href="{$_SERVER['PHP_SELF']}?op=delete_buy&buy_id={$val['buy_id']}">刪除</a></td>
        </tr>
RE;
    }
    $re.=
<<<RE
	</tbody>
    </table>
	</h4>
RE;
    return $re;
}
function order_manage($buyid)
{
    $b = new buy();
    $buy = $b->get_buy($buyid);
    $o = new order();
    $order = $o->orderListByBuy($buyid);
    $re=
<<<RE
<h3>
    <table class="table table-striped table-hover ">
		<thead>
			<tr class="success">
			  <th colspan='5'>商品: {$buy['buy_name']} 訂單列表</th>
			</tr>
			<tr class="success">
			  <th>訂單編號</th>
			  <th>訂購人姓名</th>
			  <th>訂購數量</th>
			  <th>總價</th>
			  <th></th>
			</tr>
		  </thead>
		  <tbady>
RE;

    $u = new user();
    foreach($order as $key => $val) {
        $user = $u->get_user($val['user_id']);
        $re.=
<<<RE
        <tr class="success">
            <td>{$val['order_id']}</td><td>{$user['user_name']}</td><td>{$val['num']}</td><td>{$val['price']}</td>
            <td><form action="{$_SERVER['PHP_SELF']}" method="post"><input type="hidden" name="op" value="deleteorder" />
            <input type="hidden" name="orderid" value="{$val['order_id']}" />
            <input class="btn btn-danger btn-sm" type="submit" value="刪除" /></form></td>
        </tr>
RE;
    }
    $re.=
<<<RE
		</tbody>
    </table>
	</h3>
RE;
    return $re;
}
function modifybuy($buyid,$num = null)
{
	if ($num == null) {
		return alert("數量不得為空").over_page("{$_SERVER['PHP_SELF']}?op=buy_manage");
	}
    $b = new buy();
    $buy = $b->get_buy($buyid);
    $b->buyModify($buyid,$buy['buy_name'],$num,$buy['context'],$buy['price']);
    return alert("修改資料成功").over_page("{$_SERVER['PHP_SELF']}?op=buy_manage");
}
function delete_buy($buyid)
{
    $b = new buy();
    $buy = $b->get_buy($buyid);
    $o = new order();
    $order = $o->orderListByBuy($buyid);
    if(!empty($order)) {
        return alert("該商品有注單禁止刪除").over_page("{$_SERVER['PHP_SELF']}?op=buy_manage");
    }
    $b->buyDelete($buyid);
    return alert("刪除資料成功").over_page("{$_SERVER['PHP_SELF']}?op=buy_manage");
}
function add_buy_form()
{
    $re=
<<<RE
<form class="form-horizontal" action="{$_SERVER['PHP_SELF']}" method="post" >
		<fieldset>
			<legend><h3>新增商品資料</h3></legend>
			<div class="form-group">
				<label for="inputBuyName" class="col-lg-4 control-label">商品名稱</label>
					<div class="col-lg-6">
						<input type="text" class="form-control" name="buy[buy_name]" id="inputBuyName">
					</div>
			</div>
			<div class="form-group">
				<label for="inputNum" class="col-lg-4 control-label">商品數量</label>
					<div class="col-lg-6">
						<input type="text" class="form-control" name="buy[num]" id="inputNum">
					</div>
			</div>
			<div class="form-group">
				<label for="inputPrice" class="col-lg-4 control-label">價格</label>
					<div class="col-lg-6">
						<input type="text" class="form-control" name="buy[price]" id="inputPrice">
					</div>
			</div>
			<div class="form-group">
				<label for="inputContext" class="col-lg-4 control-label">介紹</label>
					<div class="col-lg-6">
						<input type="text" class="form-control" name="buy[context]" id="inputContext" placeholder="商品簡短的介紹">
					</div>
			</div>
			<div class="form-group">
			  <div class="col-lg-10 col-lg-offset-2">
			      <input type="hidden" name="op" value="add_buy" />
				<button type="reset" class="btn btn-default">Cancel</button>
				<button type="submit" class="btn btn-primary">Submit</button>
			  </div>
			</div>
		</fieldset>
	</form>
RE;
    return $re;
}
function add_buy($buy = array())
{
	if (empty($buy['buy_name']) || empty($buy['num']) ||empty($buy['context']) || empty($buy['price'])) {
		return alert("有資料未填寫").over_page("{$_SERVER['PHP_SELF']}?op=add_buy_form");
	}
	if (strlen($buy['buy_name']) > 10) {
		return alert("商品名稱不得大於10個字元").over_page("{$_SERVER['PHP_SELF']}?op=add_buy_form");
	}
    $b = new buy();
    $b->buyAdd($buy['buy_name'],$buy['num'],$buy['context'],$buy['price']);
    return alert("新增資料成功").over_page("{$_SERVER['PHP_SELF']}?op=buy_manage");
}
function change_power($userid,$power)
{
    $power = $power ==1 ? 2 : 1;
    $u = new user();
    $user = $u->get_user($userid);
    $u->userModify($userid,$user['user_name'],$user['password'],$user['money'],$power);
    return alert("修改資料成功").over_page("{$_SERVER['PHP_SELF']}?op=user_manage");
}
function modify_user($userid,$money = null)
{
	if(empty($money)) {
		return alert("欄位不得為空").over_page("{$_SERVER['PHP_SELF']}?op=user_manage");
	}
    $u = new user();
    $user = $u->get_user($userid);
    $u->userModify($userid,$user['user_name'],$user['password'],$money);
    return alert("修改資料成功").over_page("{$_SERVER['PHP_SELF']}?op=user_manage");
}
?>