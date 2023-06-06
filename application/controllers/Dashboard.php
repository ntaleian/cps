<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	#Constructor
	public function __construct()
	{
		parent::__construct();

		$this->load->model('Dashboard_model','dashboard');
	}

	public function index()
	{
		$usertype = $this->session->userdata('alluserdata')[0]['Usertype'];

		if($usertype == "super" || $usertype == "overall")
		{
			$data['super_reports'] = $this->dashboard->get_sittings_count();
			$data['sittings'] = $this->dashboard->get_total_sittings()['TotalSittings'];
			$data['users'] = $this->dashboard->get_system_users()['SystemUsers'];
			$data['fieldtrips'] = $this->dashboard->get_total_fieldtrips()['TotalFieldtrips'];
			$data['travels'] = $this->dashboard->get_total_travels()['TotalTravels'];
			$data['sittingsPeriod'] = $this->dashboard->get_sittings_per_period();

			$data['other'] = $this->dashboard->other_stats();
		}
		else
		{
			$data['sittings'] = $this->dashboard->get_total_sittings()['TotalSittings'];
			// $data['bills'] = $this->dashboard->get_total_bills()['TotalBills'];
			$data['fieldtrips'] = $this->dashboard->get_total_fieldtrips()['TotalFieldtrips'];
			$data['travels'] = $this->dashboard->get_total_travels()['TotalTravels'];

			$data['reports'] = $this->dashboard->get_sittings_count();

			$data['other'] = $this->dashboard->get_other_activities();

			$data['other_stats'] = $this->dashboard->other_stats_normal();

			$data['total_reports'] = $this->dashboard->total_reports();

		}

		$data['active'] = "dash";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('home', $data);
		$this->load->view('incl/footer');
	}

	

}

?>