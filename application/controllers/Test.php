<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	#Constructor
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		
	}

	function home()
	{
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar');
		$this->load->view('dashboard');
		$this->load->view('incl/footer');

	}

	function seat()
	{
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar');
		$this->load->view('seat');
		$this->load->view('incl/footer');
	}

	function seat2()
	{
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar');
		$this->load->view('seat2');
		$this->load->view('incl/footer');
	}

}

?>