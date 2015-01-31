<?php
require_once(dirname(__FILE__).'/security.php');
class DB{

		var $dbconnect = false;
		var $security;
		public function __construct(){
				$this->security = new Security();
		}
		private function connect(){
				if( $this->dbconnect != false )//¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿
						return array(
										'code'=>0,
										'msg'=>'',
										'data'=>$this->dbconnect//ÔÚÊ¹ÓÃmysqli_connectÁ´½ÓÊý¾Ý¿âÖ®Ç°ÏÈ¿´¿´ÊÇ·ñÒÑÁ¬½Ó£¬ÒÑÁ¬½ÓÔò·µ»Ødbconnect
									);
				$this->dbconnect = mysqli_connect("localhost:3306", "root","jd123","book");
				if( $this->dbconnect == false )//Á´½ÓÊ§°Ü
						return array(
										'code'=>1,
										'msg'=>'Á¬½ÓÊý¾Ý¿âÊ§°Ü',
										'data'=>''
									);
				return array(//Á´½Ó³É¹¦
								'code'=>0,
								'msg'=>'',
								'data'=>$this->dbconnect
							);
		}
		private function close($db){
				if( $db != false ){
						mysqli_close($db);
						$this->dbconnect = false;
				}
		}
		public function select($table,$data){
				$result = $this->connect();//½¨Á¢Á´½Ó£¬·µ»ØÊý×é
				if( $result['code'] != 0 )//Èç¹ûÌõ¼þ³ÉÁ¢£¬ÎÞÁ´½Ó
						return $result;
				$db = $result['data'];//Êý¾Ý¿âÖ¸Õë

				$sql = 'select * from '.$this->security->sqlEncode($table);//½¨Á¢sqlÓï¾ä£¬²ÎÊýtableÊÇ±íÃû£¬¶ÔÆä½øÐÐ×ªÒå
				if( count($data) != 0 ){//²ÎÊýdataÊôÓÚwhereÌõ¼þ
						$sql .= ' where ';//´æÔÚwhereÌõ¼þ
						$isFirst = true;//ÅÐ¶ÏÓÐ¼¸¸öÌõ¼þ
						foreach($data as $key=>$value ){//¸ÃÌõ¼þ±ØÈ»ÓÐµÈºÅ£¬µÈºÅ×ó±ßÎª¼ü£¬ÓÒ±ßÎªÖµ
								if( $isFirst == false )
										$sql .= ' and ';//Ìõ¼þ¶àÔòand¶à
								$sql .= $this->security->sqlEncode($key)." = '".$this->security->sqlEncode($value)."' ";
								$isFirst = false;
						}
				}
				$query = mysqli_query($db,$sql);
				if( $query == false ){
					//	$this->close($db);
						return array(
										'code'=>1,
										'msg'=>'Ö´ÐÐsqlÓï¾äÊ§°Ü '.$sql,
										'data'=>''
									);
				}

				$data = array();
				while( $singleData = mysqli_fetch_array($query,MYSQL_ASSOC) ){//Ò»´Î¼´Ò»ÐÐ
						//singleData is an array
						$data[] = $singleData;//ËùÓÐÊý¾Ý
				}
				//$this->close($db);
				return array(
								'code'=>0,
								'msg'=>'',
								'data'=>$data
							);
		}

		public function insert($table,$data){
				$result = $this->connect();
				if( $result['code'] != 0 )
						return $result;
				$db = $result['data'];

				$sql = 'insert into '.$this->security->sqlEncode($table).'( ';
								$isFirst = true;
								foreach( $data as $key=>$value ){
								if( $isFirst == false )
								$sql .= ',';
								$sql .= $this->security->sqlEncode($key);
								$isFirst = false;
								}
								$sql .= ')values(';
										$isFirst = true;
										foreach( $data as $key=>$value ){
										if( $isFirst == false )
										$sql .= ',';
										$sql .= "'".$this->security->sqlEncode($value)."'";
										$isFirst = false;
										}
										$sql .= ')';
										$query = mysqli_query($db,$sql);
										if( $query == false ){
									//	$this->close($db);
										return array(
												'code'=>1,
												'msg'=>'Ö´ÐÐsqlÓï¾äÊ§°Ü '.$sql,
												'data'=>''
												);
										}
									//	$this->close($db);
										return array(
												'code'=>0,
												'msg'=>'',
												'data'=>''
												);
		}

		public function delete($table,$data){
				$result = $this->connect();
				if( $result['code'] != 0 )
						return $result;
				$db = $result['data'];

				$sql = 'delete from '.$this->security->sqlEncode($table);
				if( count($data) != 0 ){
						$sql .= ' where ';
						$isFirst = true;
						foreach($data as $key=>$value ){
								if( $isFirst == false )
										$sql .= ' and ';
								$sql .= $this->security->sqlEncode($key)." = '".$this->security->sqlEncode($value)."'";
								$isFirst = false;
						}
				}
				$query = mysqli_query($db,$sql);
				if( $query == false ){
						//$this->close($db);
						return array(
										'code'=>1,
										'msg'=>'Ö´ÐÐsqlÓï¾äÊ§°Ü '.$sql,
										'data'=>''
									);
				}
				//$this->close($db);
				return array(
								'code'=>0,
								'msg'=>'',
								'data'=>''
							);
		}

		public function update($table, $data, $condition){
				$result = $this->connect();
				if($result['code'] != 0)
						return $result;
				$db = $result['data'];

				$sql = 'update '.$this->security->sqlEncode($table).' set ';
				$isFirst = true;
				foreach( $data as $key=>$value){
						if($isFirst == false)
								$sql .= ',';
						$sql .= $this->security->sqlEncode($key)."='".$this->security->sqlEncode($value)."'";
						$isFirst = false;
				}
				if($isFirst == false){
						$isFirst = true;
				}
				$sql .= ' where ';
				foreach( $condition as $key=>$value){
						if($isFirst == false)
								$sql .= ' and ';
						$sql .= $this->security->sqlEncode($key)."='".$this->security->sqlEncode($value)."'";
						$isFirst = false;
				}
				$query = mysqli_query($db,$sql);
				if( $query == false ){
						//$this->close($db);
						return array(
										'code'=>1,
										'msg'=>'Ö´ÐÐsqlÓï¾äÊ§°Ü '.$sql,
										'data'=>''
									);
				}

				//$this->close($db);
				return array(
								'code'=>0,
								'msg'=>'',
								'data'=>''
							);
		}

};
?>
