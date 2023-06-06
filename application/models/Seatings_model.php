<?php

class Seatings_model extends CI_Model {
	
	#Constructor
	public function __construct()
	{
		parent::__construct();
	}

	 public function do_connect(){
        $hostname = "localhost";
        $username = "root";
        $password = "root";
        $database = "cps";

        $conn = mysqli_connect($hostname, $username, $password, $database);

        if(mysqli_connect_errno()){
            echo "Failed to connect to MySQL: ".mysqli_connect_error();
        }

        $this->data['conn'] = $conn;
    }

	function get_committees()
	{
		$userid = $this->session->userdata('alluserdata')[0]['EntryID'];

		$usertype = $this->session->userdata('alluserdata')[0]['Usertype'];

		if($usertype == "super" || $usertype == "overall")
		{
			$get = $this->db->query("SELECT * FROM committees");
		}
		else
		{
			$get = $this->db->query("SELECT committees.* FROM committees LEFT JOIN committee_users ON committees.EntryID=committee_users.CommitteeID WHERE committee_users.UserID='$userid' AND committee_users.IsActive='Y'");
			
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

	function insert_attendance($attArray, $SittingDate, $CommitteeID, $SittingTitle, $SessionID)
	{
		//insert sitting
		// $insertSitting = $this->db->query("INSERT INTO sittings(CommitteeID, ClerkID, SittingTitle, SittingDate, TS) VALUES('$CommitteeID', '".$this->session->userdata('alluserdata')[0]['EntryID']."', '$SittingTitle', '$SittingDate', NOW() )");

		// $response = mysqli_real_escape_string($this->data['conn'], $SittingTitle);

		// $sitData = array(
		// 	"CommitteeID" => $CommitteeID,
		// 	"ClerkID" => $this->session->userdata('alluserdata')[0]['EntryID'],
		// 	"SittingTitle" => $this->db->escape($SittingTitle),
		// 	"SittingDate" => date('Y-m-d', strtotime($SittingDate)),
		// 	"SessionID" => $SessionID,
		// 	"TS" => date('Y-m-d H:i:s')
		// );

		// $insertSitting = $this->db->insert('sittings', $sitData);

		// echo $SittingDate; exit;
		// echo date('Y-m-d', strtotime(str_replace("/", "-", $SittingDate))); exit;

		$insertSitting = $this->db->query("INSERT INTO sittings(CommitteeID, ClerkID, SittingTitle, SittingDate, SessionID, TS) VALUES ('$CommitteeID', '".$this->session->userdata('alluserdata')[0]['EntryID']."', ".$this->db->escape($SittingTitle).", '".date('Y-m-d', strtotime(str_replace("/", "-", $SittingDate)))."', '$SessionID', '".date('Y-m-d H:i:s')."')");

		$sitID = $this->db->insert_id();

		foreach($attArray as $key)
		{
			// echo $key[1]; exit;
			$insert = $this->db->query("INSERT INTO attendance (CommitteeID, MpID, SittingID, SessionID, AttendanceStatus, ApologyCategory, ApologyDetails) VALUES ('$CommitteeID', '".$key['mps']."', '$sitID', '$SessionID', '".$key['attendance']."', '".$key['apology']."', '".$key['attendancetext']."')");

		}

		return true;
	}

	function insert_sitting($attdata, $sitID)
	{
		$SessionID = $_POST['SessionID'];
		$CommitteeID = $_POST['CommitteeID'];

		if(!empty($attdata['Code']))
		{
				#check for mp using code
				$mpid = $this->db->query("SELECT * FROM mps WHERE Code='".$attdata['Code']."' AND SessionID='$SessionID'")->row_array()['EntryID'];

				#check for committee
				$check = $this->db->query("SELECT * FROM committee_members WHERE CommitteeID='$CommitteeID' AND MpID='".$mpid."' AND SessionID='$SessionID'");

				if($check->num_rows() > 0)
				{
					$status = "";

					if(strtolower($attdata['Status']) == 'p')
					{
						$status = "present";
					}
					else if(strtolower($attdata['Status']) == 'a')
					{
						$status = "absent";
					}
					else if(strtolower($attdata['Status']) == 'awa')
					{
						$status = "awo";
					}

					$insert = $this->db->query("INSERT INTO attendance (CommitteeID, MpID, SittingID, SessionID, AttendanceStatus) VALUES ('$CommitteeID', '".$mpid."', '$sitID', '$SessionID', '".$status."')");
				}
		}

		return true;
	}
}

?>