<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Message Stack
 *
 * @package		Libraries
 * @author		Maulik
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Message Stack
 *
 * @package		Libraries
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Maulik
 */
class Message_stack {

	private $_CI;
	private $_message;
	private $_key_token = "MSG_STACK_";
	
	public function __construct()
	{
		$this->CI = & get_instance();
		$this->CI->load->library("session");
	}
	
	/**
	 * Add Messages To Message Stack 
	 *
	 * @access	public
	 * @param   string [message key]
	 * @param   string [message]
	 * @return	void
	 */
	public function add_message($message_key = NULL , $message = NULL)
	{
		if($message_key != NULL && $message != NULL)
		{
			$this->CI->session->set_userdata(array($this->_key_token.$message_key=>$message));
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Read Messages From Message Stack 
	 *
	 * @access	public
	 * @param   string [message key]
	 * @return	string [message]
	 */
	public function message($message_key = NULL)
	{
		if($message_key != NULL)
		{
			$this->_message = $this->CI->session->userdata($this->_key_token.$message_key);
			//remove message from session
			$this->CI->session->unset_userdata($this->_key_token.$message_key);
			return $this->_message;
		}
	}
	
	// --------------------------------------------------------------------

}
// END General class

/* End of file Message_stack.php */
/* Location: ./application/libraries/Message_stack.php */