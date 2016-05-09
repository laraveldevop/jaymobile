<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class Employee extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->database();
		$this->load->library('Native_Session');
		$this->load->library('Session');
		$this->load->library('Message_stack');
		$this->load->library('email');
		$this->load->library("encrypt");
				
		//load all models
		$this->load->model("admin_model","admin",true);
		$this->load->model("employees_model","employees",true);
		$this->load->model("item_model","item",true);
	}

	function view_all()
	{
		$this->admin->isLogin();
		$AdminId = $this->session->userdata('AdminId');
		
		$record_per_page = $this->admin->get_records_per_page($AdminId);
		
		$limit = $record_per_page[0]['RecordsPerPage'];

		if($_GET['action'] == "show_all")
		{
			$this->session->unset_userdata('search_result');
		}

		$array_items = array("sort_by"=>$_GET['sort_by'],"sort_order"=>$_GET['sort_order'],"per_page"=>$_GET['per_page']);
		$this->session->set_userdata($array_items);
		
		$config['page_query_string'] = TRUE;
		$config['base_url'] = base_url()."employee/view_all?sort_by=".$_GET['sort_by']."&sort_order=".$_GET['sort_order'];
		$this->load->library('pagination');
		$config['per_page'] = $limit;
		
		if($this->input->post('search_data') != NULL)
		{
			$this->session->set_userdata('search_result', $this->input->post('search_data'));
		}
		
		if($this->session->userdata('search_result'))
		{
			$search = $this->session->userdata('search_result');
		}
		else
		{
			$search = "";
		}
		
		//get user all data
		$data['employees'] = $this->employees->get_all_data($search, $limit, $_GET['sort_by'], $_GET['sort_order'], $_GET['per_page']);
		
		$config['total_rows'] = $this->employees->num_rows($search);
		$this->pagination->initialize($config);
		
		$data['per_page'] = $_GET['per_page'];
		$data['sort_by'] = $_GET['sort_by'];
		$data['sort_order'] = $_GET['sort_order'];
		$data['search'] = $search;
		
		$this->load->view('admin/view_employees', $data);
	}
	
	function view_item()
	{
		$this->admin->isLogin();
		$AdminId = $this->session->userdata('AdminId');
		
		$userData['UserId'] = $_GET['UserId'];
		$this->session->set_userdata($userData);
		
		$record_per_page = $this->admin->get_records_per_page($AdminId);
		
		$limit = $record_per_page[0]['RecordsPerPage'];

		if($_GET['action'] == "show_all")
		{
			$this->session->unset_userdata('search_result');
		}

		$array_items = array("sort_by"=>$_GET['sort_by'],"sort_order"=>$_GET['sort_order'],"per_page"=>$_GET['per_page']);
		$this->session->set_userdata($array_items);
		
		$config['page_query_string'] = TRUE;
		$config['base_url'] = base_url()."employee/view_item?sort_by=".$_GET['sort_by']."&sort_order=".$_GET['sort_order'];
		$this->load->library('pagination');
		$config['per_page'] = $limit;
		
		if($this->input->post('search_data') != NULL)
		{
			$this->session->set_userdata('search_result', $this->input->post('search_data'));
		}
		
		if($this->session->userdata('search_result'))
		{
			$search = $this->session->userdata('search_result');
		}
		else
		{
			$search = "";
		}
		
		//get user all data
		$data['employees'] = $this->item->get_all_data($search, $limit, $_GET['sort_by'], $_GET['sort_order'], $_GET['per_page'],$this->session->userdata('UserId'));
		
		$config['total_rows'] = $this->item->num_rows($search,$this->session->userdata('UserId'));
		$this->pagination->initialize($config);
		
		$data['per_page'] = $_GET['per_page'];
		$data['sort_by'] = $_GET['sort_by'];
		$data['sort_order'] = $_GET['sort_order'];
		$data['search'] = $search;
		
		$this->load->view('admin/view_items', $data);
	}
	
	/**
	 * This Function Is Used To Change Status
	 * @access public
	 * @param $id is used to change status of that record by clicking on image
	 * @return void()
	 * @author Piyush
	 */
	function change_status()
	{
		$this->admin->isLogin();
		
		if(isset($_GET['id']))
		{
		
			$result = $this->employees->get_status($_GET['id']);
			
			if($result['Status'] == '0')
			{
				$data['Status'] = '1';
			}
			else if($result['Status'] == '1')
			{
				$data['Status'] = '0';
			}
	
			$data['Id'] = $_GET['id'];
	
			$sort_by = $this->session->userdata('sort_by');
			$sort_order = $this->session->userdata('sort_order');
			$per_page = $this->session->userdata('per_page');
	
			$this->employees->update_status($data);
			$this->message_stack->add_message('message', 'Employee Status Change Successfully');
	
			redirect('employee/view_all?sort_by='.$sort_by.'&sort_order='.$sort_order.'&per_page='.$per_page);
		}
	}
	
	function delete_record()
	{
		$this->admin->isLogin();
		
		$this->employees->delete_by_id($_GET['UserId']);
		
		$sort_by = $this->session->userdata('sort_by');
		$sort_order = $this->session->userdata('sort_order');
		$per_page = $this->session->userdata('per_page');
			
		$this->message_stack->add_message('message', 'Delete Record Successfully');
		redirect('employee/view_all?sort_by='.$sort_by.'&sort_order='.$sort_order.'&per_page='.$per_page);
	}
	
	
	/**
	 * This Function Is Used To Delete Multiple Records of employee
	 * @access public
	 * @return void()
	 * @author Piyush
	 */
	function delete_multi()
	{
		$this->admin->isLogin();
		
		$user_ids = $this->input->post('user_id');
		$this->employees->delete_by_id($user_ids);
		
		$sort_by = $this->session->userdata('sort_by');
		$sort_order = $this->session->userdata('sort_order');
		$per_page = $this->session->userdata('per_page');
		
		$this->message_stack->add_message('message', 'Delete Records Successfully');
		redirect('employee/view_all?sort_by='.$sort_by.'&sort_order='.$sort_order.'&per_page='.$per_page);
	}
	
	/**
	 * This Function Is Used To Change Status
	 * @access public
	 * @param $id is used to change status of that record by clicking on image
	 * @return void()
	 * @author Piyush
	 */
	function change_status_item()
	{
		$this->admin->isLogin();
		$userData['UserId'] = $_GET['UserId'];
		$this->session->set_userdata($userData);
		
		if(isset($_GET['id']))
		{
		
			$result = $this->item->get_status($_GET['id'],$this->session->userdata('UserId'));
			
			if($result['Status'] == '0')
			{
				$data['Status'] = '1';
			}
			else if($result['Status'] == '1')
			{
				$data['Status'] = '0';
			}
	
			$data['Id'] = $_GET['id'];
	
			$sort_by = $this->session->userdata('sort_by');
			$sort_order = $this->session->userdata('sort_order');
			$per_page = $this->session->userdata('per_page');
	
			$this->item->update_status($data,$this->session->userdata('UserId'));
			$this->message_stack->add_message('message', 'Employee Item Status Change Successfully');
	
			redirect('employee/view_item?UserId='.$this->session->userdata('UserId').'&Id='.$data['Id']);
		}
	}
	
	function delete_record_item()
	{
		$this->admin->isLogin();
		$userData['UserId'] = $_GET['UserId'];
		$this->session->set_userdata($userData);
		
		$this->item->delete_by_id($_GET['Id']);
		
		$sort_by = $this->session->userdata('sort_by');
		$sort_order = $this->session->userdata('sort_order');
		$per_page = $this->session->userdata('per_page');
			
		$this->message_stack->add_message('message', 'Delete Record Successfully');
		redirect('employee/view_item?UserId='.$this->session->userdata('UserId'));
	}
	
	
	/**
	 * This Function Is Used To Delete Multiple Records of employee
	 * @access public
	 * @return void()
	 * @author Piyush
	 */
	function delete_multi_item()
	{
		$this->admin->isLogin();
		$userData['UserId'] = $_GET['UserId'];
		$this->session->set_userdata($userData);
		
		$user_ids = $this->input->post('user_id');
		$this->item->delete_by_id($user_ids);
		
		$sort_by = $this->session->userdata('sort_by');
		$sort_order = $this->session->userdata('sort_order');
		$per_page = $this->session->userdata('per_page');
		
		$this->message_stack->add_message('message', 'Delete Records Successfully');
		redirect('employee/view_item?UserId='.$this->session->userdata('UserId'));
	}
	
	function record_per_page()
	{
		$this->admin->record_per_page();
	}
	
	/**
	 * This Function Is for Add and Update User Record
	 * @access public
	 * @param $userid is used when admin want to update user record
	 * @return void()
	 * @author Piyush
	 */
	function add()
	{
		$this->admin->isLogin();
		
		$user_detail = $this->input->post();
		
		if($user_detail['Save'])
		{
			unset($user_detail['Save']);
			unset($user_detail['ConfirmPassword']);
			unset($user_detail['Id']);
		
			if($user_detail['Password1'] == NULL)
			{
				unset($user_detail['Password1']);
			}
			else
			{
				$user_detail["Password"] = $this->encrypt->sha1($user_detail["Password1"]);
				unset($user_detail["Password1"]);
			}
			
			$user_detail['CreatedAt '] = date('Y-m-d H:i:s',time());
			
			$this->employees->insert_detail($user_detail);
			$this->message_stack->add_message('message', 'New Employee Added Successfully ');
			redirect(base_url().'employee/view_all');		
		}
		else if($user_detail['Update'])
		{
			unset($user_detail['Update']);
			unset($user_detail['ConfirmPassword']);
			
			if($user_detail['Password'] == NULL)
			{
				unset($user_detail['Password']);
			}
			else 
			{
				$user_detail["Password"] = $this->encrypt->sha1($user_detail["Password"]);
			}
			
			$sort_by = $this->session->userdata('sort_by');
			$sort_order = $this->session->userdata('sort_order');
			$per_page = $this->session->userdata('per_page');
		
			$this->employees->update_detail($user_detail);
			$this->message_stack->add_message('message', ' Employee Updated Successfully ');
			redirect(base_url().'employee/view_all?sort_by='.$sort_by.'&sort_order='.$sort_order.'&per_page='.$per_page);				
		}
		
		$data['user_detail']=$this->employees->get_by_id($this->input->get('UserId'));
		
		$this->load->view('admin/add_employee', $data);
	}
	
	/**
	 * This Function Is for Add and Update User Record
	 * @access public
	 * @param $userid is used when admin want to update user record
	 * @return void()
	 * @author Piyush
	 */
	function add_item()
	{
		$this->admin->isLogin();
		
		$user_detail = $this->input->post();
		$userData['UserId'] = $_GET['UserId'];
		$this->session->set_userdata($userData);
		
		if($user_detail['Save'])
		{
			unset($user_detail['Save']);
			unset($user_detail['Id']);
			
			$user_detail['UserId '] = $this->session->userdata('UserId');
			$user_detail['CreatedAt '] = date('Y-m-d H:i:s',time());
			
			$this->item->insert_detail($user_detail);
			$this->message_stack->add_message('message', 'New Employee Item Added Successfully ');
			redirect(base_url().'employee/view_item?UserId='.$this->session->userdata('UserId'));
		}
		else if($user_detail['Update'])
		{
			unset($user_detail['Update']);
			
			$sort_by = $this->session->userdata('sort_by');
			$sort_order = $this->session->userdata('sort_order');
			$per_page = $this->session->userdata('per_page');
		
			$this->item->update_detail($user_detail);
			$this->message_stack->add_message('message', ' Employee Item Updated Successfully ');
			redirect(base_url().'employee/view_item?UserId='.$this->session->userdata('UserId'));				
		}
		
		$data['user_detail']=$this->item->get_by_id($this->input->get('Id'));
		
		$this->load->view('admin/add_item', $data);
	}
	
	public function searchEmployee()
	{
		$EmployeeName = $_GET['EmployeeName'];
		$response = $this->employees->search($EmployeeName);
		echo json_encode($response);
	}
	

}
?>