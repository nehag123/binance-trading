<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class User_model extends CI_Model {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	/**
	 * create_user function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @param mixed $email
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function create_user($username, $email, $user_role, $password,$trading_account) {
		
		$data = array(
			'username'   => $username,
			'email'      => $email,
			'user_role'      => $user_role,
			'password'   => $this->hash_password($password),
			'trading_account' =>$trading_account,
			'created_at' => date('Y-m-j H:i:s')
		);
		
		return $this->db->insert('users', $data);
		
	}
	
	/**
	 * 
	 * Update user
	 * 
	 **/
	 
	 public function update_user($id,$data)
	 {
		 $this->db->where('id', $id);
         return $this->db->update('users', $data);
		 
		}
		
	/*
	 * delete user
	 * 
	 */
	 
	 	public function delete_user($id,$data)
	   {
		 $this->db->where('id', $id);
         return $this->db->update('users', $data);
		 
		}
	
	/**
	 * resolve_user_login function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function resolve_user_login($username, $password) {
		
		$this->db->select('password');
		$this->db->from('users');
		$where=array('username'=>$username,'trash !='=>1);
		$this->db->where($where);
		$hash = $this->db->get()->row('password');
	   return $this->verify_password_hash($password, $hash);
		
	}
	
	/**
	 * get_user_id_from_username function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_user_id_from_username($username) {
		
		$this->db->select('id');
		$this->db->from('users');
		$this->db->where('username', $username);

		return $this->db->get()->row('id');
		
	}
	
	/**
	 * Get all users
	 **/
	
	public function get_user_list() {
		
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('trash', 0);
       return $this->db->get()->result_array();
		
	}
	
	
	/**
	 * get_user function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user($user_id) {
		
		$this->db->from('users');
		$this->db->where('id', $user_id);
		return $this->db->get()->row();
		
	}
	
	/**
	 * hash_password function.
	 * 
	 * @access private
	 * @param mixed $password
	 * @return string|bool could be a string on success, or bool false on failure
	 */
	private function hash_password($password) {
		
		return password_hash($password, PASSWORD_BCRYPT);
		
	}
	
	/**
	 * verify_password_hash function.
	 * 
	 * @access private
	 * @param mixed $password
	 * @param mixed $hash
	 * @return bool
	 */
	private function verify_password_hash($password, $hash) {
		
		return password_verify($password, $hash);
		
	}
	
	/**
	 *  Get all trading accounts
	 * 
	 * */
	
   public function getAllTradingAccounts(){
	 
	 	$this->db->select('id,account_name');
		$this->db->from('user_temp');
		return $this->db->get()->result_array();
		
	 
	 }	
	
}
