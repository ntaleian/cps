<?php

class Benchmarking_model extends CI_Model {
	
	#Constructor
	public function __construct()
	{
		parent::__construct();
	}

	function add_benchmark($formdata, $to, $fro)
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$benchArray = array(
			'VisitTitle' => $formdata['VisitTitle'],
			'CommitteeID' => $formdata['CommitteeID'],
			'SessionID' => $formdata['SessionID'],
			'FromDate' => $fro,
			'ToDate' => $to,
			'Amount' => $formdata['VisitAmount'],
			'ReportStatus' => $formdata['ReportStatus'],
			'EditedBy' => $userid,
			'TS' => date('Y-m-d H:i:s')
		);

		$insertArray = $this->db->insert('benchmarking_visits', $benchArray);

		$benchID = $this->db->insert_id();

		if(!empty($formdata['mps_id']))
		{
			$mps = $formdata['mps_id'];

			foreach($mps as $mp)
			{
				$insert = $this->db->query("INSERT INTO benchmarking_members (BenchmarkID, MpID, EditedBy, TS) VALUES ('".$benchID."', '".$mp."', '".$userid."', '".date('Y-m-d H:i:s')."')");
			}

		}

		
		return true;
	}

}

?>