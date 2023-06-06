<?php

class Bills_model extends CI_Model {
	
	#Constructor
	public function __construct()
	{
		parent::__construct();
	}

	function get_processed_bills()
	{

		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$usertype = $this->session->userdata('alluserdata')[0]['Usertype'];

		$sessionID = $this->session->userdata('alluserdata')[0]['SessionID'];

		if($usertype == "super" || $usertype == "overall")
		{

			$get = $this->db->query("SELECT b.*, c.Title, CONCAT(u.Firstname, ' ', u.Lastname) AS Fullname FROM bills b LEFT JOIN committees c ON b.CommitteeID=c.EntryID LEFT JOIN committee_users cu ON c.EntryID=cu.CommitteeID LEFT JOIN users u ON b.EditedBy=u.EntryID WHERE b.SessionID='$sessionID' AND b.Status='ACTIVE'");
		}
		else
		{

		$get = $this->db->query("SELECT b.*, c.Title, CONCAT(u.Firstname, ' ', u.Lastname) AS Fullname FROM bills b LEFT JOIN committees c ON b.CommitteeID=c.EntryID LEFT JOIN committee_users cu ON c.EntryID=cu.CommitteeID LEFT JOIN users u ON b.EditedBy=u.EntryID WHERE cu.UserID='$userid' AND b.Status='ACTIVE'");
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


	function add_bill()
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		// $insertArray = array(
		// 					'CommitteeID' => $_POST['CommitteeID'],
		// 					'BillName' => $_POST['BillName'],
		// 					'BillStatus' => $_POST['BillStatus'],
		// 					'DateProcessed' => $_POST['DateProcessed'],
		// 					'EditedBy' => $userid,
		// 					'TS' => date('Y-m-d H:i:s')
		// );

		// $insertBill = $this->db->insert('bills', $insertArray);

		$insertBill = $this->db->query("INSERT INTO bills (CommitteeID, SessionID, BillName, BillStatus, BillType, Comments, DateProcessed, EditedBy, TS) VALUES ('".$_POST['CommitteeID']."', '".$_POST['SessionID']."', ".$this->db->escape($_POST['BillName']).", '".$_POST['BillStatus']."', '".$_POST['BillType']."', ".$this->db->escape($_POST['Comments']).", '".date('Y-m-d', strtotime($_POST['DateProcessed_submit']))."', '$userid', '".date('Y-m-d H:i:s')."')");

		if($insertBill)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function update_bill()
	{
		$update = $this->db->query("UPDATE bills SET BillStatus='".$_POST['BillStatus']."' WHERE EntryID='".$_POST['EntryID']."'");

		if($update)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

}

?>