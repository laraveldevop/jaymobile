<?php
class Admin extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->database();
		$this->load->library('Native_Session');
		$this->load->library('Session');
		$this->load->library('Message_stack');
		$this->load->library('email');
		
		//load all models
		$this->load->model("attendance/user_model","user",true);
		$this->load->model("attendance/attendance_model","attendance",true);
		$this->load->model("attendance/time_manages_model","time",true);
		$this->load->model("attendance/user_logs_model","logs",true);
		$this->load->model("attendance/login_status_model","status",true);
	}
	
	function index()
	{
		if($this->session->userdata('admin_email_id'))
		{
			$url=base_url().'admin/dashboard';
			redirect($url);
		}
		
		$this->load->view("admin/login");
	}
	
	function login()
	{
		if($this->session->userdata('admin_email_id'))
		{
			$url=base_url().'admin/dashboard';
			redirect($url);
		}
		
		$this->load->model("admin_model","admin",true);
		$data = $this->input->post();
		$result=$this->admin->get_record($data);
		
		if(!empty($result))
		{
			$array_items = array("admin_email_id"=>$result[0]->email_id,"admin_id"=>$result[0]->id,"user_id"=>$result[0]->user_id,"first_name"=>$result[0]->first_name,"last_name"=>$result[0]->last_name);
			$this->session->set_userdata($array_items);
			$url=base_url().'admin/dashboard';
			redirect($url);
		}
		else
		{
			$this->session->set_flashdata('item','User Name Or Password Incorrect');
		
			$this->load->view("admin/login");
		}
	}	
	
	function dashboard($page="",$img="")
	{
		$this->isLogin();
		
		if($page=="remove_session")
		{
				$this->session->unset_userdata('search_date');
		}
	
		$newdata = array("page_no"=>$page);
		
		$this->session->set_userdata($newdata);
		
		$this->load->library('pagination');

		$config['base_url'] = base_url().'admin/dashboard/';
		$config['total_rows'] = $this->db->count_all('users');
		
		$search_date = $this->input->post();
		
		if(isset($search_date['Search'])&& $search_date['Search']!=NULL)
		{
			$newdata = array("search_date"=>$search_date['Search']);
			$this->session->set_userdata($newdata);
		}
		
		if($this->session->userdata('search_date'))
		{
			$current_date =$this->session->userdata('search_date');
		}
		else
		{
			$current_date = date("Y-m-d");
		}
		
		$data['user_data']=$this->user->get_records($page);
			
		foreach($data as $datas)
		{
			foreach($datas as $key=>$user_info )
			{
				$data['user_data'][$key]['user_info']=$this->logs->get_user_datas($user_info['id'],$current_date);
				$data['user_data'][$key]['user_login_status']=$this->status->get_user_status($user_info['id']); 
				
				
				foreach($data['user_data'][$key]['user_info'] as $key1=>$user_data)
				{
				
					$user_logs_info[]=$user_data;	
					$time_manage_data=$this->time->get_time_magage_record($user_data['id']);
					$data['user_data'][$key]['user_info'][$key1]['approve']=$time_manage_data;				
				}
				
				$total_hours=0;
				$total_min=0;
				$total_second=0;
				$minute=0;
				$hours=0;
					
				foreach($data['user_data'][$key]['user_info'] as $user_data)
				{
						$total_time_cal=explode(":",$user_data['duration']);
						$total_hours+= $total_time_cal[0];
						$total_min+=$total_time_cal[1];
						$total_second+=$total_time_cal[2];
						
				}
					
				if($total_second >= 60)
				{
					$minute=($total_second/60);
					$total_second=($total_second % 60);
					$total_min+=floor($minute);		
				}	
			
				if($total_min >=60)
				{
					$hours=($total_min/60);
					$total_min=($total_min%60);
					$total_hours+=floor($hours);
				}
					
				$total_time=$total_hours.":".$total_min.":".$total_second;
				
			
				$data['user_data'][$key]['total_time']=$total_time;
			
		}
	}
		if(empty($data['user_data']))
		{
			$data['user_data']="";
		}
		
        $this->pagination->initialize($config);
		$this->load->view("admin/dashboard",$data);
	}
	
	function employee_detail()
	{
		$this->isLogin();
	
		$this->load->library('pagination');
				
		$page=$this->session->userdata['page_no'];
		
		$config['base_url'] = base_url().'admin/dashboard/';
		$config['total_rows'] = $this->db->count_all('users');
		
		$data['user_data']=$this->user->get_records($page);
		
		if($this->session->userdata('search_date'))
		{
			$current_date =$this->session->userdata('search_date');
		}
		else
		{
			$current_date = date("Y-m-d");
		}
		
				
		foreach($data as $datas)
		{
			foreach($datas as $key=>$user_info )
			{
				$data['user_data'][$key]['user_info']=$this->logs->get_user_datas($user_info['id'],$current_date);
				$data['user_data'][$key]['user_login_status']=$this->status->get_user_status($user_info['id']); 
				
				foreach($data['user_data'][$key]['user_info'] as $key1=>$user_data)
				{
					$user_logs_info[]=$user_data;	
					$time_manage_data=$this->time->get_time_magage_record($user_data['id']);
					$data['user_data'][$key]['user_info'][$key1]['approve']=$time_manage_data;				
				}
				
				$total_hours=0;
				$total_min=0;
				$total_second=0;
				$minute=0;
				$hours=0;
					
				foreach($data['user_data'][$key]['user_info'] as $user_data)
				{
						$total_time_cal=explode(":",$user_data['duration']);
						$total_hours+= $total_time_cal[0];
						$total_min+=$total_time_cal[1];
						$total_second+=$total_time_cal[2];
						
				}
					
				if($total_second >= 60)
				{
					$minute=($total_second/60);
					$total_second=($total_second % 60);
					$total_min+=floor($minute);		
				}	
			
				if($total_min >=60)
				{
					$hours=($total_min/60);
					$total_min=($total_min%60);
					$total_hours+=floor($hours);
				}
					
				$total_time=$total_hours.":".$total_min.":".$total_second;
				$data['user_data'][$key]['total_time']=$total_time;			
			}
			
		}
		
		if(empty($data['user_data']))
		{
			$data['user_data']="";
		}
		
		$this->load->view("admin/employee_detail",$data);
	}
	
	function delete_user($id="")
	{
		$this->isLogin();
		
		$this->user->delete_record($id);
		$this->session->set_flashdata('item','Delete Record Successfully');
		
		$url=base_url().'admin/dashboard';
		redirect($url);	
	}
	
	function isLogin()
	{
		if($this->session->userdata('admin_email_id'))
		{
			return true;
		}
		else
		{
			$this->session->set_flashdata('item','User Name Or Password Require');
			$url=base_url().'admin/login';
			redirect($url);
		}
	}

	function profile()
	{
		$this->isLogin();
		
		 $admin_id=$this->session->userdata('admin_id');
		$this->load->model("admin_model","admin",true);
		$data['profile']=$this->admin->get_profile($admin_id);
		
		$this->load->view("admin/profile",$data);
	}
	
	function edit_profile()
	{
		$this->isLogin();
		
		$admin_id=$this->session->userdata('admin_id');
		$this->load->model("admin_model","admin",true);
		$data['profile']=$this->admin->get_profile($admin_id);
		$this->load->view("admin/edit_profile",$data);
		$data = $this->input->post();
		
		if(!empty($data))
		{
			unset($data['Update']);
			$result=$this->admin->update($data);
			
			copy(APPDIR.'assets/admin/upload/temp/'.$data['profile_image'],APPDIR.'assets/admin/upload/'.$data['profile_image']);
			
			$this->session->set_flashdata('item','Profile Update Successfully');
			$url=base_url().'admin/profile';
			redirect($url);
		}
	}

	function change_password()
	{
		$this->isLogin();
		
		$this->load->view("admin/change_password");
		$data = $this->input->post();
		
		if(!empty($data))
		{
			$admin_id=$this->session->userdata('admin_id');
			$data['id']=$admin_id;
			
			if($data['password']==$data['confirm_password']) 
			{
				$this->load->model("admin_model","admin",true);
				$admin_data=$this->admin->get_profile($admin_id);
				
				if($admin_data[0]->password == md5($data['old_password']))
				{
					unset($data['old_password']);
					unset($data['confirm_password']);
					unset($data['Update']);
					//unset($data['admin_id']);
					$this->admin->update_password($data);
					
					$this->session->set_flashdata('item',"Your Password Updated");
					$url=base_url().'admin/profile';
					redirect($url);
				}
				else
				{
					$this->session->set_flashdata('item',"Old Password Incorrect");
					$url=base_url().'admin/change_password';
					redirect($url);
				}
			}
			else
			{
				$this->session->set_flashdata('item',"New Password And Rewrite Password Do Not Match");
				$url=base_url().'admin/change_password';
				redirect($url);
			}
		}
	}
	
	function image_upload()
	{
		$this->isLogin();
		
		$filename[] = $_FILES['image']['name'];
		$image_path=base_url()."assets/admin/upload/temp";
		
		if (($_FILES["image"]["type"] == "image/gif") || ($_FILES["image"]["type"] == "image/jpeg") || ($_FILES["image"]["type"] == "image/swf"))
		{
			if(!is_dir(APPDIR.'assets/admin/upload/temp'))
			{
				
				$u = umask(0);
				mkdir(APPDIR.'assets/admin/upload/temp',0777,true);

				umask($u);
			}
				
			copy($_FILES['image']['tmp_name'],APPDIR.'assets/admin/upload/temp/'.$filename[0]);
			chmod(APPDIR.'assets/admin/upload/temp/'.$filename[0],0777);
			echo json_encode($filename);	
		}
		else
		{
			$msg[0] = "false";
			echo json_encode($msg);
		}
	}
	
	function user_image_upload()
	{
		$this->isLogin();
		
		$filename[] = $_FILES['image']['name'];
		$image_path=base_url()."assets/admin/upload/temp";
		
		if (($_FILES["image"]["type"] == "image/gif") || ($_FILES["image"]["type"] == "image/jpeg") || ($_FILES["image"]["type"] == "image/swf"))
		{
			if(!is_dir(APPDIR.'assets/public/upload/temp'))
			{
				$u = umask(0);
				mkdir(APPDIR.'assets/public/upload/temp',0777,true);
				umask($u);
			}
				
			copy($_FILES['image']['tmp_name'],APPDIR.'assets/public/upload/temp/'.$filename[0]);
			chmod(APPDIR.'assets/admin/upload/temp/'.$filename[0],0777);
			echo json_encode($filename);	
		}
		else
		{
			$msg[0] = "false";
			echo json_encode($msg);
		}
	}
	
	function edit_time($id="")
	{
		$this->isLogin();
		
		$this->load->model("admin_model","admin",true);
		
		$user_data['user_data']=$this->logs->get_user($id);
		$this->load->view("admin/edit_time",$user_data);
		$data = $this->input->post();
		$user_id=$data['user_id'];
		
		if(!empty($data))
		{
			unset($data['Update']);
			
			if($data['login_at_time']==$data['login_at'] && $data['logout_at_time']== $data['logout_at']){}
			else
			{
				if(strtotime($data["logout_at"]) > strtotime($data["login_at"]))
				{
					
					if(strtotime($data["logout_at"]) <= strtotime(date("Y-m-d H:i:s")))
					{
						$user_logs_info=$this->logs->get_user($data['id']);
						
						
						if(date('Y-m-d',strtotime($data['logout_at']==date("Y-m-d"))))
						{
							if($data['logout_at']=="0000-00-00 00:00:00")
							{
								$data['logout_at']=date('Y-m-d H:i:s');
							}
						}
						
						$data['duration']=$this->calculateTime($data['login_at'],$data['logout_at']);
						
						if(date('Y-m-d',strtotime($data['logout_at']==date("Y-m-d"))))
						{
							if($data['logout_at']==date('Y-m-d H:i:s'))
							{
								$data['logout_at']="0000-00-00 00:00:00";
							}
						}
							
						if(strtotime($data['duration']) > strtotime($user_logs_info[0]['duration']))
						{
							
							$attendance_data['login_at']=$data['login_at'];
							$attendance_data['user_id']=$user_id;
							$attendance_data=$this->admin->get_attendance_data($attendance_data);
							
						
							$old_duration=$this->calculateTime($data['login_at_time'],$data['logout_at_time']);
							unset($data['login_at_time']);
							unset($data['logout_at_time']);	
							
							$total_duration=$this->calculateTime($data['duration'],$old_duration);
							
							$duration_diff=explode(':',$total_duration);
							
							$total_min=0;
							$second=0;
							$minute=0;
							$hours=0;
							
							$total_duration =explode(':',$attendance_data[0]['total_time']);
							
							$hours=$total_duration[0]+$duration_diff[0];
							$minute=$total_duration[1]+$duration_diff[1];
							$second=$total_duration[2]+$duration_diff[2];
							
							if($second >= 60)
							{
								$minute+=floor($second/60);
								$second=($second % 60);	
							}	
						
							if($minute >=60)
							{
								$hours+=floor($minute/60);
								$minute=($minute%60);	
							}
							
							
							$total_min=$duration_diff[0]*60;
							$total_min+=$duration_diff[1];
							$total_min+=$attendance_data[0]['minute'];
							
							$total_minute = $total_min;
							$total_time=$hours.":".$minute.":".$second;
						
						}
						else if(strtotime($data['duration']) < strtotime($user_logs_info[0]['duration']))
						{
							$attendance_data['login_at']=$data['login_at'];
							$attendance_data['user_id']=$user_id;
							
							
							$attendance_data=$this->admin->get_attendance_data($attendance_data);
				
							$old_duration=$this->calculateTime($data['login_at_time'],$data['logout_at_time']);
					
							unset($data['login_at_time']);
							unset($data['logout_at_time']);	
							
							$total_duration=$this->calculateTime($data['duration'],$old_duration);

							$duration_diff=explode(':',$total_duration);
							
							$total_min=0;
							$second=0;
							$minute=0;
							$hours=0;
							
							$total_duration =explode(':',$attendance_data[0]['total_time']);
							
							
							$total_min=$duration_diff[0]*60;
							$total_min+=$duration_diff[1];
							$attendance_data[0]['minute']-=$total_min;
							
							$total_minute=$attendance_data[0]['minute'];	
							
							
							if($total_minute >=60)
							{
								$hours+=floor($total_minute/60);
								$minute=($total_minute%60);	
							}
							else
							{
								$minute=$total_minute;
							}
							$total_time=$hours.":".$minute.":".$second;
						}
						
					
						if($total_minute >= 500)
						{
							$attendance_update_value['credit']='4';
						}
						else if($total_minute >= 375)
						{
							$attendance_update_value['credit']='3';
						}
						else if($total_minute >= 250)
						{
							$attendance_update_value['credit']='2';
						}
						
						else if($total_minute >= 125)
						{
							$attendance_update_value['credit']='1';
						}
						else
						{
							$attendance_update_value['credit']='0';
						}
						
						$attendance_update_value['created_date']=date('Y-m-d',strtotime($user_logs_info[0]['login_at']));
						$attendance_update_value['user_id']=$user_logs_info[0]['user_id'];
						$attendance_update_value['minute']=$total_minute;
						$attendance_update_value['total_time']=$total_time;
						$attendance_update_value['updated_date']=date('Y-m-d');
						
						$this->attendance->update_attendance($attendance_update_value);
						
						$this->logs->update_login($data);
					}
				}
			}
			$this->session->set_flashdata('item',"Login Time Update Successfully");
			$url=base_url().'admin/daily_work/'.$user_id;
			redirect($url);
		}
	}
	
	function calculateTime($startDate,$endDate)
	{
		$diff = abs(strtotime($startDate) - strtotime($endDate)); 
		$years   = floor($diff / (365*60*60*24)); 
		$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
		$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
		$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 
		$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60)); 

		return ($hours . ":" . $minuts . ":" . $seconds);
	}
	
	function daily_work($id="",$page="")
	{	
		$this->isLogin();
		
		$this->load->library('pagination');
		
		$config['base_url'] = base_url().'admin/daily_work/'.$id.'/';
				
				
		$config['total_rows'] = $this->logs->row_count($id);
		$user_data['user_data']=$this->logs->get_users($id,$page);
		$config['uri_segment'] = 4; 
		$user_data['user_id']=$id;
		$this->pagination->initialize($config);
		
		$this->load->view("admin/daily_work",$user_data);
	}
	
	function user_profile($id="")
	{
		$this->isLogin();
		
		$user_data['user_profile']=$this->user->get_profile($id);
		
		$user_data['user_id']=$id;
		$this->load->view("admin/user_profile",$user_data);
	}
	
	function edit_user_profile($id="")
	{
		$this->isLogin();
		
		$user_data['user_profile']=$this->user->get_profile($id);
		$this->load->view("admin/edit_user_profile",$user_data);
		
		$data = $this->input->post();
		
		if(!empty($data))
		{
			unset($data['Update']);
			unset($data['confirm_password']);
	
			$id=$data['id'];
			
			if($data['password']==NULL && $data['confirm_password']==NULL)
			{
				unset($data['password']);	
			}
			else
			{
				$data['password']=md5($data['password']);
			}
			
			
			if(!is_dir(APPDIR.'assets/public/upload/'.$id))
			{
				$u = umask(0);
				mkdir(APPDIR.'assets/public/upload/'.$id,0777,true);
				umask($u);
			}
			if(!empty($data['profile_image']))
			{
				copy(APPDIR.'assets/public/upload/temp/'.$data['profile_image'],APPDIR.'assets/public/upload/'.$id.'/'.$data['profile_image']);
				unlink(APPDIR.'assets/public/upload/temp/'.$data['profile_image']);
			}
			
			$this->user->update_profile($data);
			
			$this->session->set_flashdata('item',"Employee Status Update Successfully");
			$url=base_url().'admin/user_profile/'.$id;
			redirect($url);
		}
	}
	
	function forgot_password()
	{
		$this->load->view("admin/forgot_password");
		
		$data = $this->input->post();
		
		if(!empty($data))
		{
			$this->load->model("admin_model","admin",true);
			$result=$this->admin->forgot_pass($data);
			
			if(!empty($result))
			{
				$common =new Common();
				$new_password = $common->genPassword();
				$admin_value['password'] = md5($new_password);
				$admin_value['id'] = $result[0]['id'];
							
				$subject  = "Password retrival";
				$message = "your account's new password is : " . $new_password;
				
				$this->email->from('test@yudiz.com', 'Yudiz Solution');
				$this->email->to($result[0]['email_id']);
				$this->email->subject($subject);
				$this->email->message($message);
				
				if($this->email->send())
				{	
					$this->load->model("admin_model","admin");
					$this->admin->update($admin_value);
					$this->session->set_flashdata('item','New Password Send To Your Mail Account Shortly.');
					$url=base_url().'admin/forgot_password';
					redirect($url);
				}
				else
				{
					$this->session->set_flashdata('item','Error in sending mail please try after some time. ');
					$url=base_url().'admin/forgot_password';
					redirect($url);
				}				
			}
			else
			{
				$this->session->set_flashdata('item','Wrong Email Id ');	
				$url=base_url().'admin/forgot_password';
				redirect($url);
			}
		}
	}
	
	function approve_time($action="",$user_logs_id="")
	{
		$this->isLogin();
		
		$this->load->model("admin_model","admin",true);
		
		if($action=="approve")
		{
			$get_time_manage_data=$this->admin->get_time_manage_data($user_logs_id);
			
			$user_logs_info=$this->admin->get_user_logs_data($get_time_manage_data[0]['user_log_id']);
			
			$duration_different=$this->calculateTime($get_time_manage_data[0]['duration'],$user_logs_info[0]['duration']);
			
			if(strtotime($get_time_manage_data[0]['duration']) > strtotime($user_logs_info[0]['duration']) )
			{
				$attendance_data['login_at']=$user_logs_info[0]['login_at'];
				$attendance_data['user_id']=$user_logs_info[0]['user_id'];
				
				$attendance_data=$this->admin->get_attendance_data($attendance_data);
				
				$duration_diff=explode(':',$duration_different);
				
				$total_min=0;
				$second=0;
				$minute=0;
				$hours=0;
				
				$total_duration =explode(':',$attendance_data[0]['total_time']);
				
				$hours=$total_duration[0]+$duration_diff[0];
				$minute=$total_duration[1]+$duration_diff[1];
				$second=$total_duration[2]+$duration_diff[2];
				
				if($second >= 60)
				{
					$minute+=floor($second/60);
					$second=($second % 60);	
				}	
			
				if($minute >=60)
				{
					$hours+=floor($minute/60);
					$minute=($minute%60);	
				}
				$total_min=$duration_diff[0]*60;
				$total_min+=$duration_diff[1];
				$total_min+=$attendance_data[0]['minute'];
			
				$total_time=$hours.":".$minute.":".$second;
				
			}
			else if(strtotime($get_time_manage_data[0]['duration']) < strtotime($user_logs_info[0]['duration']) )
			{
				$attendance_data['login_at']=$user_logs_info[0]['login_at'];
				$attendance_data['user_id']=$user_logs_info[0]['user_id'];
				
				$attendance_data=$this->admin->get_attendance_data($attendance_data);
				
				$duration_diff=explode(':',$duration_different);
				
				$total_min=0;
				$second=0;
				$minute=0;
				$hours=0;
				
				$total_duration =explode(':',$attendance_data[0]['total_time']);
				
				$total_min=$duration_diff[0]*60;
				$total_min+=$duration_diff[1];
				$attendance_data[0]['minute']-=$total_min;
				
				$total_minute=$attendance_data[0]['minute'];	
				
				if($total_minute >=60)
				{
					$hours+=floor($total_minute/60);
					$minute=($total_minute%60);	
				}
				else
				{
					$minute=$total_minute;
				}
				
				$total_time=$hours.":".$minute.":".$second;
				
			}
			
			
			if($total_min >= 500)
			{
				$attendance_update_value['credit']='4';
			}
			else if($total_min >= 375)
			{
				$attendance_update_value['credit']='3';
			}
			else if($total_min >= 250)
			{
				$attendance_update_value['credit']='2';
			}
			
			else if($total_min >= 125)
			{
				$attendance_update_value['credit']='1';
			}
			else
			{
				$attendance_update_value['credit']='0';
			}
			
			$attendance_update_value['created_date']=date('Y-m-d',strtotime($user_logs_info[0]['login_at']));
			$attendance_update_value['user_id']=$user_logs_info[0]['user_id'];
			$attendance_update_value['minute']=$total_min;
			$attendance_update_value['total_time']=$total_time;
			$attendance_update_value['updated_date']=date('Y-m-d');
				
			$this->admin->update_attendance($attendance_update_value);
				
			$user_logs_data['login_at']=$get_time_manage_data[0]['login_at'];
			$user_logs_data['logout_at']=$get_time_manage_data[0]['logout_at'];
			$user_logs_data['duration']=$get_time_manage_data[0]['duration'];
			$user_logs_data['id']=$get_time_manage_data[0]['user_log_id'];
			$this->admin->update_user_logs($user_logs_data);
			
			
			$this->admin->delete_time_manage($user_logs_id);
			$this->session->set_flashdata('item','Time Approve Successfully ');	
		}
		
		else if($action="not_approve")
		{
			$this->admin->delete_time_manage($user_logs_id);	
			$this->session->set_flashdata('item','Time Not Approve Successfully ');	
		}
		
		$url=base_url().'admin/dashboard';
		redirect($url);
	}
	
	function attendance_report($page=1)
	{
		$date_array=array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);
		//print_r($date_array);
		//exit;
		$data['user_data']=$this->user->get_user_records($page=1);
		
		
		foreach($data as $datas)
		{
			
			foreach($datas as $key=>$user_info )
			{
				$total_credit=0;
				
				$data['user_data'][$key]['user_attendance']=$this->attendance->get_user_attendance($user_info['id']);
				
				foreach($date_array as $key1=>$date)
				{
					foreach($data['user_data'][$key]['user_attendance'] as $user_attendace_data)
					{		
						if(date("d",strtotime($user_attendace_data['created_date']))==$date)
						{
							$data['user_data'][$key]['credit'][$key1]['credit']=$user_attendace_data['credit'];
							
							$total_credit+=$user_attendace_data['credit'];
							$data['user_data'][$key]['total_credit']=$total_credit;
							
							break;
							
						}
						else
						{
							$data['user_data'][$key]['credit'][$key1]['credit']='-';
						}							
					}
					
				}
				
				
			 
			}
		}
		//echo "<pre>";
		//print_r($data);
		$this->load->view("admin/attendance_report",$data);	
	}
	function sign_out()
	{
		$this->isLogin();
		
		$array_items = array('admin_email_id' => '', 'user_id' => '','admin_id'=>'','page'=>'','first_name'=>'','last_name'=>'');	
		$this->session->unset_userdata($array_items);
		$this->session->set_flashdata('item','Log Out Successfully ');
		$url=base_url().'admin/login';
		redirect($url);
	}
	
}
?>