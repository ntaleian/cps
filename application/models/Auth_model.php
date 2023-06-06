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

}

?>