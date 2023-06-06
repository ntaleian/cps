<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	#Constructor
	public function __construct()
	{
		parent::__construct();

		$this->load->model('Auth_model','auth');
	}

	public function index()
	{
		
	}

	function login()
	{
		if($this->input->post('login'))
		{
			$loginQry = $this->auth->login();

			if(!$loginQry)
			{
				redirect(base_url()."auth/login");

			}
			else
			{
				$this->session->set_userdata('alluserdata', $loginQry);
				$this->session->set_userdata('isUserLoggedIn', 'Y');

				$trail_array = array(
									'action' => "Login",
									'description' => "Login User",
									'userid' => $this->session->userdata('alluserdata')[0]['EntryID'],
									'ipaddress' => $_SERVER['REMOTE_ADDR']
								);

				// $insertTrail = log_trail($this, $trail_array);

				redirect(base_url()."dashboard");
			}
		}

		$this->load->view('auth/login');
	}

	function logout(){

					$trail_array = array(
									'action' => "Logout",
									'description' => "Logout User",
									'userid' => $this->session->userdata('alluserdata')[0]['EntryID'],
									'ipaddress' => $_SERVER['REMOTE_ADDR']
								);

				// $insertTrail = log_trail($this, $trail_array);

        $this->session->unset_userdata('isUserLoggedIn');
        $this->session->unset_userdata('alluserdata');
        $this->session->sess_destroy();
        redirect(base_url()."auth/login");
    }

}

?>