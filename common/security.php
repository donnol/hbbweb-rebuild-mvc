<?php
class Security{
	//�����ݿ���������ݵ���
	public function htmlEncode($str){
		return htmlspecialchars($str);
	}
	//�������ݿ�����ݵ���
	public function sqlEncode($str){
		return addslashes($str);
	}
}
?>