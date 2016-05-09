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
 * YPM Initial Class
 *
 * A Project Management System
 *
 * @package		YPM
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Maulik
 */
class Initial {

	public $ci;
	
	public function __construct($params = array())
	{
		$this->ci = & get_instance();
		$this->ci->load->library("session");
		if(!empty($params))
		{
			$this->ci->load->model("initial_model","init",TRUE);
			$this->ci->init->initialize($params['table']);
		}	
	}

	/**
	 * Login user and redirect to the success url 
	 *
	 * @access	public
	 * @return	array
	 */
	public function login($username = NULL , $password = NULL , $select_fields = array() , $initital_fields = array())
	{
		if($username != NULL && $password != NULL)
		{
			$user = $this->ci->init->authenticate($username,$password,$select_fields,$initital_fields);
			if(!empty($user))
			{
				$this->ci->session->set_userdata($user);
				return true;
			}	
			else 
			{
				return false;
			}
			return false;
		}
		return false;
	}
	
	// --------------------------------------------------------------------
	
	/** 
    * logout
    * @access public
    * @return boolean
    * @author maulik
    */
	public function logout($select_fields = array())
	{
		if(empty($select_fields))
    	{
    	    $select_fields = array("id"=>"","username"=>"");
    	}
		$this->ci->session->unset_userdata($select_fields);
		return true;
	}
	
	/** 
    * Checks login status of user
    * @access public
    * @return boolean
    * @author maulik
    */
	public function is_loggedin($id = NULL)
	{
		if($id != NULL)
		{
			if($this->ci->session->userdata($id))
			{
				return true;	
			}
			return false;
		}
		return false;
	}
	
	/** 
     * Create user 
     * @access public 
     * @param  array  - user data
     * @param  string  - password field name
     * @return insert id
     * @author maulik
     */
    function create_user($user_data,$password,$created)
    {
    	if($id = $this->ci->init->save($user_data,$password,$created))
    		return $id;
    	else 
    		return false;
    }
    
	/** 
     * Update user 
     * @access public 
     * @param  array  - user data
     * @param  string  - password field name
     * @return insert id
     * @author maulik
     */
    function update_user($user_data,$fieldValue)
    {
    	if($this->ci->init->update($user_data,$fieldValue))
    		return true;
    	else 
    		return false;
    }
    
	/** 
     * Delete user 
     * @access public 
     * @param  array  - user data
     * @param  string  - password field name
     * @return insert id
     * @author maulik
     */
    function delete_user($fieldValue)
    {
    	if($this->ci->init->delete($fieldValue))
    		return true;
    	else 
    		return false;
    }
}
// END General class

/* End of file Initial.php */
/* Location: ./application/libraries/General */