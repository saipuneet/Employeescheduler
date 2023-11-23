<?php
defined("BASEPATH") or exit("NO direct script access allow");
require_once(APPPATH.'libraries/sendgrid/sendgrid-php.php');

class Secure extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function getEmployeeslist($stime, $etime, $station, $day, $eid='')
	{

		$html = '<option value="">Select Employee</option>';

		if($eid){
			$this->db->where("id !=", $eid);
		}
		$users = $this->db->order_by("id","desc")->get_where("tbl_users", ["station"=>$station])->result(); 

		foreach($users as $k => $u){

			$cCount = $this->db->get_where("tbl_employee_class_timings", ["employee_id"=>$u->id]);

			$sttime = date("H:i:s", strtotime($stime));
			$ettime = date("H:i:s", strtotime($etime));
 
			$cTimings = $this->db->query("SELECT * FROM `tbl_employee_class_timings` WHERE `day` = '$day' AND `employee_id` = '$u->id' AND (`start_time` > '$sttime' AND `start_time` < '$ettime' OR `end_time` > '$sttime' AND `end_time` < '$ettime')");

			$this->db->where("start_time <=", $sttime);
			$this->db->where("end_time >=", $ettime);
			$cTimings1 = $this->db->get_where("tbl_employee_class_timings", ["day"=>$day,"employee_id"=>$u->id]);
			// if($cTimings1 == 0){
			// 	$html .= '<option value="'.$u->id.'">'.$u->first_name." ".$u->last_name.'</option>';
			// }

			if($cCount->num_rows() > 0 && $cTimings->num_rows() == 0 && $cTimings1->num_rows() == 0){
				$html .= '<option value="'.$u->id.'">'.$u->first_name." ".$u->last_name.'</option>';
			}else{
				
			}
		}
		return $html;
	}

	public function generateCaptcha()
	{

		$config = array(
            'img_path'      => 'uploads/captcha/',
            'img_url'       => base_url().'uploads/captcha/',
			'img_width' => 160,
			'img_height' => 35,
			'word_length'   => 6,
//			'font_size' => 50,
            'font_path'     => FCPATH.'uploads/captcha/fonts/verdana.ttf',
		);
	
        $captcha = create_captcha($config);
        
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode', $captcha['word']);
        
        $captchaImg = $captcha['image'];
		return($captchaImg);

	}

	public function encrypt($data)
	{

		$key = "bjvd!@#$%^&*13248*/-/*vjvdf";
		$hmac_key = "kbdkh2365765243";


		$e = $this->encryption->initialize(
			array(
				'cipher' => 'blowfish',
				'mode' => 'cbc',
				'key' => $key,
				'hmac_digest' => 'sha256',
				'hmac_key' => $hmac_key
			)
		);

		$s = $this->encryption->encrypt($data);


		if ($s) {

			return $s;
		} else {

			return false;
		}
	}

	public function encryptWithKey($data, $key)
	{

		$this->encryption->initialize(
			array(
				'cipher' => 'aes-256',
				'mode' => 'ctr',
				'key' => $key
			)
		);

		$s = $this->encryption->encrypt($data);


		if ($s) {

			return $s;
		} else {

			return false;
		}
	}

	public function decrypt($data)
	{

		$key = "bjvd!@#$%^&*13248*/-/*vjvdf";
		$hmac_key = "kbdkh2365765243";

		$d = $this->encryption->initialize(
			array(
				'cipher' => 'blowfish',
				'mode' => 'cdc',
				'key' => $key,
				'hmac_digest' => 'sha256',
				'hmac_key' => $hmac_key
			)
		);
		$s = $this->encryption->decrypt($data);
		if ($s) {

			return $s;
		} else {

			return false;
		}
	}

	public function sendEmail($subject,$toemail,$content){
		$ufrom = new SendGrid\Email("Shiftmate", "nukalakasiviswanath@gmail.com");
		$usubject = $subject;
		$uto = new SendGrid\Email("Shiftmate",$toemail);

		$ucontent = new SendGrid\Content("text/html",$content);
		$umail = new SendGrid\Mail($ufrom, $usubject, $uto, $ucontent);
		$usg = new \SendGrid("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");
		$uresponse = $usg->client->mail()->send()->post($umail);
		return $uresponse;
	}

}
