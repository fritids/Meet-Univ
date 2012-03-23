<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->gallery_path = realpath(APPPATH . '../uploads/home_gallery');
		// $data['base'] = $this->config->item('base_url');
		// $data['css'] = $this->config->item('css_path');
		// $data['css'] = $this->config->item('img_path');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
	}

	function index()
	{
		$data = $this->path->all_path();
		//$this->load->view('auth/header',$data);
		//$this->load->view('auth/footer',$data);
		if (!$this->tank_auth->is_admin_logged_in()) {
			redirect('admin/adminlogin/');
		} else {
			$data['username']	= $this->tank_auth->get_username();
			$data['user_id']	= $this->tank_auth->get_admin_user_id();
			$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
			$data['admin_priv']=$this->adminmodel->get_user_privilege($data['user_id']);
			//fetch user privilege data from model
			$this->load->view('admin/header', $data);
			$this->load->view('admin/sidebar', $data);	
			$this->load->view('admin/main', $data);
			
		}

		
		
		
		/*if ($message = $this->session->flashdata('message')) {
			$this->load->view('auth/general_message', array('message' => $message));
		} else {
			redirect('admin/adminlogin');
		}*/
	}

	/**
	 * Login user on the site
	 *
	 * @return void
	 */
	 
	 
	 
	function adminlogin()
	{
		$data = $this->path->all_path();
		if ($this->tank_auth->is_admin_logged_in()) {									// logged in
			redirect('');

		}  else {
			$data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND
					$this->config->item('use_username', 'tank_auth'));
			$data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');

			$this->form_validation->set_rules('login', 'Login', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('remember', 'Remember me', 'integer');
			$this->form_validation->set_rules('user_type', 'user_type', 'string');

			// Get login for counting attempts to login
			if ($this->config->item('login_count_attempts', 'tank_auth') AND
					($login = $this->input->post('login'))) {
				$login = $this->security->xss_clean($login);
			} else {
				$login = '';
			}

			//$data['use_recaptcha'] = $this->config->item('use_recaptcha', 'tank_auth');
			/*if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
				if ($data['use_recaptcha'])
					$this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
				else
					$this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
			}*/
			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if ($this->tank_auth->login(
						$this->form_validation->set_value('login'),
						$this->form_validation->set_value('password'),
						$this->form_validation->set_value('remember'),
						$data['login_by_username'],
						$data['login_by_email'],
						$this->form_validation->set_value('user_type')
						)) {								// success
					redirect('/admin/');

				} else {
					$errors = $this->tank_auth->get_error_message();
					if (isset($errors['banned'])) {								// banned user
						$this->_show_message($this->lang->line('auth_message_banned').' '.$errors['banned']);

					} elseif (isset($errors['not_activated'])) {				// not activated user
						redirect('/auth/send_again/');

					} else {													// fail
						foreach ($errors as $k => $v)	{
						$data['errors'][$k] = $this->lang->line($v);
						}
						
					}
				}
			}
			/*$data['show_captcha'] = FALSE;
			if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
				$data['show_captcha'] = TRUE;
				if ($data['use_recaptcha']) {
					$data['recaptcha_html'] = $this->_create_recaptcha();
				} else {
					$data['captcha_html'] = $this->_create_captcha();
				}
			}*/
		//	$this->load->view('auth/login', $data);
		}
		$this->load->view('admin/backend',$data);
	}

	/**
	 * Logout user
	 *
	 * @return void
	 */
	function adminlogout()
	{
		$this->tank_auth->adminlogout();
		redirect('admin');
		//$this->_show_message($this->lang->line('auth_message_logged_out'));
	}

	
	
	/**
	 * Register user on the site
	 *
	 * @return void
	 */
	function adduser()
	{
	if (!$this->tank_auth->is_admin_logged_in()) {
			redirect('admin/adminlogin/');
		}
	else {

			
	
	$data = $this->path->all_path();
	$data['user_id']	= $this->tank_auth->get_admin_user_id();
	$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
	$data['admin_priv']=$this->adminmodel->get_user_privilege($data['user_id']);
	
	$this->load->view('admin/header',$data);
	$this->load->view('admin/sidebar',$data);
	$use_username = $this->config->item('use_username', 'tank_auth');
			if ($use_username) {
				$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|min_length['.$this->config->item('username_min_length', 'tank_auth').']|max_length['.$this->config->item('username_max_length', 'tank_auth').']|alpha_dash');
			}
			$this->form_validation->set_rules('fullname', 'Fullname', 'trim|required|xss_clean');
			$this->form_validation->set_rules('createdby', 'Createdby', 'trim');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]');
			$this->form_validation->set_rules('user_type', 'user_type', 'trim|string');
			$this->form_validation->set_rules('level_user', 'User Roll', 'trim|required|string');
			$data['errors'] = array();

			$email_activation = $this->config->item('email_activation', 'tank_auth');

			if ($this->form_validation->run()) {								// validation ok
				if (!is_null($data = $this->tank_auth->create_user(
						$use_username ? $this->form_validation->set_value('username') : '',
						$this->form_validation->set_value('fullname'),
						$this->form_validation->set_value('createdby'),
						$this->form_validation->set_value('level_user'),
						$this->form_validation->set_value('email'),
						$this->form_validation->set_value('password'),
						$this->form_validation->set_value('user_type'),
						$email_activation
						))) {									// success

					$data['site_name'] = $this->config->item('website_name', 'tank_auth');

					
				} else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			
			
			
			//$this->load->view('auth/adduser', $data);
		}
	$add_user_priv=array('4','6','8','10');
	$flag=0;
	foreach($data['admin_priv'] as $userdata['admin_priv']){
	if($userdata['admin_priv']['privilege_type_id']==1 && in_array($userdata['admin_priv']['privilege_level'],$add_user_priv) )
	{
	$this->load->view('admin/adduser', $data);
	$flag=1;
	break;
	}
	}
	if($flag==0)
	{
	$this->load->view('admin/accesserror', $data);
	}
	}
	
	
	}

	/**
	 * Send activation email again, to the same or new email address
	 *
	 * @return void
	 */
	function send_again()
	{
		if (!$this->tank_auth->is_admin_logged_in(FALSE)) {							// not logged in or activated
			redirect('/login/');

		} else {
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if (!is_null($data = $this->tank_auth->change_email(
						$this->form_validation->set_value('email')))) {			// success

					$data['site_name']	= $this->config->item('website_name', 'tank_auth');
					$data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;

					$this->_send_email('activate', $data['email'], $data);

					$this->_show_message(sprintf($this->lang->line('auth_message_activation_email_sent'), $data['email']));

				} else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$this->load->view('auth/send_again_form', $data);
		}
	}

	/**
	 * Activate user account.
	 * User is verified by user_id and authentication code in the URL.
	 * Can be called by clicking on link in mail.
	 *
	 * @return void
	 */
	function activate()
	{
		$user_id		= $this->uri->segment(3);
		$new_email_key	= $this->uri->segment(4);

		// Activate user
		if ($this->tank_auth->activate_user($user_id, $new_email_key)) {		// success
			$this->tank_auth->logout();
			$this->_show_message($this->lang->line('auth_message_activation_completed').' '.anchor('/auth/login/', 'Login'));

		} else {																// fail
			$this->_show_message($this->lang->line('auth_message_activation_failed'));
		}
	}

	/**
	 * Generate reset code (to change password) and send it to user
	 *
	 * @return void
	 */
	function forgot_password()
	{
		if ($this->tank_auth->is_admin_logged_in()) {									// logged in
			redirect('');

		} elseif ($this->tank_auth->is_admin_logged_in(FALSE)) {						// logged in, not activated
			redirect('/send_again/');

		} else {
			$this->form_validation->set_rules('login', 'Email or login', 'trim|required|xss_clean');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if (!is_null($data = $this->tank_auth->forgot_password(
						$this->form_validation->set_value('login')))) {

					$data['site_name'] = $this->config->item('website_name', 'tank_auth');

					// Send email with password activation link
					$this->_send_email('forgot_password', $data['email'], $data);

					$this->_show_message($this->lang->line('auth_message_new_password_sent'));

				} else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$this->load->view('auth/forgot_password_form', $data);
		}
	}

	/**
	 * Replace user password (forgotten) with a new one (set by user).
	 * User is verified by user_id and authentication code in the URL.
	 * Can be called by clicking on link in mail.
	 *
	 * @return void
	 */
	function reset_password()
	{
		$user_id		= $this->uri->segment(3);
		$new_pass_key	= $this->uri->segment(4);

		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
		$this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');

		$data['errors'] = array();

		if ($this->form_validation->run()) {								// validation ok
			if (!is_null($data = $this->tank_auth->reset_password(
					$user_id, $new_pass_key,
					$this->form_validation->set_value('new_password')))) {	// success

				$data['site_name'] = $this->config->item('website_name', 'tank_auth');

				// Send email with new password
				$this->_send_email('reset_password', $data['email'], $data);

				$this->_show_message($this->lang->line('auth_message_new_password_activated').' '.anchor('/auth/login/', 'Login'));

			} else {														// fail
				$this->_show_message($this->lang->line('auth_message_new_password_failed'));
			}
		} else {
			// Try to activate user by password key (if not activated yet)
			if ($this->config->item('email_activation', 'tank_auth')) {
				$this->tank_auth->activate_user($user_id, $new_pass_key, FALSE);
			}

			if (!$this->tank_auth->can_reset_password($user_id, $new_pass_key)) {
				$this->_show_message($this->lang->line('auth_message_new_password_failed'));
			}
		}
		$this->load->view('auth/reset_password_form', $data);
	}

	/**
	 * Change user password
	 *
	 * @return void
	 */
	function change_password()
	{
		if (!$this->tank_auth->is_admin_logged_in()) {								// not logged in or not activated
			redirect('/login/');

		} else {
			$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
			$this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if ($this->tank_auth->change_password(
						$this->form_validation->set_value('old_password'),
						$this->form_validation->set_value('new_password'))) {	// success
					$this->_show_message($this->lang->line('auth_message_password_changed'));

				} else {														// fail
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$this->load->view('auth/change_password_form', $data);
		}
	}

	/**
	 * Change user email
	 *
	 * @return void
	 */
	function change_email()
	{
		if (!$this->tank_auth->is_admin_logged_in()) {								// not logged in or not activated
			redirect('/login/');

		} else {
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if (!is_null($data = $this->tank_auth->set_new_email(
						$this->form_validation->set_value('email'),
						$this->form_validation->set_value('password')))) {			// success

					$data['site_name'] = $this->config->item('website_name', 'tank_auth');

					// Send email with new email address and its activation link
					$this->_send_email('change_email', $data['new_email'], $data);

					$this->_show_message(sprintf($this->lang->line('auth_message_new_email_sent'), $data['new_email']));

				} else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$this->load->view('auth/change_email_form', $data);
		}
	}

	/**
	 * Replace user email with a new one.
	 * User is verified by user_id and authentication code in the URL.
	 * Can be called by clicking on link in mail.
	 *
	 * @return void
	 */
	function reset_email()
	{
		$user_id		= $this->uri->segment(3);
		$new_email_key	= $this->uri->segment(4);

		// Reset email
		if ($this->tank_auth->activate_new_email($user_id, $new_email_key)) {	// success
			$this->tank_auth->logout();
			$this->_show_message($this->lang->line('auth_message_new_email_activated').' '.anchor('/auth/login/', 'Login'));

		} else {																// fail
			$this->_show_message($this->lang->line('auth_message_new_email_failed'));
		}
	}

	/**
	 * Delete user from the site (only when user is logged in)
	 *
	 * @return void
	 */
	function unregister()
	{
		if (!$this->tank_auth->is_admin_logged_in()) {								// not logged in or not activated
			redirect('/login/');

		} else {
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if ($this->tank_auth->delete_user(
						$this->form_validation->set_value('password'))) {		// success
					$this->_show_message($this->lang->line('auth_message_unregistered'));

				} else {														// fail
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$this->load->view('auth/unregister_form', $data);
		}
	}

	/**
	 * Show info message
	 *
	 * @param	string
	 * @return	void
	 */
	function _show_message($message)
	{
		$this->session->set_flashdata('message', $message);
		redirect('/auth/');
	}

	/**
	 * Send email message of given type (activate, forgot_password, etc.)
	 *
	 * @param	string
	 * @param	string
	 * @param	array
	 * @return	void
	 */
	function _send_email($type, $email, &$data)
	{
		$this->load->library('email');
		$this->email->from($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->to($email);
		$this->email->subject(sprintf($this->lang->line('auth_subject_'.$type), $this->config->item('website_name', 'tank_auth')));
		$this->email->message($this->load->view('email/'.$type.'-html', $data, TRUE));
		$this->email->set_alt_message($this->load->view('email/'.$type.'-txt', $data, TRUE));
		$this->email->send();
	}

	/**
	 * Create CAPTCHA image to verify user as a human
	 *
	 * @return	string
	 */
	function _create_captcha()
	{
		$this->load->helper('captcha');

		$cap = create_captcha(array(
			'img_path'		=> './'.$this->config->item('captcha_path', 'tank_auth'),
			'img_url'		=> base_url().$this->config->item('captcha_path', 'tank_auth'),
			'font_path'		=> './'.$this->config->item('captcha_fonts_path', 'tank_auth'),
			'font_size'		=> $this->config->item('captcha_font_size', 'tank_auth'),
			'img_width'		=> $this->config->item('captcha_width', 'tank_auth'),
			'img_height'	=> $this->config->item('captcha_height', 'tank_auth'),
			'show_grid'		=> $this->config->item('captcha_grid', 'tank_auth'),
			'expiration'	=> $this->config->item('captcha_expire', 'tank_auth'),
		));

		// Save captcha params in session
		$this->session->set_flashdata(array(
				'captcha_word' => $cap['word'],
				'captcha_time' => $cap['time'],
		));

		return $cap['image'];
	}

	/**
	 * Callback function. Check if CAPTCHA test is passed.
	 *
	 * @param	string
	 * @return	bool
	 */
	function _check_captcha($code)
	{
		$time = $this->session->flashdata('captcha_time');
		$word = $this->session->flashdata('captcha_word');

		list($usec, $sec) = explode(" ", microtime());
		$now = ((float)$usec + (float)$sec);

		if ($now - $time > $this->config->item('captcha_expire', 'tank_auth')) {
			$this->form_validation->set_message('_check_captcha', $this->lang->line('auth_captcha_expired'));
			return FALSE;

		} elseif (($this->config->item('captcha_case_sensitive', 'tank_auth') AND
				$code != $word) OR
				strtolower($code) != strtolower($word)) {
			$this->form_validation->set_message('_check_captcha', $this->lang->line('auth_incorrect_captcha'));
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * Create reCAPTCHA JS and non-JS HTML to verify user as a human
	 *
	 * @return	string
	 */
	function _create_recaptcha()
	{
		$this->load->helper('recaptcha');

		// Add custom theme so we can get only image
		$options = "<script>var RecaptchaOptions = {theme: 'custom', custom_theme_widget: 'recaptcha_widget'};</script>\n";

		// Get reCAPTCHA JS and non-JS HTML
		$html = recaptcha_get_html($this->config->item('recaptcha_public_key', 'tank_auth'));

		return $options.$html;
	}

	/**
	 * Callback function. Check if reCAPTCHA test is passed.
	 *
	 * @return	bool
	 */
	function _check_recaptcha()
	{
		$this->load->helper('recaptcha');

		$resp = recaptcha_check_answer($this->config->item('recaptcha_private_key', 'tank_auth'),
				$_SERVER['REMOTE_ADDR'],
				$_POST['recaptcha_challenge_field'],
				$_POST['recaptcha_response_field']);

		if (!$resp->is_valid) {
			$this->form_validation->set_message('_check_recaptcha', $this->lang->line('auth_incorrect_captcha'));
			return FALSE;
		}
		return TRUE;
	}
	
	/* add new user function by super admin */
	/*function adduser()
	{
		$data = $this->path->all_path();
		//$this->load->view('auth/header',$data);
		//$this->load->view('auth/footer',$data);
		if (!$this->tank_auth->is_admin_logged_in()) {
			redirect('admin/adminlogin/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$this->load->view('admin/header', $data);
			$this->load->view('admin/sidebar', $data);	
			$this->load->view('admin/adduser', $data);
			
		}
	}*/
	
	function user_privileges()
	{
		if (!$this->tank_auth->is_admin_logged_in()) {
			redirect('admin/adminlogin/');
		}
		else
		{
		
		
		$nadminid=$this->tank_auth->get_newadmin_inprocess();
		if($nadminid=='1')
		{
		
		$data = $this->path->all_path();
		$data['results'] = $this->adminmodel->userprivlegetype();
		$data['new_user_level']=$this->tank_auth->get_newadmin_user_level();
		$data['user_id']	= $this->tank_auth->get_admin_user_id();
		$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
		$data['admin_priv']=$this->adminmodel->get_user_privilege($data['user_id']);
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar',$data);
		$this->load->view('admin/user_privilege',$data);
		}
		else
		{
		redirect('admin/adduser/');
		}
		
		}
	}
	
	
	function usercreated()
	{
		if (!$this->tank_auth->is_admin_logged_in()) {
			redirect('admin/adminlogin/');
		}
		else{
		
			$email_activation = $this->config->item('email_activation', 'tank_auth');
		//insert data in user and profile table
		if($this->tank_auth->get_newadmin_inprocess())
		{
			if (!is_null($newadminid = $this->tank_auth->create_admin_user(
						$email_activation))) {									// success
					$data['site_name'] = $this->config->item('website_name', 'tank_auth');	
				}
		
		
		$data = $this->path->all_path();
		$this->adminmodel->insert_userprivlege_data($newadminid);
		$this->tank_auth->delete_newadmin_sessiondata();
		redirect('admin/manageusers/ucs');
	//	print_r($data);
		/*$data['user_id']	= $this->tank_auth->get_admin_user_id();
		$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
		$data['admin_priv']=$this->adminmodel->get_user_privilege($data['user_id']);
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar',$data);
		$this->load->view('admin/usersuccess',$data);*/
		}
		else
		{
			redirect('admin/adduser');
		}
		}
			
	}
	
	//function for show users
	function manageusers($ups='')
	{
		
		$data = $this->path->all_path();
		$data['user_id']	= $this->tank_auth->get_admin_user_id();
		$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
		$data['admin_priv']=$this->adminmodel->get_user_privilege($data['user_id']);
		
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar',$data);
		$data['user_detail']= $this->adminmodel->fetch_user_data();
		$flag=0;
		foreach($data['admin_priv'] as $userdata['admin_priv']){
		if($userdata['admin_priv']['privilege_type_id']==1 && $userdata['admin_priv']['privilege_level']!=0)
		{
		if($ups=='ups')
		{
		$data['msg']='User Updated Successfully';
		$this->load->view('admin/userupdated',$data);
		}
		else if($ups=='uds')
		{
		$data['msg']='User Deleted Successfully';
		$this->load->view('admin/userupdated',$data);
		}
		else if($ups=='ucs')
		{
		$data['msg']='User Created Successfully';
		$this->load->view('admin/userupdated',$data);
		}
		$this->load->view('admin/manageuser',$data);
		$flag=1;
		break;
		}
		}
		if($flag==0)
		{
		$this->load->view('admin/accesserror',$data);
		}
	}
	
	/*function edituser()
	{
		if (!$this->tank_auth->is_admin_logged_in()) {
			redirect('admin/adminlogin/');
		}
		else{
		$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
			
		
		}
		
	
	}*/
	
	function edituser($id='',$level)
	{
		$data = $this->path->all_path();
		$data['user_id']	= $this->tank_auth->get_admin_user_id();
		$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
		$data['admin_priv']=$this->adminmodel->get_user_privilege($data['user_id']);
		$data['current_user_priv']=$this->adminmodel->get_user_privilege($id);
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar',$data);
		$data['user_detail_edit'] = $this->adminmodel->fetch_data_edit($id);
		//fetch all privilege type 
		$data['results'] = $this->adminmodel->userprivlegetype();
		$this->form_validation->set_rules('fullname', 'Fullname', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
		if ($this->form_validation->run()) {
		$this->adminmodel->edit_user_data();
		redirect('admin/manageusers/ups');
		}
		$edit_user_priv=array('3','6','7','10');
		$flag=0;
		foreach($data['admin_priv'] as $userdata['admin_priv']){
		if($userdata['admin_priv']['privilege_type_id']==1 && in_array($userdata['admin_priv']['privilege_level'],$edit_user_priv) && $id!=$data['user_id'] && $level!='5' )
		{
		$this->load->view('admin/edituser', $data);
		$flag=1;
		break;
		}
		}
		if($flag==0)
		{
		$this->load->view('admin/accesserror', $data);
		}
		//$send_id = '123';
		
	}
	function update_user_detail()
	{
			
		$this->load->view('admin/edituser',$data);
		
		//$this->adminmodel->edit_user_profile_data(); 
		
	}
	
	//call back function for unique email when updating
	function update_unique_email($email)
	{
		$data['admin_priv']=$this->adminmodel->check_unique_email($email);
	}
	function userupdated()
	{
		$data = $this->path->all_path();
		$data['user_id']	= $this->tank_auth->get_admin_user_id();
		$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
		$data['admin_priv']=$this->adminmodel->get_user_privilege($data['user_id']);
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar',$data);
		$this->load->view('admin/userupdated',$data);
	}
	
	function deleteuser($user_level,$user_id)
	{
		$data = $this->path->all_path();
		$data['user_id']	= $this->tank_auth->get_admin_user_id();
		$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
		$data['admin_priv']=$this->adminmodel->get_user_privilege($data['user_id']);
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar',$data);
		$delete_user_priv=array('5','7','8','10');
		$flag=0;
		foreach($data['admin_priv'] as $userdata['admin_priv']){
		if($userdata['admin_priv']['privilege_type_id']==1 && in_array($userdata['admin_priv']['privilege_level'],$delete_user_priv) && $user_id!=$data['user_id'] && $user_level!='5')
		{
		$this->load->view('admin/userdeleted', $data);
		$flag=1;
		break;
		}
		}
		if($flag==0)
		{
		$this->load->view('admin/accesserror', $data);
		}
		else if($flag==1)
		{
		$this->adminmodel->deleteuser($user_level,$user_id);
		redirect('admin/manageusers/uds');
		}
		
	}
	
	function home_gallery()
	{
		$data = $this->path->all_path();
		$data['user_id']	= $this->tank_auth->get_admin_user_id();
		$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
		$data['admin_priv']=$this->adminmodel->get_user_privilege($data['user_id']);
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar',$data);
		$add_gallery_priv=array('4','6','8','10');
		$flag=0;
		foreach($data['admin_priv'] as $userdata['admin_priv']){
		if($userdata['admin_priv']['privilege_type_id']==1 && in_array($userdata['admin_priv']['privilege_level'],$add_gallery_priv) )
		{
		$flag=1;
		
		break;
		}
		}
		if($flag==0)
		{
		$this->load->view('admin/accesserror', $data);
		}
		else 
		{
		if ($this->input->post('upload')) {
		$data['x']=$this->adminmodel->do_upload();
		redirect('admin/manage_home_gallery');
		//print_r($data['x']);
		
		}
		 $this->load->view('admin/home_gallery', $data);
		}
		
	}
	
	function manage_home_gallery($del_pic=0)
	{
		
		$data = $this->path->all_path();
		$data['user_id']	= $this->tank_auth->get_admin_user_id();
		$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
		$data['admin_priv']=$this->adminmodel->get_user_privilege($data['user_id']);
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar',$data);
		$flag=0;
		$delete=0;
		foreach($data['admin_priv'] as $userdata['admin_priv']){
		if($userdata['admin_priv']['privilege_type_id']==11 && $userdata['admin_priv']['privilege_level']!=0)
		{
		$delete_gallery_pic=array('5','7','8','10');
		if(in_array($userdata['admin_priv']['privilege_level'],$delete_gallery_pic))
		{
		$delete=1;
		}
		$flag=1;
		}
		}
		if($flag==0)
		{
		$this->load->view('admin/accesserror', $data);
		}
		else if($flag==1)
		{
		if ($this->input->post('update')) {
		$this->adminmodel->update_gallery();
		$data['msg']="Gallery Updated successfully";
		$this->load->view('admin/userupdated', $data);
		}
		if($delete==1 && $del_pic!=0 && $del_pic!='' && $del_pic!=NULL)
		{
			$this->adminmodel->delete_gallery_pic($del_pic);
			$data['msg']="Gallery Image Deleted successfully";
			$this->load->view('admin/userupdated', $data);
		
		}
		}
		$data['gallery']=$this->adminmodel->get_gallery_info();
		$this->load->view('admin/manage_gallery', $data);
			
	}
	
	function create_university()
	{
		$data = $this->path->all_path();
		$data['user_id']	= $this->tank_auth->get_admin_user_id();
		$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
		$data['admin_priv']=$this->adminmodel->get_user_privilege($data['user_id']);
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar',$data);
		if($this->input->post('submit'))
		{
		$this->form_validation->set_rules('univ_name', 'University', 'trim|required');
		$this->form_validation->set_rules('address1', 'Addrss Line1', 'trim|xss_clean');
		$this->form_validation->set_rules('address2', 'Addrss Line2', 'trim|xss_clean');
		$this->form_validation->set_rules('phone_no', 'phone no', 'trim|xss_clean');
		$this->form_validation->set_rules('contact_us', 'Contact Us', 'trim|xss_clean');
		$this->form_validation->set_rules('about_us', 'About Us', 'trim|xss_clean');
		$this->form_validation->set_rules('univ_owner', 'University Owner', 'trim|required|string');
		$this->form_validation->set_rules('sub_domain', 'Sub Domain', 'xss_clean|alpha_dash|trim|required|string|is_unique[university.subdomain_name]');
		if ($this->form_validation->run()) {
		$data['x']=$this->adminmodel->create_univ();
		//print_r($data['x']);
		//$this->adminmodel->edit_user_data();
		//redirect('admin/manageusers/ups');
		}
		}
		$create_univ=array('4','6','8','10');
		$flag=0;
		foreach($data['admin_priv'] as $userdata['admin_priv']){
		if($userdata['admin_priv']['privilege_type_id']==5 && in_array($userdata['admin_priv']['privilege_level'],$create_univ) )
		{
		$flag=1;
		break;
		}
		}
		if($flag==0)
		{
		$this->load->view('admin/accesserror', $data);
		}
		else
		{
		$data['model']='0';
		$data['select_place']=array('0','0','0');
		if($this->input->post('addcountry'))
		{
		$this->form_validation->set_rules('country_model', 'Country', 'trim|required|is_unique[country.country_name]');
		$this->form_validation->set_rules('state_model', 'State', 'trim|required');
		$this->form_validation->set_rules('city_model', 'City', 'trim|required');
		if ($this->form_validation->run()) {
		$data['select_place']=array();
		$data['select_place']=$this->adminmodel->enterplacelevel1();
		$data['msg']='Your Place Added Successfully';
		$this->load->view('admin/userupdated', $data);
		}
		else
		{
		$data['model']='1';
		}
		}
		else if($this->input->post('addstate'))
		{
		$this->form_validation->set_rules('country_model1', 'Country', 'trim|required|string');
		$this->form_validation->set_rules('state_model1', 'State', 'trim|required|xss_clean|callback_state_check');
		$this->form_validation->set_rules('city_model1', 'City', 'trim|required|string');
		if ($this->form_validation->run()) {
		$data['select_place']=array();
		$data['select_place']=$this->adminmodel->enterplacelevel2();
		$data['msg']='Your Place Added Successfully';
		$this->load->view('admin/userupdated', $data);
		
		}
		else
		{
		$data['model']='2';
		}
		}
		else if($this->input->post('addcity'))
		{
		$this->form_validation->set_rules('country_model2', 'Country', 'trim|required|string');
		$this->form_validation->set_rules('state_model2', 'State', 'trim|required|xss_clean');
		$this->form_validation->set_rules('city_model2', 'City', 'trim|required|string|callback_city_check');
		if ($this->form_validation->run()) {
		$data['select_place']=array();
		$data['select_place']=$this->adminmodel->enterplacelevel3();
		$data['msg']='Your Place Added Successfully';
		$this->load->view('admin/userupdated', $data);
		
		}
		else
		{
		$data['model']='3';
		}
		}
		$data['univ_admins']=$this->adminmodel->get_univ_admin();
		$data['countries']=$this->users->fetch_country();
		$this->load->view('admin/add_university', $data);
		}
		
	
	}
	
	function state_list_ajax($cid='0',$ssid='0')
	{
		$data['region']=$this->adminmodel->fetch_states($cid);
		$data['ssid']=$ssid;
		$this->load->view('ajaxviews/state_ajax',$data);
	}
	function city_list_ajax($sid='0',$scid='0')
	{
		
		$data['region']=$this->adminmodel->fetch_city($sid);
		$data['scid']=$scid;
		$this->load->view('ajaxviews/city_ajax',$data);
	}
	
	function state_check()
	{
		if($this->adminmodel->state_chk_in_country($this->input->post('country_model1'),$this->input->post('state_model1')))
		{
		$this->form_validation->set_message('state_check', 'This State is alredy exist in this Country');
		return FALSE;
		}
		else
		{
		return TRUE;
		}
	}
	function city_check()
	{
		if($this->adminmodel->city_chk_in_state($this->input->post('state_model2'),$this->input->post('city_model2')))
		{
		$this->form_validation->set_message('city_check', 'This CIty is alredy exist in this State');
		return FALSE;
		}
		else
		{
		return TRUE;
		}
	}
	
	function manage_university()
	{
		$data = $this->path->all_path();
		$data['user_id']	= $this->tank_auth->get_admin_user_id();
		$data['admin_user_level']=$this->tank_auth->get_admin_user_level();
		$data['admin_priv']=$this->adminmodel->get_user_privilege($data['user_id']);
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar',$data);
		$data['msg']='University Created Successfully';
		$this->load->view('admin/userupdated',$data);
		
	
	}
	
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */