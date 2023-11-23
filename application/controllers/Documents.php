<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Documents extends CI_Controller {


	public function __construct() {
        parent::__construct();
        if(!$this->session->userdata('user_id')){
			redirect('home/login');
		}
    } 

	public function deleteEmployee($eid)
	{

		$d = $this->db->delete("tbl_users", ["id"=>$eid]);

		if($d){
			$this->db->delete("tbl_schedules", ["employee_id"=>$eid]);
			$this->db->delete("tbl_employee_class_timings", ["employee_id"=>$eid]);
			echo json_encode(["status"=>true, "msg"=>"Successfully Deleted"]);
			exit;
		}else{
			echo json_encode(["status"=>false, "msg"=>"Error Occured"]);
			exit;
		}

	}

	public function insertRequest()
	{
		$user_id = $this->session->userdata('user_id');
		$employee_id = $this->input->post('employee_id');
		$document_type = $this->input->post('document_type');

		$chkSchedule = $this->db->get_where("tbl_documents", ["employee_id"=>$employee_id, "document_type"=>$document_type])->num_rows();

		if($chkSchedule > 0){
			echo json_encode(["status"=>false, "msg"=>"Request Already Sent"]);
			exit;
		}

		$d = $this->db->insert("tbl_documents", ["created_by"=>$user_id,"document_type"=>$document_type,"employee_id"=>$employee_id]);

		if($d){

			$udata = $this->db->get_where("tbl_users",["id"=>$employee_id])->row();
			$subject = "Request for Submission of Required Documents";
			$toemail = $udata->email;
			$content = '
				<p>
					Dear '.$udata->first_name." ".$udata->last_name.', <br><br> 
					
					I hope this message finds you well. As part of our ongoing efforts to maintain accurate records and ensure compliance with company policies and legal requirements, we kindly request your assistance in submitting certain documents.<br><br>
					The following documents are required from you:<br><br>
					'.$document_type.'
				</p>
			';
			$this->secure->sendEmail($subject, $toemail, $content);
			redirect('dashboard/documents');
		}else{
			redirect('dashboard/documents');
		}

	}

	public function uploadDocument(){

		$user_id = $this->session->userdata('user_id');
		$id = $this->input->post('id');
		$file = "";

		$config['upload_path']          = 'uploads/documents/';
		$config['allowed_types']        = '*';
		$config['encrypt_name']        = true;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('file'))
		{
			$this->session->set_flashdata('error', $this->upload->display_errors());
			redirect('dashboard/documents');
		}
		else
		{
			$fd=$this->upload->data();
			
			// $oName = $fd['client_name'];
			$file = "uploads/documents/".$fd['file_name'];

		}

		$d = $this->db->where("id", $id)->update("tbl_documents", ["document"=>$file]);

		if($d){
			redirect('dashboard/documents');
		}else{
			$this->session->set_flashdata('error', "Error Occured");
			redirect('dashboard/documents');
		}

	}
	
}
