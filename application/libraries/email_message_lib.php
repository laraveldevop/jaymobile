<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * YPM
 *
 * A Project Management System
 *
 * @package		YPM
 * @author		Maulik
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
 * @author		Maulik
 */
class Email_message_lib {

	/**
	 * Encode array or object in json 
	 *
	 * @access	public
	 * @return	array
	 */
	public function message_lib($user_detail)
	{
	      $message = '<table style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;">';
	      $message.='<tr><td >Dear User :- '.$user_detail['FirstName'].'</td></tr>';
	      $message.='<tr><td >Your User Name Is :- '.$user_detail['UserName'].'</td></tr>';
    	  $message .= '<tr><td >Your Login Password Is :- '.$user_detail['Password'].'</td></tr>';
							'</table>';
   	    	return $message;	
	}
		
	public function mail_send($to,$from,$subject,$message)
	{
		$CI = & get_instance();
		$CI->load->library("email");
		
		$CI->email->from($from);
		$CI->email->to($to);
		$CI->email->subject($subject);
		$CI->email->message($message);	
		
		if($CI->email->send())
        {
        	return true;          
        }
        else
        {
            return false;
        }
	}	
	
	// --------------------------------------------------------------------

}
// END General class

/* End of file General.php */
/* Location: ./application/libraries/General */