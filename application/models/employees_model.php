<?php

class Employees_model extends CI_Model
{
 	function __construct()
    {
	    // Call the Model constructor
        parent::__construct();
      	$this->load->library("encrypt");
    }
    
    
	/** 
     * Authenticate user For Front Side
     * @access public 
     * @param  string - $username
     * @param  string - $password
     * @return array()
     */
    function authenticate($username = NULL, $password = NULL)
    {
    	if($username != NULL && $password != NULL)
    	{
	    	$conditions = array("UserName"=>$username,"Password"=>$this->encrypt->sha1($password),"DeletedAt"=>"");
	    	
	    	$this->db->select('Id,UserName,FirstName,LastName,Status,RecordsPerPage')->from('employees')->where($conditions);
	    	
	        $query = $this->db->get();
	        $user = $query->result_array();
	      
	        if(!empty($user))
	        	return $user[0];
	        else
	        	return array();
    	}
    	else 
    	{
    		return array();
    	}
    }
    

	/**
	 * Function To Get User Status
	 * @access public
	 * @param array - $id - field name & value
	 * @return array()
	 */
	function get_status($id)
	{
		$this->db->select('Status');
		$query=$this->db->get_where('employees', array("Id"=>$id));
		return $query->row_array();
	}
	
	/**
	 * Function To Update User Status
	 * @access public
	 * @param array - $data - field name & value
	 */
	function update_status($data)
	{
		$this->db->update('employees', $data, array('Id' => $data['Id']));	
	}
	
	/**
	 * Function For Delete Single User Record By Id
	 * @access public
	 * @param integer - $id
	 */
    function delete_by_id($id)
	{
	
		$user_detail['DeletedAt'] = date("Y-m-d");
		$this->db->where_in('Id',$id);
		$this->db->update("employees",$user_detail);
	} 
	
	/**
	 * Function To Get Status by Get By Id
	 * @access public
	 * @param array - $id
	 */
	function get_by_id($id)
	{
	
		$this->db->select('*');
		$query=$this->db->get_where('employees', array('Id'=>$id));
		return $query->result_array();
	}
	
	/**
	 * Function To Get  Insert Detail 
	 * @access public
	 * @param array - $id
	 */
	function insert_detail($detail)
	{
		$this->db->insert("employees", $detail);
		return $this->db->insert_id(); 
	}
	
/**
	 * Function To Update User Status
	 * @access public
	 * @param array - $data - field name & value
	 */
	function update_detail($data)
	{
		$this->db->update('employees', $data, array('Id' => $data['Id']));	
	}
	
	
/**
	 * Function For Search User Record
	 * @param string - $search
	 * @param integer - $limit
	 * @param string - $sort_by
	 * @param string - $sort_order
	 * @param integer - $offset
	 * @return array()
	 */
	function get_all_data($search,$limit, $sort_by, $sort_order, $offset)
	{
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('Id', 'ShopName', 'FirstName', 'LastName','Status');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'Id';
	
		$data = array(
			'ShopName' => $search,
			'FirstName' => $search,
			'LastName' => $search,
		);
			
		$this->db->select('*');
		$this->db->from('employees');
		$where="`DeletedAt` = '' AND (`ShopName` LIKE '$search%%' OR `FirstName` LIKE '$search%%' OR `LastName` LIKE '$search%%')";
		$this->db->where($where);	
		//$this->db->or_like($data);
		$this->db->limit($limit, $offset);
		$this->db->order_by($sort_by, $sort_order);
		$query = $this->db->get();
		
		return $query->result_array();
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
		
		$data['Id'] = $this->session->userdata('Id');
		$this->update_record_per_page($data);
		
		$record_per_page = $this->get_records_per_page($data['Id']);
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
    	 $this->db->update('employees',$data,array('Id' =>$data['Id']));
    }
    
	/** 
     * This Function Return Number Of Records Per Page
     * @access public 
     * @param array - $AdminId - field name & value
     * @return array()
     */
    function get_records_per_page($Id)
    {
    	$this->db->select('RecordsPerPage');
		$this->db->from('employees');
		$this->db->where('Id',$Id);
		$query = $this->db->get();
		return $query->result_array();
    }
    
	
	/**
	 * Function For Count Number Of Rows
	 * @access public
	 * @param string - $search
	 */
	function num_rows($search)
	{
		$data = array('ShopName' => $search,'FirstName' => $search,'LastName' => $search);
		
		$this->db->select('*');
		$this->db->from('employees');
		$where="`DeletedAt` = '' AND (`ShopName` LIKE '$search%%' OR `FirstName` LIKE '$search%%' OR `LastName` LIKE '$search%%')";
		$this->db->where($where);	
		$query = $this->db->get();
		
		return $query->num_rows;
	}
	
	/**
	 * Function For Check Is Login Or not
	 * @access public
	 * @param string - $search
	 */
	
	function isLogin()
	{
		if($this->session->userdata('Id'))
		{
			return true;
		}
		else
		{
			$this->message_stack->add_message('message','User Name Or Password Require ');
			$url=base_url().'user';
			redirect($url);
		}
	}
	
	
	/** 
     *  Forgot Password 
     * @access public 
     * @param array - $data - field name & value
     */
	function forgot_pass($data)
	{
		$query=$this->db->get_where('employees',array('UserName' => $data['Email']));	
		
		return $query->result_array();
	}
	
	/** 
     *  Update Password 
     * @access public 
     * @param array  - field name & value
     * )
     */
	function update_password($data)
	{
		$this->db->update('employees',$data, array('Id' => $data['Id']));	
	}
	
	/**
	 * Function To Serch Employees by name
	 * @access public
	 * @param array - $emp_detail - field name & value
	 */
	function get_detail_by_employeename($employee_name)
	{
		$company_details["EmployeeName"] = trim($employee_name);
		//$query = $this->db->get_where('schools', array('SCHNAM' =>$user_details["Name"]));
		
		$this->db->select('FirstName,LastName,Id');
		$this->db->from('employees');
		$this->db->like("FirstName",$company_details["EmployeeName"]);
		$this->db->or_like("LastName",$company_details["EmployeeName"]);
		$this->db->where("DeletedAt","");
		$this->db->limit("5");
		
		$query=$this->db->get();
		
		$data = $query->result_array();
		
		return $data;		
	}
	
	public function search($EmployeeName)
	{
		$company_data = $this->get_detail_by_employeename($EmployeeName);
		$response['results'] = array();
		$i=0;
		
		foreach($company_data as $company) {
			$response['results'][$i]['id'] = $company['Id'];
			$response['results'][$i]['value'] = $company['FirstName']." ".$company['LastName'];
			$i++;
		}		
		return $response;
	}
	
	function get_detail_by_name($employee_detail)
	{
		$query=$this->db->get_where('employees',array('FirstName' => $employee_detail['FirstName'],'LastName' => $employee_detail['LastName'],'DeletedAt'=>""));	
		return $query->result_array();
		
	}
	
/**
	 * Function To Get Status by Get By Id
	 * @access public
	 * @param array - $id
	 */
	function get_name_by_id($id)
	{
	
		$this->db->select('FirstName,LastName');
		$query=$this->db->get_where('employees', array('Id'=>$id));
		$employee_detail=$query->result_array();
		foreach($employee_detail as $employee_name)
		{
			return $employee_name['FirstName'].' '.$employee_name['LastName'];	
			//exit;
		}
	}
	
    
	
}
?>