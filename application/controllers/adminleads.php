<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Adminleads extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('tank_auth');
		$this->load->model('lead_tele_model');
		$this->load->library('pagination');


	}

	function managetelecalls($start=0)
	{
		$data = $this->path->all_path();
		if (!$this->tank_auth->is_admin_logged_in()) {
   
   redirect('admin/adminlogin/');
	} else {
	   $flag=0;
	  $data['username'] = $this->tank_auth->get_username();
	   $data['user_id'] = $this->tank_auth->get_admin_user_id();
	   $data['admin_user_level']=$this->tank_auth->get_admin_user_level();
		   //fetch user privilege data from model
	  if($flag==0)
	 {
	  $data['teleleads']=$this->lead_tele_model->tele_lead_users($start);
	  if ($this->input->post('ajax')) {
      $this->load->view('ajaxviews/admin_engage/manage_tele_leads', $data);
    } else {
	$this->load->view('admin/header', $data);
	  $this->load->view('admin/sidebar', $data); 
      $this->load->view('admin/leads/manage_tele_leads', $data);
    }
	 
	 }
		
		 
	}
	
	}
	
	function manage_verified_telecalls($start=0)
	{
		$data = $this->path->all_path();
		if (!$this->tank_auth->is_admin_logged_in()) {
   
   redirect('admin/adminlogin/');
	} else {
	   $flag=0;
	  $data['username'] = $this->tank_auth->get_username();
	   $data['user_id'] = $this->tank_auth->get_admin_user_id();
	   $data['admin_user_level']=$this->tank_auth->get_admin_user_level();
		   //fetch user privilege data from model
	  if($flag==0)
	 {
	  $data['verify_teleleads']=$this->lead_tele_model->manage_verify_teleleads($start);
	  if ($this->input->post('ajax')) {
      $this->load->view('ajaxviews/admin_engage/manage_verify_tele_leads', $data);
    } else {
	$this->load->view('admin/header', $data);
	  $this->load->view('admin/sidebar', $data); 
      $this->load->view('admin/leads/manage_verify_tele_leads', $data);
    }
	 
	 }
		
		 
	}
	}
	
	function fetch_user_info_for_tele()
	{
	  $data = $this->path->all_path();
		if (!$this->tank_auth->is_admin_logged_in()) {
   
	   redirect('admin/adminlogin/');
		} else {
		   $flag=0;
		   $user_id=$this->input->post('id');
		   $data['username'] = $this->tank_auth->get_username();
		   $data['user_id'] = $this->tank_auth->get_admin_user_id();
		   $data['admin_user_level']=$this->tank_auth->get_admin_user_level();
		   $data['lead_info']=$this->lead_tele_model->lead_user_info($user_id);
		   $data['country_res']=$this->users->fetch_country();
		   $data['state_res'] = $this->lead_tele_model->fetch_state();
		   $data['city_res'] = $this->lead_tele_model->fetch_city();
		   //print_r( $data['lead_info']);
		   $view=$this->load->view('ajaxviews/admin_engage/edit_tele_user', $data,TRUE);
		   echo $view;
		 }
			
			 
	}
	
	function fetch_user_info_for_verify_tele()
	{
		$data = $this->path->all_path();
		if (!$this->tank_auth->is_admin_logged_in()) {
   
	   redirect('admin/adminlogin/');
		} else {
		   $flag=0;
		   $user_id=$this->input->post('id');
		   $data['username'] = $this->tank_auth->get_username();
		   $data['user_id'] = $this->tank_auth->get_admin_user_id();
		   $data['admin_user_level']=$this->tank_auth->get_admin_user_level();
		   $data['lead_info']=$this->lead_tele_model->verify_lead_user_info($user_id);
		   $data['country_res']=$this->users->fetch_country();
		   $data['state_res'] = $this->lead_tele_model->fetch_state();
		   $data['city_res'] = $this->lead_tele_model->fetch_city();
		   //print_r( $data['lead_info']);
		   $view=$this->load->view('ajaxviews/admin_engage/edit_verify_tele_user', $data,TRUE);
		   echo $view;
		 }
	}
	
	function save_verified_leads()
	{
		$dob = $this->input->post('year').'-'.$this->input->post('month').'-'.$this->input->post('date');
		
		$lead_info = array(
		'v_fullname'=>$this->input->post('fullname'),
		'v_email'=>$this->input->post('email'),
		'v_phone'=>$this->input->post('phone'),
		'v_dob'=>$dob,
		'v_country'=>$this->input->post('country'),
		'v_state'=>$this->input->post('state'),
		'v_city'=>$this->input->post('city'),
		'v_enroll_key'=>$this->input->post('enroll'),
		'v_notes'=>$this->input->post('notes'),
		'v_interested_country'=>$this->input->post('interested_cont'),
		'v_user_type'=>$this->input->post('lead_source')
		);
		
		$update_old_lead_info = array(
		'fullname'=>$this->input->post('fullname'),
		'email'=>$this->input->post('email'),
		'phone_no1'=>$this->input->post('phone'),
		'dob'=>$dob,
		'home_country_id'=>$this->input->post('country'),
		'state'=>$this->input->post('state'),
		'city'=>$this->input->post('city'),
		'lead_verified'=>'1',
		'studying_country_id'=>$this->input->post('interested_cont')
		);
		$data['submit_verified_lead_info'] = $this->lead_tele_model->save_verified_lead_info($lead_info,$update_old_lead_info);
		if($data['submit_verified_lead_info'] == 1)
		{
			echo "1";
		}
		else if($data['submit_verified_lead_info'] == 0)
		{
			echo "0";
		}
	}
	
	function update_verify_leads()
	{
		$dob = $this->input->post('year').'-'.$this->input->post('month').'-'.$this->input->post('date');
		$update_verify_lead_info = array(
		'v_fullname'=>$this->input->post('fullname'),
		'v_email'=>$this->input->post('email'),
		'v_phone'=>$this->input->post('phone'),
		'v_dob'=>$dob,
		'v_country'=>$this->input->post('country'),
		'v_state'=>$this->input->post('state'),
		'v_city'=>$this->input->post('city'),
		'v_enroll_key'=>$this->input->post('enroll'),
		'v_notes'=>$this->input->post('notes'),
		'v_interested_country'=>$this->input->post('interested_cont'),
		'v_user_type'=>$this->input->post('lead_source')
		);
		$data['update_verify_lead_info'] = $this->lead_tele_model->update_verify_lead_model($update_verify_lead_info);
		echo $data['update_verify_lead_info'];
	}
	
	function check_email_exist()
	{
		//$query = $this->db->get_where('verified_lead_data',);
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$data['check_email'] = $this->lead_tele_model->check_for_email_existing($email,$phone);
		echo $data['check_email'];
	}
	
	function droprecord()
	{
		$id = $this->input->post('id');
		$data['drop_record'] = $this->lead_tele_model->drop_record_from_lead($id);
		echo $data['drop_record'];
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */