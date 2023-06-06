<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Travel extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Settings_model','settings');
		$this->load->model('Seatings_model','seatings');
		$this->load->model('Bills_model','bills');
		$this->load->model('Oversight_model', 'oversight');
		$this->load->model('Benchmarking_model', 'benchmarking');
	}

	function index()
	{
		
	}

	function field_trip()
	{
		$data['sessions'] = $this->settings->view_sessions();

		$data['committees'] = $this->seatings->get_committees();

		$data['prev'] = 'Committee Business';
		$data['curr'] = 'Field Trips';
		$data['page_title'] = 'Manage Field Trips';

		$data['active'] = "ft";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('travel/field_trips', $data);
		$this->load->view('incl/footer');
	}

	function field_trip_list()
	{
		if($this->input->get('submit'))
		{

			$data['CommitteeID'] = $_GET['CommitteeID'];
			$data['SessionID'] = $_GET['SessionID'];

			$sessQry = $this->db->query("SELECT * FROM sessions WHERE EntryID='".$data['SessionID']."'");

			$sessDets = $sessQry->row_array();

			$data['sessStart'] = date('d/m/Y', strtotime($sessDets['StartDate']));
			$data['sessEnd'] = date('d/m/Y', strtotime($sessDets['EndDate']));

			$members = $this->settings->view_committee_members($_GET['CommitteeID'], $_GET['SessionID']);

			$data['members'] = $members;

			$data['committee'] = $this->settings->get_committee($data['CommitteeID'])['Title'];

			$data['prev'] = 'Committee Business';
			$data['curr'] = 'Field Trips';
			$data['page_title'] = 'Add Field Trip Record for '.$data['committee'];

			$data['active'] = "ft";

			$this->load->view('incl/head');
			$this->load->view('incl/header');
			$this->load->view('incl/sidebar', $data);
			$this->load->view('travel/field_trip_list', $data);
			$this->load->view('incl/footer');

		}
	}

	function api_add_oversight()
	{
		$postData = $this->input->post();

		// $mps = $postData['mps_id'];

		// $response = array("ToDate" => date('Y-m-d', strtotime($postData['ToDate'])), "FromDate" => date('Y-m-d', strtotime($postData['FromDate'])), "postData" => $postData, "message"=> "true" );
		// $response = $postData;

		// $to = date('Y-m-d', strtotime($postData['ToDate']));
		// $fro = date('Y-m-d', strtotime($postData['FromDate']));

		$daterange = $postData['ToDate'];
		$to = date('Y-m-d', strtotime(substr($daterange, 13, 10)));
		$fro = date('Y-m-d', strtotime(substr($daterange, 0, 10)));

		$oversight = $this->oversight->add_oversight($postData, $to, $fro);

		if($oversight)
		{
			$this->session->set_flashdata('succ_msg', "The Field Trip Data Has Been Successfully Added.");
			$response = array("message" => "true");
		}
		else
		{
			$this->session->set_flashdata('err_msg', "The Field Trip Data Has Not Been Successfully Added.");
			$response = array("message" => "false");
		}

		echo json_encode($response);
	}

	function travel_abroad()
	{
		$data['sessions'] = $this->settings->view_sessions();

		$data['committees'] = $this->seatings->get_committees();

		$data['prev'] = 'Committee Business';
		$data['curr'] = 'Travels Abroad';
		$data['page_title'] = 'Manage Travels Abroad';

		$data['active'] = "ta";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('travel/travel_abroad', $data);
		$this->load->view('incl/footer');
	}

	function travel_abroad_list()
	{
		if($this->input->get('submit'))
		{

			$data['CommitteeID'] = $_GET['CommitteeID'];

			$data['SessionID'] = $_GET['SessionID'];

			$sessQry = $this->db->query("SELECT * FROM sessions WHERE EntryID='".$data['SessionID']."'");

			$sessDets = $sessQry->row_array();

			$data['sessStart'] = date('d/m/Y', strtotime($sessDets['StartDate']));
			$data['sessEnd'] = date('d/m/Y', strtotime($sessDets['EndDate']));

			$members = $this->settings->view_committee_members($_GET['CommitteeID'], $_GET['SessionID']);

			$data['committee'] = $this->settings->get_committee($data['CommitteeID'])['Title'];

			$data['members'] = $members;

			$data['prev'] = 'Committee Business';
			$data['curr'] = 'Travels Abroad';
			$data['page_title'] = 'Add Travel Abroad for '.$data['committee'];

			$data['active'] = "ta";

			$this->load->view('incl/head');
			$this->load->view('incl/header');
			$this->load->view('incl/sidebar', $data);
			$this->load->view('travel/travel_abroad_list', $data);
			$this->load->view('incl/footer');

		}
	}

	function api_add_benchmark()
	{
		$postData = $this->input->post();

		// $mps = $postData['mps_id'];

		// $response = array("FromDate" => date('Y-m-d', strtotime($postData['FromDate'])), "mps" => $mps[0] );

		// $to = date('Y-m-d', strtotime($postData['ToDate']));
		// $fro = date('Y-m-d', strtotime($postData['FromDate']));

		$daterange = $postData['ToDate'];
		$to = date('Y-m-d', strtotime(substr($daterange, 13, 10)));
		$fro = date('Y-m-d', strtotime(substr($daterange, 0, 10)));

		$benchmark = $this->benchmarking->add_benchmark($postData, $to, $fro);

		if($benchmark)
		{
			$this->session->set_flashdata('succ_msg', "The Travel Data Has Been Successfully Added.");
			$response = array("message" => "true");
		}
		else
		{
			$this->session->set_flashdata('err_msg', "The Travel Data Has Not Been Successfully Added.");
			$response = array("message" => "false");
		}

		echo json_encode($response);
	}

}

?>