<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		  $config = Array(
		  'protocol' => 'smtp',
		  'smtp_host' => 'ssl://smtp.googlemail.com',
		  'smtp_port' => 465,
		  'smtp_user' => 'piyushrdc07@gmail.com', // change it to yours
		  'smtp_pass' => 'M_POwer12', // change it to yours
		  'mailtype' => 'html',
		  'charset' => 'iso-8859-1',
		  'wordwrap' => TRUE
			);
	 
		  $this->load->library('email', $config);
		  $this->email->set_newline("\r\n");
		  $this->email->from('piyushrdc07@gmail.com'); // change it to yours
		  $this->email->to('piyushv@yudiz.com'); // change it to yours
		  $this->email->subject('Email using Gmail.');
		  $this->email->message('Working fine ! !');
	 
		  if($this->email->send())
		  {
		  		echo 'Email sent.';
		  }
		  else
		 {
		 		show_error($this->email->print_debugger());
		 }
	}
	
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */