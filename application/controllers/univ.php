<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Univ extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('security');
		$this->load->helper('url');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
		$this->load->helper('string');
		$this->load->library('email');
		$this->ci =& get_instance();
		$this->load->library('fbConn/facebook');
	}

	/* Function used for single university page */
function university($univ_id='',$qid='',$uid='')
	{
		$data = $this->path->all_path();
		
		$this->load->view('auth/header',$data);
		$data['univ_id_for_program'] = $univ_id;
		$data['university_details'] = $this->users->get_university_by_id($univ_id);
		$country_id = $data['university_details']['country_id'];
		$city_id = $data['university_details']['city_id'];
		$state_id = $data['university_details']['state_id'];
		$longitude = $data['university_details']['longitude'];
		$latitude = $data['university_details']['latitude'];
		$university_name = $data['university_details']['univ_name'];
		$university_address = $data['university_details']['address_line1'];
		$logged_user_id = $this->session->userdata('user_id');
		$redirect_current_url = $this->config->site_url().$this->uri->uri_string();
   
		 $redirect_current_url = $this->config->site_url().$this->uri->uri_string();
		 $data['area_interest'] = $this->users->fetch_area_interest();
		 $data['univ_gallery'] = $this->users->get_univ_gallery($univ_id);
		 $data['article_gallery'] = $this->users->get_detail_articles_of_univ($univ_id);
		 $data['news_gallery'] = $this->users->get_detail_news_of_univ($univ_id);
		 $data['followers_detail_of_univ'] = $this->users->get_followers_detail_of_univ($univ_id);
		 $data['events_of_univ'] = $this->users->fetch_latest_events_by_univ_id($univ_id);
		 $add_follower = array(
			'follow_to_univ_id' => $univ_id,
			'followed_by' => $logged_user_id
			);
			
		$data['is_already_follow'] = $this->users->check_is_already_followed($add_follower);
		
	/* code for university map */
  $this->load->library('GMapuniv');
  $this->gmapuniv->GoogleMapAPI();
  $this->gmapuniv->setMapType('map');
  //$this->gmapuniv->addMarkerByAddress($longitude,$latitude,$university_name,$university_address);
  $this->gmapuniv->addMarkerByAddress($university_address,$university_name, $university_address);
  
      $data['headerjs'] = $this->gmapuniv->getHeaderJS();
      $data['headermap'] = $this->gmapuniv->getMapJS();
      $data['onload'] = $this->gmapuniv->printOnLoad();
      $data['map'] = $this->gmapuniv->printMap();
      $data['sidebar'] = $this->gmapuniv->printSidebar();
		
		if($this->input->post('join_now'))
		{
			if (!$this->tank_auth->is_logged_in()) {
			redirect('/home');
		} else {
			$data['user_follow_university'] = $this->users->add_followers($add_follower);
			redirect($redirect_current_url);
			}
		}

		else if($this->input->post('unjoin_now'))
		{
			$data['unjoin_now_success'] = $this->users->unjoin_now($add_follower);
			redirect($redirect_current_url);
		}
		
		else if($this->input->post('apply_now'))
		{
			
			$condition = array(
				'firstname' => $this->input->post('apply_name'),
				'prog_parent_id' => $this->input->post('apply_course_interest'),
				'email' => $this->input->post('apply_email'),
				'phone_no1' => $this->input->post('apply_mobile'),
				'applied_univ_id'=> $univ_id
			);
			//print_r($apply_now_data);
			//$this->session->set_userdata($apply_now_data);
			$this->form_validation->set_rules('apply_name', 'Name ', 'trim|required|xss_clean');
			$this->form_validation->set_rules('apply_course_interest', 'Course', 'required');
			$this->form_validation->set_rules('apply_email', 'Email', 'trim|required|xss_clean|valid_email');
			$this->form_validation->set_rules('apply_mobile', 'Email', 'trim|required|xss_clean|numeric');
			if($this->form_validation->run())
			{
			$this->session->set_userdata('current_insert_lead_email',$this->input->post('apply_email'));
			$insert_type = '0';
			$data['fb_sidebar_apply_form'] = $this->leadmodel->insert_data_lead_data($condition,$insert_type);
			if($data['fb_sidebar_apply_form'] != '')
			{
			$this->session->set_userdata('current_insert_lead_id', $this->db->insert_id());
			//print_r($this->session->userdata('current_insert_lead_id'));
			}
			redirect('find_college');
			}
			else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
			}
			//print_r($data['fb_sidebar_apply_form']);
			
		}
		else if($this->input->post('ask_quest'))
		  {
		   
		   $univ_quest = $this->input->post('quest_on_univ');
		   
			$quest_title = array(
			'ask_quest_on_univ_page'=>$univ_quest
			);
			$this->session->set_userdata($quest_title);
			redirect("UniversityQuestSection/$univ_id");

		  }
		if($data['university_details'] != 0)
		{
			$data['country_name_university'] = $this->users->fetch_country_name_by_id($country_id);
			$data['city_name_university'] = $this->users->fetch_city_name_by_id($city_id);
			$data['state_name_university'] = $this->users->fetch_state_name_by_id($state_id);
			$data['count_followers'] = $this->users->get_followers_of_univ($univ_id);
			$data['count_articles'] = $this->users->get_articles_of_univ($univ_id);
			$this->load->view('auth/univ-header-gallery-logo',$data);
			$this->load->view('auth/university',$data);
		}
		
		else{
		/* load not found if university not found */
		$data['err_msg']='<h2> Sorry....</br><span class="text-align"> Page Not Found.... </span> </h2>';
		$data['err_div']=1;
		$this->load->view('auth/NotFoundPage',$data);
		}
		
		$this->load->view('auth/footer',$data);
	}
	
	/* This Function used for get program categories provided by university */
	function univ_programs($univ_id='',$prg='')
	{
		$data = $this->path->all_path();
		$data['err_div']=0;
		$this->load->view('auth/header',$data);
		$data['univ_id_for_program'] = $univ_id;
		$data['university_details'] = $this->users->get_university_by_id($univ_id);
		
		$country_id = $data['university_details']['country_id'];
		$city_id = $data['university_details']['city_id'];
		$state_id = $data['university_details']['state_id'];
		$university_name = $data['university_details']['univ_name'];
		$university_address = $data['university_details']['address_line1'];
		$logged_user_id = $this->session->userdata('user_id');
		 $redirect_current_url = $this->config->site_url().$this->uri->uri_string();
		 $data['area_interest'] = $this->users->fetch_area_interest();
		 $data['univ_gallery'] = $this->users->get_univ_gallery($univ_id);
		
		 if($data['university_details'] != 0)
		{
			$data['country_name_university'] = $this->users->fetch_country_name_by_id($country_id);
			$data['city_name_university'] = $this->users->fetch_city_name_by_id($city_id);
			$data['state_name_university'] = $this->users->fetch_state_name_by_id($state_id);
			$data['count_followers'] = $this->users->get_followers_of_univ($univ_id);
			$data['count_articles'] = $this->users->get_articles_of_univ($univ_id);
			if($prg == 'program')
		    {
			$data['prog_title_of_univ'] = $this->users->fetch_program_title_of_univ($univ_id);
		    }
		$this->load->view('auth/univ-header-gallery-logo',$data);
		$this->load->view('auth/university-courses',$data);
		}
		else{
		$data['err_msg']='<h2> Sorry....</br><span class="text-align"> Page Not Found.... </span> </h2>';
		$data['err_div']=1;
		$this->load->view('auth/NotFoundPage',$data);
		}
		$this->load->view('auth/footer',$data);
	}
	
	/* This Function used for get course detail of program category 
	of university selected by user */
	
	function program_detail($univ_id='',$course_id='')
	{
		$data = $this->path->all_path();
		$data['err_div']=0;
		$this->load->view('auth/header',$data);
		$data['univ_id_for_program'] = $univ_id;
		$data['university_details'] = $this->users->get_university_by_id($univ_id);
		
		$country_id = $data['university_details']['country_id'];
		$city_id = $data['university_details']['city_id'];
		$state_id = $data['university_details']['state_id'];
		$university_name = $data['university_details']['univ_name'];
		$university_address = $data['university_details']['address_line1'];
		$logged_user_id = $this->session->userdata('user_id');
		 $redirect_current_url = $this->config->site_url().$this->uri->uri_string();
		 $data['area_interest'] = $this->users->fetch_area_interest();
		 $data['univ_gallery'] = $this->users->get_univ_gallery($univ_id);
		
		
		if($data['university_details'] != 0)
		{
			$data['country_name_university'] = $this->users->fetch_country_name_by_id($country_id);
			$data['city_name_university'] = $this->users->fetch_city_name_by_id($city_id);
			$data['state_name_university'] = $this->users->fetch_state_name_by_id($state_id);
			$data['count_followers'] = $this->users->get_followers_of_univ($univ_id);
			$data['count_articles'] = $this->users->get_articles_of_univ($univ_id);
			
			/* get detail of course */
			$data['detail_of_course'] = $this->users->fetch_course_detail($univ_id,$course_id);
			$this->load->view('auth/univ-header-gallery-logo',$data);
			$this->load->view('auth/course_detail_of_univ',$data);
		}
		else{
		$data['err_msg']='<h2> Sorry....</br><span class="text-align"> Page Not Found.... </span> </h2>';
		$data['err_div']=1;
		$this->load->view('auth/NotFoundPage',$data);
		}
		
		$this->load->view('auth/footer',$data);
	}
	
		function scrap()
		{
			$url = "http://www.ucas.com/students/choosingcourses/choosinguni/instguide/z/";
			$data['scrapdata'] = $this->users->get_content($url);
			//$this->load->view('scrap',$data);
		}
		//function for shonwing the univ event
		function univ_event($univ_id='',$event_id='')
		{
			$data = $this->path->all_path();
			$data['err_div']=0;
			$this->load->view('auth/header',$data);
			//$this->load->view('auth/univ-header-gallery-logo',$data);
			$data['univ_id_for_program'] = $univ_id;	
			$data['university_details'] = $this->users->get_university_by_id($univ_id);
			$country_id = $data['university_details']['country_id'];
			$city_id = $data['university_details']['city_id'];
			$state_id = $data['university_details']['state_id'];
			$university_name = $data['university_details']['univ_name'];
			$university_address = $data['university_details']['address_line1'];
			$data['univ_gallery'] = $this->users->get_univ_gallery($univ_id);
			$data['event_detail']=$this->frontmodel->get_event_detail_by_univ($univ_id,$event_id);
			 if($data['university_details'] != 0 )
			 {
				
				$data['country_name_university'] = $this->users->fetch_country_name_by_id($country_id);
				$data['city_name_university'] = $this->users->fetch_city_name_by_id($city_id);
				$data['state_name_university'] = $this->users->fetch_state_name_by_id($state_id);
				$data['count_followers'] = $this->users->get_followers_of_univ($univ_id);
				$data['count_articles'] = $this->users->get_articles_of_univ($univ_id);
				$this->load->view('auth/univ-header-gallery-logo',$data);
				$data['clear_comment']=0;
				if($data['event_detail']!=0)
				{
				$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
				$this->form_validation->set_rules('full_name', 'Name ', 'trim|required|xss_clean');
				$this->form_validation->set_rules('commented_text', 'Commented Text ', 'trim|required|xss_clean'); 
				if ($this->form_validation->run()) {								// validation ok
				$this->frontmodel->insert_user_comment();
				$data['clear_comment']=1;
				}
				$data['event_comments']=$this->frontmodel->fetch_all_comments('event',$event_id);
				$data['user_is_logged_in']=0;
				if($this->tank_auth->is_logged_in())
				{
				$data['user_is_logged_in']=1;
				$data['user_detail']=$this->users->fetch_profile($this->ci->session->userdata('user_id'));
				}
				//print_r($data['user_detail']);
				/* code for Event map-Added by Subh */
				//print_r($data['event_detail']);
				$event_title_map = $data['event_detail']['event_title'];
				$city_event = $data['city_name_university']['cityname'];
				$state_event = $data['state_name_university']['statename'];
				$country_event = $data['country_name_university']['country_name'];
				$event_place_name = $data['event_detail']['event_place'];
				if($event_place = $data['event_detail']['event_place'] == 0 || $event_place = $data['event_detail']['event_place'] == '')
				{
				$event_place = $city_event.','.$state_event.','.$country_event;
				}
				else if($data['city_name_university']['cityname'] == 0 || $data['city_name_university']['cityname'] == '') {
				$event_place = $event_place_name.' '.$state_event.' '.$country_event;
				}
				else if($data['state_name_university']['statename'] == 0 || $data['state_name_university']['statename'] ==''){
				$event_place = $event_place_name.' '.$city_event.' '.$country_event;
				}
				else if($data['country_name_university']['country_name'] == 0 || $data['country_name_university']['country_name'] =='')
				{
					$event_place = $event_place_name.' '.$city_event.' '.$state_event;
				}
				else {
				$event_place = $event_place_name.' '.$city_event.' '.$state_event.' '.$country_event;
				}	 		
					  $this->load->library('GMapevent');
					  $this->gmapevent->GoogleMapAPI();
					  $this->gmapevent->setMapType('map');
					  //$this->gmapuniv->addMarkerByAddress($longitude,$latitude,$university_name,$university_address);
					  $this->gmapevent->addMarkerByAddress($event_place,$event_title_map, $event_place);
					  
						  $data['headerjs'] = $this->gmapevent->getHeaderJS();
						  $data['headermap'] = $this->gmapevent->getMapJS();
						  $data['onload'] = $this->gmapevent->printOnLoad();
						  $data['map'] = $this->gmapevent->printMap();
						  $data['sidebar'] = $this->gmapevent->printSidebar();
				$this->load->view('auth/univ_event_detail',$data);
				
				}
				else
				{
				$data['err_msg']='<h2> Sorry....</br><span class="text-align"> Event Not Found.... </span> </h2>';
				$this->load->view('auth/NotFoundPage',$data);
				}
				
			}
			else{
			$data['err_msg']='<h2> Sorry....</br><span class="text-align"> Page Not Found.... </span> </h2>';
			$data['err_div']=1;
			$this->load->view('auth/NotFoundPage',$data);
			}
				$this->load->view('auth/footer',$data);
		}
	function university_events_list($univ_id='')
	{
			$data = $this->path->all_path();
			$data['err_div']=0;
			$this->load->view('auth/header',$data);
			//$this->load->view('auth/univ-header-gallery-logo',$data);
			$data['univ_id_for_program'] = $univ_id;	
			$data['university_details'] = $this->users->get_university_by_id($univ_id);
			$country_id = $data['university_details']['country_id'];
			$city_id = $data['university_details']['city_id'];
			$state_id = $data['university_details']['state_id'];
			$university_name = $data['university_details']['univ_name'];
			$university_address = $data['university_details']['address_line1'];
			$data['univ_gallery'] = $this->users->get_univ_gallery($univ_id);
			$data['event_list_detail']=$this->frontmodel->get_events_list_by_univ($univ_id);
			if($data['university_details'] != 0 )
			{
				$data['country_name_university'] = $this->users->fetch_country_name_by_id($country_id);
				$data['city_name_university'] = $this->users->fetch_city_name_by_id($city_id);
				$data['state_name_university'] = $this->users->fetch_state_name_by_id($state_id);
				$data['count_followers'] = $this->users->get_followers_of_univ($univ_id);
				$data['count_articles'] = $this->users->get_articles_of_univ($univ_id);
				$this->load->view('auth/univ-header-gallery-logo',$data);
				if($data['event_list_detail']!=0)
				{
				$this->load->view('auth/university_events_list',$data);
				}
				else
				{
				$data['err_msg']='<h2> Sorry....</br><span class="text-align">No Upcoming Event.... </span> </h2>';
				$this->load->view('auth/NotFoundPage',$data);
				}
			}
			else{
			$data['err_msg']='<h2> Sorry....</br><span class="text-align">Page Not Found.... </span> </h2>';
			$data['err_div']=1;
			$this->load->view('auth/NotFoundPage',$data);
			}
			$this->load->view('auth/footer',$data);
	}

	function university_news_list($univ_id='')
	{
			$data = $this->path->all_path();
			$data['err_div']=0;
			$this->load->view('auth/header',$data);
			//$this->load->view('auth/univ-header-gallery-logo',$data);
			$data['univ_id_for_program'] = $univ_id;	
			$data['university_details'] = $this->users->get_university_by_id($univ_id);
			$country_id = $data['university_details']['country_id'];
			$city_id = $data['university_details']['city_id'];
			$state_id = $data['university_details']['state_id'];
			$university_name = $data['university_details']['univ_name'];
			$university_address = $data['university_details']['address_line1'];
			$data['univ_gallery'] = $this->users->get_univ_gallery($univ_id);
			$data['news_list_detail']=$this->frontmodel->get_news_list_by_univ($univ_id);
			if($data['university_details'] != 0 )
			{
				$data['country_name_university'] = $this->users->fetch_country_name_by_id($country_id);
				$data['city_name_university'] = $this->users->fetch_city_name_by_id($city_id);
				$data['state_name_university'] = $this->users->fetch_state_name_by_id($state_id);
				$data['count_followers'] = $this->users->get_followers_of_univ($univ_id);
				$data['count_articles'] = $this->users->get_articles_of_univ($univ_id);
				$this->load->view('auth/univ-header-gallery-logo',$data);
				if($data['news_list_detail']!=0)
				{
				$this->load->view('auth/university_news_list',$data);
				}
				else
				{
				$data['err_msg']='<h2> Sorry....</br><span class="text-align">No Recent News.... </span> </h2>';
				$this->load->view('auth/NotFoundPage',$data);
				}
			}
			else{
			$data['err_msg']='<h2> Sorry....</br><span class="text-align">Page Not Found.... </span> </h2>';
			$data['err_div']=1;
			$this->load->view('auth/NotFoundPage',$data);
			}
			$this->load->view('auth/footer',$data);
	}

	function university_article_list($univ_id='')
	{
			$data = $this->path->all_path();
			$data['err_div']=0;
			$this->load->view('auth/header',$data);
			//$this->load->view('auth/univ-header-gallery-logo',$data);
			$data['univ_id_for_program'] = $univ_id;	
			$data['university_details'] = $this->users->get_university_by_id($univ_id);
			$country_id = $data['university_details']['country_id'];
			$city_id = $data['university_details']['city_id'];
			$state_id = $data['university_details']['state_id'];
			$university_name = $data['university_details']['univ_name'];
			$university_address = $data['university_details']['address_line1'];
			$data['univ_gallery'] = $this->users->get_univ_gallery($univ_id);
			$data['articles_list_detail']=$this->frontmodel->get_articles_list_by_univ($univ_id);
			if($data['university_details'] != 0 )
			{
				$data['country_name_university'] = $this->users->fetch_country_name_by_id($country_id);
				$data['city_name_university'] = $this->users->fetch_city_name_by_id($city_id);
				$data['state_name_university'] = $this->users->fetch_state_name_by_id($state_id);
				$data['count_followers'] = $this->users->get_followers_of_univ($univ_id);
				$data['count_articles'] = $this->users->get_articles_of_univ($univ_id);
				$this->load->view('auth/univ-header-gallery-logo',$data);
				if($data['articles_list_detail']!=0)
				{
				$this->load->view('auth/university_articles_list',$data);
				}
				else
				{
				$data['err_msg']='<h2> Sorry....</br><span class="text-align">No Recent Articles.... </span> </h2>';
				$this->load->view('auth/NotFoundPage',$data);
				}
			}
			else{
			$data['err_msg']='<h2> Sorry....</br><span class="text-align">Page Not Found.... </span> </h2>';
			$data['err_div']=1;
			$this->load->view('auth/NotFoundPage',$data);
			}
			$this->load->view('auth/footer',$data);
	}
		function univ_news($univ_id='',$news_id='')
		{
			$data = $this->path->all_path();
			$data['err_div']=0;
			$this->load->view('auth/header',$data);
			//$this->load->view('auth/univ-header-gallery-logo',$data);
			$data['univ_id_for_program'] = $univ_id;	
			$data['university_details'] = $this->users->get_university_by_id($univ_id);
			$country_id = $data['university_details']['country_id'];
			$city_id = $data['university_details']['city_id'];
			$state_id = $data['university_details']['state_id'];
			$university_name = $data['university_details']['univ_name'];
			$university_address = $data['university_details']['address_line1'];
			$data['univ_gallery'] = $this->users->get_univ_gallery($univ_id);
			$data['news_detail']=$this->frontmodel->get_news_detail_by_univ($univ_id,$news_id);
			 if($data['university_details'] != 0 )
			{
				
				$data['country_name_university'] = $this->users->fetch_country_name_by_id($country_id);
				$data['city_name_university'] = $this->users->fetch_city_name_by_id($city_id);
				$data['state_name_university'] = $this->users->fetch_state_name_by_id($state_id);
				$data['count_followers'] = $this->users->get_followers_of_univ($univ_id);
				$data['count_articles'] = $this->users->get_articles_of_univ($univ_id);
				$this->load->view('auth/univ-header-gallery-logo',$data);
				$data['clear_comment']=0;
				if($data['news_detail']!=0)
				{
				$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
				$this->form_validation->set_rules('full_name', 'Name ', 'trim|required|xss_clean');
				$this->form_validation->set_rules('commented_text', 'Commented Text ', 'trim|required|xss_clean'); 
				if ($this->form_validation->run()) {								// validation ok
				$this->frontmodel->insert_user_comment();
				$data['clear_comment']=1;
				}
				$data['news_comments']=$this->frontmodel->fetch_all_comments('news',$news_id);
				$data['user_is_logged_in']=0;
				if($this->tank_auth->is_logged_in())
				{
				$data['user_is_logged_in']=1;
				$data['user_detail']=$this->users->fetch_profile($this->ci->session->userdata('user_id'));
				}
				//print_r($data['user_detail']);
				$this->load->view('auth/univ_news_detail',$data);
				}
				else
				{
				$data['err_msg']='<h2> Sorry....</br><span class="text-align"> NO Recent News Found.... </span> </h2>';
				$this->load->view('auth/NotFoundPage',$data);
				}
				
			}
			else{
			$data['err_msg']='<h2> Sorry....</br><span class="text-align"> Page Not Found.... </span> </h2>';
			$data['err_div']=1;
			$this->load->view('auth/NotFoundPage',$data);
			}
				$this->load->view('auth/footer',$data);
		}
		
	
		function univ_articles($univ_id='',$article_id='')
		{
			$data = $this->path->all_path();
			$data['err_div']=0;
			$this->load->view('auth/header',$data);
			//$this->load->view('auth/univ-header-gallery-logo',$data);
			$data['univ_id_for_program'] = $univ_id;	
			$data['university_details'] = $this->users->get_university_by_id($univ_id);
			$country_id = $data['university_details']['country_id'];
			$city_id = $data['university_details']['city_id'];
			$state_id = $data['university_details']['state_id'];
			$university_name = $data['university_details']['univ_name'];
			$university_address = $data['university_details']['address_line1'];
			$data['univ_gallery'] = $this->users->get_univ_gallery($univ_id);
			$data['articles_detail']=$this->frontmodel->get_article_detail_by_univ($univ_id,$article_id);
			 if($data['university_details'] != 0 )
			{
				
				$data['country_name_university'] = $this->users->fetch_country_name_by_id($country_id);
				$data['city_name_university'] = $this->users->fetch_city_name_by_id($city_id);
				$data['state_name_university'] = $this->users->fetch_state_name_by_id($state_id);
				$data['count_followers'] = $this->users->get_followers_of_univ($univ_id);
				$data['count_articles'] = $this->users->get_articles_of_univ($univ_id);
				$this->load->view('auth/univ-header-gallery-logo',$data);
				$data['clear_comment']=0;
				if($data['articles_detail']!=0)
				{
				$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
				$this->form_validation->set_rules('full_name', 'Name ', 'trim|required|xss_clean');
				$this->form_validation->set_rules('commented_text', 'Commented Text ', 'trim|required|xss_clean'); 
				if ($this->form_validation->run()) {								// validation ok
				$this->frontmodel->insert_user_comment();
				$data['clear_comment']=1;
				}
				$data['article_comments']=$this->frontmodel->fetch_all_comments('article',$article_id);
				$data['user_is_logged_in']=0;
				if($this->tank_auth->is_logged_in())
				{
				$data['user_is_logged_in']=1;
				$data['user_detail']=$this->users->fetch_profile($this->ci->session->userdata('user_id'));
				}
				$this->load->view('auth/univ_article_detail',$data);
				}
				else
				{
				$data['err_msg']='<h2> Sorry....</br><span class="text-align"> NO Recent Article Found.... </span> </h2>';
				$this->load->view('auth/NotFoundPage',$data);
				}
				
			}
			else{
			$data['err_msg']='<h2> Sorry....</br><span class="text-align"> Page Not Found.... </span> </h2>';
			$data['err_div']=1;
			$this->load->view('auth/NotFoundPage',$data);
			}
				$this->load->view('auth/footer',$data);
		}
		
		function post_comment()
		{
			$data = $this->path->all_path();
			$logged_in_user_id=$this->ci->session->userdata('user_id');
			$data['commented_on']=$this->input->post('commentd_on');
			$commented_on_id=$this->input->post('commented_on_id');
			$data['commented_text']=$this->input->post('commented_text');
	$data['delete_comment']=$this->frontmodel->post_comment_by_logged_in_user($logged_in_user_id,$data['commented_on'],$commented_on_id,$data['commented_text']);
			$data['user_detail']=$this->users->fetch_profile($logged_in_user_id);
			$this->load->view('ajaxviews/post_comment',$data);
		}
		function delete_comment()
		{
		$this->frontmodel->delete_comment();
		}
		
		function count_comment($commented_on_id='')
		{
			$event_id = $commented_on_id;
			$data['count_comment']=$this->frontmodel->fetch_all_comments('event',$event_id);
			$data['event_comments_count'] = count($data['count_comment']);
			print_r($data['event_comments_count']);
			$this->load->view('ajaxviews/count_comment',$data);
		}
	
  function UniversityQuest($univ_id='',$quest_id='',$user_id='')
  {
   $data = $this->path->all_path();
   $this->load->view('auth/header',$data);
   $data['univ_id_for_program'] = $univ_id; 
   $data['university_details'] = $this->users->get_university_by_id($univ_id);
   $country_id = $data['university_details']['country_id'];
   $city_id = $data['university_details']['city_id'];
   $state_id = $data['university_details']['state_id'];
   $university_name = $data['university_details']['univ_name'];
   $university_address = $data['university_details']['address_line1'];
   $data['univ_gallery'] = $this->users->get_univ_gallery($univ_id);
   if($data['university_details'] != 0 )
   {
    $data['country_name_university'] = $this->users->fetch_country_name_by_id($country_id);
    $data['city_name_university'] = $this->users->fetch_city_name_by_id($city_id);
	$data['state_name_university'] = $this->users->fetch_state_name_by_id($state_id);
    $data['count_followers'] = $this->users->get_followers_of_univ($univ_id);
    $data['count_articles'] = $this->users->get_articles_of_univ($univ_id);
    $this->load->view('auth/univ-header-gallery-logo',$data);
				
    if($univ_id !=''&& $quest_id !='' && $user_id !='')
    {
    $data['single_quest'] = $this->quest_ans_model->get_single_quest_detail($univ_id,$quest_id,$user_id);
	$data['clear_comment']=0;
	if($data['single_quest']!=0)
	{
				$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
				$this->form_validation->set_rules('full_name', 'Name ', 'trim|required|xss_clean');
				$this->form_validation->set_rules('commented_text', 'Commented Text ', 'trim|required|xss_clean'); 
				if ($this->form_validation->run()) {								// validation ok
				$this->frontmodel->insert_user_comment();
				$data['clear_comment']=1;
				}
				$data['question_comments']=$this->frontmodel->fetch_all_comments('qna',$quest_id);
				$data['user_is_logged_in']=0;
				if($this->tank_auth->is_logged_in())
				{
				$data['user_is_logged_in']=1;
				$data['user_detail']=$this->users->fetch_profile($this->ci->session->userdata('user_id'));
				}
	}
    //print_r($data['single_quest']);
    }
    $this->load->view('auth/univ_questions',$data);
   }
   else{
   $data['err_msg']='<h2> Sorry....</br><span class="text-align">Page Not Found.... </span> </h2>';
   $data['err_div']=1;
   $this->load->view('auth/NotFoundPage',$data);
   }
   $this->load->view('auth/footer',$data);
  }
		function UniversityQuestSection($univ_id='',$quest_id='',$user_id='')
		{
			$data = $this->path->all_path();
			$this->load->view('auth/header',$data);
			if($this->session->userdata('quest_send_suc')=='1')
			{
				$data['show_quest_send_msg'] = '1';
				//$this->session->set_userdata('quest_send_suc','');
				$this->session->set_userdata('quest_send_suc','');
			}
			else{
				$data['show_quest_send_msg'] = '';
			}
			$data['univ_id_for_program'] = $univ_id;	
			$data['university_details'] = $this->users->get_university_by_id($univ_id);
			$country_id = $data['university_details']['country_id'];
			$city_id = $data['university_details']['city_id'];
			$state_id = $data['university_details']['state_id'];
			$university_name = $data['university_details']['univ_name'];
			$university_address = $data['university_details']['address_line1'];
			$data['univ_gallery'] = $this->users->get_univ_gallery($univ_id);
			if($data['university_details'] != 0 )
			{
				$data['country_name_university'] = $this->users->fetch_country_name_by_id($country_id);
				$data['city_name_university'] = $this->users->fetch_city_name_by_id($city_id);
				$data['state_name_university'] = $this->users->fetch_state_name_by_id($state_id);
				$data['count_followers'] = $this->users->get_followers_of_univ($univ_id);
				$data['count_articles'] = $this->users->get_articles_of_univ($univ_id);
				$data['get_all_question_of_univ'] = $this->quest_ans_model->get_all_quest_of_univ_user_info($univ_id);
				$data['count_all_question_of_univ'] = $this->quest_ans_model->count_all_questions_of_univ($univ_id);
				$this->load->view('auth/univ-header-gallery-logo',$data);
				
				if($this->input->post('post_quest_on_univ'))
				{
					$this->form_validation->set_rules('quest_title','Question Title','required');
					if($this->form_validation->run())
					{
					
					if (!$this->tank_auth->is_logged_in()) {
			$univ_or_country_id = $univ_id;
			$quest_title = $this->input->post('quest_title');
			$quest_detail = $this->input->post('quest_detail');
			//$quest_cat_type = 'col';
			
			$quest = array(
			'q_category'=>'univ',
			'q_univ_id'=>$univ_or_country_id,
			'q_title'=>$quest_title,
			'q_detail'=>$quest_detail,
			'q_approve'=>'0',
			'q_featured_home_que'=>'0',
			'q_featured_country_que'=>'0',
			);
			$quest_sess = array(
			'quest_sess_active'=>'true'
			);
			$quest_cat_type = array(
			'quest_cat_type'=>'col'
			);
			
			$this->session->set_userdata($quest);
			$this->session->set_userdata('redirect_section',$univ_id);
			$this->session->set_userdata($quest_sess);
			$this->session->set_userdata($quest_cat_type);
			
			redirect('/login/');
		} else {
			$univ_or_country_id = $univ_id;
			$quest_title = $this->input->post('quest_title');
			$quest_detail = $this->input->post('quest_detail');
			$data['user_id']	= $this->tank_auth->get_user_id();
			$quest_cat_type = 'col';
			
			$quest = array(
			'q_category'=>'univ',
			'q_univ_id'=>$univ_or_country_id,
			'q_title'=>$quest_title,
			'q_detail'=>$quest_detail,
			'q_askedby'=>$data['user_id'],
			'q_approve'=>'0',
			'q_featured_home_que'=>'0',
			'q_featured_country_que'=>'0',
			);
			$data['post_quest'] = $this->quest_ans_model->post_quest($quest);
			$this->session->set_userdata('ask_quest_on_univ_page','');
			$data['show_quest_send_msg'] = '1';
			}
			}		
			}		
				
				$this->load->view('auth/ask_quest_in_univ',$data);
				
			}
			else{
			$data['err_msg']='<h2> Sorry....</br><span class="text-align">Page Not Found.... </span> </h2>';
			$data['err_div']=1;
			$this->load->view('auth/NotFoundPage',$data);
			}
			$this->load->view('auth/footer',$data);
		}
		
	function univ_aboutus($univ_id='')
	{
			$data = $this->path->all_path();
			$data['err_div']=0;
			$this->load->view('auth/header',$data);
			//$this->load->view('auth/univ-header-gallery-logo',$data);
			$data['univ_id_for_program'] = $univ_id;	
			$data['university_details'] = $this->users->get_university_by_id($univ_id);
			$country_id = $data['university_details']['country_id'];
			$city_id = $data['university_details']['city_id'];
			$state_id = $data['university_details']['state_id'];
			$university_name = $data['university_details']['univ_name'];
			$university_address = $data['university_details']['address_line1'];
			$data['univ_gallery'] = $this->users->get_univ_gallery($univ_id);
			if($data['university_details'] != 0 )
			{
				$data['country_name_university'] = $this->users->fetch_country_name_by_id($country_id);
				$data['city_name_university'] = $this->users->fetch_city_name_by_id($city_id);
				$data['state_name_university'] = $this->users->fetch_state_name_by_id($state_id);
				$data['count_followers'] = $this->users->get_followers_of_univ($univ_id);
				$data['count_articles'] = $this->users->get_articles_of_univ($univ_id);
				$this->load->view('auth/univ-header-gallery-logo',$data);
				$this->load->view('auth/univ_about_us',$data);
			}
			else{
			$data['err_msg']='<h2> Sorry....</br><span class="text-align">Page Not Found.... </span> </h2>';
			$data['err_div']=1;
			$this->load->view('auth/NotFoundPage',$data);
			}
		$this->load->view('auth/footer',$data);
	}	
	
	function follow_to_univ()
	{
		if (!($this->tank_auth->is_logged_in())) {	
		$this->session->set_userdata('follow_to_univ','1');
			echo "login";
		}
		else
		{
		$user_id	= $this->tank_auth->get_user_id();
		$add_follower = array(
			'follow_to_univ_id' => $this->input->post('univ_id'),
			'followed_by' => $user_id
			);
		$already_followed=$this->users->check_is_already_followed($add_follower);	
		if(!($already_followed))	
		{
		$this->users->add_followers($add_follower);
		echo "nowfollowed";
		}
		else
		{
		$this->users->unjoin_now($add_follower);
		echo "nowunfollowed";	
		}
		}
	}
	
	function search_event_by_calendar()
		{
			$data = $this->path->all_path();
			$event_date = $this->input->post('date');
			$event_month = $this->input->post('month');
			$event_year = $this->input->post('year');
			$complete_event_date = $event_date .' '. $event_month .' '. $event_year;
			$type= $this->input->post('type');
			
			if($type == "all")
			{
			$event_date = array(
			'event_date_time'=>$complete_event_date,
			'event_type'=>'univ_event'
			);
			$data['search_event_by_calendar'] = $this->search_event_calendar->get_event_list_by_calendar($event_date);
			$this->load->view('ajaxviews/all_event_list_by_calendar_ajax',$data);
			}
			else if($type == "spot")
			{
			$event_date = array(
			'event_date_time'=>$complete_event_date,
			'event_type'=>'univ_event',
			'event_category'=>'spot_admission'
			);
			$data['search_event_by_calendar'] = $this->search_event_calendar->get_event_list_by_calendar($event_date);
			//print_r($data['search_event_by_calendar']);
				$this->load->view('ajaxviews/spot_event_list_by_calendar_ajax',$data);
			}
			else if($type == "fairs")
			{
				$event_date = array(
			'event_date_time'=>$complete_event_date,
			'event_type'=>'univ_event',
			'event_category'=>'fairs'
			);
			$data['search_event_by_calendar'] = $this->search_event_calendar->get_event_list_by_calendar($event_date);
				$this->load->view('ajaxviews/fairs_event_list_by_calendar_ajax',$data);
			}
			else if($type == "counsell")
			{
			$event_date = array(
			'event_date_time'=>$complete_event_date,
			'event_type'=>'univ_event',
			'event_category'=>'alumuni'
			);
			$data['search_event_by_calendar'] = $this->search_event_calendar->get_event_list_by_calendar($event_date);
				$this->load->view('ajaxviews/counsell_event_list_by_calendar_ajax',$data);
			}
		}
	
}		
	
?>