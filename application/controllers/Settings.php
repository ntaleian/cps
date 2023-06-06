<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Settings_model','settings');

		$this->load->library('csvimport');
	}

	function allocation()
	{
		$committees = $this->settings->clerk_committees_list();

		// print_r($committees); exit;

		$data['committees'] = $committees;

		$data['prev'] = 'Settings';
		$data['curr'] = 'Committees';
		$data['page_title'] = 'Budget Allocation';

		$data['active'] = "alloc";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('settings/budget_alloc', $data);
		$this->load->view('incl/footer');
	}

	function add_money()
	{
		if($this->input->post('addamount'))
		{
			// print_r($_POST); exit;

			$add = $this->settings->add_money();

			if($add)
			{
				$this->session->set_flashdata('comm_flash', "The Committee Allocation Data Has Been Successfully Added.");
			}
			else
			{
				$this->session->set_flashdata('comm_flash', "The Committee Allocation Data Has Not Been Successfully Added.");
			}

			redirect(base_url()."settings/allocation");
		}

		$commid = $this->input->get('id');
		$realid = $commid;

		$alloc = $this->input->get('alloc');
		$data['alloc'] = $alloc;

		$data['committee'] = $this->settings->get_committee($realid);

		$data['prev'] = 'Settings';
		$data['curr'] = 'Committees';
		$data['page_title'] = 'Budget Allocation';

		$data['active'] = "alloc";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('settings/add_money', $data);
		$this->load->view('incl/footer');
		
	}

	function edit_money()
	{
		if($this->input->post('editamount'))
		{
			$edit = $this->settings->edit_money();

			if($add)
			{
				$this->session->set_flashdata('comm_flash', "The Committee Allocation Data Has Been Successfully Updated.");
			}
			else
			{
				$this->session->set_flashdata('comm_flash', "The Committee Allocation Data Has Not Been Successfully Updated.");
			}

			redirect(base_url()."settings/allocation");
		}

		$commid = $this->input->get('id');
		$realid = $commid;

		$alloc = $this->input->get('alloc');
		$data['alloc'] = $alloc;

		$data['committee'] = $this->settings->get_alloc_details($realid, $alloc);

		$data['prev'] = 'Settings';
		$data['curr'] = 'Committees';
		$data['page_title'] = 'Budget Allocation';

		$data['active'] = "alloc";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('settings/edit_money', $data);
		$this->load->view('incl/footer');
	}

	function add_committee()
	{
		if($this->input->post('submit'))
		{
			$addComm = $this->settings->add_committee();

			if($addComm)
			{
				$this->session->set_flashdata('succ_msg', "The Committee Has Been Successfully Inserted");
			}
			else
			{
				$this->session->set_flashdata('err_msg', "The Committee Has Not Been Successfully Inserted");
			}

			redirect(base_url()."settings/add_committee");
		}

		$data['prev'] = 'Settings';
		$data['curr'] = 'Committees';
		$data['page_title'] = 'Add Committee'; 

		$data['active'] = "add_committee";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('settings/add_committee');
		$this->load->view('incl/footer');
	}

	function committees_list()
	{
		$committees = $this->settings->committees_list();

		$data['committees'] = $committees;

		$data['prev'] = 'Settings';
		$data['curr'] = 'Committees';
		$data['page_title'] = 'Committees List';

		$data['active'] = "committees";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('settings/committees_list', $data);
		$this->load->view('incl/footer');
	}

	function assign_members()
	{

		$usertype = $this->session->userdata('alluserdata')[0]['Usertype'];

		if($usertype == "super" || $usertype == "overall")
		{
			$data['redirectUrl'] = "committees_list";

			$data['active'] = "committees";
		}
		else
		{
			$data['redirectUrl'] = "clerk_committees_list";

			$data['active'] = "c_committees";
		}

		$getid = $this->input->get('id');

		// $getid = $this->cencrypt->decode($getid);

		$gettype = $this->input->get('type');

		$data['id'] = $getid;

		$data['committee'] = $this->settings->get_committee($getid)['Title'];

		$mps = $this->settings->other_mps_list($getid, $gettype);

		$data['mps'] = $mps;

		$data['prev'] = 'Settings';
		$data['curr'] = 'Committees';
		$data['page_title'] = 'Assign Committee Members';

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('settings/assign_committee', $data);
		$this->load->view('incl/footer');
	}

	function clerk_committees_list()
	{
		$committees = $this->settings->clerk_committees_list();

		// print_r($committees); exit;

		$data['committees'] = $committees;

		$data['prev'] = 'Settings';
		$data['curr'] = 'Committees';
		$data['page_title'] = 'Committees List';

		$data['active'] = "c_committees";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('settings/committees_list', $data);
		$this->load->view('incl/footer');
	}

	function committee_members()
	{
		$getid = $this->input->get('id');

		// $getid = $this->cencrypt->decode($getid);

		$data['id'] = $getid;

		$sessionqry = $this->db->query("SELECT EntryID FROM sessions WHERE IsActive='Y'");

		$sessionid = $sessionqry->row_array()['EntryID'];

		$members = $this->settings->view_committee_members($getid, $sessionid);

		$data['committee'] = $this->settings->get_committee($getid)['Title'];
		$data['committeeid'] = $getid;

		$data['members'] = $members;

		$data['prev'] = 'Settings';
		$data['curr'] = 'Committees';
		$data['page_title'] = 'Committee Members for '.$data['committee'];

		$data['active'] = "committee_members";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('settings/individual_members', $data);
		$this->load->view('incl/footer');
	}

	function view_members()
	{
		$committees = $this->settings->view_committee();

		$data['committees'] = $committees;

		$data['prev'] = 'Settings';
		$data['curr'] = 'Committees';
		$data['page_title'] = 'View Committee Members';

		$data['active'] = "committee_members";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('settings/committee_members', $data);
		$this->load->view('incl/footer');
	}

	function clerk_view_members()
	{
		$committees = $this->settings->clerk_view_committee();

		$data['committees'] = $committees;

		$data['prev'] = 'Settings';
		$data['curr'] = 'Committees';
		$data['page_title'] = 'View Committee Members';

		$data['active'] = "c_committee_members";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('settings/committee_members', $data);
		$this->load->view('incl/footer');
	}

	function mps_list()
	{
		$mps = $this->settings->mps_list();

		$data['mps'] = $mps;

		$data['prev'] = 'Settings';
		$data['curr'] = 'MPs';
		$data['page_title'] = 'MPs List';

		$data['active'] = "mps";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('settings/mps_list', $data);
		$this->load->view('incl/footer');
	}

	function add_mps()
	{
		if($this->input->post('submit'))
		{
			$file_data = $this->csvimport->get_array($_FILES['MPFile']['tmp_name']);

			foreach($file_data as $row)
			{
				// print_r($row); exit;

				$mpdata = array(
					'Code' => $row['Code'],
					'Name' => $row['Name'],
					'Party' => $row['Party'],
					'Constituency' => $row['Constituency'],
					'District' => $row['District'],
					'SessionID' => $_POST['SessionID']
				);

				$this->settings->insert_mps($mpdata);

			}

			$this->session->set_flashdata('succ_msg', "MPs Batch Upload Has Been Completed");

			redirect(base_url()."settings/mps_list");

		}

		else

		{
			$data['sessions'] = $this->settings->view_sessions();

			$data['prev'] = 'Settings';
			$data['curr'] = 'MPs';
			$data['page_title'] = 'Add MPs';

			$data['active'] = "add_mps_file";

			$this->load->view('incl/head');
			$this->load->view('incl/header');
			$this->load->view('incl/sidebar', $data);
			$this->load->view('settings/add_mp_file', $data);
			$this->load->view('incl/footer');
		}

	}

	function add_single_mp()
	{
		if($this->input->post('submit'))
		{
			$this->settings->insert_mp();

			$this->session->set_flashdata('succ_msg', "MP Data Has Been Completed");

			redirect(base_url()."settings/mps_list");

		}

		else

		{

		$data['sessions'] = $this->settings->view_sessions();

			$data['prev'] = 'Settings';
			$data['curr'] = 'MPs';
			$data['page_title'] = 'Add Single MP';

			$data['active'] = "add_mps_single";

			$this->load->view('incl/head');
			$this->load->view('incl/header');
			$this->load->view('incl/sidebar', $data);
			$this->load->view('settings/add_single_mp', $data);
			$this->load->view('incl/footer');

		}
	}

	function add_session()
	{
		if($this->input->post('submit'))
		{
			// print_r($_POST); exit;

			$insertSession = $this->settings->insert_session($_POST);

			if($insertSession)
			{
				$this->session->set_flashdata('succ_msg', "The Session Data Has Been Successfully Added.");
			}
			else
			{
				$this->session->set_flashdata('err_msg', "The Session Data Has Not Been Added.");
			}

			redirect(base_url()."settings/sessions_list");
		}

		$data['prev'] = 'Settings';
		$data['curr'] = 'Sessions';
		$data['page_title'] = 'Add New Session';

		$data['active'] = "add_session";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('settings/add_session', $data);
		$this->load->view('incl/footer');
	}

	function sessions_list()
	{
		$sessions = $this->settings->view_sessions();

		$data['sessions'] = $sessions;

		$data['prev'] = 'Settings';
		$data['curr'] = 'Sessions';
		$data['page_title'] = 'Sessions List';

		$data['active'] = "sessions_list";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('settings/sessions_list', $data);
		$this->load->view('incl/footer');
	}

	function edit_session()
	{
		if($this->input->post('submit'))
		{
			// print_r($_POST); exit;

			$editSession = $this->settings->save_session($_POST);

			if($editSession)
			{
				$this->session->set_flashdata('succ_msg', "The Session Data Has Been Successfully Updated.");
			}
			else
			{
				$this->session->set_flashdata('err_msg', "The Session Data Has Not Been Updated.");
			}

			redirect(base_url()."settings/sessions_list");
		}

		$id = $_GET['id'];

		$data['sess'] = $this->settings->get_session($id);

		$data['prev'] = 'Settings';
		$data['curr'] = 'Sessions';
		$data['page_title'] = 'Add New Session';

		$data['active'] = "add_session";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('settings/edit_session', $data);
		$this->load->view('incl/footer');
	}

	function add_user()
	{

		if($this->input->post('submit'))
		{
			// print_r($_POST); exit;
			$addQry = $this->settings->add_user();

			if($addQry)
			{
				$this->session->set_flashdata('succ_msg', "The User Has Been Successfully Inserted");
			}
			else
			{
				$this->session->set_flashdata('err_msg', "The User Has Not Been Successfully Inserted");
			}
		}

		$data['prev'] = 'Settings';
		$data['curr'] = 'Add User';
		$data['page_title'] = 'Add New User'; 

		$data['active'] = "add_user";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('settings/add_user');
		$this->load->view('incl/footer');
	}

	function users_list()
	{
		$users = $this->settings->users_list();

		$data['users'] = $users;

		$data['prev'] = 'Settings';
		$data['curr'] = 'Users List';
		$data['page_title'] = 'Users List'; 

		$data['active'] = "users_list";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('settings/users_list', $data);
		$this->load->view('incl/footer');
	}

	function assign_user()
	{
		$getid = $this->input->get('id');

		// $getid = $this->cencrypt->decode($getid);

		$data['id'] = $getid;

		$committees = $this->settings->user_non_committees($getid);

		$data['username'] = $this->settings->get_username($getid)['Username'];

		$data['committees'] = $committees;

		$data['prev'] = 'Settings';
		$data['curr'] = 'Assign Committees to '.$data['username'];
		$data['page_title'] = 'Assign Committees to '.$data['username'];

		$data['active'] = "users_list";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('settings/assign_user', $data);
		$this->load->view('incl/footer');
	}

	function do_assign_user()
	{
		if($this->input->post('assign'))
		{
			// print_r($_POST); exit;

			$assign = $this->settings->assign_users($_POST);

			if($assign)
			{
				$this->session->set_flashdata('succ_msg', "The Committees Have Been Successfully Added.");
			}
			else
			{
				$this->session->set_flashdata('err_msg', "The Committees Have Not Been Successfully Added.");
			}

			redirect(base_url()."settings/users_list");
		}
	}

	function assign()
	{
		if($this->input->post('assign'))
		{
			// print_r($_POST); exit;
			$assign = $this->settings->assign($_POST);

			if($assign)
			{
				$this->session->set_flashdata('succ_msg', "The Members Have Been Successfully Added.");
			}
			else
			{
				$this->session->set_flashdata('err_msg', "The Members Have Not Been Successfully Added.");
			}

			redirect(base_url()."settings/committees_list");
		}
	}

	function api_assign()
	{
		$postData = $this->input->post();

		$response = $postData;

		$usertype = $this->session->userdata('alluserdata')[0]['Usertype'];

		if($usertype == "super" || $usertype == "overall")
		{
			$redirectUrl = "committees_list";
		}
		else
		{
			$redirectUrl = "clerk_committees_list";
		}

		$assign = $this->settings->assign($postData);

		if($assign)
		{
			$this->session->set_flashdata('succ_msg', "The Members Have Been Successfully Added.");
			$response = array("message" => "true", "redirectUrl" => $redirectUrl);
		}
		else
		{
			$this->session->set_flashdata('err_msg', "The Members Have Not Been Successfully Added.");
			$response = array("message" => "false", "redirectUrl" => $redirectUrl);
		}

		echo json_encode($response);
	}


	function user_profile()
	{

		if($this->input->post('update'))
		{
			$update = $this->settings->update_profile();

			if($update)
			{
				$this->session->set_flashdata('succ_msg', "The User Profile Information Has Been Successfully Updated.");
			}
			else
			{
				$this->session->set_flashdata('err_msg', "The User Profile Information Has Not Been Successfully Updated.");
			}

			redirect(base_url()."settings/user_profile");
		}

		$data['user'] = $this->settings->get_user_details();

		$data['prev'] = 'Settings';
		$data['curr'] = 'User Profile';
		$data['page_title'] = 'User Profile';

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('settings/profile', $data);
		$this->load->view('incl/footer');
	}

	function remove_individual_member()
	{
		$mpid = $this->input->get('id');
		$newmpid = $mpid;
		$committeeid = $this->input->get('comm');
		$newcommitteeid = $committeeid;

		$remove = $this->settings->remove_member($newmpid, $newcommitteeid);

		if($remove)
		{
			$this->session->set_flashdata('succ_msg', "The Committee Member Has Been Successfully Removed.");
		}
		else
		{
			$this->session->set_flashdata('err_msg', "The Committee Member Has Not Been Successfully Removed.");
		}

		redirect(base_url()."settings/committee_members?id=".$committeeid);

	}

	

}

?>