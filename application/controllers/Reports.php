<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

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
			$data['committees'] = $this->reports->get_custom_committees();
			$data['cats'] = $this->seatings->get_sittings_categories();

			$daterange = $_GET['ReqDate'];
			$end = date('Y-m-d', strtotime($_GET['ToDate']));
			$start = date('Y-m-d', strtotime($_GET['FromDate']));

			$cat = $_GET['Category'];
			if($cat == 'all')
			{
				$category = "All Categories";
			}
			else
			{
				$getcat = $this->db->query("SELECT category FROM sitting_categories WHERE id='".$_GET['Category']."' ")->row_array()['category'];
				$category = $getcat." Category";
			}

			$data['msg'] = "Attendance Report From ".$start." To ".$end." For ".$category;
		}
		else
		{
			$data['msg'] = "Please select start and end date to generate a custom report";
			$data['committees'] = $this->reports->get_committees();
			$data['cats'] = $this->seatings->get_sittings_categories();
		}

		$data['prev'] = 'Reports';
		$data['curr'] = 'Attendance Report';
		$data['page_title'] = 'Attendance Reports'; 

		$data['active'] = "report_att";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('reports/attendance', $data);
		$this->load->view('incl/footer');
	}

	function attendance_mp()
	{
		if(isset($_GET['submit']))
		{
			$data['committees'] = $this->reports->get_custom_committees();

			$daterange = $_GET['ReqDate'];
			// $end = date('Y-m-d', strtotime(substr($daterange, 13, 10)));
			// $start = date('Y-m-d', strtotime(substr($daterange, 0, 10)));

			$end = date('Y-m-d', strtotime($_GET['ToDate']));
			$start = date('Y-m-d', strtotime($_GET['FromDate']));

			$data['msg'] = "Attendance Report From ".$start." To ".$end;
		}
		else
		{
			$data['msg'] = "Please select start and end date to generate a custom report";
			$data['committees'] = $this->reports->get_committees();
		}
		
		// $data['committees'] = $this->reports->get_committees();

		$data['prev'] = 'Reports';
		$data['curr'] = 'Attendance by MPs';
		$data['page_title'] = 'Attendance by MPs'; 

		$data['active'] = "report_att_mp";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('reports/attendance_mp', $data);
		$this->load->view('incl/footer');
	}

	function view_sittings()
	{
		$gettype = $this->input->get('type');

		$gettype2 = $this->input->get('type2');

		if(!empty($gettype))
		{
			$getid = $this->input->get('id');
			$getfrom = $this->input->get('from');
			$getto = $this->input->get('to');

			// $getid = $this->cencrypt->decode($getid);
			// $getfrom = $this->cencrypt->decode($getfrom);
			// $getto = $this->cencrypt->decode($getto);

			// echo "ID: ".$getid." From: ".$getfrom." To: ".$getto; exit;

			$get_sittings = $this->reports->get_sittings_rep($getid, $getfrom, $getto);

			if($get_sittings)
			{
				$data['sittings'] = $get_sittings;
			}
		}
		else if(!empty($gettype2))
		{
			$getid = $this->input->get('id');
			$getsess = $this->input->get('session');

			// $getid = $this->cencrypt->decode($getid);
			// $getsess = $this->cencrypt->decode($getsess);

			// echo "ID: ".$getid." From: ".$getfrom." To: ".$getto; exit;

			$get_sittings = $this->reports->get_sittings_rep_sess($getid, $getsess);

			if($get_sittings)
			{
				$data['sittings'] = $get_sittings;
			}
		}
		else
		{
			$getid = $this->input->get('id');

			if(!empty($getid))
			{
				// $getid = $this->cencrypt->decode($getid);

				$data['id'] = $getid;
			}

			$get_sittings = $this->reports->get_sittings($getid);

			if($get_sittings)
			{
				$data['sittings'] = $get_sittings;
			}
		}

		$data['url'] = $this->input->get('id');		

		$data['committee'] = $this->settings->get_committee($getid)['Title'];

		$data['prev'] = 'Reports';
		$data['curr'] = 'Attendance Report';
		$data['page_title'] = 'Sittings Reports for '.$data['committee'];

		$data['active'] = "report_att";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('reports/sittings', $data);
		$this->load->view('incl/footer');
	}

	function view_sittings_mp()
	{
		$gettype = $this->input->get('type');

		if(!empty($gettype))
		{
			$getid = $this->input->get('id');
			$getfrom = $this->input->get('from');
			$getto = $this->input->get('to');

			// $getid = $this->cencrypt->decode($getid);
			// $getfrom = $this->cencrypt->decode($getfrom);
			// $getto = $this->cencrypt->decode($getto);

			// echo "ID: ".$getid." From: ".$getfrom." To: ".$getto; exit;

			$get_sittings = $this->reports->get_sittings_mp_rep($getid, $getfrom, $getto);

			if($get_sittings)
			{
				$data['sittings'] = $get_sittings;
			}
		}
		else
		{
			$getid = $this->input->get('id');

			if(!empty($getid))
			{
				// $getid = $this->cencrypt->decode($getid);

				$data['id'] = $getid;
			}

			$get_sittings = $this->reports->get_sittings_mp($getid);

			if($get_sittings)
			{
				$data['sittings'] = $get_sittings;
			}
		}		

			$data['committee'] = $this->settings->get_committee($getid)['Title'];

			$data['prev'] = 'Reports';
			$data['curr'] = 'Attendance by MP';
			$data['page_title'] = 'Sittings Reports by MP for '.$data['committee'];

			$data['active'] = 'report_att_mp';

			$this->load->view('incl/head');
			$this->load->view('incl/header');
			$this->load->view('incl/sidebar', $data);
			$this->load->view('reports/sittings_mp', $data);
			$this->load->view('incl/footer');
	}

	function update_sitting()
	{
		$update = $this->reports->update_sitting();

		if($update)
		{
			$this->session->set_flashdata('succ_msg', "Sitting Details Updated Successfully.");
		}
		else
		{
			$this->session->set_flashdata('err_msg', "Sitting Details NOT Updated Successfully.");
		}

		$url = $_POST['Url'];

		redirect(base_url()."reports/view_sittings?id=".$url);
	}

	function delete_sitting()
	{
		$getid = $this->input->get('id');

		$url = $this->input->get('url');

		if(!empty($getid))
		{
			// $getid = $this->cencrypt->decode($getid);

			$delete = $this->sys->delete_row($getid, 'sittings');

			if($delete)
			{
				$this->session->set_flashdata('succ_msg', "Sitting Record Deleted Successfully.");
			}
			else
			{
				$this->session->set_flashdata('err_msg', "Sitting Record NOT Deleted Successfully.");
			}

			redirect(base_url()."reports/view_sittings?id=".$url);
		}
	}

	function view_member_attendance()
	{
		$getid = $this->input->get('id');

		$data['id'] = $getid;

		if(!empty($getid))
		{
			// $getid = $this->cencrypt->decode($getid);
		}

		$get_member_attendance = $this->reports->get_member_attendance($getid);

		if($get_member_attendance)
		{
			$data['members'] = $get_member_attendance;
		}

		$data['committee'] = $this->settings->get_committee($getid)['Title'];

		$data['prev'] = 'Reports';
		$data['curr'] = 'Attendance Report';
		$data['page_title'] = 'Attendance List Reports for '.$get_member_attendance[0]['SittingTitle'];

		$data['active'] = "report_att";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('reports/member_attendance', $data);
		$this->load->view('incl/footer');
	}

	function update_attendance()
	{
		$update = $this->reports->update_attendance();

		if($update)
		{
			$this->session->set_flashdata('succ_msg', "Attendance Record Updated Successfully.");
		}
		else
		{
			$this->session->set_flashdata('err_msg', "Attendance Record NOT Updated Successfully.");
		}

		$url = $_POST['UrlID'];

		redirect(base_url()."reports/view_member_attendance?id=".$url);
	}

	function bills_report()
	{
		$data['committees'] = $this->reports->get_bills_committees();

		$data['prev'] = 'Reports';
		$data['curr'] = 'Bills Report';
		$data['page_title'] = 'Bills Reports';

		$data['active'] = "report_bills";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('reports/bills', $data);
		$this->load->view('incl/footer');
	}

	function view_committee_bills()
	{
		$gettype = $this->input->get('type');

		$gettype2 = $this->input->get('type2');

		if(!empty($gettype))
		{
			$getid = $this->input->get('id');
			$getfrom = $this->input->get('from');
			$getto = $this->input->get('to');

			// $getid = $this->cencrypt->decode($getid);
			// $getfrom = $this->cencrypt->decode($getfrom);
			// $getto = $this->cencrypt->decode($getto);

			$get_sittings = $this->reports->get_committee_bills_rep($getid, $getfrom, $getto);

			if($get_sittings)
			{
				$data['bills'] = $get_sittings;
			}

			$committee = $this->settings->get_committee($getid)['Title'];
		}
		else if(!empty($gettype2))
		{
			$getid = $this->input->get('id');
			$getsess = $this->input->get('session');

			// $getid = $this->cencrypt->decode($getid);
			// $getsess = $this->cencrypt->decode($getsess);

			$get_sittings = $this->reports->get_committee_bills_rep_sess($getid, $getsess);

			if($get_sittings)
			{
				$data['bills'] = $get_sittings;
			}

			$committee = $this->settings->get_committee($getid)['Title'];
		}
		else
		{
			$getid = $this->input->get('id');
			$committee = $this->input->get('committee');

			// $getid = $this->cencrypt->decode($getid);
			// $committee = $this->cencrypt->decode($committee);

			$data['bills'] = $this->reports->get_committee_bills($getid);
		}

		$data['url'] = $this->input->get('id');
		$data['urlComm'] = $this->input->get('committee');

		$data['committee'] = $committee;

		$data['prev'] = 'Reports';
		$data['curr'] = 'Bills Report';
		$data['page_title'] = 'Committee Bills for '.$data['committee'];

		$data['active'] = "report_bills";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('reports/committee_bills', $data);
		$this->load->view('incl/footer');
	}

	function update_bill()
	{
		$update = $this->reports->update_bill();

		if($update)
		{
			$this->session->set_flashdata('succ_msg', "Bill Details Updated Successfully.");
		}
		else
		{
			$this->session->set_flashdata('err_msg', "Bill Details NOT Updated Successfully.");
		}

		$url = $_POST['Url'];
		$urlComm = $_POST['CommUrl'];

		redirect(base_url()."reports/view_committee_bills?id=".$url."&committee=".$urlComm);
	}

	function delete_bill()
	{
		$getid = $this->input->get('id');

		$url = $this->input->get('url');

		$comm = $this->input->get('comm');

		if(!empty($getid))
		{
			// $getid = $this->cencrypt->decode($getid);

			$delete = $this->sys->delete_row($getid, 'bills');

			if($delete)
			{
				$this->session->set_flashdata('succ_msg', "Bill Record Deleted Successfully.");
			}
			else
			{
				$this->session->set_flashdata('err_msg', "Bill Record NOT Deleted Successfully.");
			}

			redirect(base_url()."reports/view_committee_bills?id=".$url."&committee=".$comm);
		}
	}

	function field_trip_report()
	{
		$data['committees'] = $this->reports->get_oversight_committees();

		$data['prev'] = 'Reports';
		$data['curr'] = 'Field Trips';
		$data['page_title'] = 'Field Trips Reports';

		$data['active'] = "report_ft";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('reports/field_trip_visits', $data);
		$this->load->view('incl/footer');
	}

	function view_committee_oversight()
	{
		$gettype = $this->input->get('type');

		$gettype2 = $this->input->get('type2');

		if(!empty($gettype))
		{
			$getid = $this->input->get('id');
			$getfrom = $this->input->get('from');
			$getto = $this->input->get('to');

			// $getid = $this->cencrypt->decode($getid);
			// $getfrom = $this->cencrypt->decode($getfrom);
			// $getto = $this->cencrypt->decode($getto);

			$get_sittings = $this->reports->get_committee_oversight_rep($getid, $getfrom, $getto);

			if($get_sittings)
			{
				$data['oversight'] = $get_sittings;
			}

			$committee = $this->settings->get_committee($getid)['Title'];
		}
		else if(!empty($gettype2))
		{
			$getid = $this->input->get('id');
			$getsess = $this->input->get('session');

			// $getid = $this->cencrypt->decode($getid);
			// $getsess = $this->cencrypt->decode($getsess);

			$get_sittings = $this->reports->get_committee_oversight_rep_sess($getid, $getsess);

			if($get_sittings)
			{
				$data['oversight'] = $get_sittings;
			}

			$committee = $this->settings->get_committee($getid)['Title'];
		}
		else
		{
			$getid = $this->input->get('id');
			$committee = $this->input->get('committee');

			// $getid = $this->cencrypt->decode($getid);
			// $committee = $this->cencrypt->decode($committee);

			$data['oversight'] = $this->reports->get_committee_oversight($getid);			
		}

		$data['url'] = $this->input->get('id');
		$data['urlComm'] = $this->input->get('committee');

		$data['committee'] = $committee;

		$data['prev'] = 'Reports';
		$data['curr'] = 'Field Trips';
		$data['page_title'] = 'Field Trips Reports for '.$data['committee'];

		$data['active'] = "report_ft";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('reports/committee_oversight', $data);
		$this->load->view('incl/footer');
	}


	function update_oversight()
	{
		$update = $this->reports->update_oversight();

		if($update)
		{
			$this->session->set_flashdata('succ_msg', "Field Trip Details Updated Successfully.");
		}
		else
		{
			$this->session->set_flashdata('err_msg', "Field Trip Details NOT Updated Successfully.");
		}

		$url = $_POST['Url'];
		$urlComm = $_POST['CommUrl'];

		redirect(base_url()."reports/view_committee_oversight?id=".$url."&committee=".$urlComm);
	}

	function delete_ft()
	{
		$getid = $this->input->get('id');

		$url = $this->input->get('url');

		$comm = $this->input->get('comm');

		if(!empty($getid))
		{
			// $getid = $this->cencrypt->decode($getid);

			$delete = $this->sys->delete_row($getid, 'oversight_visits');

			if($delete)
			{
				$this->session->set_flashdata('succ_msg', "Fied Trip Record Deleted Successfully.");
			}
			else
			{
				$this->session->set_flashdata('err_msg', "Field Trip Record NOT Deleted Successfully.");
			}

			redirect(base_url()."reports/view_committee_oversight?id=".$url."&committee=".$comm);
		}
	}


	function travels_abroad_report()
	{
		$data['committees'] = $this->reports->get_benchmarking_committees();

		$data['prev'] = 'Reports';
		$data['curr'] = 'Travels Abroad';
		$data['page_title'] = 'Travels Abroad Reports';

		$data['active'] = "report_ta";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('reports/travels_abroad', $data);
		$this->load->view('incl/footer');
	}

	function view_committee_benchmarking()
	{
		$gettype = $this->input->get('type');

		$gettype2 = $this->input->get('type2');

		if(!empty($gettype))
		{
			$getid = $this->input->get('id');
			$getfrom = $this->input->get('from');
			$getto = $this->input->get('to');

			// $getid = $this->cencrypt->decode($getid);
			// $getfrom = $this->cencrypt->decode($getfrom);
			// $getto = $this->cencrypt->decode($getto);

			$get_sittings = $this->reports->get_committee_benchmarking_rep($getid, $getfrom, $getto);

			if($get_sittings)
			{
				$data['benchmarking'] = $get_sittings;
			}

			$committee = $this->settings->get_committee($getid)['Title'];
		}
		else if(!empty($gettype2))
		{
			$getid = $this->input->get('id');
			$getsess = $this->input->get('session');

			// $getid = $this->cencrypt->decode($getid);
			// $getsess = $this->cencrypt->decode($getsess);

			$get_sittings = $this->reports->get_committee_benchmarking_rep_sess($getid, $getsess);

			if($get_sittings)
			{
				$data['benchmarking'] = $get_sittings;
			}

			$committee = $this->settings->get_committee($getid)['Title'];
		}
		else
		{
			$getid = $this->input->get('id');
			$committee = $this->input->get('committee');

			// $getid = $this->cencrypt->decode($getid);
			// $committee = $this->cencrypt->decode($committee);

			$data['benchmarking'] = $this->reports->get_committee_benchmarking($getid);
		}
		
		$data['url'] = $this->input->get('id');
		$data['urlComm'] = $this->input->get('committee');

		$data['committee'] = $committee;

		$data['prev'] = 'Reports';
		$data['curr'] = 'Travels Abroad';
		$data['page_title'] = 'Travels Abroad Reports for '.$data['committee'];

		$data['active'] = "report_ta";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('reports/committee_benchmarking', $data);
		$this->load->view('incl/footer');
	}


	function update_travel_abroad()
	{
		$update = $this->reports->update_travel_abroad();

		if($update)
		{
			$this->session->set_flashdata('succ_msg', "Travel Abroad Details Updated Successfully.");
		}
		else
		{
			$this->session->set_flashdata('err_msg', "Travel Abroad Details NOT Updated Successfully.");
		}

		$url = $_POST['Url'];
		$urlComm = $_POST['CommUrl'];

		redirect(base_url()."reports/view_committee_benchmarking?id=".$url."&committee=".$urlComm);
	}

	function delete_ta()
	{
		$getid = $this->input->get('id');

		$url = $this->input->get('url');

		$comm = $this->input->get('comm');

		if(!empty($getid))
		{
			// $getid = $this->cencrypt->decode($getid);

			$delete = $this->sys->delete_row($getid, 'benchmarking_visits');

			if($delete)
			{
				$this->session->set_flashdata('succ_msg', "Travel Abroad Record Deleted Successfully.");
			}
			else
			{
				$this->session->set_flashdata('err_msg', "Travel Abroad Record NOT Deleted Successfully.");
			}

			redirect(base_url()."reports/view_committee_benchmarking?id=".$url."&committee=".$comm);
		}
	}


	function mps_report()
	{
		$data['mps'] = $this->reports->get_individual_mps();

		$data['prev'] = 'Reports';
		$data['curr'] = 'MPs Report';
		$data['page_title'] = 'Individual MPs Reports'; 

		$data['active'] = "report_mps";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('reports/individual_mps', $data);
		$this->load->view('incl/footer');
	}

	function view_mp_record()
	{
		$getid = $this->input->get('id');

		// $getid = $this->cencrypt->decode($getid);

		$data['name'] = $this->reports->get_mps_details($getid)['Name'];

		$data['committees'] = $this->reports->get_mps_committees($getid);
		$data['mp_record'] = $this->reports->get_individual_mp($getid);

		$data['mpid'] = $getid;

		// print_r($data['mp_recs']); exit;

		$data['prev'] = 'Reports';
		$data['curr'] = 'MPs Report';
		$data['page_title'] = 'Individual MP Report for '.$data['name'];

		$data['active'] = "report_mps";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('reports/mp_record', $data);
		$this->load->view('incl/footer');
	}

	function budget_allocation()
	{
		$data['committees'] = $this->reports->get_allocation_committees();

		$data['prev'] = 'Reports';
		$data['curr'] = 'Budget Allocation';
		$data['page_title'] = 'Committee Budget Reports';

		$data['active'] = "report_alloc";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('reports/budget_alloc', $data);
		$this->load->view('incl/footer');
	}

	function committee_history()
	{
		$data['committees'] = $this->reports->get_committee_history();

		$data['prev'] = 'Reports';
		$data['curr'] = 'Committee Reports';
		$data['page_title'] = 'Committee History Reports';

		$data['active'] = "mps_history";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('reports/committee_history', $data);
		$this->load->view('incl/footer');
	}

	function history_details()
	{
		$id = $_GET['id'];

		$data['committees'] = $this->reports->get_history_details($id);

		$data['prev'] = 'Reports';
		$data['curr'] = 'Committee Reports';
		$data['page_title'] = 'Committee History Reports';

		$data['active'] = "mps_history";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('reports/history_details', $data);
		$this->load->view('incl/footer');
	}

	function edit_field_trip()
	{
		$id = $_GET['id'];
		$commid = $_GET['commid'];
		$sessionID = $this->session->userdata('alluserdata')[0]['SessionID'];

		$members = $this->settings->view_committee_members($commid, $sessionID);
		$data['members'] = $members;

		$data['attendees'] = $this->settings->view_ft_mps($id);

		$data['ft_id'] = $id;
		$data['comm_id'] = $commid;
		$data['session_id'] = $sessionID;

		$data['committee'] = $this->settings->get_committee($commid)['Title'];

		$data['prev'] = 'Reports';
		$data['curr'] = 'Field Trips';
		$data['page_title'] = 'Edit Field Trip for '.$data['committee'];

		$data['active'] = "report_ft";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('reports/edit_field_trip', $data);
		$this->load->view('incl/footer');
	}

	function api_update_oversight()
	{
		$postData = $this->input->post();

		$oversight = $this->oversight->update_oversight($postData);

		if($oversight)
		{
			$this->session->set_flashdata('succ_msg', "The Field Trip Attendance Data Has Been Successfully Updated.");
			$response = array("ft_id"=>$postData['EntryID'], "session_id"=>$postData['SessionID'], "comm_id"=>$postData['CommitteeID'], "message" => "true");
		}
		else
		{
			$this->session->set_flashdata('err_msg', "The Field Trip Attendance Data Has Not Been Successfully Updated.");
			$response = array("ft_id"=>$postData['EntryID'], "session_id"=>$postData['SessionID'], "comm_id"=>$postData['CommitteeID'], "message" => "false");
		}

		echo json_encode($response);
	}

	function edit_travel_abroad()
	{
		$id = $_GET['id'];
		$commid = $_GET['commid'];
		$sessionID = $this->session->userdata('alluserdata')[0]['SessionID'];

		$members = $this->settings->view_committee_members($commid, $sessionID);
		$data['members'] = $members;

		$data['attendees'] = $this->settings->view_ta_mps($id);

		// echo "<pre>"; print_r($data['attendees']); echo "</pre>"; exit;

		$data['ft_id'] = $id;
		$data['comm_id'] = $commid;
		$data['session_id'] = $sessionID;

		$data['committee'] = $this->settings->get_committee($commid)['Title'];

		$data['prev'] = 'Reports';
		$data['curr'] = 'Travels Abroad';
		$data['page_title'] = 'Edit Travel Abroad for '.$data['committee'];

		$data['active'] = "report_ta";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('reports/edit_travel_abroad', $data);
		$this->load->view('incl/footer');
	}


	function api_update_benchmarking()
	{
		$postData = $this->input->post();

		$oversight = $this->oversight->update_benchmarking($postData);

		if($oversight)
		{
			$this->session->set_flashdata('succ_msg', "The Travel Abroad Attendance Data Has Been Successfully Updated.");
			$response = array("ft_id"=>$postData['EntryID'], "session_id"=>$postData['SessionID'], "comm_id"=>$postData['CommitteeID'], "message" => "true");
		}
		else
		{
			$this->session->set_flashdata('err_msg', "The Travel Abroad Attendance Data Has Not Been Successfully Updated.");
			$response = array("ft_id"=>$postData['EntryID'], "session_id"=>$postData['SessionID'], "comm_id"=>$postData['CommitteeID'], "message" => "false");
		}

		echo json_encode($response);
	}

}

?>