<?php
require_once(dirname(__FILE__).'/security.php');
class DB{

		var $dbconnect = false;
		var $security;
		public function __construct(){
				$this->security = new Security();
		}
		private function connect(){
				if( $this->dbconnect != false )//���������������
						return array(
										'code'=>0,
										'msg'=>'',
										'data'=>$this->dbconnect//��ʹ��mysqli_connect�������ݿ�֮ǰ�ȿ����Ƿ������ӣ��������򷵻�dbconnect
									);
				$this->dbconnect = mysqli_connect("localhost:3306", "root","jd123","book");
				if( $this->dbconnect == false )//����ʧ��
						return array(
										'code'=>1,
										'msg'=>'�������ݿ�ʧ��',
										'data'=>''
									);
				return array(//���ӳɹ�
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
				$result = $this->connect();//�������ӣ���������
				if( $result['code'] != 0 )//�������������������
						return $result;
				$db = $result['data'];//���ݿ�ָ��

				$sql = 'select * from '.$this->security->sqlEncode($table);//����sql��䣬����table�Ǳ������������ת��
				if( count($data) != 0 ){//����data����where����
						$sql .= ' where ';//����where����
						$isFirst = true;//�ж��м�������
						foreach($data as $key=>$value ){//��������Ȼ�еȺţ��Ⱥ����Ϊ�����ұ�Ϊֵ
								if( $isFirst == false )
										$sql .= ' and ';//��������and��
								$sql .= $this->security->sqlEncode($key)." = '".$this->security->sqlEncode($value)."' ";
								$isFirst = false;
						}
				}
				$query = mysqli_query($db,$sql);
				if( $query == false ){
					//	$this->close($db);
						return array(
										'code'=>1,
										'msg'=>'ִ��sql���ʧ�� '.$sql,
										'data'=>''
									);
				}

				$data = array();
				while( $singleData = mysqli_fetch_array($query,MYSQL_ASSOC) ){//һ�μ�һ��
						//singleData is an array
						$data[] = $singleData;//��������
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
												'msg'=>'ִ��sql���ʧ�� '.$sql,
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
										'msg'=>'ִ��sql���ʧ�� '.$sql,
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
										'msg'=>'ִ��sql���ʧ�� '.$sql,
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
