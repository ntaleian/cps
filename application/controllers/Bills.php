<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bills extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Seatings_model','seatings');
		$this->load->model('Bills_model','bills');
		$this->load->model('Settings_model','settings');
	}

	function index()
	{
		$data['sessions'] = $this->settings->view_sessions();

		$data['committees'] = $this->seatings->get_committees();

		$data['bills'] = $this->bills->get_processed_bills();

		$data['prev'] = "Committee Business";
		$data['curr'] = "Manage Bills";

		$data['active'] = "bills";

		$this->load->view('incl/head');
		$this->load->view('incl/header');
		$this->load->view('incl/sidebar', $data);
		$this->load->view('bills/bills', $data);
		$this->load->view('incl/footer');
	}

	function add_bill()
	{
		if($this->input->post('savebill'))
		{
			// print_r($_POST); exit;

			$addBill = $this->bills->add_bill();

			if($addBill)
			{
				$this->session->set_flashdata('succ_msg', "The Processed Bill Has Been Added.");
			}
			else
			{
				$this->session->set_flashdata('err_msg', "The Processed Bill Has Not Been Added.");
			}

			redirect(base_url()."bills");
		}
		else if($this->input->post('updatebill'))
		{
			$updateBill = $this->bills->update_bill();

			if($updateBill)
			{
				$this->session->set_flashdata('succ_msg', "The Processed Bill Has Been Updated.");
			}
			else
			{
				$this->session->set_flashdata('err_msg', "The Processed Bill Has Not Been Updated.");
			}

			redirect(base_url()."bills");
		}
	}

}

?>