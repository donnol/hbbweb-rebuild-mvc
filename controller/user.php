<?php
require_once(dirname(__FILE__).'/../model/user/user.php');
require_once(dirname(__FILE__).'/../view/json.php');
$user = new User();
function add(){
		global $user;
		$result = $user->isLogin();
		if( $result['code'] != 0 ){
				show_view($result);
				return;
		}

		$pwd = '123';
		$name = $_POST["name"];
		$result = $user->add(
						$name,
						$pwd,
						$_POST["tel"],
						$_POST["addr"],
						$_POST["cert"]
						);
		show_view($result);
}
function del(){
		global $user;
		$result = $user->isLogin();
		if( $result['code'] != 0 ){
				show_view($result);
				return;
		}

		$result = $user->del(
						$_GET["id"]
						);
		show_view($result);
}
function update(){
		global $user;
		$result = $user->isLogin();
		if($result['code'] != 0){
				show_view($result);
				return;
		}
				
				

		$result = $user->update(
						$_POST["name"],
						$_POST["tel"],
						$_POST["addr"],
						$_POST["cert"],
						$_GET["id"]
						);
		show_view($result);
}
function get(){
		global $user;
		$result = $user->isLogin();
		if( $result['code'] != 0){
				show_view($result);
				return;
		}
		$result = $user->get();
		show_view($result);
}
function getone(){
		global $user;
		$result = $user->isLogin();
		if($result['code'] != 0){
				show_view($result);
				return;
		}
		$id = $_GET['id'];
		$result = $user->getone($id);
		show_view($result);
}
function login(){
		global $user;
		$result = $user->login(
						$_POST['username'],
						$_POST['pwd']
						);
		show_view($result);
}
function logout(){
		global $user;
		$result = $user->logout();
		show_view($result);
}
function isLogin(){
		global $user;
		$result = $user->isLogin();
		show_view($result);
}
$func = $_GET['func'];
if( $func == 'add')
add();
else if( $func == 'del' )
del();
else if( $func == 'update')
update();
else if( $func == 'login' )
login();
else if( $func == 'logout' )
logout();
else if( $func == 'get')
get();
else if ($func =='getone')
getone();
else if($func == 'listname')
listname();
else if( $func == 'isLogin')
isLogin();
else
echo 'unknown func!'.$func;
?>
