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
class General {

	/**
	 * Encode array or object in json 
	 *
	 * @access	public
	 * @param   array - data
	 * @param   string - initial key
	 * @param   string - extra key
	 * @param   array - field selection
	 * @param   array - extra data to append
	 * @return	array
	 */
	public function encode_data_in_json($data = array(),$key = NULL,$extra_key = NULL,$selection = array(),$extra_data = array())
	{
		if($key != NULL)
			$data_as_json[$key] = array();
		else 
			$data_as_json = array();
			
		if(!empty($data))
		{
			foreach ($data as &$val)
			{
				//append extra data
				if(!empty($extra_data))
				{
					foreach ($extra_data as $k=>$v)
					{
						$val[$k] = $v;
					}
				}
				//end
				
				if(!empty($selection))
					$temp = elements($selection,$val);
				else 	
					$temp = $val;
					
				if($key != NULL)
					$data_as_json[$key][] = $temp;
				else 
					$data_as_json[] = $temp;
			}
				
			if($extra_key != NULL)
				$data_as_json[$extra_key] = $data_as_json;	
			
			return json_encode($data_as_json);
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Clear all files which is in given folder 
	 *
	 * @access	public
	 * @param   string - folder path
	 * @return	boolean
	 */
	public function clear_files($folder_path = NULL)
	{
		if($folder_path != NULL)
		{
			if(is_dir($folder_path))
			{
				$files = get_filenames($folder_path,TRUE);
				if(!empty($files))
				{
					foreach($files as $file)
					{
						if(file_exists($file))
							unlink($file);
					}
				}
			}
			return true;
		}
		return false;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete Attachment File 
	 *
	 * @access	public
	 * @param   number - project id
	 * @param   string - folder name
	 * @return	boolean
	 */
	public function delete_attachment($project_id = NULL , $folder_name = NULL , $file_name = NULL)
	{
		if($project_id != NULL && $folder_name != NULL && $file_name != NULL)
		{
			$dir_path = APPDIR . "/upload/" . $project_id . "/" . $folder_name . "/"; 
			if(is_dir($dir_path))
			{
				$file_path = $dir_path . $file_name;
				if(file_exists($file_path))
					unlink($file_path);
				return true;
			}
			return false;
		}
		return false;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get File Extension 
	 *
	 * @access	public
	 * @param   string - file name
	 * @return	boolean
	 */
	public function file_extension($file_name = NULL)
	{
		if($file_name != NULL)
		{
			return end(explode(".", $file_name));
		}
		return false;
	}
	
	// --------------------------------------------------------------------
	
	/** 
    * Sort Multiple Array
    * @access public
    * @return boolean
    * @author maulik
    */
	public function multi_array_sort(& $data,$field_name = NULL,$sort_flag = "asc")
	{
		$field_values = array();
		
		if(!empty($data) && $field_name != NULL)
		{
			foreach ($data as $key => $row) 
			{
				$field_values[$key]  = $row[$field_name]; 
			}
		
			if(strtolower($sort_flag) == "asc")
				$flag = SORT_ASC;
			else 
				$flag = SORT_DESC;
				
			array_multisort($field_values, $flag, $data);
			
			return true;
		}
		return false;
	}
	
	// --------------------------------------------------------------------
	
	/** 
    * Upload File From Input Stream
    * @access public
    * @return boolean
    * @author maulik
    */
	public function upload()
	{
		$CI = & get_instance();
		
		$input = fopen("php://input", "r");
        $temp = tmpfile();
		
		$realSize = stream_copy_to_stream($input, $temp);
        fclose($input);
        
        $temp_path = TEMP_UPLOAD_PATH;
        
        $file_name = $CI->input->get('qqfile');
        $folder_name = $CI->input->get('id');
    	//replace underscore with space	
        $file_name = str_replace(" ", "_", $file_name);
        
        $path = $temp_path.$file_name;
        
        $target = fopen($path, "w");        
        fseek($temp, 0, SEEK_SET);
        stream_copy_to_stream($temp, $target);
        fclose($target);

        return htmlspecialchars(json_encode(array('success'=>true)), ENT_NOQUOTES);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Preservs Last Cache File 
	 *
	 * @access	public
	 * @return	void()
	 */
	public function preserve_cache()
	{
		$i=0;
		$files = array();
		$dirs = get_filenames(APPDIR."cache/", TRUE);
		foreach ($dirs as $dir)
		{
			$files[$i]['name'] = basename($dir);
			$files[$i]['path'] = $dir; 
			$files[$i]['time'] = date ("F d Y H:i:s.", filemtime($dir));;
			$i++;
		}
		$i=0;
		$this->multi_array_sort($files,"time","desc");
		foreach ($files as $file)
		{
			if($i != 0)
			{
				if(file_exists($file['path']))
				{	//unlink($file['path']);
				}
			}
			$i++;
		}
		print_r($files);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Write Cache File 
	 *
	 * @access	public
	 * @param   string - output
	 * @param   string - action
	 * @return	void()
	 */
	public function write_cache($output=NULL,$action=NULL)
	{
		if($output != NULL && $action != NULL)
		{
			$CI =& get_instance();
			$path = $CI->config->item('cache_path');
			$cache_path = ($path == '') ? APPPATH . 'cache/' : $path;

			write_file($cache_path.$action, $output);
			
			chmod($cache_path.$action,0777);
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Write Cache File 
	 *
	 * @access	public
	 * @return	void()
	 */
	public function read_cache($action=NULL)
	{
		if($action != NULL)
		{
			$CI =& get_instance();
			$path = $CI->config->item('cache_path');
			$cache_path = ($path == '') ? APPPATH . 'cache/' : $path;
			
			if(file_exists($cache_path.$action))
				return read_file($cache_path.$action);
			else
				return false;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete Cache File 
	 *
	 * @access	public
	 * @return	void()
	 */
	public function delete_cache($action=NULL)
	{
		if($action != NULL)
		{
			$CI =& get_instance();
			$path = $CI->config->item('cache_path');
			$cache_path = ($path == '') ? APPPATH . 'cache/' : $path;
			
			if(file_exists($cache_path.$action))
				return unlink($cache_path.$action);
			else
				return false;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Type Name For Activity 
	 *
	 * @access	public
	 * @param   number - type
	 * @return	string
	 */
	public function get_type_name($type = NULL)
	{
		$type_name = "";
		if($type != NULL)
		{
			switch($type)
			{
				case '0':
				$type_name = "To-Do";
				break;
				case '1':
				$type_name = "Comment";
				break;
				case '2':
				$type_name = "Message";
				break;
				case '3':
				$type_name = "File";
				break;
				case '4':
				$type_name = "Comment";
				break;
			}
		}
		return $type_name;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Status For Activity 
	 *
	 * @access	public
	 * @param   number - status
	 * @return	string
	 */
	public function get_status($status = NULL)
	{
		$status_name = "";
		if($status != NULL)
		{
			switch($status)
			{
				case '0':
				$status_name = "Posted";
				break;
				case '1':
				$status_name = "Completed";
				break;
				case '2':
				$status_name = "Edited";
				break;
				case '3':
				$status_name = "Deleted";
				break;
				case '4':
				$status_name = "Assigned";
				break;
				case '5':
				$status_name = "Resolved";
				break;
				case '6':
				$status_name = "Reopened";
				break;
				case '7':
				$status_name = "Closed";
				break;
				case '8':
				$status_name = "QA";
				break;
				case '9':
				$status_name = "Commented";
				break;
				case '10':
				$status_name = "Uploaded";
				break;
				
			}
		}
		return $status_name;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Class Name For Activity View [for right text background class]
	 *
	 * @access	public
	 * @param   number - type
	 * @return	string
	 */
	public function get_class_name($type = NULL)
	{
		$type_name = "";
		if($type != NULL)
		{
			switch($type)
			{
				case '0':
				$type_name = "ToDoBg";
				break;
				case '1':
				$type_name = "CommentBg";
				break;
				case '2':
				$type_name = "MassageBg";
				break;
				case '3':
				$type_name = "FileBg";
				break;
				case '4':
				$type_name = "CommentBg";
				break;
			}
		}
		return $type_name;
	}

}
// END General class

/* End of file General.php */
/* Location: ./application/libraries/General */