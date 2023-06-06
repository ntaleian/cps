<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sittings extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Seatings_model','seatings');
		$this->load->model('Settings_model', 'settings');		

		$this->load->library('csvimport');
	}

	public function index()
	{
		$data['sessions'] = $this->settings->view_sessions();

		$data['committees'] = $this->seatings->get_committees();

		$data['prev'] = "Committee Business";
		$data['curr'] = "Manage Sittings";
		$data['active'] = "sittings";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('sittings/sittings', $data);
		$this->load->view('incl/footer');
	}

	function manage_sittings()
	{
		if($this->input->get('submit'))
		{
			$data['CommitteeID'] = $_GET['CommitteeID'];
			// $data['SeatingDate'] = $_POST['SeatingDate'];
			$data['SessionID'] = $_GET['SessionID'];

			$sessQry = $this->db->query("SELECT * FROM sessions WHERE EntryID='".$data['SessionID']."'");

			$sessDets = $sessQry->row_array();

			$data['sessStart'] = date('d/m/Y', strtotime($sessDets['StartDate']));
			$data['sessEnd'] = date('d/m/Y', strtotime($sessDets['EndDate']));

			$members = $this->settings->view_committee_members($data['CommitteeID'], $_GET['SessionID']);

			$data['committee'] = $this->settings->get_committee($data['CommitteeID'])['Title'];
			$data['committeeID'] = $data['CommitteeID'];
			// $data['SittingTitle'] = $_POST['SittingTitle'];

			$data['members'] = $members;

			$data['prev'] = 'Committee Business';
			$data['curr'] = 'Manage Sittings';
			$data['page_title'] = 'Manage Sittings';

			$data['active'] = "sittings";

			// echo "<pre>"; print_r($data['members']); echo "</pre>"; exit;

			$this->load->view('incl/head');
			$this->load->view('incl/header');
			$this->load->view('incl/sidebar', $data);
			$this->load->view('sittings/manage_sittings', $data);
			$this->load->view('incl/footer');
		}
	}

	function attendance()
	{
		$attendance = array();
		$mps = $_POST['mps'];
		foreach($mps as $mp)
		{
			$key = "attendance-".$mp;
			$attendance[] = $_POST[$key];
		}

		// print_r($attendance); echo "<br/><br/>";

		// echo "<pre>"; print_r($_POST); echo "</pre>"; exit;

		foreach($attendance as $idx => $val)
		{
			// echo $_POST['mps'][$idx]; exit;
			$all_array[] = ['attendance'=>$val, 'apology'=>$_POST['apology'][$idx], 'attendancetext'=>$_POST['att_text'][$idx], 'mps'=>$_POST['mps'][$idx] ];
		}

		// echo "<pre>"; print_r($all_array); echo "</pre>"; exit;

		$insertAttendance = $this->seatings->insert_attendance($all_array, $_POST['SittingDate'], $_POST['CommitteeID'], $_POST['SittingTitle'], $_POST['SessionID']);

		if($insertAttendance)
		{
			$this->session->set_flashdata('succ_msg', "Attendance Details for ".$_POST['CommitteeName']." for ".date('l jS F Y', strtotime($_POST['SittingDate']))." have been added.");
		}
		else
		{
			$this->session->set_flashdata('err_msg', "Attendance Details for ".$_POST['CommitteeName']." for ".date('l jS F Y', strtotime($_POST['SittingDate']))." have not been successfully added.");
		}

		redirect(base_url()."sittings");
	}

	function sitting_file()
	{
		$data['sessions'] = $this->settings->view_sessions();

		$data['committees'] = $this->seatings->get_committees();

		$data['prev'] = 'Committee Business';
		$data['curr'] = 'Sittings';
		$data['page_title'] = 'Add Sitting File';

		$data['active'] = "sittings_file";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('sittings/sittings_file', $data);
		$this->load->view('incl/footer');
	}

	function add_sitting_file()
	{
		// print_r($_POST); echo "<br/><br/>";
		// print_r($_FILES); exit;

		if($this->input->post('submit'))
		{
			$SessionID = $_POST['SessionID'];
			$CommitteeID = $_POST['CommitteeID'];

			$file_data = $this->csvimport->get_array($_FILES['AttFile']['tmp_name']);

			$fdata = array();

			foreach($file_data as $row)
			{
			    if(!empty($row['Code'])){
				    $fdata[$row['Date']][] = $row;
			    }
			}

			foreach($fdata as $datarow)
			{
				// echo $datarow[0]['Date']." Date: ".date('Y-m-d', strtotime($datarow[0]['Date'])); exit;

				$insertSitting = $this->db->query("INSERT INTO sittings (CommitteeID, ClerkID, SittingDate, SessionID, TS) VALUES ('$CommitteeID', '".$this->session->userdata('alluserdata')[0]['EntryID']."', '".date('Y-m-d', strtotime($datarow[0]['Date']))."', '$SessionID', '".date('Y-m-d H:i:s')."')");

				$sitID = $this->db->insert_id();

				foreach($datarow as $singlerow)
				{
					$attdata = array(
						'Code' => $singlerow['Code'],
						'Status' => $singlerow['Status']
					);

					$this->seatings->insert_sitting($attdata, $sitID);
				}

				// print_r($datarow); exit;
			}

			$this->session->set_flashdata('succ_msg', "MPs Attendance Data Has Been Captured");

			redirect(base_url()."sittings/sitting_file");

		}
	}

}

?>