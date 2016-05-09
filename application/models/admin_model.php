<?php
class Admin_model extends CI_Model
{

	
	/** 
     * Authenticate administrator
     * @access public 
     * @param  string - $username
     * @param  string - $password
     * @return array()
     */
    function authenticate($email = NULL, $password = NULL)
    {
   
    
    	if($email != NULL && $password != NULL)
    	{
    	
	    	$conditions = array("Email"=>$email,"Password"=>$this->encrypt->sha1($password));
	    	$this->db->select('AdminId,UserName,RecordsPerPage,Email')->from('admin')->where($conditions);
	        $query = $this->db->get();
	       
	        $admin = $query->result_array();
	        
	        if(!empty($admin))
	        	return $admin[0];
	        else
	        	return array();
    	}
    	else 
    	{
    		return array();
    	}
    }
    
	/** 
     * This Function Return Number Of Records Per Page
     * @access public 
     * @param array - $AdminId - field name & value
     * @return array()
     */
    function get_records_per_page($AdminId)
    {
    	$this->db->select('RecordsPerPage');
		$this->db->from('admin');
		$this->db->where('AdminId',$AdminId);
		$query = $this->db->get();
		
		return $query->result_array();
    }
    
/**
	 * Function For Check Is Login Or not
	 * @access public
	 * @param string - $search
	 */
	
	function isLogin()
	{
		if($this->session->userdata('AdminId'))
		{
			return true;
		}
		else
		{
			$this->message_stack->add_message('message','User Name Or Password Require ');
			$url=base_url().'admin';
			redirect($url);
		}
	}
	
	
	/**
	 * Function To Set Record Per Page Data 
	 * @access public
	 * @param $action
	 * @return void()
	 * @author mahesh
	 */
	function record_per_page()
	{
		$this->isLogin();
		
		$data['RecordsPerPage'] = $_POST['page'];
		
		$data['AdminId'] = $this->session->userdata('AdminId');
		$this->update_record_per_page($data);
		
		$record_per_page = $this->get_records_per_page($data['AdminId']);
		$array_items = array("records_per_page"=>$record_per_page[0]['RecordsPerPage']);
		$this->session->set_userdata($array_items);
		redirect($_GET['action']);
	}
	
 /** 
     * Update Record Per page 
     * @access public 
     * @param array - $data - field name & value
     */
    function update_record_per_page($data)
    {
    	 $this->db->update('admin',$data,array('AdminId' =>$data['AdminId']));
    }
    
	/** 
     *  Forgot Password 
     * @access public 
     * @param array - $data - field name & value
     */
	function forgot_pass($data)
	{
		$query=$this->db->get_where('admin',array('Email' => $data['Email']));	
		
		return $query->result_array();
	}
	
 	/** 
     *  Get Admin Record By Id
     * @access public 
     * @param array - $data - field name & value
     */
	function get_data_by_id($admin_id)
	{
		$query=$this->db->get_where('admin',array('AdminId' => $admin_id));	
		return $query->result_array();
	}

	/**
	 * This Function Update's record
	 * @access public
	 * @param array - $data - field name & value
	 */
	function update($data)
	{
		$this->db->update('admin',$data, array('AdminId' => $data['AdminId']));	
	}
	
	/** 
     *  Update Password 
     * @access public 
     * @param array  - field name & value
     * )
     */
	function update_password($data)
	{
		$this->db->update('admin',$data, array('AdminId' => $data['AdminId']));	
	}
	
}
?>