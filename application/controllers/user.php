<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller 
{

	public function __construct()
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
	
		$this->load->model("employees_model","employees",true);
	}
	
	/** 
    * Index function
    * @access public
    * @return void()
    * @author mahesh
    */
	public function index()
	{	
		$this->load->view('user/index');
	}
	
	public function hasfor()
	{
		echo "test";
	}
	
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */