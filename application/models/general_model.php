<?php

class General_model extends CI_Model
{
	private $_table;
	private $_fields;
	public $fields;
	
    function __construct()
    {
	    // Call the Model constructor
        parent::__construct();
    }
	 /** 
     * Set table name
     * @access public 
     * @param  string - sets table_name
     * @return
     */
    function set_table($table_name)
    {
        $this->_table = $table_name;
		$this->_fields = $this->db->list_fields($this->_table);
		foreach($this->_fields as $field) {
			$this->fields[$field] = "";
		}
    }
	
	/** 
     * Get record from menus
     * @access public 
     * @param number - sets limit
     * @param number - sets offset
     * @param array  - sets order
     * @return array()
     */
    function get_fields_array()
    {
        return $this->_fields;
    }
    
    /** 
     * Get record from table
     * @access public 
     * @param number - sets limit
     * @param number - sets offset
     * @param array  - sets order
     * @return array()
     */
    function get($select = array(),$conditions = array(),$order=array("id"=>"ASC"),$limit=NULL,$offset=NULL)
    {
    	$this->db->select($select)->from($this->_table)->where($conditions)->order_by(key($order),$order[key($order)])->limit($limit,$offset);
        $query = $this->db->get();
        return $query->result_array();
    }
	
	/** 
     * Get record by id from table
     * @access public 
     * @param number - sets limit
     * @param number - sets offset
     * @param array  - sets order
     * @return array()
     */
	 
    function get_by_id($id,$order=array("id"=>"ASC"),$limit='1',$offset=NULL)
    {
		$this->db->where("id",$id);
    	$this->db->from($this->_table)->order_by(key($order),$order[key($order)])->limit($limit,$offset);
        $query = $this->db->get();
        return $query->result_array();
    }

    /** 
     * Save record in table 
     * @access public 
     * @param array  - task data
     * @return insert id
     */
    function save($data,$password = NULL,$created = NULL)
    {
    	if(!empty($data))
    	{
    		//if password field exist then 
	    	if($password != NULL)
	    	{
	    		$this->load->library('encrypt');
	    		$data[$password] = $this->encrypt->sha1($data[$password]);
	    	} 
	    	if($created != NULL)
	    	{
	    		$data[$created] =  date('Y-m-d H:i:s'); 
	    	}
	    	 
			$data = elements($this->_fields,$data);
        	$this->db->insert($this->_table, $data);
        	return $this->db->insert_id();
    	}
    	return false;
    }

    /** 
     * Update record in table
     * @access public 
     * @param array  - task data
     * @param array  - field name & value
     * @return boolean
     */
    function update($data,$fieldValue = array())
    {
    	if(!empty($data) && !empty($fieldValue))
    	{
    		$this->db->where($fieldValue);
        	$this->db->update($this->_table,$data);
  
        	if($this->db->affected_rows() > 0)
        		return true;
        	else
        		return false;
    	}
    	return false;
    }
	
	/** 
     * Delete record in table 
     * @access public 
     * @param array  - field name & value
     * @return boolean
     */
	 
    function delete($fieldValue = array())
    {
    	if(!empty($fieldValue))
    	{
    		$this->db->where($fieldValue);
        	$this->db->delete($this->_table,$fieldValue);
        		return true;
    	}
    	return false;
    }	
    
	/** 
     * Get Field or Fields By Id 
     * @access public 
     * @param  string  - field name
     * @param  number  - field id 
     * @return boolean
     */
	 
    function get_fields($field_names = NULL , $id = NULL)
    {
    	if($field_names != NULL && $id != NULL)
    	{
    		$this->db->select($field_names)->from($this->_table)->where('id',$id);
			$query = $this->db->get();
	        $record = $query->result_array();
	        if(!empty($record))
	        {
	        	if(count(explode(",", $field_names)) > 1)
	        		return $record[0];
	        	else 
	        		return $record[0][$field_names];	
	        }
	        return "";
    	}
    	return "";
    }
}