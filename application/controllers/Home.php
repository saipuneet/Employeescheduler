<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function dashboard()
	{
		$this->load->view('index');
	}


	public function login()
	{
		$this->load->view('login');
	}

	
	public function forgot()
	{
		$this->load->view('forgot');
	}

	public function signup()
	{
		$this->load->view('signup');
	}

	
	public function insertUser()
	{
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$email = $this->input->post('email');
		$mobile_number = $this->input->post('mobile_number');
		$password = $this->input->post('password');
		$cpassword = $this->input->post('cpassword');
		$class_start_time = $this->input->post('class_start_time');
		$class_end_time = $this->input->post('class_end_time');
		
		if($password !== $cpassword){
			echo json_encode(["status"=>400, "message"=>"Password & Confirm Password Not Matched."]);
			exit;
		}

		$eChk = $this->db->get_where("tbl_users",["email"=>$email])->num_rows();
		if($eChk > 0){
			echo json_encode(["status"=>400, "message"=>"Email Already Registered With Us."]);
			exit;
		}

		$data = [
			"first_name" => $first_name,
			"last_name" => $last_name,
			"email" => $email,
			/* "class_start_time" => $class_start_time,
			"class_end_time" => $class_end_time, */
			"password" => $this->secure->encrypt($password),
			"created_date" => date("Y-m-d H:i:s")
		];

		$d = $this->db->insert("tbl_users",$data);
		$lid = $this->db->insert_id();

		if($d){

			echo json_encode(["status"=>200, "message"=>"Successfully Registered."]);
			exit;
		}else{
			echo json_encode(["status"=>400, "message"=>"Error Occured."]);
			exit;
		}

	}

	public function do_login(){
	
		$email = $this->input->post("email");
		$password = $this->input->post("password");
		$role = $this->input->post("role");

		if($role){
			$this->db->where("role", "admin");
		}else{
			$this->db->where("role", "employee");
		}
		$mchk = $this->db->get_where("tbl_users",array("email"=>$email,"status"=>"Active"))->num_rows();
		
		if($mchk == 1){
	
			if($role){
				$this->db->where("role", "admin");
			}else{
				$this->db->where("role", "employee");
			}
			$pchk = $this->db->get_where("tbl_users",array("email"=>$email,"status"=>"Active"))->row();
			$cpass = $this->secure->decrypt($pchk->password);
		
			if($cpass == $password){
				$this->session->set_userdata(["user_id"=>$pchk->id,"user_name"=>$pchk->first_name." ".$pchk->last_name, "role" => $pchk->role, "email"=>$email]);
				echo json_encode(["status"=>200,"message"=>"Logged in successfully."]);
				exit;
			}else{
				echo json_encode(["status"=>400,"message"=>"Password is Wrong."]);
				exit;
			}
	
		}else{
			
			echo json_encode(["status"=>400,"message"=>"You are not registered with us. Please sign up with us."]);
			exit;
			
		}
		
	}

	public function updatePassword(){
	
		$email = $this->input->post("email");
		$password = $this->input->post("password");
		$cpassword = $this->input->post("cpassword");
		
		if($password !== $cpassword){
			echo json_encode(["status"=>400, "message"=>"Password & Confirm Password Not Matched."]);
			exit;
		}
	
		$pchk = $this->db->where("email",$email)->update("tbl_users",array("password" => $this->secure->encrypt($password)));
		
		if($pchk){
			echo json_encode(["status"=>200,"message"=>"Password Updated successfully."]);
			exit;
		}else{
			echo json_encode(["status"=>400,"message"=>"Error Occured."]);
			exit;
		}
	
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect("home/login");
	}
	
}
