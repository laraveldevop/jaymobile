<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * YPM
 *
 * A Project Management System
 *
 * @package		YPM
 * @author		Mahesh
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * YPM General Class
 *
 * A Project Management System
 *
 * @package		YPM
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Mahesh
 */
class Forgot_password_lib {

	/**
	 * Encode array or object in json 
	 *
	 * @access	public
	 * @return	array
	 */
	public function forgot_password($model_name,$action)
	{
		$CI = & get_instance();
		$CI->load->library("encrypt");
			
		$data=$CI->input->post();	
		
		
		$CI->load->model($model_name);
		
		if(!empty($data))
		{
			
			$result=$CI->$model_name->forgot_pass($data);
			
			if(!empty($result))
			{
				$new_password = $this->_generatePassword();
				
				$_value['Password'] =$CI->encrypt->sha1($new_password);
				
				if($action=="admin")
				{
					$_value['AdminId'] = $result[0]['AdminId'];
				}
				else if($action=="user")
				{
					$_value['Id'] = $result[0]['Id'];
				}
			
				$CI->load->library("email_message_lib");	
			
				if($action=="admin")
				{
					$to=$result[0]['Email'];
				}
				else if($action=="user")
				{
					
					$to=$result[0]['UserName'];
				}
					
				$from=ADMIN_EMAIL_ID;
	   			$message = "your account's new password is : " . $new_password;
	   			$subject  = "Password retrival";
	   			
	  		    $email_send=$CI->email_message_lib->mail_send($to,$from,$subject,$message);
	  		
				if($email_send)
				{	
					$CI->$model_name->update_password($_value);
					$CI->message_stack->add_message('message','New Password Send To Your Mail Account Shortly.');
					$url=base_url().''.$action.'/forgot_password';
					redirect($url);
				}
				else
				{
					$CI->message_stack->add_message('message','Error in sending mail please try after some time. ');
					$url=base_url().''.$action.'/forgot_password';
					redirect($url);
				}				
			}
			else
			{
			
				$CI->message_stack->add_message('message','Wrong Email Id ');	
				$url=base_url().''.$action.'/forgot_password';
				redirect($url);
			}
		}
	}
	
	private function _generatePassword() 
    {
            $length = 10;
            $characters = "0123456789abcdefghijklmnopqrstuvwxyz";
            $string = "";    
       
            for ($p = 0; $p < $length; $p++) 
             {
                     $string .= $characters[mt_rand(0, strlen($characters)-1)];
             }
            return $string;
    }
    
    
	// --------------------------------------------------------------------

}
// END General class

/* End of file General.php */
/* Location: ./application/libraries/General */