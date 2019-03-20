<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Trading_model extends CI_Model {

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

//////////////////////////////////////////// Get Trading Account By Name //////////////////////////////////////////////////////////////////
	
function getTradingAccountName($trading_account)
{
	$account=$this->db->get_where('user_temp', array('id' => $trading_account))->row();
	if($account){
	return $account->account_name;
 }else{
	   return false;
	   }
 }

////////////////////////////////////////////// Get All Trading Accounts  /////////////////////////////////////////////////////////////////////////

 function getTradingAccounts()
 {
	$this->db->select('*');
	$this->db->from('user_temp');
	$this->db->where('trash',0);
	return $this->db->get()->result_array();
 }
 
 ////////////////////////////////////////////////////// Add Trading Account ////////////////////////////////////////////////////////////////
 
 function addNewTradingAccount($data)
 {
	 
 	 return $this->db->insert('user_temp', $data);
	 
 }
 
//////////////////////////////////////////////////// Get Trading Account ///////////////////////////////////////////////////////////////////////// 
 
function getTradingAccount($trading_account)
{   
	$account=$this->db->get_where('user_temp', array('id' => $trading_account))->row();
	if($account){
	return $account;
 }else{
	   return false;
	   }
}
 
////////////////////////////////////////////////// Update Trading Account ////////////////////////////////////////////////////////////////////

 public function update_tradingAccount($id,$data)
  {
		 $this->db->where('id', $id);
         return $this->db->update('user_temp', $data);
		 
  }
  
//////////////////////////////////////////////// Delete Trading Account ///////////////////////////////////////////////////////////////////

  public function delete_tradingAccount($id,$data)
	   {
		 $this->db->where('id', $id);
         return $this->db->update('user_temp', $data);
		 
		}   

}	
