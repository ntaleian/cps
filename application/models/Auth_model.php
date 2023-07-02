<?php

class Auth_model extends CI_Model {
	
	#Constructor
	public function __construct()
	{
		parent::__construct();
	}

	function login()
	{
		$username = $this->input->post('Username');
		$password = strtoupper(md5($this->input->post('Password')));

		$auth = $this->db->query("SELECT u.*, (SELECT EntryID FROM sessions WHERE IsActive='Y') AS SessionID, (SELECT SessionName FROM sessions WHERE IsActive='Y') AS SessionName FROM users u WHERE u.Username='$username' AND u.Password='$password'");

		if($auth->num_rows() > 0)
		{
			return $auth->result_array();
		}
		else
		{
			return false;
		}
	}

	function get_user_details($email)
	{
		$get = $this->db->query("SELECT * FROM users WHERE Email=".$this->db->escape($email)." AND Status='ACTIVE' ");

		if($get->num_rows() > 0)
		{
			return $get->row_array();
		}
		else
		{
			return false;
		}
	}

	function insert_mfa_otp($uid, $uemail, $code, $start, $end)
	{
		$cdate = date('Y-m-d H:i:s');

		$insert = $this->db->query("INSERT INTO mfa_otp(userid, email, code, alloc, expiry, ip_address, date_created) VALUES('$uid', '$uemail', '$code', '$start', '$end', '".$_SERVER['REMOTE_ADDR']."', '$cdate')");

		if($insert)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function validate_code()
	{
		// echo "<pre>"; print_r($_POST); echo "</pre>"; exit;

		$uemail = $_POST['Email'];
		$code = $this->input->post('otp_code');
		$code = trim($code);

		$pwd = $_POST['pwd1']; $cpwd = $_POST['pwd2'];

		if($pwd == $cpwd)
		{

			$user_query = $this->db->query("SELECT * FROM users WHERE Email=".$this->db->escape($uemail)." AND Status='ACTIVE' ");
			if($user_query->num_rows() > 0)
			{
				$user = $user_query->row_array();

				$checkQuery = $this->db->query("SELECT * FROM mfa_otp WHERE code='".$code."' AND userid='".$user['EntryID']."'");

				if($checkQuery->num_rows() > 0){

			    	$res = $checkQuery->row_array();

			    	$start = $res['alloc'];
			    	$end = $res['expiry'];

			    	$ck = date('H:i:s',time());

			    	if($ck >= $start && $ck <= $end){
			        	// return $res;
			        	// update password

			    		$pwd = md5($pwd);
		        		$reset = $this->db->query("UPDATE users SET Password=".$this->db->escape($pwd)." WHERE EntryID='".$user['EntryID']."' AND Status='ACTIVE' ");

		        		return true;

			    	}
			    	else
			    	{
			        	return false;

			    	}
				}
				else
				{
			    	return false;
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
		
	}

}

?>