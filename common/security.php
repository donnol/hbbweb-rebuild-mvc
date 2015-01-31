<?php
class Security{
	//从数据库输出的数据调用
	public function htmlEncode($str){
		return htmlspecialchars($str);
	}
	//输入数据库的数据调用
	public function sqlEncode($str){
		return addslashes($str);
	}
}
?>