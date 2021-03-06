<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_courses extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->gallery_path = realpath(APPPATH . '../uploads/home_gallery');
		$this->excel_path = realpath(APPPATH . '../uploads/Excel');
		$this->xsl_path = realpath(APPPATH . '../uploads');
		
		$this->ci =& get_instance();
		$this->ci->load->config('tank_auth', TRUE);
		// $data['base'] = $this->config->item('base_url');
		// $data['css'] = $this->config->item('css_path');
		// $data['css'] = $this->config->item('img_path');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
		$this->load->model('admin/courses_model');
	}

	
	
	function upload_courses()
	{
	
		$data = $this->path->all_path();
		if (!$this->tank_auth->is_admin_logged_in()) {
			redirect('admin/adminlogin/');
		} else {
			$data['user_id']	= $this->tank_auth->get_admin_user_id();
			$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
			$data['admin_priv']=$this->adminmodel->get_user_privilege($data['user_id']);
			if(!($data['admin_priv']))
			{
			redirect('admin/adminlogout');
			}
			$this->load->view('admin/header', $data);
			$this->load->view('admin/sidebar', $data);
			if($data['admin_user_level']=='5')
			{
			if($this->input->post('upload'))
			{
			$this->courses->upload_bulk_courses();
			
			}
			$this->load->view('admin/courses/upload_bulk_courses');	
			}
			else
			{
			$this->load->view('admin/accesserror',$data);
			}
			
		}
			
			
	}
	
	function manage_courses($msg='')
	{
		$data = $this->path->all_path();
		if (!$this->tank_auth->is_admin_logged_in()) {
			redirect('admin/adminlogin/');
		} else {
			$data['user_id']	= $this->tank_auth->get_admin_user_id();
			$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
			$data['admin_priv']=$this->adminmodel->get_user_privilege($data['user_id']);
			if(!($data['admin_priv']))
			{
			redirect('admin/adminlogout');
			}
			$this->load->view('univadmin/header', $data);
			$this->load->view('univadmin/sidebar', $data);
			if($data['admin_user_level']=='5')
			{
			if($msg=='bcus')
			{
			$data['msg']='All Program Added Sucessfully';
			$this->load->view('admin/userupdated',$data);
			}
			if($msg=='cas')
			{
			$data['msg']='Program Added Sucessfully';
			$this->load->view('admin/userupdated',$data);
			}
			if($msg=='cds')
			{
			$data['msg']='Course Deleted Sucessfully';
			$this->load->view('admin/userupdated',$data);
			}
			$data['course_info']=$this->courses->program_info();
			$this->load->view('admin/courses/manage_courses',$data);	
			}
			else
			{
			$this->load->view('admin/accesserror',$data);
			}
			
		}
	}
	
	function add_course()
	{
		$data = $this->path->all_path();
		if (!$this->tank_auth->is_admin_logged_in()) {
			redirect('admin/adminlogin/');
		} else {
			$data['user_id']	= $this->tank_auth->get_admin_user_id();
			$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
			$data['admin_priv']=$this->adminmodel->get_user_privilege($data['user_id']);
			if(!($data['admin_priv']))
			{
			redirect('admin/adminlogout');
			}
			$data['educ_level']=$this->users->fetch_educ_level();
			$data['area_interest']=$this->users->fetch_area_interest();
			$this->load->view('admin/header', $data);
			$this->load->view('admin/sidebar', $data);
			if($data['admin_user_level']=='5')
			{
			$this->form_validation->set_rules('course_name', 'Course Name', 'trim|required');
			$this->form_validation->set_rules('prog_title', 'Program Title', 'trim|required|xss_clean');
			$this->form_validation->set_rules('educ_level', 'Education Level', 'trim|required|xss_clean');
			$this->form_validation->set_rules('area_interest', 'Area of Interest', 'trim|required|xss_clean');
			
			
			if ($this->form_validation->run()) {
			$this->courses->add_single_course();
			redirect('admincourses/manage_courses/cas');
			//$data['x']=$this->adminmodel->create_univ();
			//print_r($data['x']);
			//$this->adminmodel->edit_user_data();
			//redirect('admin/manageusers/ups');
			}
			
			$this->load->view('admin/courses/add_single_course',$data);
			}
			else
			{
			$this->load->view('admin/accesserror',$data);
			}
			
		}
	}
	
	function university_addcourse($submit='')
	{
		$data = $this->path->all_path();
			if (!$this->tank_auth->is_admin_logged_in()) 
			{
				redirect('admin/adminlogin/');
			} else {
			$data['user_id']	= $this->tank_auth->get_admin_user_id();
			$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
			$data['admin_priv']=$this->adminmodel->get_user_privilege($data['user_id']);
			if(!($data['admin_priv']))
			{
			redirect('admin/adminlogout');
			}
			$data['educ_level']=$this->users->fetch_educ_level();
			$data['area_interest']=$this->users->fetch_area_interest();
			$this->load->view('admin/header', $data);
			$this->load->view('admin/sidebar', $data);
			if($data['admin_user_level']=='5' || $data['admin_user_level']=='3')
			{
			$this->form_validation->set_rules('program', 'Program', 'trim|required|xss_clean|callback_check_univ_course');
			$this->form_validation->set_rules('educ_level', 'Education Level', 'trim|required|xss_clean');
			$this->form_validation->set_rules('area_interest', 'Area of Interest', 'trim|required|xss_clean');
			$this->form_validation->set_rules('university', 'University', 'trim|required|xss_clean');
			$this->form_validation->set_rules('tution_fee1', 'Tution Fee 1st', 'trim|xss_clean|numeric');
			$this->form_validation->set_rules('tution_fee2', 'Tution Fee 2nd', 'trim|xss_clean|numeric');
			$this->form_validation->set_rules('per_required', 'Percantage Field', 'trim|xss_clean|numeric|max_length[2]');
			
			if($this->input->post('tution_fee1')!='' && $this->input->post('tution_fee1')!=null )
			{
			$this->form_validation->set_rules('currency1', 'Currency', 'trim|xss_clean|required');
			}
			if($this->input->post('tution_fee2')!='' && $this->input->post('tution_fee2')!=null)
			{
			$this->form_validation->set_rules('currency2', 'Currency', 'trim|xss_clean|required');
			}
			if ($this->form_validation->run()) {
			$this->courses->add_course_to_univ();
			redirect('admincourses/manage_univ_course/cas');
			}
			$data['submit_attemp']=0;
			if($submit=='submit')
			{
			$data['submit_attemp']=1;
			}
			if($data['admin_user_level']=='5')
			{
			$data['univ_info']=$this->events->get_univ_detail();
			}else if($data['admin_user_level']=='3')
			{
			$data['univ_info']=$this->events->get_univ_id_by_user_id($data['user_id']);
			}
			$this->load->view('admin/courses/add_course_to_univ',$data);
			}
			else
			{
			$this->load->view('admin/accesserror',$data);
			}
			
		}
	}
	
	function fetch_programs()
	{
		if (!$this->tank_auth->is_admin_logged_in()) {
			redirect('admin/adminlogin/');
		}
		else {
		$data['result']=$this->courses->fetch_programs($this->input->post('educ_level'),$this->input->post('area_interest'));
		$this->load->view('ajaxviews/program_view',$data);
		}
	}
	
	/*function add_univ_prog($submit='')
	{
			$data = $this->path->all_path();
			if (!$this->tank_auth->is_admin_logged_in()) {
				redirect('admin/adminlogin/');
			} else {
			$data['user_id']	= $this->tank_auth->get_admin_user_id();
			$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
			$data['admin_priv']=$this->adminmodel->get_user_privilege($data['user_id']);
			$data['educ_level']=$this->users->fetch_educ_level();
			$data['area_interest']=$this->users->fetch_area_interest();
			$this->load->view('admin/header', $data);
			$this->load->view('admin/sidebar', $data);
			if($data['admin_user_level']=='5')
			{
			$this->form_validation->set_rules('course_name', 'Course Name', 'trim|required');
			$this->form_validation->set_rules('prog_title', 'Program Title', 'trim|required|xss_clean');
			$this->form_validation->set_rules('educ_level', 'Education Level', 'trim|required|xss_clean');
			$this->form_validation->set_rules('area_interest', 'Area of Interest', 'trim|required|xss_clean');
			$this->form_validation->set_rules('university', 'University', 'trim|required|xss_clean');
			$this->form_validation->set_rules('tution_fee1', 'Tution Fee 1st', 'trim|xss_clean|numeric');
			$this->form_validation->set_rules('tution_fee2', 'Tution Fee 2nd', 'trim|xss_clean|numeric');
			$this->form_validation->set_rules('per_required', 'Percantage Field', 'trim|xss_clean|numeric|max_length[2]');
			if($this->input->post('tution_fee1')!='' && $this->input->post('tution_fee1')!=null )
			{
			$this->form_validation->set_rules('currency1', 'Currency', 'trim|xss_clean|required');
			}
			if($this->input->post('tution_fee2')!='' && $this->input->post('tution_fee2')!=null)
			{
			$this->form_validation->set_rules('currency1', 'Currency', 'trim|xss_clean|required');
			}
			if ($this->form_validation->run()) {
			$this->courses->add_course_to_univ();
			}
			}
			else
			{
			$this->load->view('admin/accesserror',$data);
			}
		}
	}*/		
		function check_univ_course()
		{
			$data['res']=$this->courses->check_univ_course($this->input->post('university'),$this->input->post('program'));
			if($data['res'])
			{
			$this->form_validation->set_message('check_univ_course', 'This Course is alredy Exist In This University');
			return FALSE;
			}
			else
			{
			return TRUE;
			}
		}
		function check_univ_course_ajax()
		{
		if (!$this->tank_auth->is_admin_logged_in()) {
			redirect('admin/adminlogin/');
		}
		else {
		$data['result']=$this->courses->check_univ_course($this->input->post('university'),$this->input->post('program'));
		$this->load->view('ajaxviews/check_unique_field', $data);
		}	
		}
		
		function delete_single_course($prog_id)
		{
		
		if (!$this->tank_auth->is_admin_logged_in()) {
			redirect('admin/adminlogin/');
		}
		else{
		$data = $this->path->all_path();
		$data['user_id']	= $this->tank_auth->get_admin_user_id();
		$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
		$data['admin_priv']=$this->adminmodel->get_user_privilege($data['user_id']);
		if(!($data['admin_priv']))
		{
			redirect('admin/adminlogout');
		}
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar',$data);
		$delete_user_priv=array('5','7','8','10');
		$flag=0;
		if($data['admin_user_level']=='5')
		{
		$this->courses->delete_single_course($prog_id);
		redirect('admincourses/manage_courses/cds');
		}
		else{
		$this->load->view('admin/accesserror', $data);
		}
		
		}
		}
		//new
		function delete_single_course_univ($prog_id='')
		{
		
		if (!$this->tank_auth->is_admin_logged_in()) {
			redirect('admin/adminlogin/');
		}
		else{
		$data = $this->path->all_path();
		$data['user_id']	= $this->tank_auth->get_admin_user_id();
		$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
		$data['admin_priv']=$this->adminmodel->get_user_privilege($data['user_id']);
		if(!($data['admin_priv']))
		{
			redirect('admin/adminlogout');
		}
		
		if($data['admin_user_level']=='5' || $data['admin_user_level']=='3') 
		{ 
			$deleted=$this->courses_model->delete_single_course_univ($prog_id);
			echo $deleted;
		}
		else
		{
			echo 0;
		}
		}
		}
		function delete_courses()
		{
		
		if (!$this->tank_auth->is_admin_logged_in()) {
			redirect('admin/adminlogin/');
		}
		else{
		$data = $this->path->all_path();
		$data['user_id']	= $this->tank_auth->get_admin_user_id();
		$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
		$data['admin_priv']=$this->adminmodel->get_user_privilege($data['user_id']);
		if(!($data['admin_priv']))
		{
			redirect('admin/adminlogout');
		}
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar',$data);
		if($data['admin_user_level']=='5')
		{
		$this->courses->delete_courses();
		redirect('admincourses/manage_courses/cds');
		}
		else{
		$this->load->view('admin/accesserror', $data);
		}
		
		}
		}
		//new
		function manage_univ_course($msg='')
		{
			if (!$this->tank_auth->is_admin_logged_in()) 
			{
				redirect('admin/adminlogin/');
			}
			else
			{
				$data = $this->path->all_path();
				$data['user_id']	= $this->tank_auth->get_admin_user_id();
				$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
				$data['admin_priv']=$this->adminmodel->get_user_privilege($data['user_id']);
				if(!($data['admin_priv']))
				{
					redirect('admin/adminlogout');
				}
				$data['openhtml']=0;		
				if($data['admin_user_level']=='5' || $data['admin_user_level']=='3')
				{
					if($msg=='cds')
					{
						$data['msg']='Course Deleted Sucessfully';
						$this->load->view('admin/userupdated',$data);
					}
					if($msg=='cas')
					{
						$data['msg']='Program Added Sucessfully';
						$this->load->view('admin/userupdated',$data);
					}
					if($data['admin_user_level']=='3')
					{
						$this->load->view('univadmin/header',$data);
						$this->load->view('univadmin/sidebar',$data);
						$univ=$this->events->fetch_univ_id($data['user_id']);
						$univ_id=$univ['univ_id'];
						$data['course_info']=$this->courses_model->fetch_univ_courses($univ_id);
						$data['course_latest']=$this->courses_model->univ_courses_latest($univ_id);
						$this->load->view('univadmin/courses/univ_courses', $data);
					}
					else if($data['admin_user_level']=='5')
					{
						$this->load->view('univadmin/header',$data);
						$this->load->view('univadmin/sidebar',$data);
						$data['univ_info']=$this->events->get_univ_detail();
						$data['course_info']=$this->courses_model->fetch_all_univ_courses();
						$data['course_latest']=$this->courses_model->fetch_univ_courses_latest();
						//$this->load->view('admin/courses/manage_univ_courses', $data);
						$this->load->view('univadmin/courses/univ_courses', $data);
					}
					
					
				}
				else
				{
					$this->load->view('admin/accesserror', $data);
				}
		
			}
		}
		//new
	function delete_univ_courses()
	{
		if (!$this->tank_auth->is_admin_logged_in()) 
		{
			redirect('admin/adminlogin/');
		}
		else
		{
			$data = $this->path->all_path();
			$data['user_id']	= $this->tank_auth->get_admin_user_id();
			$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
			$data['admin_priv']=$this->adminmodel->get_user_privilege($data['user_id']);
			if(!($data['admin_priv']))
			{
				redirect('admin/adminlogout');
			}
			
			if($data['admin_user_level']=='5' || $data['admin_user_level']=='3')
			{			
				$deleted=$this->courses_model->delete_univ_courses();
				echo $deleted;
			}
			else
			{
			echo 0;
			}
		
		}
	}

	function fetch_univ_course_ajax()
	{
		if (!$this->tank_auth->is_admin_logged_in()) {
			redirect('admin/adminlogin/');
		}
		else {
		$data = $this->path->all_path();
		$data['user_id']	= $this->tank_auth->get_admin_user_id();
		$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
		$univ_id=$this->input->post('university');
		$data['course_info']=$this->courses->fetch_univ_courses($univ_id);
		$this->load->view('ajaxviews/manage_univ_courses',$data);
		}
	}
	
	function map_area_interest_and_progrmas()
	{
		if (!$this->tank_auth->is_admin_logged_in()) {
			redirect('admin/adminlogin/');
		}
		else{
		$data = $this->path->all_path();
		$data['user_id']	= $this->tank_auth->get_admin_user_id();
		$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
		$data['admin_priv']=$this->adminmodel->get_user_privilege($data['user_id']);
		if(!($data['admin_priv']))
		{
			redirect('admin/adminlogout');
		}
		$data['area_interest']=$this->users->fetch_area_interest();
		$data['program_list']=$this->courses->fetch_program_list('4');
		
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar',$data);
		if($data['admin_user_level']=='5')
		{
		$this->load->view('admin/courses/area_vs_postgraduate_program', $data);
		
		}
		else{
		$this->load->view('admin/accesserror', $data);
		}
		
		}
	
	}
	
	function map_program_and_university($cis='')
	{
		if (!$this->tank_auth->is_admin_logged_in()) {
				redirect('admin/adminlogin/');
			}
			else{
			$data = $this->path->all_path();
			$data['user_id']	= $this->tank_auth->get_admin_user_id();
			$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
			$data['admin_priv']=$this->adminmodel->get_user_privilege($data['user_id']);
			if(!($data['admin_priv']))
			{
			redirect('admin/adminlogout');
			}
			$data['university_detail']=$this->courses->fetch_universities();
			
			$this->load->view('admin/header',$data);
			$this->load->view('admin/sidebar',$data);
			if($data['admin_user_level']=='5')
			{
			if($this->input->post('submit'))
			{
			 $this->courses->insert_courses_to_univ();
			redirect('admincourses/map_program_and_university/cis');			 
			}
			if($cis=='cis')
			{
			$data['msg']='Course Updated in the selected university sucessfully';
			$this->load->view('admin/userupdated',$data);
			}	
			$this->load->view('admin/courses/univ_vs_program', $data);
			
			}
			else{
			$this->load->view('admin/accesserror', $data);
			}
			
			}
	}
	
	function fetch_univ_programs_ajax()
	{
		
		if (!$this->tank_auth->is_admin_logged_in()) {
				redirect('admin/adminlogin/');
			}
			else{
			$data = $this->path->all_path();
			$data['user_id']	= $this->tank_auth->get_admin_user_id();
			$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
			if($data['admin_user_level']=='5')
			{
			$data['program_list']=$this->courses->fetch_program_list_with_educ_level();
			$data['univ_program']=$this->courses->fetch_univ_program($this->input->post('university'));
			$this->load->view('ajaxviews/univ_vs_program_ajax', $data);	
			}
			
			}
	}
	
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */