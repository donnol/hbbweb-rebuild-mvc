<?php
require_once(dirname(__FILE__).'/../common/db.php');
class User{
		private $hasSessionStart = false;
		private $db;
		public function __construct(){
				$this->db = new DB();
		}
		private function beginSession(){
				if( $this->hasSessionStart == false )
						session_start();
				$this->hasSessionStart = true;
		}
		public function add($name,$password,$tel,$addr,$cert){
				$re = $this->db->select('t_user', array('name'=>$name));
				if($re['code'] != 0)
						return $re;

				if( count($re['data']) != 0){
						return array(
										'code'=>1,
										'msg'=>'name is already exists',
										'data'=>''
									);
				}
				else{
						return $this->db->insert('t_user',array(
												'name'=>$name,
												'pwd'=>sha1($password),
												'tel'=>$tel,
												'addr'=>$addr,
												'cert'=>$cert,
												));
				}
		}
		public function del($id){
				return $this->db->delete('t_user',array(
										'id'=>$id
										));
		}
		public function get(){
				return $this->db->select('t_user', array());
		}
		public function getone($id){
				return $this->db->select('t_user', array('id'=>$id,));
		}
		public function isLogin(){
				$this->beginSession();
				if (!isset ($_SESSION['shili']))
						return array(
										'code'=>1,
										'msg'=>'has not login',
										'data'=>''
									);
				return array(
								'code'=>0,
								'msg'=>'',
								'data'=>$_SESSION['shili']
							);
		}
		public function login($name,$password){
				$this->beginSession();
				$result = $this->db->select('t_user',array(
										'name'=>$name,
										'pwd'=>sha1($password)
										));
				if( $result['code'] != 0 )
						return $result;

				$users = $result['data'];
				if( count($users) == 0 )
						return array(
										'code'=>1,
										'msg'=>'name or password error',
										'data'=>''
									);

				$_SESSION['shili'] = $name;
				return array(
								'code'=>0,
								'msg'=>'',
								'data'=>''
							);
		}

		public function update($name,$tel,$addr,$cert,$id){
				$result = $this->db->select('t_user', array('id'=>$id));
				if($result['code'] != 0)
						return $result;
				$data = $result['data'];
				$tmp = $data[0];
				$oldname = $tmp['name'];
				if($oldname == $name)
						return  $this->db->update('t_user', array(
												'name'=>$name,
												'tel'=>$tel,
												'addr'=>$addr,
												'cert'=>$cert,
												), array(
														'id'=>$id,
														));


				//
				$re = $this->db->select('t_user', array('name'=>$name));
				if($re['code'] != 0)
						return $re;

				if( count($re['data']) != 0 ){
						return array(
										'code'=>1,
										'msg'=>'name is already exist.',
										'data'=>''
									);
				}
				else{
						return $this->db->update('t_user', array(
												'name'=>$name,
												'tel'=>$tel,
												'addr'=>$addr,
												'cert'=>$cert,
												), array(
														'id'=>$id,
														));
				}
		}

		public function logout(){
				$this->beginSession();
				session_destroy();
		}
};
?>
