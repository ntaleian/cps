<?php

class Oversight_model extends CI_Model {
	
	#Constructor
	public function __construct()
	{
		parent::__construct();
	}

	function get_oversight_visits()
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$get = $this->db->query("SELECT om.*, m.Name, c.Title, CONCAT(u.Firstname, ' ', u.Lastname) AS Fullname FROM oversight_visits o LEFT JOIN oversight_members om ON o.EntryID=om.OversightID LEFT JOIN mps m ON om.MpID=m.EntryID LEFT JOIN committees c ON o.CommitteeID=c.EntryID LEFT JOIN committee_users cu ON c.EntryID=cu.CommitteeID LEFT JOIN users u ON o.EditedBy=u.EntryID WHERE cu.UserID='$userid'");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}

		else

		{
			return false;
		}
	}

	function add_oversight($formdata, $to, $fro)
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$ovArray = array(
			'VisitTitle' => $formdata['VisitTitle'],
			'SessionID' => $formdata['SessionID'],
			'CommitteeID' => $formdata['CommitteeID'],
			'FromDate' => $fro,
			'ToDate' => $to,
			'Amount' => $formdata['VisitAmount'],
			'ReportStatus' => $formdata['ReportStatus'],
			'EditedBy' => $userid,
			'TS' => date('Y-m-d H:i:s')
		);

		$insertOv = $this->db->insert('oversight_visits', $ovArray);

		$ovID = $this->db->insert_id();

		if(!empty($formdata['mps_id']))
		{
			$mps = $formdata['mps_id'];

			foreach($mps as $mp)
			{
				$insert = $this->db->query("INSERT INTO oversight_members (OversightID, MpID, EditedBy, TS) VALUES ('".$ovID."', '".$mp."', '".$userid."', '".date('Y-m-d H:i:s')."')");
			}
		}		

		return true;
	}

	function update_oversight($formdata)
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$mps = $formdata['mps_id'];

		if(!empty($mps))
		{
			#remove mps from field trip
			$del = $this->db->query("DELETE FROM oversight_members WHERE OversightID='".$formdata['EntryID']."'");

			foreach($mps as $mp)
			{
				$insert = $this->db->query("INSERT INTO oversight_members (OversightID, MpID, EditedBy, TS) VALUES ('".$formdata['EntryID']."', '".$mp."', '".$userid."', '".date('Y-m-d H:i:s')."')");
			}
		}
		else
		{
			return false;
		}

		return true;
	}

	function update_benchmarking($formdata)
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$mps = $formdata['mps_id'];

		if(!empty($mps))
		{
			#remove mps from field trip
			$del = $this->db->query("DELETE FROM benchmarking_members WHERE BenchmarkID='".$formdata['EntryID']."'");

			foreach($mps as $mp)
			{
				$insert = $this->db->query("INSERT INTO benchmarking_members (BenchmarkID, MpID, EditedBy, TS) VALUES ('".$formdata['EntryID']."', '".$mp."', '".$userid."', '".date('Y-m-d H:i:s')."')");
			}
		}
		else
		{
			return false;
		}

		return true;
	}

}

?>