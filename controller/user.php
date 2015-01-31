<?php
require_once(dirname(__FILE__).'/user/user.php');
$user = new User();
function add(){
		global $user;
		$result = $user->isLogin();
		if( $result['code'] != 0 ){
				echo json_encode($result);
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
		echo json_encode($result);
}
function del(){
		global $user;
		$result = $user->isLogin();
		if( $result['code'] != 0 ){
				echo json_encode($result);
				return;
		}

		$result = $user->del(
						$_GET["id"]
						);
		echo json_encode($result);
}
function update(){
		global $user;
		$result = $user->isLogin();
		if($result['code'] != 0){
				echo json_encode($result);
				return;
		}
				
				

		$result = $user->update(
						$_POST["name"],
						$_POST["tel"],
						$_POST["addr"],
						$_POST["cert"],
						$_GET["id"]
						);
		echo json_encode($result);
}
function get(){
		global $user;
		$result = $user->isLogin();
		if( $result['code'] != 0){
				echo json_encode($result);
				return;
		}
		$result = $user->get();
		echo json_encode($result);
}
function getone(){
		global $user;
		$result = $user->isLogin();
		if($result['code'] != 0){
				echo json_encode($result);
				return;
		}
		$id = $_GET['id'];
		$result = $user->getone($id);
		echo json_encode($result);
}
function login(){
		global $user;
		$result = $user->login(
						$_POST['username'],
						$_POST['pwd']
						);
		echo json_encode( $result );
}
function logout(){
		global $user;
		$result = $user->logout();
		echo json_encode( $result );
}
function isLogin(){
		global $user;
		$result = $user->isLogin();
		echo json_encode($result);
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
