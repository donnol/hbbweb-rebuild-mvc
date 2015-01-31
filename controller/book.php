<?php
require_once(dirname(__FILE__).'/../model/user/user.php');
require_once(dirname(__FILE__).'/../model/book/book.php');
require_once(dirname(__FILE__).'/../view/json.php');
$user = new User();
$book = new Book();
function add(){
		global $user;
		global $book;
		$result = $user->isLogin();
		if( $result['code'] != 0 ){
				show_view($result);
				return;
		}

		$result = $book->add(
						$_POST["name"],
						$_POST["cate"],
						$_POST["page"],
						$_POST["content"]
						);
		show_view($result);
}
function del(){
		global $user;
		global $book;
		$result = $user->isLogin();
		if( $result['code'] != 0 ){
				show_view($result);
				return;
		}

		$result = $book->del(
						$_GET["id"]
						);
		show_view($result);
}
function update(){
		global $user;
		global $book;
		$result = $user->isLogin();
		if($result['code'] != 0){
				show_view($result);
				return;
		}

		$result = $book->update(
						$_POST['name'],
						$_POST['cate'],
						$_POST['page'],
						$_POST['content'],
						$_GET['id']
						);
		show_view($result);
}
function get(){
		global $user;
		global $book;
		$result = $user->isLogin();
		if($result['code'] != 0){
				show_view($result);
				return;
		}

		$result = $book->get();
		show_view($result);
}
function getone(){
		global $user;
		global $book;
		$result = $user->isLogin();
		if($result['code'] != 0){
				show_view($result);
				return;
		}
		$id = $_GET['id'];
		$result = $book->getone($id);
		show_view($result);
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
