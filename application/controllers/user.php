<?php if (!defined('BASEPATH')) exit('No direct script access allowed');class User extends CI_Controller{	function __construct()	{		parent::__construct();		// $data['base'] = $this->config->item('base_url');		// $data['css'] = $this->config->item('css_path');		// $data['css'] = $this->config->item('img_path');		$this->load->helper(array('form', 'url'));		$this->load->library('form_validation');		//$this->ci->load->config('tank_auth', TRUE);		//$this->ci->load->library('session');		$this->load->library('security');		$this->load->helper('url');		$this->load->library('tank_auth');		$this->lang->load('tank_auth');		$this->load->helper('string');		$this->load->library('email');		$this->ci =& get_instance();		$this->load->library('fbConn/facebook');	}	function index()	{		$data = $this->path->all_path();			$data['gallery_home'] = $this->users->fetch_home_gallery();		$data['country'] = $this->users->fetch_country();		$data['area_interest'] = $this->users->fetch_program();		/*  Upload code end */		$this->load->view('auth/header',$data);		$this->load->view('auth/home',$data);		$this->load->view('auth/footer',$data);	}		/* Code for user inbox */	/* Code for user inbox */	function inbox($id='')	{		$data = $this->path->all_path();		$this->load->view('auth/header',$data);		//$this->load->view('welcome');		if (!$this->tank_auth->is_logged_in()) {			redirect('/login/');		} else {			$data['user_id']	= $this->tank_auth->get_user_id();			$data['username']	= $this->tank_auth->get_username();			$data['get_sender_email'] = '0';			$logged_user = $data['user_id'];			$data['count_inbox'] = 0;			$data['count_outbox'] = 0;			//$this->load->model('users');			$data['fetch_profile'] = $this->users->fetch_profile($logged_user);			$data['query'] = $this->users->fetch_all_data($logged_user);			$data['profile_pic'] = $this->users->fetch_profile_data($logged_user); 		//	print_r($data['profile_pic']);			$data['educ_level'] = $this->users->fetch_educ_level();			$data['country'] = $this->users->fetch_country();			//print_r($data['country']);			$data['area_interest'] = $this->users->fetch_area_interest();			$data['inbox_messages'] = $this->users->inbox_message($logged_user);			$data['my_collage_of_user'] = $this->users->my_collage_of_user($logged_user);						$data['count_inbox'] = $this->users->count_inbox_user($logged_user);			$data['count_outbox'] = $this->users->count_outbox_user($logged_user);			$data['send_msg_via_reply'] = 0;			$data['error_send_msg_via_reply'] = 0;			//print_r($data['inbox_messages']);			if($id != '')			{				$message_condition = array(				'recipent_id'=> $logged_user,				'id'=> $id				);				$data['message_full'] = $this->users->fetch_message_by_id($message_condition);				if($data['message_full'] != 0)				{					$data['set_msg_read_status'] = $this->users->set_msg_read_status($message_condition);				}				if($this->input->post('btn_msg_reply'))				{					$this->form_validation->set_rules('msg_sub','Subject','trim|required|xss_clean');					$this->form_validation->set_rules('msg_body','Message','trim|required|xss_clean');					if($this->form_validation->run())					{						$sender_id = $data['message_full']['sender_id'];						$recipent_id = $data['message_full']['recipent_id'];												$send_msg_reply = array(						'recipent_id'=> $sender_id,						'sender_id'=> $recipent_id,						'subject'=> $this->input->post('msg_sub'),						'body'=> $this->input->post('msg_body'),						);						$data['send_msg_via_reply'] = $this->users->send_message_to_user($send_msg_reply);					}					else{					$errors = $this->tank_auth->get_error_message();					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);					$data['error_send_msg_via_reply'] = 1;					}				}				if($data['message_full'] != 0)				{					$sender_id = $data['message_full']['sender_id'];					$data['get_sender_email'] = $this->users->get_sender_email($sender_id);					//print_r($data['get_sender_email']);				}				$this->load->view('user/message_open',$data);			}			else{					$this->load->view('user/inbox',$data);				}		$this->load->view('auth/footer',$data);		}	}	/* inbox code end here */		/* Code for delete inbox message */	function delete_message_inbox($msg_id='')	{		$data['user_id']	= $this->tank_auth->get_user_id();		$data['username']	= $this->tank_auth->get_username();		$logged_user = $data['user_id'];				$msg_del_cond = array(		'id'=> $msg_id,		'recipent_id' => $logged_user		);		if($this->input->post('del_multi_msg'))		{			$del_msg_ids = $this->input->post('msg');			foreach($del_msg_ids as $id)			{			$msg_del_cond = array(			'id'=> $id,			'recipent_id' => $logged_user			);			$data['delete_multiple_message_status'] = $this->users->delete_single_message_inbox($msg_del_cond);			}		}		else{		$data['delete_single_message_status'] = $this->users->delete_single_message_inbox($msg_del_cond);		}		redirect('inbox');		// if($data['delete_single_message_status'] == 1)		// {			// redirect('inbox/delmsg_suc');		// }		// else		// {			// redirect('inbox/delmsg_fail');		// }	}		function compose_email()	{		$data = $this->path->all_path();		$this->load->view('auth/header',$data);		if (!$this->tank_auth->is_logged_in()) {			redirect('/login/');		} else {		$data['user_id']	= $this->tank_auth->get_user_id();			$data['username']	= $this->tank_auth->get_username();			$logged_user = $data['user_id'];			$data['count_inbox'] = 0;			$data['count_outbox'] = 0;			//$this->load->model('users');			$data['fetch_profile'] = $this->users->fetch_profile($logged_user);			$data['query'] = $this->users->fetch_all_data($logged_user);			$data['profile_pic'] = $this->users->fetch_profile_data($logged_user); 		//	print_r($data['profile_pic']);			$data['educ_level'] = $this->users->fetch_educ_level();			$data['country'] = $this->users->fetch_country();			//print_r($data['country']);			$data['area_interest'] = $this->users->fetch_area_interest();			$data['my_collage_of_user'] = $this->users->my_collage_of_user($logged_user);						$data['count_inbox'] = $this->users->count_inbox_user($logged_user);			$data['count_outbox'] = $this->users->count_outbox_user($logged_user);			$data['msg_send_suc'] = '0';			if($this->input->post('msg_send_btn'))			{			echo $this->input->post('msg_body');				$insert = array(				'sender_id'=>$data['user_id'],				'recipent_id'=>$this->input->post('recp_id'),				'subject'=>$this->input->post('msg_sub'),				'body'=>$this->input->post('msg_body')				);				$data['send_msg_by_search'] = $this->users->send_msg_by_search($insert);				if($data['send_msg_by_search'] == '1')				{					$data['msg_send_suc'] = '1';				}				else{					$data['msg_send_suc'] = '0';				}			}		}		$this->load->view('user/compose_message',$data);		$this->load->view('auth/footer',$data);	}		function search_user_list($email="")	{		$data['user_list'] = $this->users->fetch_user_list_compose($email);		//echo $email;		//print_r($data['user_list']);		$this->load->view('ajaxviews/user_list_ajax',$data);	}		function outbox($id='')	{		$data = $this->path->all_path();		$this->load->view('auth/header',$data);		if (!$this->tank_auth->is_logged_in()) {			redirect('/login/');		} else {		$data['user_id']	= $this->tank_auth->get_user_id();			$data['username']	= $this->tank_auth->get_username();			$logged_user = $data['user_id'];			$data['count_inbox'] = 0;			$data['count_outbox'] = 0;			//$this->load->model('users');			$data['fetch_profile'] = $this->users->fetch_profile($logged_user);			$data['query'] = $this->users->fetch_all_data($logged_user);			$data['profile_pic'] = $this->users->fetch_profile_data($logged_user); 		//	print_r($data['profile_pic']);			$data['educ_level'] = $this->users->fetch_educ_level();			$data['country'] = $this->users->fetch_country();			//print_r($data['country']);			$data['area_interest'] = $this->users->fetch_area_interest();			$data['inbox_messages'] = $this->users->outbox_message($logged_user);			$data['my_collage_of_user'] = $this->users->my_collage_of_user($logged_user);						$data['count_inbox'] = $this->users->count_inbox_user($logged_user);			$data['count_outbox'] = $this->users->count_outbox_user($logged_user);			$data['msg_send_suc'] = '0';			if($id != '')			{			$message_condition = array(				'sender_id'=> $logged_user,				'id'=> $id				);				$data['message_full'] = $this->users->fetch_outbox_message_by_id($message_condition);								if($data['message_full'] != 0)				{					$sender_id = $data['message_full']['sender_id'];					$data['get_sender_email'] = $this->users->get_sender_email($sender_id);					//print_r($data['get_sender_email']);				}			$this->load->view('user/message_open_outbox',$data);			}			else{				$this->load->view('user/outbox',$data);			}		}		$this->load->view('auth/footer',$data);	}				function delete_message_outbox($msg_id='')	{		$data['user_id']	= $this->tank_auth->get_user_id();		$data['username']	= $this->tank_auth->get_username();		$logged_user = $data['user_id'];				$msg_del_cond = array(		'id'=> $msg_id,		'sender_id' => $logged_user		);		if($this->input->post('del_multi_msg'))		{			$del_msg_ids = $this->input->post('msg');			foreach($del_msg_ids as $id)			{			$msg_del_cond = array(			'id'=> $id,			'sender_id' => $logged_user			);			$data['delete_multiple_message_status'] = $this->users->delete_single_message_outbox($msg_del_cond);			}		}		else{		$data['delete_single_message_status'] = $this->users->delete_single_message_outbox($msg_del_cond);		}		redirect('outbox');		// if($data['delete_single_message_status'] == 1)		// {			// redirect('inbox/delmsg_suc');		// }		// else		// {			// redirect('inbox/delmsg_fail');		// }	}	}