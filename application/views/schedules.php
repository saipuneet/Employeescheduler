<?php
  $this->load->view('includes/header')
?>

    <!-- page content starts -->
    <div class="page-content">
      <? if($this->session->userdata('role') == 'admin'){ ?>  
        <div class="header">Schedules <a class="float-right btn btn-primary btn-sm" href="<? echo base_url('dashboard/createSchedule') ?>">Create Schedule <i class="fa fa-plus" style="font-weight: bold;"></i></a></div>
      <? }else{ ?>  
        <div class="header">My Schedules</div>
      <? } ?>  
      <div class="" style="margin-top:20px;">
        <div class="table-responsive">
          <table id="example" class="display" style="width:100%;">
            <thead>
                <tr>
                    <th>Station</th>
                    <? if($this->session->userdata('role') == 'admin'){ ?>
                      <th>Employee</th>
                    <? } ?>  
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>No'of Work Hours</th>
                </tr>
            </thead>
            <tbody>
              <? 
                if($this->session->userdata('role') == 'employee'){
                  $this->db->where("employee_id", $this->session->userdata('user_id'));
                }
                $schedules = $this->db->order_by("id","desc")->get_where("tbl_schedules")->result(); 
                 foreach($schedules as $k => $u){
                  $edata = $this->db->get_where('tbl_users', ['role'=>'employee','id'=>$u->employee_id])->row();

                  $time1 = date("H:i:s", strtotime($u->start_time));
                  $time2 = date("H:i:s", strtotime($u->end_time));
                  
              ?>
                <tr>
                    <td><? echo $u->station ?></td>
                    <? if($this->session->userdata('role') == 'admin'){ ?>
                      <td><? echo $edata->first_name." ".$edata->last_name ?></td>
                    <? } ?>  
                    <td><? echo date("d-m-Y h:i A", strtotime($u->start_time)) ?></td>
                    <td><? echo date("d-m-Y h:i A", strtotime($u->end_time)) ?></td>
                    <td><? echo ($time2-$time1)." hrs" ?></td>
                </tr>
              <? } ?>  
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
  $(document).ready(function(){
    $("#example").dataTable();
  })
</script>