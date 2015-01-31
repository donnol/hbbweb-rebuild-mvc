<?php
class Security{
	public function htmlEncode($str){
		return htmlspecialchars($str);
	}
	public function sqlEncode($str){
		return addslashes($str);
	}
}
?>
