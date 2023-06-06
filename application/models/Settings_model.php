<?php

class Settings_model extends CI_Model {
	
	#Constructor
	public function __construct()
	{
		parent::__construct();
	}

	function add_user()
	{
		$userData = array(
			"Username" => $this->input->post('Username'),
			"Email" => $this->input->post('Email'),
			"Password" => strtoupper(md5($this->input->post('Password'))),
			"Firstname" => $this->input->post('Firstname'),
			"Lastname" => $this->input->post('Lastname'),
			"Usertype" => $this->input->post('Usertype')
		);

		$insertQry = $this->db->insert('users', $userData);

		if($insertQry)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function users_list()
	{
		$get = $this->db->query("SELECT * FROM users WHERE Status='ACTIVE'");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function add_committee()
	{
		$commData = array(
			"Title" => $this->input->post('Title'),
			"Category" => $this->input->post('Category')
		);

		$insertQry = $this->db->insert('committees', $commData);

		if($insertQry)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function committees_list()
	{
		$get = $this->db->query("SELECT * FROM committees");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function clerk_committees_list()
	{
		$sessid = $this->session->userdata('alluserdata')[0]['SessionID'];

		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$usertype = $this->session->userdata('alluserdata')[0]['Usertype'];

		if($usertype == "overall")
		{
			$get = $this->db->query("SELECT c.*, (SELECT Amount FROM budget_alloc b WHERE b.CommitteeID=c.EntryID AND b.SessionID='$sessid' AND b.AllocType='FT') as FT, (SELECT Amount FROM budget_alloc b WHERE b.CommitteeID=c.EntryID AND b.SessionID='$sessid' AND b.AllocType='TA') as TA FROM committees c");
		}
		else
		{
			$get = $this->db->query("SELECT c.*, (SELECT Amount FROM budget_alloc b WHERE b.CommitteeID=c.EntryID AND b.SessionID='$sessid' AND b.AllocType='FT') as FT, (SELECT Amount FROM budget_alloc b WHERE b.CommitteeID=c.EntryID AND b.SessionID='$sessid' AND b.AllocType='TA') as TA FROM committees c LEFT JOIN committee_users u ON c.EntryID=u.CommitteeID WHERE u.UserID='$userid' AND u.IsActive='Y'");
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

	function add_money()
	{
		$sessid = $this->session->userdata('alluserdata')[0]['SessionID'];

		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$insert = $this->db->query("INSERT INTO budget_alloc (CommitteeID, SessionID, AllocType, Amount, AddedBy, DateAdded) VALUES ('".$_POST['CommitteeID']."', '$sessid', '".$_POST['AllocType']."', '".$_POST['Amount']."', '$userid', NOW())");

		if($insert)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function edit_money()
	{
		$update = $this->db->query("UPDATE budget_alloc SET Amount='".$_POST['Amount']."' WHERE EntryID='".$_POST['AllocID']."'");

		if($update)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function mps_list()
	{
		$sessid = $this->session->userdata('alluserdata')[0]['SessionID'];

		$get = $this->db->query("SELECT mps.*, (SELECT SessionName FROM sessions WHERE EntryID='$sessid') AS SessionName FROM mps WHERE mps.Status='ACTIVE' AND mps.SessionID='".get_current_session($this)."'");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function get_committee($id)
	{
		$get = $this->db->query("SELECT EntryID, Title FROM committees WHERE EntryID='$id'");

		if($get->num_rows() > 0)
		{
			return $get->row_array();
		}
		else
		{
			return false;
		}
	}

	function get_alloc_details($id, $AllocType)
	{
		$get = $this->db->query("SELECT b.*, c.EntryID AS CommID, c.Title FROM budget_alloc b LEFT JOIN committees c ON b.CommitteeID=c.EntryID WHERE b.CommitteeID='$id' AND b.SessionID='".get_current_session($this)."' AND b.AllocType='$AllocType'");

		if($get->num_rows() > 0)
		{
			return $get->row_array();
		}
		else
		{
			return false;
		}
	}

	function other_mps_list($id, $type)
	{
		$SessionID = $this->session->userdata('alluserdata')[0]['SessionID'];

		if($type == "standing")
		{
			$get = $this->db->query("SELECT * FROM mps WHERE mps.EntryID NOT IN (SELECT MpID FROM committee_members WHERE CommitteeID='$id' AND SessionID='".get_current_session($this)."' AND IsActive='Y') AND mps.EntryID NOT IN (SELECT m.MpID FROM committee_members m LEFT JOIN committees c ON m.CommitteeID=c.EntryID WHERE m.CommitteeID=c.EntryID AND c.Category='Standing Committee' AND m.SessionID='".get_current_session($this)."' AND m.IsActive='Y') AND SessionID='".get_current_session($this)."'");
		}
		else if($type == "sectoral")
		{
			$get = $this->db->query("SELECT * FROM mps WHERE mps.EntryID NOT IN (SELECT MpID FROM committee_members WHERE CommitteeID='$id' AND SessionID='".get_current_session($this)."' AND IsActive='Y') AND mps.EntryID NOT IN (SELECT m.MpID FROM committee_members m LEFT JOIN committees c ON m.CommitteeID=c.EntryID WHERE m.CommitteeID=c.EntryID AND c.Category='Sectoral Committee' AND m.SessionID='".get_current_session($this)."' AND m.IsActive='Y') AND SessionID='".get_current_session($this)."' ");
		}
		else if($type == "select")
		{
			$get = $this->db->query("SELECT * FROM mps WHERE mps.EntryID NOT IN (SELECT MpID FROM committee_members WHERE CommitteeID='$id' AND SessionID='".get_current_session($this)."' AND IsActive='Y') AND mps.EntryID NOT IN (SELECT m.MpID FROM committee_members m LEFT JOIN committees c ON m.CommitteeID=c.EntryID WHERE m.CommitteeID=c.EntryID AND c.Category='Select Committee' AND m.SessionID='".get_current_session($this)."' AND m.IsActive='Y') AND SessionID='".get_current_session($this)."'");
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

	function assign($postdata)
	{
		$sessionid = $this->session->userdata('alluserdata')[0]['SessionID'];
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$mps = $postdata['mps_id'];
		$CommitteeID = $postdata['CommitteeID'];

		foreach($mps as $mp)
		{
			// print_r($mp); exit;

			$query = $this->db->query("INSERT INTO committee_members (CommitteeID, MpID, SessionID, IsActive) VALUES ('".$CommitteeID."', '".$mp."', '$sessionid', 'Y')");

			#insert into history
			$ins = $this->db->query("INSERT INTO committee_history (MpID, CommitteeID, SessionID, Direction, EditedBy, TS) VALUES ('".$mp."', '".$CommitteeID."', '$sessionid', '1', '$userid', NOW() ) ");

		}

		return true;
	}

	function view_committee()
	{
		$get = $this->db->query("SELECT a.*, (SELECT COUNT(committee_members.CommitteeID) FROM committee_members WHERE committee_members.CommitteeID=a.EntryID AND committee_members.SessionID='".get_current_session($this)."' AND committee_members.IsActive='Y') NoOfMembers FROM committees a");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function clerk_view_committee()
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$sessid = $this->session->userdata('alluserdata')[0]['SessionID'];

		$get = $this->db->query("SELECT a.*, (SELECT COUNT(committee_members.CommitteeID) FROM committee_members WHERE committee_members.CommitteeID=a.EntryID AND committee_members.SessionID='$sessid' AND committee_members.IsActive='Y') NoOfMembers FROM committees a LEFT JOIN committee_users u ON a.EntryID=u.CommitteeID WHERE u.UserID='$userid' AND u.IsActive='Y'");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function view_committee_members($id, $sessionid)
	{
		$get = $this->db->query("SELECT mps.* FROM mps LEFT JOIN committee_members ON mps.EntryID=committee_members.MpID WHERE committee_members.CommitteeID='$id' AND committee_members.SessionID='$sessionid' AND committee_members.IsActive='Y'");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function view_ft_mps($id)
	{
		$get = $this->db->query("SELECT * FROM oversight_members WHERE OversightID='$id'");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function view_ta_mps($id)
	{
		$get = $this->db->query("SELECT * FROM benchmarking_members WHERE BenchmarkID='$id'");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function get_username($id)
	{
		$get = $this->db->query("SELECT * FROM users WHERE EntryID='$id'");

		if($get->num_rows() > 0)
		{
			return $get->row_array();
		}
		else
		{
			return false;
		}
	}

	function user_non_committees($id)
	{
		$get = $this->db->query("SELECT * FROM committees");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function assign_users($formdata)
	{
		$committees = $formdata['committees_id'];

		$CommitteeID = $formdata['CommitteeID'];

		//delete previous permissions
		
		$deleteQry = $this->db->query("UPDATE committee_users SET IsActive='N', DateEnded=NOW() WHERE UserID='$CommitteeID' AND IsActive='Y'");

		foreach($committees as $committee)
		{
			// print_r($mp); exit;

			$query = $this->db->query("INSERT INTO committee_users (UserID, CommitteeID, IsActive, DateAssigned) VALUES ('".$CommitteeID."', '".$committee."', 'Y', NOW())");

		}

		return true;
	}

	function remove_member($mpid, $committeeid)
	{
		$sessid = $this->session->userdata('alluserdata')[0]['SessionID'];
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$delete = $this->db->query("UPDATE committee_members SET IsActive='N' WHERE MpID='$mpid' AND CommitteeID='$committeeid' AND SessionID='$sessid'");

		#insert into history
		$ins = $this->db->query("INSERT INTO committee_history (MpID, CommitteeID, SessionID, Direction, EditedBy, TS) VALUES ('$mpid', '$committeeid', '$sessid', '2', '$userid', NOW() ) ");

		if($delete)
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	function view_sessions()
	{
		$get = $this->db->query("SELECT * FROM sessions");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function insert_session($formdata)
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		if(!empty($formdata['SessionEnd']))
		{
			$EndDate = date('Y-m-d', strtotime($formdata['SessionEnd_submit']));
		}
		else
		{
			$EndDate = NULL;
		}

		$act = $formdata['IsActive'];

		if($act == 'Y')
		{
			#check if there is active session
			$getAct = $this->db->query("SELECT * FROM sessions WHERE IsActive='Y'");
			if($getAct->num_rows() > 0){
				$actRes = $getAct->row_array()['EntryID'];
				$upd = $this->db->query("UPDATE sessions SET IsActive='N' WHERE EntryID='$actRes' ");
			}
		}

		$insertArray = array(
			'SessionName' => $formdata['SessionName'],
			'StartDate' => date('Y-m-d', strtotime($formdata['SessionStart_submit'])),
			'EndDate' => $EndDate,
			'IsActive' => $formdata['IsActive'],
			'UpdatedBy' => $userid
		);

		// echo "<pre>"; print_r($insertArray); echo "</pre>"; exit;

		$insertQry = $this->db->insert('sessions', $insertArray);

		if($insertQry)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function save_session($formdata)
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		//first update isactive
		if($formdata['IsActive'] == 'Y')
		{
			$updateActive = $this->db->query("UPDATE sessions SET IsActive='N', UpdatedBy='$userid' WHERE IsActive='Y'");
		}

		if(!empty($formdata['SessionStart']))
		{
			$StartDate = date('Y-m-d', strtotime($formdata['SessionStart_submit']));
		}
		else
		{
			$StartDate = NULL;
		}

		if(!empty($formdata['SessionEnd']))
		{
			$EndDate = date('Y-m-d', strtotime($formdata['SessionEnd_submit']));
		}
		else
		{
			$EndDate = NULL;
		}

		$update = $this->db->query("UPDATE sessions SET SessionName=".$this->db->escape($formdata['SessionName']).", StartDate='$StartDate', EndDate='$EndDate', IsActive='".$formdata['IsActive']."', UpdatedBy='$userid' WHERE EntryID='".$formdata['SessionID']."'");

		if($update)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function get_session($id)
	{
		$get = $this->db->query("SELECT * FROM sessions WHERE EntryID='$id'");

		return $get->row();
	}

	function update_session($formdata)
	{
		
	}

	function insert_mps($mpsdata)
	{
		// print_r($mpsdata); exit;

		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		if(!empty($mpsdata['Name']))
		{
			$query = $this->db->query("INSERT INTO mps(Code, Name, Party, Constituency, District, SessionID, Status, UpdatedBy) VALUES (".$this->db->escape($mpsdata['Code']).", ".$this->db->escape($mpsdata['Name']).", ".$this->db->escape($mpsdata['Party']).", ".$this->db->escape($mpsdata['Constituency']).", ".$this->db->escape($mpsdata['District']).", '".$mpsdata['SessionID']."', 'ACTIVE', '$userid')");

			if($query)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}

	function insert_mp()
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$insert = $this->db->query("INSERT INTO mps(Code, Name, Party, Constituency, District, SessionID, Status, UpdatedBy) VALUES (".$this->db->escape($_POST['Code']).", ".$this->db->escape($_POST['Name']).", ".$this->db->escape($_POST['Party']).", ".$this->db->escape($_POST['Constituency']).", ".$this->db->escape($_POST['District']).", '".$_POST['SessionID']."', 'ACTIVE', '$userid')");

		if($insert)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function get_user_details()
	{
		$uid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$get = $this->db->query("SELECT * FROM users WHERE EntryID='$uid'");

		return $get->row_array();
	}

	function get_user_logs($uid)
	{
		$get = $this->db->query("SELECT CONCAT(u.Firstname,' ',u.Lastname) AS UserNames, l.* FROM user_logs l LEFT JOIN users u ON l.UserID=u.EntryID WHERE l.UserID='$uid'");

		if($get->num_rows() > 0)
		{
			return $get->result_array();
		}
		else
		{
			return false;
		}
	}

	function get_session_details($sessionid)
	{
		$get = $this->db->query("SELECT * FROM sessions WHERE EntryID='$sessionid'");

		if($get->num_rows() > 0)
		{
			return $get->row_array();
		}
		else
		{
			return false;
		}
	}

	function update_profile()
	{
		$pwd_qry = "";

		if(!empty($_POST['Password']))
		{
			$pwd = strtoupper(md5($this->input->post('Password')));
			$newpwd = $_POST['NewPassword']; $newpwd2 = $_POST['NewPassword2'];
			$getPwd = $this->db->query("SELECT * FROM users WHERE EntryID='".$_POST['uid']."'")->row_array()['Password'];
			if($pwd == $getPwd)
			{
				if($newpwd == $newpwd2)
				{
					$pwd_qry = ", Password='".strtoupper(md5($newpwd))."'";
				}
			}
		}

		$update = $this->db->query("UPDATE users SET Firstname=".$this->db->escape($_POST['Firstname']).", Lastname=".$this->db->escape($_POST['Lastname']).", Email=".$this->db->escape($_POST['Email'])." ".$pwd_qry." WHERE EntryID='".$_POST['uid']."'");

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