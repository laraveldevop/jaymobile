<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Prowl_test extends CI_Controller
{
 	function index()
 	{
		// Required.
 		//$config['username'] = 'KanyeWest';
 		//$config['password'] ='douch3b4g1977';
		$config['apikey'] = 'aa61bb6859d690c5399ff956a0c1eaf034ea4d0d';
		
		// Optional. Defaults to CI Prowl.
		$config['application'] = "Kanye's Calender";
		
		$this->load->library('prowl', $config);
		
		$result = $this->prowl->send('Reminder', 'Be an idiot in public.');
		
		print_r($result);
 	}
}

?>