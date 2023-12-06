<?php
$this->load->view('includes/header')
?>
<!-- Designing the emp request page -->
<!-- page content starts -->
<div class="page-content">
  <div class="header">Requests</div>
  <? if($this->session->userdata('role') == 'employee'){ ?>
    <form method="post" action="<? echo base_url('dashboard/insertRequest') ?>">
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label>Schedule</label>
            <select class="form-control" name="schedule_id" required>
              <option value="">Select Schedule</option>
              <? 
                if($this->session->userdata('role') == 'employee'){
                  $this->db->where("employee_id", $this->session->userdata('user_id'));
                  $this->db->where("Date(start_time) >=", date("Y-m-d"));
                }
                $schedules = $this->db->order_by("id","desc")->get_where("tbl_schedules")->result(); 
                foreach($schedules as $k => $u1){
                  $chk = $this->db->get_where("tbl_requests",["schedule_id"=>$u1->id,"created_by"=>$this->session->userdata('user_id')])->num_rows();
                  if($chk == 0){
              ?>
                <option value="<? echo $u1->id ?>"><? echo date("m-d-Y", strtotime($u1->start_time))." (".date("h:iA", strtotime($u1->start_time))."-".date("h:iA", strtotime($u1->end_time)).") - ". $u1->station ?></option>
              <? }} ?>  
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Request Type</label>
            <select class="form-control" name="request_type" id="request_type" required>
              <option value="">Select Request Type</option>
              <option value="sub">SUB</option>
              <option value="swap">SWAP</option>
            </select>
          </div>
        </div>
        <div class="col-md-3" id="employee_id" style="display: none;">
          <div class="form-group">
            <label>Employees</label>
            <select class="form-control" name="employee_id" id="eid">
              <option value="">Select Employee</option>
              <?
                $user_data = $this->db->order_by("id", "desc")->get_where("tbl_users", ["role" => "employee", "status" => "Active", "id"=>$this->session->userdata('user_id')])->row();

                $users = $this->db->order_by("id", "desc")->get_where("tbl_users", ["role" => "employee", "status" => "Active", "id !="=>$this->session->userdata('user_id'), "station"=> $user_data->station])->result();
                foreach ($users as $k => $u) {
              ?>
                <option value="<? echo $u->id ?>"><? echo $u->first_name . " " . $u->last_name ?></option>
              <? } ?>  
            </select>
          </div>
        </div>
        <div class="form-group" id="employee_schudule" style="display: none;">
          <label>Employee Schedule</label>
          <select class="form-control" name="empschedule_id" id="emp_schedules">
            <option value="">Select Employee Schedule</option>
            
          </select>
        </div>
        <div class="col-md-3">
          <div class="form-group" style="margin-top: 25px;">
            <button class="btn btn-primary">Submit</button>
          </div>
        </div>
      </div>
    </form>  
  <? } ?>    
  <div class="" style="margin-top:20px;">
    <? if($this->session->flashdata('error')){ ?>
       <div class="alert alert-danger"><? echo $this->session->flashdata('error') ?></div> 
    <? } ?>             
    <div class="table-responsive">
      <table id="example" class="display" style="width:100%;">
        <thead>
          <tr>
            <th>Sl.No</th>
            <th>Schedule</th>
            <th>Employee Name</th>
            <th>Request Type</th>
            <th>Employee Swap Schedule</th>
            <? if($this->session->userdata('role') == 'admin'){ ?>
              <th>Action</th>
            <? } ?>  
          </tr>
        </thead>
        <tbody>
          <?
          if($this->session->userdata('role') == 'employee'){
            $this->db->where("created_by", $this->session->userdata('user_id')); 
          }
          $requests = $this->db->order_by("id","desc")->get_where("tbl_requests")->result();
          foreach ($requests as $k => $d) {
            $sdata = $this->db->order_by("id","desc")->get_where("tbl_schedules",["id"=>$d->schedule_id])->row();
            $esdata = $this->db->order_by("id","desc")->get_where("tbl_schedules",["id"=>$d->empschedule_id])->row();
            $udata = $this->db->order_by("id", "desc")->get_where("tbl_users", ["role" => "employee", "status" => "Active", "id"=> $d->employee_id])->row();
          ?>
          <tr>
            <td><? echo $k+1 ?></td>
            <td><? echo date("m-d-Y", strtotime($sdata->start_time))." (".date("h:iA", strtotime($sdata->start_time))."-".date("h:iA", strtotime($sdata->end_time)).") - ".$sdata->station ?></td>
            <td><? echo $udata ? $udata->first_name." ".$udata->last_name : '' ?></td>
            <td><? echo $d->request_type ?></td>
            <td><? echo $d->empschedule_id ? date("m-d-Y", strtotime($esdata->start_time))." (".date("h:iA", strtotime($esdata->start_time))."-".date("h:iA", strtotime($esdata->end_time)).") - ".$esdata->station : '-'; ?></td>
            <? if($this->session->userdata('role') == 'admin'){ ?>
              <td>
                <? if($d->request_type == "sub"){ 
                    if($d->status == 'approved'){
                      echo '<label>Approved</label>';
                    }else{  
                ?>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#mymodal<? echo $d->id ?>" class="btn btn-primary btn-sm">Approve</a>
                <? 
                  }}else{ 
                    if($d->status == 'approved'){
                      echo '<label>Approved</label>';
                    }else{
                ?>  
                    <a href="<? echo base_url('dashboard/approveRequest/').$d->id ?>" class="btn btn-primary btn-sm" onclick="return confirm('Are you sure want to approve?');">Approve</a>
                <? }} ?>  
              </td>
            <? } ?>  
          </tr>
          <div id="mymodal<? echo $d->id ?>" class="modal fade" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header" style="display: block;">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Update Request</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group" style="text-align: center;">
                  <form method="post" action="<? echo base_url('dashboard/approveRequest/').$d->id ?>">
                    <div class="row">
                      <div class="col-md-12">
                        <label>Employee</label>
                        <select class="form-control" name="employee_id" required>
                          <? 
                            $html = $this->secure->getEmployeeslist($sdata->start_time, $sdata->end_time, $sdata->station, date('D', strtotime($sdata->start_time)), $d->created_by);
                            echo $html;
                          ?>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <button type="submit" class="btn btn-primary pull-left mt-5">Submit</button>
                      </div>
                    </div>
                  </form>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <? } 
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!--  -->
<!-- page content ends -->


<?php
$this->load->view('includes/footer')
?>

<script>
  $(document).ready(function() {
    $("#example").dataTable();
  });

  $("#request_type").change(function(){
    var rtype = $(this).val();
    if(rtype == 'swap'){
      $("#employee_id").show();
      $("#employee_schudule").hide();
    }else{
      $("#employee_id").hide();
      $("#employee_schudule").hide();
    }
  });

  $("#eid").change(function(){
    $("#employee_schudule").show();
    var eid = $(this).val();
    $.ajax({
      method: 'post',
      url: "<? echo base_url('dashboard/getSelectedemployeeschedules') ?>",
      data: {emp_id: eid},
      success: function(data) {
        console.log(data);
        $("#emp_schedules").html(data);
      },
      error: function() {

      }
    })
  })

  $("#updateStation").submit(function(e) {
    e.preventDefault();
    var fdata = $(this).serialize();
    $.ajax({
      method: 'post',
      url: "<? echo base_url('dashboard/updateStation') ?>",
      data: fdata,
      dataType: 'json',
      success: function(data) {
        if (data.status) {
          Swal.fire(
            'Success',
            data.msg,
            'success'
          )
          setTimeout(() => {
            window.location.reload();
          }, 3000);
        } else {
          Swal.fire(
            'Error',
            data.msg,
            'error'
          )
        }
      },
      error: function() {

      }
    })
  })
</script>