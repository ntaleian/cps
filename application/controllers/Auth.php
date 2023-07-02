<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	#Constructor
	public function __construct()
	{
		parent::__construct();

		$this->load->model('Auth_model','auth');
	}

	public function index()
	{
		
	}

	function login()
	{
		if($this->input->post('login'))
		{
			$loginQry = $this->auth->login();

			if(!$loginQry)
			{
				redirect(base_url()."auth/login");

			}
			else
			{
				$this->session->set_userdata('alluserdata', $loginQry);
				$this->session->set_userdata('isUserLoggedIn', 'Y');

				$trail_array = array(
									'action' => "Login",
									'description' => "Login User",
									'userid' => $this->session->userdata('alluserdata')[0]['EntryID'],
									'ipaddress' => $_SERVER['REMOTE_ADDR']
								);

				// $insertTrail = log_trail($this, $trail_array);

				redirect(base_url()."dashboard");
			}
		}

		$this->load->view('auth/login');
	}

	function logout(){

					$trail_array = array(
									'action' => "Logout",
									'description' => "Logout User",
									'userid' => $this->session->userdata('alluserdata')[0]['EntryID'],
									'ipaddress' => $_SERVER['REMOTE_ADDR']
								);

				// $insertTrail = log_trail($this, $trail_array);

        $this->session->unset_userdata('isUserLoggedIn');
        $this->session->unset_userdata('alluserdata');
        $this->session->sess_destroy();
        redirect(base_url()."auth/login");
    }

    function forgot()
    {
    	if($this->input->post('forgot_pwd'))
		{
			$udata = $this->auth->get_user_details($_POST['forgot_email']);

			if(!empty($udata['Email']))
			{
				#send email

				#first generate code
				$characters = '0123456789';
				$charactersLength = strlen($characters);
				$randomString = '';
				for ($i = 0; $i < 6; $i++)
				{
					$randomString .= $characters[rand(0, $charactersLength - 1)];
				}

				//expiry time considering 3 minutes window
				$ck=date('H:i:s',time());
				$endtime = date('H:i:s', strtotime("+05 minutes", strtotime($ck)));

				$insertReset = $this->auth->insert_mfa_otp($udata['EntryID'], $udata['Email'], $randomString, $ck, $endtime);

				//send email to registered email address
				$this->load->library("PhpMailerLib");
		        $mail = $this->phpmailerlib->load();
				try {
				    //Server settings
				    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
				    $mail->isSMTP();                                      // Set mailer to use SMTP
				    $mail->Host = 'smtp.hostinger.com';  // Specify main and backup SMTP servers
				    $mail->SMTPAuth = true;                               // Enable SMTP authentication
				    $mail->Username = 'cps@certapps.net';                 // SMTP username
				    $mail->Password = 'Pca2017#';                           // SMTP password
				    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
				    $mail->Port = 465;                                    // TCP port to connect to
				    //Recipients
				    $mail->setFrom('cps@certapps.net', 'OTP from CPS');

				    $mail->addAddress($udata['Email']); 
				    // $mail->addAddress('ntaleian@gmail.com');
				    
				    //Content 
				    $mail->isHTML(true);                                  // Set email format to HTML
				    $mail->Subject = 'CPS One Time Password for '.$udata['Firstname'].' '.$udata['Lastname'];


				    $mail->Body = "<div style='font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2'>
					  <div style='margin:50px auto;width:70%;padding:20px 0'>
					    <div style='border-bottom:1px solid #eee'>
					      <a href='' style='font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600'>Committee Performance System</a>
					    </div>
					    <p style='font-size:1.1em'>Hi ".$udata['Firstname'].' '.$udata['Lastname'].",</p>
					    <p>Use the following OTP to complete your login. This OTP is valid before <b>".$endtime."</b></p>
					    <h2 style='background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;'>".$randomString."</h2>
					    <p style='font-size:0.9em;'>Regards,<br />Committee Performance System</p>
					    <hr style='border:none;border-top:1px solid #eee' />
					    <div style='float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300'>
					      <p>Committee Performance System</p>
					      <p>---</p>
					      <p>Kampala</p>
					    </div>
					  </div>
					</div>";

				    $mail->AltBody = "<div style='font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2'>
					  <div style='margin:50px auto;width:70%;padding:20px 0'>
					    <div style='border-bottom:1px solid #eee'>
					      <a href='' style='font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600'>Committee Performance System</a>
					    </div>
					    <p style='font-size:1.1em'>Hi ".$udata['Firstname'].' '.$udata['Lastname'].",</p>
					    <p>Use the following OTP to complete your login. This OTP is valid before <b>".$endtime."</b></p>
					    <h2 style='background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;'>".$randomString."</h2>
					    <p style='font-size:0.9em;'>Regards,<br />Committee Performance System</p>
					    <hr style='border:none;border-top:1px solid #eee' />
					    <div style='float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300'>
					      <p>Committee Performance System</p>
					      <p>---</p>
					      <p>Kampala</p>
					    </div>
					  </div>
					</div>";

				    ob_start();
				    $mail->send();
				    ob_end_clean();
				    // echo 'Message has been sent';



				} catch (Exception $e) {
					ob_start();
				    echo 'Message could not be sent.';
				    echo 'Mailer Error: ' . $mail->ErrorInfo;
				    // ob_end_clean();
				}

			}

			$this->session->set_flashdata('succ_msg', "If your email address is valid, please check to receive your OTP and proceed.");
			redirect(base_url()."auth/reset?id=".$udata['Email']);
		}

    	$this->load->view('auth/forgot');
    }

    function reset()
    {
    	if($_POST['reset_btn'])
    	{
    		$validate = $this->auth->validate_code();

    		if($validate)
			{
				$this->session->set_flashdata('succ_msg', "Password Successfully Reset. Please Log In.");
			}
			else
			{
				$this->session->set_flashdata('err_msg', "Password Reset Unsuccessful.");
			}

			redirect(base_url()."auth/login");
    	}

    	$this->load->view('auth/reset');
    }

}

?>