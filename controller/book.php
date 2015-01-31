<?php
require_once(dirname(__FILE__).'/user/user.php');
require_once(dirname(__FILE__).'/book/book.php');
$user = new User();
$book = new Book();
function add(){
		global $user;
		global $book;
		$result = $user->isLogin();
		if( $result['code'] != 0 ){
				echo json_encode($result);
				return;
		}

		$result = $book->add(
						$_POST["name"],
						$_POST["cate"],
						$_POST["page"],
						$_POST["content"]
						);
		echo json_encode($result);
}
function del(){
		global $user;
		global $book;
		$result = $user->isLogin();
		if( $result['code'] != 0 ){
				echo json_encode($result);
				return;
		}

		$result = $book->del(
						$_GET["id"]
						);
		echo json_encode($result);
}
function update(){
		global $user;
		global $book;
		$result = $user->isLogin();
		if($result['code'] != 0){
				echo json_encode($result);
				return;
		}

		$result = $book->update(
						$_POST['name'],
						$_POST['cate'],
						$_POST['page'],
						$_POST['content'],
						$_GET['id']
						);
		echo json_encode($result);
}
function get(){
		global $user;
		global $book;
		$result = $user->isLogin();
		if($result['code'] != 0){
				echo json_encode($result);
				return;
		}

		$result = $book->get();
		echo json_encode($result);
}
function getone(){
		global $user;
		global $book;
		$result = $user->isLogin();
		if($result['code'] != 0){
				echo json_encode($result);
				return;
		}
		$id = $_GET['id'];
		$result = $book->getone($id);
		echo json_encode($result);
}
$func = $_GET['func'];
if( $func == 'add')
add();
else if( $func == 'del' )
del();
else if( $func == 'update')
update();
else if( $func == 'get')
get();
else if( $func == 'getone')
getone();
else
echo 'unknown func!'.$func;
?>
