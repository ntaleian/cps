<?php

class Reports_model extends CI_Model {
	
	#Constructor
	public function __construct()
	{
		parent::__construct();
	}

	function get_committees()
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$usertype = $this->session->userdata('alluserdata')[0]['Usertype'];

		$sessionID = $this->session->userdata('alluserdata')[0]['SessionID'];

		// if($usertype == "super" || $usertype == "overall")
		// {
			$get = $this->db->query("SELECT committees.*, (SELECT COUNT(EntryID) FROM committee_members WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."') NoOfMembers, (SELECT COUNT(EntryID) FROM sittings WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."') TimesSat FROM committees");
		// }

		// else
		// {

		// $get = $this->db->query("SELECT committees.*, (SELECT COUNT(EntryID) FROM committee_members WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."') NoOfMembers, (SELECT COUNT(EntryID) FROM sittings WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."') TimesSat FROM committees LEFT JOIN committee_users ON committees.EntryID=committee_users.CommitteeID WHERE committee_users.UserID='$userid' AND committee_users.IsActive='Y'");

		// }

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function get_custom_committees()
	{
		$daterange = $_GET['ReqDate'];
		// $end = date('Y-m-d', strtotime(substr($daterange, 13, 10)));
		// $start = date('Y-m-d', strtotime(substr($daterange, 0, 10)));

		// echo "<pre>"; print_r($_GET); echo "</pre> <br/><br/>";

		$end = date('Y-m-d', strtotime($_GET['ToDate']));
		$start = date('Y-m-d', strtotime($_GET['FromDate']));

		$get = $this->db->query("SELECT committees.*, (SELECT COUNT(EntryID) FROM committee_members WHERE CommitteeID=committees.EntryID AND SessionID='".$_GET['SessionID']."') NoOfMembers, (SELECT COUNT(EntryID) FROM sittings WHERE CommitteeID=committees.EntryID AND SessionID='".$_GET['SessionID']."' AND DATE(SittingDate) >= '".date('Y-m-d', strtotime($start))."' AND DATE(SittingDate) <= '".date('Y-m-d', strtotime($end))."' ) TimesSat FROM committees");


		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function get_sittings($committeeID)
	{
		if(!empty($_GET['start']))
		{
			$tstr = "AND DATE(sittings.SittingDate) >= '".date('Y-m-d', strtotime($_GET['start']))."' AND DATE(sittings.SittingDate) <= '".date('Y-m-d', strtotime($_GET['end']))."' ";
		}
		else
		{
			$tstr = "";
		}

		$get = $this->db->query("SELECT sittings.*, CONCAT(users.Firstname,' ', users.Lastname) AS Fullname, committees.Title AS CommitteeTitle FROM sittings LEFT JOIN users ON sittings.ClerkID=users.EntryID LEFT JOIN committees ON sittings.CommitteeID=committees.EntryID WHERE sittings.CommitteeID='$committeeID' ".$tstr." AND sittings.SessionID='".get_current_session($this)."' AND sittings.Status='ACTIVE'");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}
	
	function get_sittings_mp($committeeID)
	{
		if(!empty($_GET['start']))
		{
			// $tstr = "AND DATE(sittings.SittingDate) >= '".date('Y-m-d', strtotime($_GET['start']))."' AND DATE(sittings.SittingDate) <= '".date('Y-m-d', strtotime($_GET['end']))."' ";
			$get = $this->db->query("SELECT a.MpID, m.Name, SUM(IF(a.AttendanceStatus='present', 1, 0)) AS present, SUM(IF(a.AttendanceStatus='absent', 1, 0)) AS absent, SUM(IF(a.AttendanceStatus='awo', 1, 0)) AS awo from attendance a LEFT JOIN mps m ON a.MpID=m.EntryID LEFT JOIN sittings s ON a.SittingID=s.EntryID where a.MpID=m.EntryID AND a.CommitteeID='$committeeID' and a.SessionID='".get_current_session($this)."' AND DATE(s.SittingDate) >= '".date('Y-m-d', strtotime($_GET['start']))."' AND DATE(s.SittingDate) <= '".date('Y-m-d', strtotime($_GET['end']))."' GROUP BY a.MpID");
		}
		else
		{
			// $tstr = "";
			$get = $this->db->query("SELECT a.MpID, m.Name, SUM(IF(a.AttendanceStatus='present', 1, 0)) AS present, SUM(IF(a.AttendanceStatus='absent', 1, 0)) AS absent, SUM(IF(a.AttendanceStatus='awo', 1, 0)) AS awo from attendance a LEFT JOIN mps m ON a.MpID=m.EntryID where a.MpID=m.EntryID AND a.CommitteeID='$committeeID' and a.SessionID='".get_current_session($this)."' GROUP BY a.MpID");
		}

		// $get = $this->db->query("SELECT a.MpID, m.Name, SUM(IF(a.AttendanceStatus='present', 1, 0)) AS present, SUM(IF(a.AttendanceStatus='absent', 1, 0)) AS absent, SUM(IF(a.AttendanceStatus='awo', 1, 0)) AS awo from attendance a LEFT JOIN mps m ON a.MpID=m.EntryID where a.MpID=m.EntryID AND a.CommitteeID='$committeeID' and a.SessionID='".get_current_session($this)."' GROUP BY a.MpID");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}
	
	function get_sittings_mp_rep($committeeID, $fromDate, $toDate)
	{
		$get = $this->db->query("SELECT a.MpID, m.Name, SUM(IF(a.AttendanceStatus='present', 1, 0)) AS present, SUM(IF(a.AttendanceStatus='absent', 1, 0)) AS absent, SUM(IF(a.AttendanceStatus='awo', 1, 0)) AS awo from attendance a LEFT JOIN sittings s ON a.SittingID=s.EntryID LEFT JOIN mps m ON a.MpID=m.EntryID where a.MpID=m.EntryID AND a.CommitteeID='$committeeID' and s.SittingDate BETWEEN '".date('Y-m-d', strtotime($fromDate))."' AND '".date('Y-m-d', strtotime($toDate))."' AND s.Status='ACTIVE' GROUP BY a.MpID");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function get_sittings_rep($committeeID, $fromDate, $toDate)
	{
		$get = $this->db->query("SELECT sittings.*, CONCAT(users.Firstname,' ', users.Lastname) AS Fullname, committees.Title AS CommitteeTitle FROM sittings LEFT JOIN users ON sittings.ClerkID=users.EntryID LEFT JOIN committees ON sittings.CommitteeID=committees.EntryID WHERE sittings.CommitteeID='$committeeID' AND sittings.SittingDate BETWEEN '".date('Y-m-d', strtotime($fromDate))."' AND '".date('Y-m-d', strtotime($toDate))."' AND sittings.Status='ACTIVE'");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function get_sittings_rep_sess($committeeID, $sessionID)
	{
		$get = $this->db->query("SELECT sittings.*, CONCAT(users.Firstname,' ', users.Lastname) AS Fullname, committees.Title AS CommitteeTitle FROM sittings LEFT JOIN users ON sittings.ClerkID=users.EntryID LEFT JOIN committees ON sittings.CommitteeID=committees.EntryID WHERE sittings.CommitteeID='$committeeID' AND sittings.SessionID='$sessionID' AND sittings.Status='ACTIVE'");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function update_sitting()
	{
		$update = $this->db->query("UPDATE sittings SET SittingTitle=".$this->db->escape($_POST['SittingTitle']).", SittingDate='".date('Y-m-d', strtotime(str_replace("/", "-", $_POST['SittingDate'])))."' WHERE EntryID='".$_POST['EntryID']."'");

		if($update)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function get_member_attendance($committeeID)
	{
		$get = $this->db->query("SELECT attendance.*, sittings.SittingTitle, sittings.SittingDate, mps.Name, mps.Party FROM attendance LEFT JOIN sittings ON attendance.SittingID=sittings.EntryID LEFT JOIN mps ON attendance.MpID=mps.EntryID WHERE sittings.EntryID='$committeeID' AND sittings.Status='ACTIVE'");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function update_attendance()
	{
		$update = $this->db->query("UPDATE attendance SET AttendanceStatus='".$_POST['AttendanceStatus']."' WHERE EntryID='".$_POST['AttID']."'");

		if($update)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function get_bills_committees()
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$usertype = $this->session->userdata('alluserdata')[0]['Usertype'];

		// if($usertype == "super" || $usertype == "overall")
		// {

			$get = $this->db->query("SELECT committees.*, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."' AND Status='ACTIVE') BillsCount, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."' AND BillStatus='Y' AND Status='ACTIVE') ReportConcluded, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."' AND BillStatus='D' AND Status='ACTIVE') ReportDraft, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."' AND BillStatus='N' AND Status='ACTIVE') NoReport FROM committees");
		// }
		// else
		// {

		// $get = $this->db->query("SELECT committees.*, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."' AND Status='ACTIVE') BillsCount, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."' AND BillStatus='Y' AND Status='ACTIVE') ReportConcluded, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."' AND BillStatus='D' AND Status='ACTIVE') ReportDraft, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."' AND BillStatus='N' AND Status='ACTIVE') NoReport FROM committees LEFT JOIN committee_users ON committees.EntryID=committee_users.CommitteeID WHERE committee_users.UserID='$userid' AND committee_users.IsActive='Y'");
		// }

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}


	function get_committee_bills($committeeID)
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$get = $this->db->query("SELECT b.*, c.Title, CONCAT(u.Firstname, ' ', u.Lastname) AS Fullname FROM bills b LEFT JOIN committees c ON b.CommitteeID=c.EntryID LEFT JOIN users u ON b.EditedBy=u.EntryID WHERE b.CommitteeID='$committeeID' AND b.SessionID='".get_current_session($this)."' AND b.Status='ACTIVE'");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}

		else

		{
			return false;
		}
	}

	function get_committee_bills_rep($committeeID, $fromDate, $toDate)
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$get = $this->db->query("SELECT b.*, c.Title, CONCAT(u.Firstname, ' ', u.Lastname) AS Fullname FROM bills b LEFT JOIN committees c ON b.CommitteeID=c.EntryID LEFT JOIN users u ON b.EditedBy=u.EntryID WHERE b.CommitteeID='$committeeID' AND b.DateProcessed BETWEEN '".date('Y-m-d', strtotime($fromDate))."' AND '".date('Y-m-d', strtotime($toDate))."' AND b.Status='ACTIVE'");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}

		else

		{
			return false;
		}
	}

	function get_committee_bills_rep_sess($committeeID, $sessionID)
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$get = $this->db->query("SELECT b.*, c.Title, CONCAT(u.Firstname, ' ', u.Lastname) AS Fullname FROM bills b LEFT JOIN committees c ON b.CommitteeID=c.EntryID LEFT JOIN users u ON b.EditedBy=u.EntryID WHERE b.CommitteeID='$committeeID' AND b.SessionID='$sessionID' AND b.Status='ACTIVE'");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}

		else

		{
			return false;
		}
	}

	function update_bill()
	{
		$update = $this->db->query("UPDATE bills SET BillName=".$this->db->escape($_POST['BillName']).", DateProcessed='".date('Y-m-d', strtotime(str_replace("/", "-", $_POST['DateProcessed'])))."', BillStatus='".$_POST['BillStatus']."' WHERE EntryID='".$_POST['EntryID']."'");

		if($update)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function get_oversight_committees()
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$usertype = $this->session->userdata('alluserdata')[0]['Usertype'];

		// if($usertype == "super" || $usertype == "overall")
		// {
			$get = $this->db->query("SELECT committees.*, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."' AND Status='ACTIVE') OversightCount, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."' AND ReportStatus='Y' AND Status='ACTIVE') ReportConcluded, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."' AND ReportStatus='D' AND Status='ACTIVE') ReportDraft, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."' AND ReportStatus='N' AND Status='ACTIVE') NoReport FROM committees");
		// }

		// else
		// {

		// 	$get = $this->db->query("SELECT committees.*, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."' AND Status='ACTIVE') OversightCount, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."' AND ReportStatus='Y' AND Status='ACTIVE') ReportConcluded, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."' AND ReportStatus='D' AND Status='ACTIVE') ReportDraft, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."' AND ReportStatus='N' AND Status='ACTIVE') NoReport FROM committees LEFT JOIN committee_users ON committees.EntryID=committee_users.CommitteeID WHERE committee_users.UserID='$userid' AND committee_users.IsActive='Y'");
		// }

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function get_committee_oversight($committeeID)
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$get = $this->db->query("SELECT o.*, c.Title, CONCAT(u.Firstname, ' ', u.Lastname) AS Fullname FROM oversight_visits o LEFT JOIN committees c ON o.CommitteeID=c.EntryID LEFT JOIN users u ON o.EditedBy=u.EntryID WHERE o.CommitteeID='$committeeID' AND o.SessionID='".get_current_session($this)."' AND o.Status='ACTIVE'");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}

		else

		{
			return false;
		}
	}

	function get_committee_oversight_rep($committeeID, $fromDate, $toDate)
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$get = $this->db->query("SELECT o.*, c.Title, CONCAT(u.Firstname, ' ', u.Lastname) AS Fullname FROM oversight_visits o LEFT JOIN committees c ON o.CommitteeID=c.EntryID LEFT JOIN users u ON o.EditedBy=u.EntryID WHERE o.CommitteeID='$committeeID' AND o.FromDate >= '".date('Y-m-d', strtotime($fromDate))."' AND o.ToDate <= '".date('Y-m-d', strtotime($toDate))."' AND o.Status='ACTIVE'");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}

		else

		{
			return false;
		}
	}

	function get_committee_oversight_rep_sess($committeeID, $sessionID)
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$get = $this->db->query("SELECT o.*, c.Title, CONCAT(u.Firstname, ' ', u.Lastname) AS Fullname FROM oversight_visits o LEFT JOIN committees c ON o.CommitteeID=c.EntryID LEFT JOIN users u ON o.EditedBy=u.EntryID WHERE o.CommitteeID='$committeeID' AND o.SessionID='$sessionID' AND o.Status='ACTIVE'");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}

		else

		{
			return false;
		}
	}

	function get_oversight_mps($comitteeID)
	{
		$get = $this->db->query("SELECT mps.* FROM oversight_members LEFT JOIN mps ON oversight_members.MpID=mps.EntryID WHERE oversight_members.OversightID='$committeeID'");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function update_oversight()
	{
		$update = $this->db->query("UPDATE oversight_visits SET VisitTitle=".$this->db->escape($_POST['VisitTitle']).", FromDate='".date('Y-m-d', strtotime(str_replace("/", "-", $_POST['FromDate'])))."', ToDate='".date('Y-m-d', strtotime(str_replace("/", "-", $_POST['ToDate'])))."', Amount=".$this->db->escape($_POST['Amount']).", ReportStatus='".$_POST['ReportStatus']."' WHERE EntryID='".$_POST['EntryID']."'");

		if($update)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function get_benchmarking_committees()
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$usertype = $this->session->userdata('alluserdata')[0]['Usertype'];

		// if($usertype == "super" || $usertype == "overall")
		// {
			$get = $this->db->query("SELECT committees.*, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."' AND Status='ACTIVE') BenchmarkingCount, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."' AND ReportStatus='Y' AND Status='ACTIVE') ReportConcluded, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."' AND ReportStatus='D' AND Status='ACTIVE') ReportDraft, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."' AND ReportStatus='N' AND Status='ACTIVE') NoReport FROM committees");
		// }

		// else
		// {

		// 	$get = $this->db->query("SELECT committees.*, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."' AND Status='ACTIVE') BenchmarkingCount, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."' AND ReportStatus='Y' AND Status='ACTIVE') ReportConcluded, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."' AND ReportStatus='D' AND Status='ACTIVE') ReportDraft, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND SessionID='".get_current_session($this)."' AND ReportStatus='N' AND Status='ACTIVE') NoReport FROM committees LEFT JOIN committee_users ON committees.EntryID=committee_users.CommitteeID WHERE committee_users.UserID='$userid' AND committee_users.IsActive='Y'");
		// }

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function get_committee_benchmarking($committeeID)
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$get = $this->db->query("SELECT b.*, c.Title, CONCAT(u.Firstname, ' ', u.Lastname) AS Fullname FROM benchmarking_visits b LEFT JOIN committees c ON b.CommitteeID=c.EntryID LEFT JOIN users u ON b.EditedBy=u.EntryID WHERE b.CommitteeID='$committeeID' AND b.SessionID='".get_current_session($this)."' AND b.Status='ACTIVE'");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}

		else

		{
			return false;
		}
	}

	function get_committee_benchmarking_rep($committeeID, $fromDate, $toDate)
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$get = $this->db->query("SELECT b.*, c.Title, CONCAT(u.Firstname, ' ', u.Lastname) AS Fullname FROM benchmarking_visits b LEFT JOIN committees c ON b.CommitteeID=c.EntryID LEFT JOIN users u ON b.EditedBy=u.EntryID WHERE b.CommitteeID='$committeeID' AND b.FromDate >= '".date('Y-m-d', strtotime($fromDate))."' AND b.ToDate <= '".date('Y-m-d', strtotime($toDate))."' AND b.Status='ACTIVE'");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}

		else

		{
			return false;
		}
	}

	function get_committee_benchmarking_rep_sess($committeeID, $sessionID)
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$get = $this->db->query("SELECT b.*, c.Title, CONCAT(u.Firstname, ' ', u.Lastname) AS Fullname FROM benchmarking_visits b LEFT JOIN committees c ON b.CommitteeID=c.EntryID LEFT JOIN users u ON b.EditedBy=u.EntryID WHERE b.CommitteeID='$committeeID' AND b.SessionID='$sessionID' AND b.Status='ACTIVE'");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}

		else

		{
			return false;
		}
	}

	function update_travel_abroad()
	{
		$update = $this->db->query("UPDATE benchmarking_visits SET VisitTitle=".$this->db->escape($_POST['VisitTitle']).", FromDate='".date('Y-m-d', strtotime(str_replace("/", "-", $_POST['FromDate'])))."', ToDate='".date('Y-m-d', strtotime(str_replace("/", "-", $_POST['ToDate'])))."', Amount=".$this->db->escape($_POST['Amount']).", ReportStatus='".$_POST['ReportStatus']."' WHERE EntryID='".$_POST['EntryID']."'");

		if($update)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function get_individual_mps()
	{
		$sessionID = $this->session->userdata('alluserdata')[0]['SessionID'];

		// $get = $this->db->query("SELECT m.*, (SELECT COUNT(c.EntryID) FROM committee_members c WHERE c.MpID=m.EntryID AND c.IsActive='Y') NoOfCommittees, (SELECT COUNT(a.EntryID) FROM attendance a LEFT JOIN sittings s ON a.SittingID=s.EntryID WHERE a.MpID=m.EntryID AND a.AttendanceStatus='present' AND s.Status='ACTIVE') Present, (SELECT COUNT(a.EntryID) FROM attendance a LEFT JOIN sittings s ON a.SittingID=s.EntryID WHERE a.MpID=m.EntryID AND a.AttendanceStatus='absent' AND s.Status='ACTIVE') Absent, (SELECT COUNT(a.EntryID) FROM attendance a LEFT JOIN sittings s ON a.SittingID=s.EntryID WHERE a.MpID=m.EntryID AND a.AttendanceStatus='awo' AND s.Status='ACTIVE') Awo, (SELECT COUNT(o.EntryID) FROM oversight_members o LEFT JOIN oversight_visits ov ON o.OversightID=ov.EntryID WHERE o.MpID=m.EntryID AND ov.Status='ACTIVE') FieldTrips, (SELECT COUNT(b.EntryID) FROM benchmarking_members b LEFT JOIN benchmarking_visits bv ON b.BenchmarkID=bv.EntryID WHERE b.MpID=m.EntryID AND bv.Status='ACTIVE') TravelsAbroad FROM mps m WHERE m.SessionID='$sessionID'");

		$get = $this->db->query("SELECT m.*, (SELECT COUNT(c.EntryID) FROM committee_members c WHERE c.MpID=m.EntryID AND c.SessionID='".get_current_session($this)."' AND c.IsActive='Y') NoOfCommittees, (SELECT COUNT(a.EntryID) FROM attendance a LEFT JOIN sittings s ON a.SittingID=s.EntryID WHERE a.MpID=m.EntryID AND a.AttendanceStatus='present' AND s.SessionID='".get_current_session($this)."' AND s.Status='ACTIVE') Present, (SELECT COUNT(a.EntryID) FROM attendance a LEFT JOIN sittings s ON a.SittingID=s.EntryID WHERE a.MpID=m.EntryID AND a.AttendanceStatus='absent' AND s.SessionID='".get_current_session($this)."' AND s.Status='ACTIVE') Absent, (SELECT COUNT(a.EntryID) FROM attendance a LEFT JOIN sittings s ON a.SittingID=s.EntryID WHERE a.MpID=m.EntryID AND a.AttendanceStatus='awo' AND s.SessionID='".get_current_session($this)."' AND s.Status='ACTIVE') Awo, (SELECT COUNT(o.EntryID) FROM oversight_members o LEFT JOIN oversight_visits ov ON o.OversightID=ov.EntryID WHERE o.MpID=m.EntryID AND ov.SessionID='".get_current_session($this)."' AND ov.Status='ACTIVE') FieldTrips, (SELECT COUNT(b.EntryID) FROM benchmarking_members b LEFT JOIN benchmarking_visits bv ON b.BenchmarkID=bv.EntryID WHERE b.MpID=m.EntryID AND bv.SessionID='".get_current_session($this)."' AND bv.Status='ACTIVE') TravelsAbroad FROM mps m WHERE m.Status='ACTIVE' AND m.SessionID='".get_current_session($this)."'");


		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function get_mps_details($mpID)
	{
		$get = $this->db->query("SELECT * FROM mps WHERE EntryID='$mpID'");

		if($get->num_rows() > 0)
		{
			return $get->row_array();
		}
		else
		{
			return false;
		}
	}

	function get_mps_committees($mpID)
	{
		$get = $this->db->query("SELECT c.EntryID, c.Title, c.Category FROM committee_members m LEFT JOIN committees c ON m.CommitteeID=c.EntryID WHERE m.MpID='$mpID' AND m.IsActive='Y'");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function get_individual_mp($mpid)
	{
		$get = $this->db->query("SELECT m.*, (SELECT COUNT(c.EntryID) FROM committee_members c WHERE c.MpID=m.EntryID) NoOfCommittees, (SELECT COUNT(a.EntryID) FROM attendance a LEFT JOIN sittings s ON a.SittingID=s.EntryID WHERE a.MpID=m.EntryID AND a.AttendanceStatus='present' AND s.Status='ACTIVE') Present, (SELECT COUNT(a.EntryID) FROM attendance a LEFT JOIN sittings s ON a.SittingID=s.EntryID WHERE a.MpID=m.EntryID AND a.AttendanceStatus='absent' AND s.Status='ACTIVE') Absent, (SELECT COUNT(a.EntryID) FROM attendance a LEFT JOIN sittings s ON a.SittingID=s.EntryID WHERE a.MpID=m.EntryID AND a.AttendanceStatus='awo' AND s.Status='ACTIVE') Awo, (SELECT COUNT(o.EntryID) FROM oversight_members o LEFT JOIN oversight_visits ov ON o.OversightID=ov.EntryID WHERE o.MpID=m.EntryID AND ov.Status='ACTIVE') FieldTrips, (SELECT COUNT(b.EntryID) FROM benchmarking_members b LEFT JOIN benchmarking_visits bv ON b.BenchmarkID=bv.EntryID WHERE b.MpID=m.EntryID AND bv.Status='ACTIVE') TravelsAbroad FROM mps m WHERE m.EntryID='$mpid'");

		if($get->num_rows() > 0)
		{
			return $get->row_array();
		}
		else
		{
			return false;
		}
	}

	function get_sessions()
	{
		$get = $this->db->query("SELECT * FROM sessions ORDER BY EntryID DESC");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function get_allocation_committees()
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$usertype = $this->session->userdata('alluserdata')[0]['Usertype'];

		$sessionID = $this->session->userdata('alluserdata')[0]['SessionID'];

		// if($usertype == "super" || $usertype == "overall")
		// {
			$get = $this->db->query("SELECT committees.*, (SELECT SUM(Amount) FROM budget_alloc WHERE CommitteeID=committees.EntryID AND SessionID='$sessionID' AND AllocType='FT') FTTotal,(SELECT SUM(Amount) FROM budget_alloc WHERE CommitteeID=committees.EntryID AND SessionID='$sessionID' AND AllocType='TA') TATotal, (SELECT SUM(Amount) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND SessionID='$sessionID' AND Status='ACTIVE') FieldAmt, (SELECT SUM(Amount) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND SessionID='$sessionID' AND Status='ACTIVE') TravelAmt FROM committees");
		// }

		// else
		// {

		// 	$get = $this->db->query("SELECT committees.*, (SELECT Amount FROM budget_alloc WHERE CommitteeID=committees.EntryID AND SessionID='$sessionID' AND AllocType='FT') FTTotal,(SELECT Amount FROM budget_alloc WHERE CommitteeID=committees.EntryID AND SessionID='$sessionID' AND AllocType='TA') TATotal, (SELECT SUM(Amount) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND SessionID='$sessionID' AND Status='ACTIVE') FieldAmt, (SELECT SUM(Amount) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND SessionID='$sessionID' AND Status='ACTIVE') TravelAmt FROM committees LEFT JOIN committee_users ON committees.EntryID=committee_users.CommitteeID WHERE committee_users.UserID='$userid' AND committee_users.IsActive='Y'");
		// }

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function get_committee_history()
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$usertype = $this->session->userdata('alluserdata')[0]['Usertype'];

		$sessionID = $this->session->userdata('alluserdata')[0]['SessionID'];

		$get = $this->db->query("SELECT c.MpID, (SELECT Name FROM mps WHERE EntryID=c.MpID) AS Name, (SELECT Code FROM mps WHERE EntryID=c.MpID) AS Code, (SELECT COUNT(MpID) FROM committee_members WHERE MpID=c.MpID AND SessionID='$sessionID') AS Comms, COUNT(c.MpID) AS Movs FROM committee_history c WHERE c.SessionID='$sessionID' GROUP BY c.MpID");
		

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function get_history_details($id)
	{
		$sessionID = $this->session->userdata('alluserdata')[0]['SessionID'];

		$get = $this->db->query("SELECT c.*, (SELECT Name FROM mps WHERE EntryID=c.MpID) AS Name, (SELECT Code FROM mps WHERE EntryID=c.MpID) AS Code, (SELECT Title FROM committees WHERE EntryID=c.CommitteeID) AS Title FROM committee_history c WHERE c.MpID='$id' AND c.SessionID='$sessionID'");
		

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function get_custom_reports()
	{

		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$usertype = $this->session->userdata('alluserdata')[0]['Usertype'];

		if($_POST['CommitteeID'] == "all")
		{
			$comm_qry = "";
		}
		else
		{
			$comm_qry = " AND committees.EntryID='".$_POST['CommitteeID']."' ";
		}

		if($_POST['Category'] == "att" || $_POST['Category'] == "att_mp")
		{
			$date_qry = "AND sittings.SittingDate BETWEEN '".date('Y-m-d', strtotime($_POST['FromDate']))."' AND '".date('Y-m-d', strtotime($_POST['ToDate']))."'";

			if($usertype == "super" || $usertype == "overall")
			{
				$get = $this->db->query("SELECT committees.*, (SELECT COUNT(EntryID) FROM sittings WHERE CommitteeID=committees.EntryID ".$date_qry." AND Status='ACTIVE') TimesSat FROM committees WHERE Status='ACTIVE' ".$comm_qry."");
			}
			else
			{

				// echo "SELECT committees.*, (SELECT COUNT(EntryID) FROM sittings WHERE CommitteeID=committees.EntryID ".$date_qry.") TimesSat FROM committees LEFT JOIN committee_users ON committees.EntryID=committee_users.CommitteeID WHERE committee_users.UserID='$userid' ".$comm_qry." AND committee_users.IsActive='Y'"; exit;

				$get = $this->db->query("SELECT committees.*, '".$_POST['FromDate']."' AS FromDate, '".$_POST['ToDate']."' AS ToDate, (SELECT COUNT(EntryID) FROM sittings WHERE CommitteeID=committees.EntryID ".$date_qry.") TimesSat FROM committees LEFT JOIN committee_users ON committees.EntryID=committee_users.CommitteeID WHERE committee_users.UserID='$userid' ".$comm_qry." AND committee_users.IsActive='Y'");

			}

		}
		else if($_POST['Category'] == "bills")
		{
			$date_qry = "AND bills.DateProcessed BETWEEN '".date('Y-m-d', strtotime($_POST['FromDate']))."' AND '".date('Y-m-d', strtotime($_POST['ToDate']))."'";

			if($usertype == "super" || $usertype == "overall")
			{
				$get = $this->db->query("SELECT committees.*, '".$_POST['FromDate']."' AS FromDate, '".$_POST['ToDate']."' AS ToDate, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID ".$date_qry." AND Status='ACTIVE') TotalCount, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID AND BillStatus='Y' ".$date_qry." AND Status='ACTIVE') ReportConcluded, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID AND BillStatus='D' ".$date_qry." AND Status='ACTIVE') ReportDraft, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID AND BillStatus='N' ".$date_qry." AND Status='ACTIVE') NoReport FROM committees WHERE Status='ACTIVE' ".$comm_qry."");
			}
			else
			{

				$get = $this->db->query("SELECT committees.*, '".$_POST['FromDate']."' AS FromDate, '".$_POST['ToDate']."' AS ToDate, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID ".$date_qry." AND Status='ACTIVE') TotalCount, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID AND BillStatus='Y' ".$date_qry." AND Status='ACTIVE') ReportConcluded, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID AND BillStatus='D' ".$date_qry." AND Status='ACTIVE') ReportDraft, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID AND BillStatus='N' ".$date_qry." AND Status='ACTIVE') NoReport FROM committees LEFT JOIN committee_users ON committees.EntryID=committee_users.CommitteeID WHERE committee_users.UserID='$userid' ".$comm_qry." AND committee_users.IsActive='Y'");

			}

		}
		else if($_POST['Category'] == "fts")
		{
			$date_qry = "AND oversight_visits.FromDate >= '".date('Y-m-d', strtotime($_POST['FromDate']))."' AND oversight_visits.ToDate <= '".date('Y-m-d', strtotime($_POST['ToDate']))."'";

			if($usertype == "super" || $usertype == "overall")
			{
				$get = $this->db->query("SELECT committees.*, '".$_POST['FromDate']."' AS FromDate, '".$_POST['ToDate']."' AS ToDate, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID ".$date_qry." AND Status='ACTIVE') TotalCount, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND ReportStatus='Y' ".$date_qry." AND Status='ACTIVE') ReportConcluded, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND ReportStatus='D' ".$date_qry." AND Status='ACTIVE') ReportDraft, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND ReportStatus='N' ".$date_qry." AND Status='ACTIVE') NoReport FROM committees WHERE Status='ACTIVE' ".$comm_qry."");
			}
			else
			{

				$get = $this->db->query("SELECT committees.*, '".$_POST['FromDate']."' AS FromDate, '".$_POST['ToDate']."' AS ToDate, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID ".$date_qry." AND Status='ACTIVE') TotalCount, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND ReportStatus='Y' ".$date_qry." AND Status='ACTIVE') ReportConcluded, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND ReportStatus='D' ".$date_qry." AND Status='ACTIVE') ReportDraft, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND ReportStatus='N' ".$date_qry." AND Status='ACTIVE') NoReport FROM committees LEFT JOIN committee_users ON committees.EntryID=committee_users.CommitteeID WHERE committee_users.UserID='$userid' ".$comm_qry." AND committee_users.IsActive='Y'");

			}

		}
		else if($_POST['Category'] == "tas")
		{
			$date_qry = "AND benchmarking_visits.FromDate >= '".date('Y-m-d', strtotime($_POST['FromDate']))."' AND benchmarking_visits.ToDate <= '".date('Y-m-d', strtotime($_POST['ToDate']))."'";

			if($usertype == "super" || $usertype == "overall")
			{
				$get = $this->db->query("SELECT committees.*, '".$_POST['FromDate']."' AS FromDate, '".$_POST['ToDate']."' AS ToDate, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID ".$date_qry." AND Status='ACTIVE') TotalCount, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND ReportStatus='Y' ".$date_qry." AND Status='ACTIVE') ReportConcluded, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND ReportStatus='D' ".$date_qry." AND Status='ACTIVE') ReportDraft, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND ReportStatus='N' ".$date_qry." AND Status='ACTIVE') NoReport FROM committees WHERE Status='ACTIVE' ".$comm_qry."");
			}
			else
			{

				$get = $this->db->query("SELECT committees.*, '".$_POST['FromDate']."' AS FromDate, '".$_POST['ToDate']."' AS ToDate, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID ".$date_qry." AND Status='ACTIVE') TotalCount, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND ReportStatus='Y' ".$date_qry." AND Status='ACTIVE') ReportConcluded, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND ReportStatus='D' ".$date_qry." AND Status='ACTIVE') ReportDraft, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND ReportStatus='N' ".$date_qry." AND Status='ACTIVE') NoReport FROM committees LEFT JOIN committee_users ON committees.EntryID=committee_users.CommitteeID WHERE committee_users.UserID='$userid' ".$comm_qry." AND committee_users.IsActive='Y'");

			}

		}

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function get_session_reports()
	{

		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$usertype = $this->session->userdata('alluserdata')[0]['Usertype'];

		if($_POST['CommitteeID'] == "all")
		{
			$comm_qry = "";
		}
		else
		{
			$comm_qry = " AND committees.EntryID='".$_POST['CommitteeID']."' ";
		}

		if($_POST['Category'] == "att")
		{
			$date_qry = "AND sittings.SessionID='".$_POST['SessionID']."'";

			if($usertype == "super" || $usertype == "overall")
			{
				$get = $this->db->query("SELECT committees.*, (SELECT COUNT(EntryID) FROM sittings WHERE CommitteeID=committees.EntryID ".$date_qry." AND Status='ACTIVE') TimesSat FROM committees WHERE Status='ACTIVE' ".$comm_qry."");
			}
			else
			{

				// echo "SELECT committees.*, (SELECT COUNT(EntryID) FROM sittings WHERE CommitteeID=committees.EntryID ".$date_qry.") TimesSat FROM committees LEFT JOIN committee_users ON committees.EntryID=committee_users.CommitteeID WHERE committee_users.UserID='$userid' ".$comm_qry." AND committee_users.IsActive='Y'"; exit;

				$get = $this->db->query("SELECT committees.*, '".$_POST['SessionID']."' AS SessionID, (SELECT COUNT(EntryID) FROM sittings WHERE CommitteeID=committees.EntryID ".$date_qry." AND Status='ACTIVE') TimesSat FROM committees LEFT JOIN committee_users ON committees.EntryID=committee_users.CommitteeID WHERE committee_users.UserID='$userid' ".$comm_qry." AND committee_users.IsActive='Y'");

			}

		}
		else if($_POST['Category'] == "bills")
		{
			$date_qry = "AND bills.SessionID='".$_POST['SessionID']."'";

			if($usertype == "super" || $usertype == "overall")
			{
				$get = $this->db->query("SELECT committees.*, '".$_POST['SessionID']."' AS SessionID, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID ".$date_qry." AND Status='ACTIVE') TotalCount, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID AND BillStatus='Y' ".$date_qry." AND Status='ACTIVE') ReportConcluded, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID AND BillStatus='D' ".$date_qry." AND Status='ACTIVE') ReportDraft, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID AND BillStatus='N' ".$date_qry." AND Status='ACTIVE') NoReport FROM committees WHERE Status='ACTIVE' ".$comm_qry."");
			}
			else
			{

				$get = $this->db->query("SELECT committees.*, '".$_POST['SessionID']."' AS SessionID, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID ".$date_qry." AND Status='ACTIVE') TotalCount, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID AND BillStatus='Y' ".$date_qry." AND Status='ACTIVE') ReportConcluded, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID AND BillStatus='D' ".$date_qry." AND Status='ACTIVE') ReportDraft, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID AND BillStatus='N' ".$date_qry." AND Status='ACTIVE') NoReport FROM committees LEFT JOIN committee_users ON committees.EntryID=committee_users.CommitteeID WHERE committee_users.UserID='$userid' ".$comm_qry." AND committee_users.IsActive='Y'");

			}

		}
		else if($_POST['Category'] == "fts")
		{
			$date_qry = "AND oversight_visits.SessionID='".$_POST['SessionID']."'";

			if($usertype == "super" || $usertype == "overall")
			{
				$get = $this->db->query("SELECT committees.*, '".$_POST['SessionID']."' AS SessionID, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID ".$date_qry." AND Status='ACTIVE') TotalCount, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND ReportStatus='Y' ".$date_qry." AND Status='ACTIVE') ReportConcluded, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND ReportStatus='D' ".$date_qry." AND Status='ACTIVE') ReportDraft, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND ReportStatus='N' ".$date_qry." AND Status='ACTIVE') NoReport FROM committees WHERE Status='ACTIVE' ".$comm_qry."");
			}
			else
			{

				$get = $this->db->query("SELECT committees.*, '".$_POST['SessionID']."' AS SessionID, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID ".$date_qry." AND Status='ACTIVE') TotalCount, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND ReportStatus='Y' ".$date_qry." AND Status='ACTIVE') ReportConcluded, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND ReportStatus='D' ".$date_qry." AND Status='ACTIVE') ReportDraft, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND ReportStatus='N' ".$date_qry." AND Status='ACTIVE') NoReport FROM committees LEFT JOIN committee_users ON committees.EntryID=committee_users.CommitteeID WHERE committee_users.UserID='$userid' ".$comm_qry." AND committee_users.IsActive='Y'");

			}

		}
		else if($_POST['Category'] == "tas")
		{
			$date_qry = "AND benchmarking_visits..SessionID='".$_POST['SessionID']."'";

			if($usertype == "super" || $usertype == "overall")
			{
				$get = $this->db->query("SELECT committees.*, '".$_POST['SessionID']."' AS SessionID, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID ".$date_qry." AND Status='ACTIVE') TotalCount, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND ReportStatus='Y' ".$date_qry." AND Status='ACTIVE') ReportConcluded, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND ReportStatus='D' ".$date_qry." AND Status='ACTIVE') ReportDraft, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND ReportStatus='N' ".$date_qry." AND Status='ACTIVE') NoReport FROM committees WHERE Status='ACTIVE' ".$comm_qry."");
			}
			else
			{

				$get = $this->db->query("SELECT committees.*, '".$_POST['SessionID']."' AS SessionID, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID ".$date_qry." AND Status='ACTIVE') TotalCount, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND ReportStatus='Y' ".$date_qry." AND Status='ACTIVE') ReportConcluded, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND ReportStatus='D' ".$date_qry." AND Status='ACTIVE') ReportDraft, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND ReportStatus='N' ".$date_qry." AND Status='ACTIVE') NoReport FROM committees LEFT JOIN committee_users ON committees.EntryID=committee_users.CommitteeID WHERE committee_users.UserID='$userid' ".$comm_qry." AND committee_users.IsActive='Y'");

			}

		}

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	################################## SESSION REPORTS ##############################################

	function get_custom_committees_sess()
	{
		$session_id = $_GET['session_id'];

		// echo "<pre>"; print_r($_GET); echo "</pre> <br/><br/>";

		$get = $this->db->query("SELECT committees.*, (SELECT COUNT(EntryID) FROM committee_members WHERE CommitteeID=committees.EntryID AND SessionID='".$session_id."') NoOfMembers, (SELECT COUNT(EntryID) FROM sittings WHERE CommitteeID=committees.EntryID AND SessionID='".$session_id."') TimesSat FROM committees");


		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function get_bills_committees_sess()
	{
		if(empty($_GET['session_id']))
		{
			$session = get_current_session($this);
		}
		else
		{
			$session = $_GET['session_id'];
		}

		$get = $this->db->query("SELECT committees.*, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID AND SessionID='".$session."' AND Status='ACTIVE') BillsCount, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID AND SessionID='".$session."' AND BillStatus='Y' AND Status='ACTIVE') ReportConcluded, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID AND SessionID='".$session."' AND BillStatus='D' AND Status='ACTIVE') ReportDraft, (SELECT COUNT(EntryID) FROM bills WHERE CommitteeID=committees.EntryID AND SessionID='".$session."' AND BillStatus='N' AND Status='ACTIVE') NoReport FROM committees");


		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function get_oversight_committees_sess()
	{
		if(empty($_GET['session_id']))
		{
			$session = get_current_session($this);
		}
		else
		{
			$session = $_GET['session_id'];
		}

		$get = $this->db->query("SELECT committees.*, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND SessionID='".$session."' AND Status='ACTIVE') OversightCount, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND SessionID='".$session."' AND ReportStatus='Y' AND Status='ACTIVE') ReportConcluded, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND SessionID='".$session."' AND ReportStatus='D' AND Status='ACTIVE') ReportDraft, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND SessionID='".$session."' AND ReportStatus='N' AND Status='ACTIVE') NoReport FROM committees");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function get_benchmarking_committees_sess()
	{
		if(empty($_GET['session_id']))
		{
			$session = get_current_session($this);
		}
		else
		{
			$session = $_GET['session_id'];
		}

		$get = $this->db->query("SELECT committees.*, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND SessionID='".$session."' AND Status='ACTIVE') BenchmarkingCount, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND SessionID='".$session."' AND ReportStatus='Y' AND Status='ACTIVE') ReportConcluded, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND SessionID='".$session."' AND ReportStatus='D' AND Status='ACTIVE') ReportDraft, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND SessionID='".$session."' AND ReportStatus='N' AND Status='ACTIVE') NoReport FROM committees");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function get_individual_mps_sess()
	{
		if(empty($_GET['session_id']))
		{
			$session = get_current_session($this);
		}
		else
		{
			$session = $_GET['session_id'];
		}

		$get = $this->db->query("SELECT m.*, (SELECT COUNT(c.EntryID) FROM committee_members c WHERE c.MpID=m.EntryID AND c.SessionID='".$session."' AND c.IsActive='Y') NoOfCommittees, (SELECT COUNT(a.EntryID) FROM attendance a LEFT JOIN sittings s ON a.SittingID=s.EntryID WHERE a.MpID=m.EntryID AND a.AttendanceStatus='present' AND s.SessionID='".$session."' AND s.Status='ACTIVE') Present, (SELECT COUNT(a.EntryID) FROM attendance a LEFT JOIN sittings s ON a.SittingID=s.EntryID WHERE a.MpID=m.EntryID AND a.AttendanceStatus='absent' AND s.SessionID='".$session."' AND s.Status='ACTIVE') Absent, (SELECT COUNT(a.EntryID) FROM attendance a LEFT JOIN sittings s ON a.SittingID=s.EntryID WHERE a.MpID=m.EntryID AND a.AttendanceStatus='awo' AND s.SessionID='".$session."' AND s.Status='ACTIVE') Awo, (SELECT COUNT(o.EntryID) FROM oversight_members o LEFT JOIN oversight_visits ov ON o.OversightID=ov.EntryID WHERE o.MpID=m.EntryID AND ov.SessionID='".$session."' AND ov.Status='ACTIVE') FieldTrips, (SELECT COUNT(b.EntryID) FROM benchmarking_members b LEFT JOIN benchmarking_visits bv ON b.BenchmarkID=bv.EntryID WHERE b.MpID=m.EntryID AND bv.SessionID='".$session."' AND bv.Status='ACTIVE') TravelsAbroad FROM mps m WHERE m.Status='ACTIVE' AND m.SessionID='".$session."'");


		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function get_mps_committees_sess($mpID, $sessionID)
	{
		$get = $this->db->query("SELECT c.EntryID, c.Title, c.Category FROM committee_members m LEFT JOIN committees c ON m.CommitteeID=c.EntryID WHERE m.MpID='$mpID' AND m.SessionID='$sessionID' AND m.IsActive='Y'");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function get_individual_mp_sess($mpid, $sessionID)
	{
		$get = $this->db->query("SELECT m.*, (SELECT COUNT(c.EntryID) FROM committee_members c WHERE c.MpID=m.EntryID AND c.SessionID='$sessionID') NoOfCommittees, (SELECT COUNT(a.EntryID) FROM attendance a LEFT JOIN sittings s ON a.SittingID=s.EntryID WHERE a.MpID=m.EntryID AND a.AttendanceStatus='present' AND s.Status='ACTIVE' AND s.SessionID='$sessionID') Present, (SELECT COUNT(a.EntryID) FROM attendance a LEFT JOIN sittings s ON a.SittingID=s.EntryID WHERE a.MpID=m.EntryID AND a.AttendanceStatus='absent' AND s.Status='ACTIVE' AND s.SessionID='$sessionID') Absent, (SELECT COUNT(a.EntryID) FROM attendance a LEFT JOIN sittings s ON a.SittingID=s.EntryID WHERE a.MpID=m.EntryID AND a.AttendanceStatus='awo' AND s.Status='ACTIVE' AND s.SessionID='$sessionID') Awo, (SELECT COUNT(o.EntryID) FROM oversight_members o LEFT JOIN oversight_visits ov ON o.OversightID=ov.EntryID WHERE o.MpID=m.EntryID AND ov.Status='ACTIVE' AND ov.SessionID='$sessionID') FieldTrips, (SELECT COUNT(b.EntryID) FROM benchmarking_members b LEFT JOIN benchmarking_visits bv ON b.BenchmarkID=bv.EntryID WHERE b.MpID=m.EntryID AND bv.Status='ACTIVE' AND bv.SessionID='$sessionID') TravelsAbroad FROM mps m WHERE m.EntryID='$mpid'");

		if($get->num_rows() > 0)
		{
			return $get->row_array();
		}
		else
		{
			return false;
		}
	}

}

?>