<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Session_reports extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Seatings_model','seatings');
		$this->load->model('Settings_model', 'settings');
		$this->load->model('Reports_model', 'reports');
		$this->load->model('Oversight_model', 'oversight');
		$this->load->model('Benchmarking_model', 'benchmarking');
	}

	function attendance_report()
	{
		if(isset($_GET['submit']))
		{
			$data['committees'] = $this->reports->get_custom_committees_sess();

			$session = $_GET['session_id'];
			$sess_name = $this->settings->get_session($session);

			$data['msg'] = "Attendance Report For Session: <b>".$sess_name->SessionName."</b>";
		}
		else
		{
			$data['msg'] = "Please select session to generate a report.";
			$data['committees'] = $this->reports->get_committees();
		}

		$data['prev'] = 'Session Reports';
		$data['curr'] = 'Attendance Report';
		$data['page_title'] = 'Attendance Reports'; 

		$data['sessions'] = $this->reports->get_sessions();

		$data['active'] = "report_att_sess";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('session_reports/attendance', $data);
		$this->load->view('incl/footer');
	}

	function view_sittings()
	{
		$getid = $this->input->get('id');
		$getsess = $this->input->get('session');

		$get_sittings = $this->reports->get_sittings_rep_sess($getid, $getsess);

		if($get_sittings)
		{
			$data['sittings'] = $get_sittings;
		}

		$data['url'] = $this->input->get('id');	

		$session = $_GET['session'];
		$sess_name = $this->settings->get_session($session);	

		$data['committee'] = $this->settings->get_committee($getid)['Title'];

		$data['prev'] = 'Session Reports';
		$data['curr'] = 'Attendance Report';
		$data['page_title'] = 'Attendance Reports for '.$data['committee']." for Session <b>".$sess_name->SessionName."</b>";

		$data['active'] = "report_att_sess";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('session_reports/sittings', $data);
		$this->load->view('incl/footer');
	}

	function attendance_mp()
	{
		if(isset($_GET['submit']))
		{
			$data['committees'] = $this->reports->get_custom_committees_sess();

			$session = $_GET['session_id'];
			$sess_name = $this->settings->get_session($session);	

			$data['msg'] = "Attendance Report For Session: <b>".$sess_name->SessionName."</b>";
		}
		else
		{
			$data['msg'] = "Please select Session";
			$data['committees'] = $this->reports->get_committees();
		}

		$data['prev'] = 'Session Reports';
		$data['curr'] = 'Attendance by MPs';
		$data['page_title'] = 'Attendance by MPs'; 

		$data['sessions'] = $this->reports->get_sessions();

		$data['active'] = "report_att_mp_sess";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('session_reports/attendance_mp', $data);
		$this->load->view('incl/footer');
	}

	function bills_report()
	{
		if(isset($_GET['submit']))
		{
			$data['committees'] = $this->reports->get_bills_committees_sess();

			$session = $_GET['session_id'];
			$sess_name = $this->settings->get_session($session);	

			$data['msg'] = "Bills Report For Session: <b>".$sess_name->SessionName."</b>";
		}
		else
		{
			$data['committees'] = $this->reports->get_bills_committees_sess();

			$data['msg'] = "Please select Session";
		}

		$data['sessions'] = $this->reports->get_sessions();

		$data['prev'] = 'Session Reports';
		$data['curr'] = 'Bills Report';
		$data['page_title'] = 'Bills Reports';

		$data['active'] = "report_bills_sess";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('session_reports/bills', $data);
		$this->load->view('incl/footer');
	}

	function view_committee_bills()
	{
		$getid = $this->input->get('id');
		$getsess = $this->input->get('session');

		$get_sittings = $this->reports->get_committee_bills_rep_sess($getid, $getsess);

		if($get_sittings)
		{
			$data['bills'] = $get_sittings;
		}

		$committee = $this->settings->get_committee($getid)['Title'];

		$data['url'] = $this->input->get('id');
		$data['urlComm'] = $this->input->get('committee');

		$data['committee'] = $committee;

		$data['prev'] = 'Session Reports';
		$data['curr'] = 'Bills Report';
		$data['page_title'] = 'Committee Bills for '.$data['committee'];

		$data['active'] = "report_bills_sess";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('reports/committee_bills', $data);
		$this->load->view('incl/footer');
	}

	function field_trip_report()
	{
		if(isset($_GET['submit']))
		{
			$data['committees'] = $this->reports->get_oversight_committees_sess();

			$session = $_GET['session_id'];
			$sess_name = $this->settings->get_session($session);	

			$data['msg'] = "Field Trip Report For Session: <b>".$sess_name->SessionName."</b>";
		}
		else
		{
			$data['committees'] = $this->reports->get_oversight_committees_sess();

			$data['msg'] = "Please select Session";
		}

		$data['sessions'] = $this->reports->get_sessions();

		$data['prev'] = 'Session Reports';
		$data['curr'] = 'Field Trips';
		$data['page_title'] = 'Field Trips Reports';

		$data['active'] = "report_ft_sess";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('session_reports/field_trip_visits', $data);
		$this->load->view('incl/footer');
	}

	function view_committee_oversight()
	{
		$getid = $this->input->get('id');
		$getsess = $this->input->get('session');

		$get_sittings = $this->reports->get_committee_oversight_rep_sess($getid, $getsess);

		if($get_sittings)
		{
			$data['oversight'] = $get_sittings;
		}

		$committee = $this->settings->get_committee($getid)['Title'];

		$data['url'] = $this->input->get('id');
		$data['urlComm'] = $this->input->get('committee');

		$data['committee'] = $committee;

		$data['prev'] = 'Session Reports';
		$data['curr'] = 'Field Trips';
		$data['page_title'] = 'Field Trips Reports for '.$data['committee'];

		$data['active'] = "report_ft_sess";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('reports/committee_oversight', $data);
		$this->load->view('incl/footer');
	}

	function travels_abroad_report()
	{
		if(isset($_GET['submit']))
		{
			$data['committees'] = $this->reports->get_benchmarking_committees_sess();

			$session = $_GET['session_id'];
			$sess_name = $this->settings->get_session($session);	

			$data['msg'] = "Travel Abroad Report For Session: <b>".$sess_name->SessionName."</b>";
		}
		else
		{
			$data['committees'] = $this->reports->get_benchmarking_committees_sess();

			$data['msg'] = "Please select Session";
		}

		$data['prev'] = 'Session Reports';
		$data['curr'] = 'Travels Abroad';
		$data['page_title'] = 'Travels Abroad Reports';

		$data['active'] = "report_ta_sess";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('session_reports/travels_abroad', $data);
		$this->load->view('incl/footer');
	}

}

?>