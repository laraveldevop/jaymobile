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
class GeneralDB {

	public $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->model("general_model","general_m",TRUE);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Task Catagory For Creating Select Element In HTML
	 *
	 * @access	public
	 * @return	array
	 */
	public function get_task_catagory_for_select($project_id = array())
	{
		//$this->CI->load->model("general_model","general",TRUE);
		$this->CI->general_m->set_table("task_categories");
		$records = $this->CI->general_m->get(array("id","name"),$project_id);
		$task_catagories = array();
		foreach($records as $record)
		{
			$task_catagories[$record['id']] = $record['name'];
		}
		return $task_catagories;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Project List For Creating Select Element In HTML
	 *
	 * @access	public
	 * @param   number - user id
	 * @return	array
	 */
	public function get_project_for_select($user_id)
	{
		$this->CI->general_m->set_table("projects");
		$records = $this->CI->general_m->get(array("id","name"),array("assignTo REGEXP"=>"[[:<:]]{$user_id}[[:>:]]"));
		$projects = array();
		foreach($records as $record)
		{
			$projects[$record['id']] = $record['name'];
		}
		return $projects;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Project Catagory For Creating Select Element In HTML
	 *
	 * @access	public
	 * @return	array
	 */
	public function get_project_catagory_for_select()
	{
		$this->CI->general_m->set_table("project_categories");
		$records = $this->CI->general_m->get(array("id","name"));
		$project_catagories = array();
		foreach($records as $record)
		{
			$project_catagories[$record['id']] = $record['name'];
		}
		return $project_catagories;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Add activities
	 *
	 * @access public
	 * @parama $project_id    - project id
	 * @params $activity_type - activity type
	 * @params $type_id       - activity type id 
	 * @params $description   - avtivity description
	 * @params $status        - activity status
	 * @params $for           - activity for
	 * @params $forId         - activity for id
	 * @params $path          - path for file activity
	 * @return void
	 */
	public function add_activity($project_id,$activity_type,$type_id,$descrpition,$status,$for = '0',$forId = 0,$path = NULL)
	{
		$this->CI->load->model("general_model");
		$this->CI->load->model("activities_model","activity");
		if($project_id != NULL && $activity_type != NULL && $type_id != NULL)
		{
			$activity_data['userId'] = $this->CI->session->userdata("id");
			$activity_data['projectId'] = $project_id;
			$activity_data['type'] = $activity_type;
			$activity_data['typeId'] = $type_id;
			$activity_data['description'] = $descrpition;
			$activity_data['status'] = $status;
			$activity_data['for'] = $for;
			$activity_data['forId'] = $forId;
			$activity_data['path'] = $path;
			$activity_data['createdDate'] = date('Y-m-d');
			$activity_data['createdTime'] = date('H:i:s');
			
			$this->CI->activity->save($activity_data);
		}
	}
	
	// --------------------------------------------------------------------
	
	

}
// END General class

/* End of file General.php */
/* Location: ./application/libraries/General */