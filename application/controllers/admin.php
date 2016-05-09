<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class Admin extends CI_Controller
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
	//	$this->load->model("programs_model","programs",true);
	//	$this->load->model("trainee_program_model","trainee_program",true);
	//	$this->load->model("program_comments_model","program_comments",true);
	}

	function index()
	{
		if($this->session->userdata('AdminId'))
		{
			$url=base_url().'employee/view_all';
			redirect($url);
		}

		$this->load->view("admin1/login");
	}

	function login()
	{

		$email = $this->input->post('EmailId');
		$password = $this->input->post('Password');


		if($email != "" && $password != "")
		{

			$admin = $this->admin->authenticate($email, $password);

			if(!empty($admin))
			{
				$this->session->set_userdata($admin);
				$url= base_url().'employee/view_all';
				redirect($url);
			}
			else
			{
				$this->message_stack->add_message('message', 'User Name Or Password Incorrect');
				$url= base_url().'admin';
				redirect($url);
			}
		}
			//redirect('/admin/');
	}

	/**
	 * Function for Forgot Password
	 * @access public
	 * @return void()
	 * @author mahesh
	 */
	function forgot_password()
	{
		$this->load->library("forgot_password_lib");

		$model_name = "admin_model";
		$action = "admin";
		$this->forgot_password_lib->forgot_password($model_name, $action);

		$this->load->view("admin/forgot_password");
	}

	/**
	 * Function for Profile
	 * @access public
	 * @return void()
	 * @author manish
	 */
	function profile()
	{
		$this->admin->isLogin();
		$AdminId = $this->session->userdata('AdminId');

		$profile_data['profile'] = $this->admin->get_data_by_id($AdminId);
		$this->load->view('admin/edit_profile', $profile_data);

		$data = $this->input->post();

		if(!empty($data))
		{
			if($data['Password'] == $data['ConfirmPassword'])
			{
				unset($data['Update']);
				unset($data['ConfirmPassword']);

				if($data['Password'] == NULL)
				{
					unset($data['Password']);
				}
				else
				{
					$data['Password'] = $this->encrypt->sha1($data['Password']);
				}

				$data['AdminId'] = $this->session->userdata('AdminId');
				$this->admin->update($data);

				$this->message_stack->add_message('message', 'Profile Update Successfully');
				$url = base_url().'admin/profile';
				redirect($url);
			}
			else
			{
				$this->message_stack->add_message('message', "New Password And Confirm Password Not Match");
				$url = base_url().'admin/profile';
				redirect($url);
			}
		}
	}

	function sign_out()
	{

		$this->admin->isLogin();

		$array_items = array('AdminId' => '', 'UserName' => '','RecordsPerPage'=>'','Email'=>'');
		$this->session->unset_userdata($array_items);
		$this->message_stack->add_message('message','Log Out Successfully ');

		$url=base_url().'admin';
		redirect($url);
	}


}
?>