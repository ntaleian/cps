<?php

class Dashboard_model extends CI_Model {
	
	#Constructor
	public function __construct()
	{
		parent::__construct();
	}

	function get_sittings_count()
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$usertype = $this->session->userdata('alluserdata')[0]['Usertype'];

		if($usertype == "super" || $usertype="overall")
		{
			$get = $this->db->query("SELECT s.CommitteeID, COUNT(s.CommitteeID) AS NoOfSittings, c.Title FROM sittings s LEFT OUTER JOIN committees c ON s.CommitteeID=c.EntryID WHERE s.SessionID='".get_current_session($this)."' AND s.Status='ACTIVE' GROUP BY s.CommitteeID");

		}

		else
		{

			$get = $this->db->query("SELECT s.CommitteeID, COUNT(s.CommitteeID) AS NoOfSittings, c.Title FROM sittings s LEFT OUTER JOIN committees c ON s.CommitteeID=c.EntryID LEFT JOIN committee_users u ON c.EntryID=u.CommitteeID WHERE c.EntryID=u.CommitteeID AND u.UserID='$userid' AND s.SessionID='".get_current_session($this)."' AND s.Status='ACTIVE' GROUP BY s.CommitteeID");
		}

		// $get = $this->db->query("SELECT s.CommitteeID, COUNT(s.CommitteeID) AS NoOfSittings, c.Title FROM sittings s LEFT OUTER JOIN committees c ON s.CommitteeID=c.EntryID WHERE s.ClerkID='$userid' GROUP BY s.CommitteeID");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function get_other_activities()
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		// $get = $this->db->query("SELECT committees.* FROM committees LEFT JOIN committee_users ON committees.EntryID=committee_users.CommitteeID WHERE committee_users.UserID='$userid'");
		$get = $this->db->query("SELECT committees.*, (SELECT COUNT(EntryID) FROM oversight_visits WHERE CommitteeID=committees.EntryID AND Status='ACTIVE') Oversight, (SELECT COUNT(EntryID) FROM benchmarking_visits WHERE CommitteeID=committees.EntryID AND Status='ACTIVE') Benchmarking FROM committees LEFT JOIN committee_users ON committees.EntryID=committee_users.CommitteeID WHERE committee_users.UserID='$userid'");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function get_total_sittings()
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$usertype = $this->session->userdata('alluserdata')[0]['Usertype'];

		if($usertype == "super" || $usertype="overall")
		{
			$get = $this->db->query("SELECT COUNT(EntryID) AS TotalSittings FROM sittings WHERE SessionID='".get_current_session($this)."'");
		}
		else
		{
			// $get = $this->db->query("SELECT COUNT(s.EntryID) AS TotalSittings FROM sittings s LEFT OUTER JOIN committees c ON s.CommitteeID=c.EntryID LEFT JOIN committee_users u ON c.EntryID=u.CommitteeID WHERE s.ClerkID='$userid' AND c.EntryID=u.CommitteeID GROUP BY s.CommitteeID");
			$get = $this->db->query("SELECT COUNT(s.EntryID) AS TotalSittings FROM sittings s LEFT OUTER JOIN committees c ON s.CommitteeID=c.EntryID LEFT JOIN committee_users u ON c.EntryID=u.CommitteeID WHERE c.EntryID=u.CommitteeID AND u.UserID='$userid' AND s.SessionID='".get_current_session($this)."' GROUP BY s.CommitteeID AND s.Status='ACTIVE'");
		}

		if($get->num_rows() > 0)
		{
			return $get->row_array();
		}
		else
		{
			return false;
		}
	}

	function get_system_users()
	{
		$get = $this->db->query("SELECT COUNT(EntryID) AS SystemUsers FROM users WHERE Usertype='normal'");

		if($get->num_rows() > 0)
		{
			return $get->row_array();
		}
		else
		{
			return false;
		}
	}

	function get_total_fieldtrips()
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$usertype = $this->session->userdata('alluserdata')[0]['Usertype'];

		if($usertype == "super" || $usertype="overall")
		{
			$get = $this->db->query("SELECT COUNT(EntryID) AS TotalFieldtrips FROM oversight_visits WHERE SessionID='".get_current_session($this)."' AND Status='ACTIVE'");
		}

		else
		{
			// $get = $this->db->query("SELECT COUNT(o.EntryID) AS TotalFieldtrips FROM oversight_visits o LEFT OUTER JOIN committee_users u ON o.CommitteeID=u.CommitteeID WHERE o.EditedBy='$userid' AND u.UserID='$userid'");
			$get = $this->db->query("SELECT COUNT(o.EntryID) AS TotalFieldtrips FROM oversight_visits o LEFT OUTER JOIN committee_users u ON o.CommitteeID=u.CommitteeID WHERE o.CommitteeID=u.CommitteeID AND u.UserID='$userid' AND o.SessionID='".get_current_session($this)."' AND o.Status='ACTIVE'");
		}

		if($get->num_rows() > 0)
		{
			return $get->row_array();
		}
		else
		{
			return false;
		}
	}

	function get_total_travels()
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$usertype = $this->session->userdata('alluserdata')[0]['Usertype'];

		if($usertype == "super" || $usertype="overall")
		{
			$get = $this->db->query("SELECT COUNT(EntryID) AS TotalTravels FROM benchmarking_visits WHERE SessionID='".get_current_session($this)."' AND Status='ACTIVE'");
		}
		else
		{

			// $get = $this->db->query("SELECT COUNT(b.EntryID) AS TotalTravels FROM benchmarking_visits b LEFT OUTER JOIN committees c ON b.CommitteeID=c.EntryID LEFT JOIN committee_users u ON c.EntryID=u.CommitteeID WHERE b.EditedBy='$userid' AND c.EntryID=u.CommitteeID GROUP BY b.CommitteeID");
			$get = $this->db->query("SELECT COUNT(b.EntryID) AS TotalTravels FROM benchmarking_visits b LEFT OUTER JOIN committees c ON b.CommitteeID=c.EntryID LEFT JOIN committee_users u ON c.EntryID=u.CommitteeID WHERE c.EntryID=u.CommitteeID AND u.UserID='$userid' AND b.SessionID='".get_current_session($this)."' AND b.Status='ACTIVE' GROUP BY b.CommitteeID");

		}

		if($get->num_rows() > 0)
		{
			return $get->row_array();
		}
		else
		{
			return false;
		}
	}

	function get_sittings_per_period()
	{
		$get = $this->db->query("SELECT COUNT(EntryID) NoOfSittings, CONCAT(YEAR(SittingDate),'-',MONTH(SittingDate)) MonthSat FROM `sittings` WHERE Status='ACTIVE' GROUP BY YEAR(SittingDate), MONTH(SittingDate) DESC");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function other_stats()
	{
		$orig_year = date('Y') - 5;
		$years = array();
		$x = 1;

		for($i = 1; $i <= 5; $i++)
		{
			$years[] = $orig_year + $x;
			$x++;
		}

		// print_r($years); exit;

		// $years = array('2015','2016','2017','2018','2019');

		$stats = array();

		foreach($years as $year)
		{
			
				$get = $this->db->query("SELECT '$year' AS Period, (SELECT COUNT(o.EntryID) FROM oversight_visits o WHERE o.Status='ACTIVE' AND YEAR(o.FromDate)='$year') FieldTrips, (SELECT COUNT(b.EntryID) FROM benchmarking_visits b WHERE YEAR(b.FromDate)='$year' AND b.Status='ACTIVE') Travels, COUNT(s.EntryID) NoOfSittings FROM sittings s WHERE YEAR(s.SittingDate)='$year' AND s.Status='ACTIVE' ");

			if($get->num_rows() > 0)
			{
				$result = $get->row_array();

				array_push($stats, $result);
			}
		}

		// print_r($stats); exit;
		return $stats;
	}

	function other_stats_normal()
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$usertype = $this->session->userdata('alluserdata')[0]['Usertype'];

		$years = array('2015','2016','2017','2018','2019');

		$stats = array();

		foreach($years as $year)
		{

			$get = $this->db->query("SELECT '$year' AS Period, (SELECT COUNT(o.EntryID) FROM oversight_visits o LEFT JOIN committee_users u ON o.CommitteeID=u.CommitteeID WHERE YEAR(o.FromDate)='$year' AND u.UserID='$userid' AND o.Status='ACTIVE') FieldTrips, (SELECT COUNT(b.EntryID) FROM benchmarking_visits b LEFT JOIN committee_users u ON b.CommitteeID=u.CommitteeID WHERE YEAR(b.FromDate)='$year' AND u.UserID='$userid' AND b.Status='ACTIVE') Travels, COUNT(s.EntryID) NoOfSittings FROM sittings s LEFT JOIN committee_users u ON s.CommitteeID=u.CommitteeID WHERE YEAR(s.SittingDate)='$year' AND u.UserID='$userid' AND s.Status='ACTIVE' ");

			if($get->num_rows() > 0)
			{
				$result = $get->row_array();

				array_push($stats, $result);
			}
		}

		// print_r($stats); exit;
		return $stats;
	}

	function total_reports()
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$usertype = $this->session->userdata('alluserdata')[0]['Usertype'];

		$sessionID = $this->session->userdata('alluserdata')[0]['SessionID'];

		$billreports = $this->db->query("SELECT COUNT(b.EntryID) AS NoOfBills FROM bills b LEFT JOIN committee_users u ON b.CommitteeID=u.CommitteeID WHERE b.BillStatus IN ('Y','D') AND u.UserID='$userid' AND b.Status='ACTIVE' AND b.SessionID='$sessionID' ");

		$billtotal = $billreports->row_array()['NoOfBills'];

		$fieldreports = $this->db->query("SELECT COUNT(o.EntryID) AS NoOfFields FROM oversight_visits o LEFT JOIN committee_users u ON o.CommitteeID=u.CommitteeID WHERE o.ReportStatus IN ('Y','D') AND u.UserID='$userid' AND o.Status='ACTIVE' AND o.SessionID='$sessionID' ");

		$fieldtotal = $fieldreports->row_array()['NoOfFields'];

		$travelreports = $this->db->query("SELECT COUNT(b.EntryID) AS NoOfTravels FROM benchmarking_visits b LEFT JOIN committee_users u ON b.CommitteeID=u.CommitteeID WHERE b.ReportStatus IN ('Y','D') AND u.UserID='$userid' AND b.Status='ACTIVE' AND b.SessionID='$sessionID' ");

		$traveltotal = $travelreports->row_array()['NoOfTravels'];

		$grand = $billtotal + $fieldtotal + $traveltotal;

		return $grand;
	}
}

?>