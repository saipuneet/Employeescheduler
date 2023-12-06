<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
/**
 *Dashboard functionality
 */
	public function __construct() {
        parent::__construct();
        if(!$this->session->userdata('user_id')){
			redirect('home/login');
		}
    } 

	public function index()
	{
		$this->load->view('index');
	}

	public function employees()
	{
		$this->load->view('employees');
	}

	public function help()
	{
		$this->load->view('help');
	}

	public function documents()
	{
		$this->load->view('documents');
	}

	public function mngrequests()
	{
		$this->load->view('mngrequests');
	}

	public function adminrequests()
	{
		$this->load->view('adminrequests');
	}

	public function requests()
	{
		$this->load->view('emprequests');
	}

	public function profile()
	{
		$this->load->view('profile');
	}

	public function schedules()
	{
		$this->load->view('schedules');
	}
	
	public function createSchedule()
	{
		$this->load->view('createSchedule');
	}
	
	public function getSchedules()
	{

		$color = 'blue';
		$station = $this->input->post('station');
		if($station == 'Mooyah'){
			$color = MOOYAH;
		}elseif($station == 'Dining'){
			$color = DINING;
		}elseif($station == 'Zen'){
			$color = ZEN;
		}

		$sdata = [];                
		$schedules = $this->db->get_where("tbl_schedules", ["station"=>$station])->result(); 
		foreach($schedules as $s){
			$edata = $this->db->get_where('tbl_users', ['role'=>'employee','id'=>$s->employee_id])->row();
			$sdata[] = [
				"title" => $edata->first_name." ".$edata->last_name,
				"start" => $s->start_time,
				"end" => $s->end_time,
				"color" => $color
			];
		}

		echo json_encode(["status"=>true, "sdata"=>$sdata]);
		exit;

	}
	
	public function getEmployees()
	{

		$stime = $this->input->post('start_time');
		$etime = $this->input->post('end_time');
		$station = $this->input->post('station');
		$day = $this->input->post('day');

		$html = $this->secure->getEmployeeslist($stime, $etime, $station, $day);
		echo $html;

	}
	
	public function deleteEmployee($eid)
	{

		$d = $this->db->delete("tbl_users", ["id"=>$eid]);

		if($d){
			$this->db->delete("tbl_schedules", ["employee_id"=>$eid]);
			$this->db->delete("tbl_employee_class_timings", ["employee_id"=>$eid]);
			$this->db->delete("tbl_documents", ["employee_id"=>$eid]);
			$this->db->delete("tbl_requests", ["created_by"=>$eid]);
			$this->db->delete("tbl_requests", ["employee_id"=>$eid]);
			echo json_encode(["status"=>true, "msg"=>"Successfully Deleted"]);
			exit;
		}else{
			echo json_encode(["status"=>false, "msg"=>"Error Occured"]);
			exit;
		}

	}

	public function updateStation()
	{
		$station = $this->input->post('station');
		$employee_id = $this->input->post('eid');

		if($station == ""){
			echo json_encode(["status"=>false, "msg"=>"Station Is Required"]);
			exit;
		}
		if($employee_id == ""){
			echo json_encode(["status"=>false, "msg"=>"Employee ID Is Required"]);
			exit;
		}

		$d = $this->db->where("id",$employee_id)->update("tbl_users",["station"=>$station]);

		if($d){
			echo json_encode(["status"=>true, "msg"=>"Successfully Updated"]);
			exit;
		}else{
			echo json_encode(["status"=>false, "msg"=>"Error Occured"]);
			exit;
		}
	}
	
	public function insertSchedule()
	{
		$user_id = $this->session->userdata('user_id');
		$start_time = $this->input->post('start_time');
		$end_time = $this->input->post('end_time');
		$station = $this->input->post('station');
		$employee_id = $this->input->post('employee_id');

		$chkSchedule = $this->db->get_where("tbl_schedules", ["employee_id"=>$employee_id, "start_time"=>$start_time, "end_time"=>$end_time])->num_rows();

		if($chkSchedule > 0){
			echo json_encode(["status"=>false, "msg"=>"Schedule Already Created"]);
			exit;
		}

		$d = $this->db->insert("tbl_schedules", ["created_by"=>$user_id,"station"=>$station,"start_time"=>$start_time,"end_time"=>$end_time,"employee_id"=>$employee_id]);

		if($d){

			$udata = $this->db->get_where("tbl_users", ["id"=>$employee_id])->row();
			$subject = "Confirmation of Scheduled Timings";
			$toemail = $udata->email;
			$content = '
				<p>
					Dear '.$udata->first_name." ".$udata->last_name.', <br><br> 
					I hope this email finds you well. I am writing to confirm the scheduled timings for your upcoming tasks or responsibilities. Please review the following details: <br><br>
					Date: '.date('m-d-Y', strtotime($start_time)).'	<br>
					Time: '.date('h:iA', strtotime($start_time)).' - '.date('h:iA', strtotime($end_time)).'<br>
					Station: '.$station.'
				</p>
			';
			$this->secure->sendEmail($subject, $toemail, $content);
			echo json_encode(["status"=>true, "msg"=>"Successfully Created"]);
			exit;
		}else{
			echo json_encode(["status"=>false, "msg"=>"Error Occured"]);
			exit;
		}

	}

	public function updateTimings()
	{

		$days = ["Mon", "Tue", "Wed", "Thu", "Fri"];
		$eid = $this->session->userdata("user_id");

		foreach($days as $d){

			$stime = $this->input->post("starttime".$d);
			$etime = $this->input->post("endtime".$d);
			
			$delTimings = $this->db->delete("tbl_employee_class_timings", ["employee_id" => $eid, "day" => $d]);
			
			foreach($stime as $sk => $st){
				$data = [
					"employee_id" => $eid,
					"day" => $d,
					"start_time" => $st,
					"end_time" => $etime[$sk],
				];

				// print_r($data);

				$d1 = $this->db->insert("tbl_employee_class_timings", $data);
			}

		}

		if($d1){
			echo json_encode(["status"=>true, "msg"=>"Successfully Updated Class Timings"]);
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
		$schedule_id = $this->input->post('schedule_id');
		$request_type = $this->input->post('request_type');
		$empschedule_id = $this->input->post('empschedule_id');
		
		$data = ["schedule_id"=>$schedule_id,"request_type"=>$request_type,"created_by"=>$user_id];
		if($request_type == "swap"){
			$data["employee_id"] = $employee_id;
			$data["empschedule_id"] = $empschedule_id;
		}

		$d = $this->db->insert("tbl_requests", $data);

		if($d){
			$adata = $this->db->get_where("tbl_users",["role"=>"admin"])->row();
			$udata = $this->db->get_where("tbl_users",["id"=>$user_id])->row();
			$sdata = $this->db->get_where("tbl_schedules",["id"=>$schedule_id])->row();

			$subject = "Request for Substitute/Swap";
			$toemail = $adata->email;
			$content = '
				<p>
					Dear '.$adata->first_name." ".$adata->last_name.', <br><br> 
					
					I hope this message finds you well. I am ('.$udata->first_name." ".$udata->last_name.') writing to request a substitution or a swap for my upcoming  scheduled for '.date('m-d-Y', strtotime($sdata->start_time))." ".date('h:iA', strtotime($sdata->start_time)).' - '.date('h:iA', strtotime($sdata->end_time)).'
				</p>
			';
			$this->secure->sendEmail($subject, $toemail, $content);
			redirect('dashboard/requests');
		}else{
			redirect('dashboard/requests');
		}

	}

	public function getSelectedemployeeschedules(){
		$eid = $this->input->post('emp_id');
		$this->db->where("employee_id", $eid);
		$this->db->where("Date(start_time) >=", date("Y-m-d"));
		$schedules = $this->db->order_by("id","desc")->get_where("tbl_schedules")->result(); 

		$html = '<option value="">Select Employee Schedule</option>';
		foreach($schedules as $k => $u1){
			$chk = $this->db->get_where("tbl_requests",["schedule_id"=>$u1->id,"created_by"=>$eid])->num_rows();
			if($chk == 0){
				$html .= '<option value="'.$u1->id.'">'.date("m-d-Y", strtotime($u1->start_time))." (".date("h:iA", strtotime($u1->start_time))."-".date("h:iA", strtotime($u1->end_time)).")".'</option>';
			}
		} 
		echo $html;
	}

	public function approveRequest($rid = ""){

		$rsdata = $this->db->get_where("tbl_requests", ["id"=>$rid])->row();

		if($rsdata->request_type == "swap"){

			$this->db->where("id", $rsdata->schedule_id)->update("tbl_schedules", ["employee_id"=>$rsdata->employee_id]);
			$this->db->where("id", $rsdata->empschedule_id)->update("tbl_schedules", ["employee_id"=>$rsdata->created_by]);

			$this->db->where("id", $rid)->update('tbl_requests', ['status'=>'approved']);

			$udata = $this->db->get_where("tbl_users",["id"=>$rsdata->created_by])->row();
			$sdata = $this->db->get_where("tbl_schedules",["id"=>$rsdata->schedule_id])->row();

			$subject = "Admin Appoval of Substitute/Swap";
			$toemail = $udata->email;
			$content = '
				<p>
					Dear '.$udata->first_name." ".$udata->last_name.', <br><br> 

					Admin have approved your swap request of '.date('m-d-Y', strtotime($sdata->start_time))." ".date('h:iA', strtotime($sdata->start_time)).' - '.date('h:iA', strtotime($sdata->end_time)).'
				</p>
			';
			$this->secure->sendEmail($subject, $toemail, $content);

			redirect('dashboard/requests');

		}else{

			$this->db->where("id", $rsdata->schedule_id)->update("tbl_schedules", ["employee_id"=>$this->input->post('employee_id')]);
			$this->db->where("id", $rid)->update('tbl_requests', ['status'=>'approved', 'employee_id'=>$this->input->post('employee_id')]);

			$udata = $this->db->get_where("tbl_users",["id"=>$rsdata->created_by])->row();
			$sdata = $this->db->get_where("tbl_schedules",["id"=>$rsdata->schedule_id])->row();

			$subject = "Admin Appoval of Substitute/Swap";
			$toemail = $udata->email;
			$content = '
				<p>
					Dear '.$udata->first_name." ".$udata->last_name.', <br><br> 

					Admin have approved your sub request of '.date('m-d-Y', strtotime($sdata->start_time))." ".date('h:iA', strtotime($sdata->start_time)).' - '.date('h:iA', strtotime($sdata->end_time)).'
				</p>
			';
			$d = $this->secure->sendEmail($subject, $toemail, $content);
			
			redirect('dashboard/requests');

		}

	}

	public function insertChat()
	{
		$user_id = $this->session->userdata('user_id');
		$udata = $this->db->get_where('tbl_users',["id"=>$user_id])->row();
		
		$data = ["message_sent_by"=>$user_id,"message"=>$this->input->post('message')];
		$d = $this->db->insert("tbl_chat", $data);

		if($d){
			echo json_encode(['status'=>true,'name'=>$udata->first_name]);
		}else{
			echo json_encode(['status'=>false]);
		}

	}

	public function getLatestchat(){
		$ccount = $this->input->post('last_count');
		$mchat = $this->db->order_by('created_date', 'desc')->get_where('tbl_chat');
		$cData = $mchat->row();

		if(($mchat->num_rows() > $ccount) && ($cData->message_sent_by !== $this->session->userdata('user_id'))){
			
			$udata = $this->db->select('first_name')->get_where('tbl_users',['id'=>$cData->message_sent_by])->row();
			echo json_encode(["status"=>true,"name"=> $udata->first_name, "message" => $cData->message, "ccount"=>$mchat->num_rows()]);
			
		}

	}
	
}
