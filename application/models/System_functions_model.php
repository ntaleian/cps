<?php

class System_functions_model extends CI_Model {
	
	#Constructor
	public function __construct()
	{
		parent::__construct();
	}

	function delete_row($ItemID, $TableName)
	{
		$delete = $this->db->query("UPDATE $TableName SET Status='INACTIVE' WHERE EntryID='$ItemID'");

		if($delete)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function check_access($commid)
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$get = $this->db->query("SELECT committees.* FROM committees LEFT JOIN committee_users ON committees.EntryID=committee_users.CommitteeID WHERE committee_users.UserID='$userid' AND committee_users.IsActive='Y' AND committee_users.CommitteeID='$commid'");

		if($get->num_rows() > 0)
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