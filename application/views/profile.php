<?php
$this->load->view('includes/header')
?>

<style>
  .student-profile .card {
    border-radius: 10px;
  }

  .student-profile .card .card-header .profile_img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    margin: 10px auto;
    border: 10px solid #ccc;
    border-radius: 50%;
  }

  .student-profile .card h3 {
    font-size: 20px;
    font-weight: 700;
  }

  .student-profile .card p {
    font-size: 16px;
    color: #000;
  }

  .student-profile .table th,
  .student-profile .table td {
    font-size: 14px;
    padding: 5px 10px;
    color: #000;
  }
</style>

<div class="container">
  <header class="ScriptHeader">
    <div class="rt-container" style="margin-left:30px;margin-top:20px;">
      <div class="col-rt-12">
        <div class="rt-heading">
          <h1>Profile Page</h1>
        </div>
      </div>
    </div>
  </header>

  <section>
    <div class="rt-container">
      <div class="col-rt-12">
        <div class="Scriptcontent">

          <!-- Student Profile -->
          <div class="student-profile py-4">
            <div class="container">
              <div class="row">
                <div class="col-lg-4">
                  <div class="card shadow-sm">
                    <div class="card-header bg-transparent text-center">
                      <img class="profile_img" src="https://source.unsplash.com/600x300/?student" alt="student dp">
                      <h3><?php echo $this->session->userdata('user_name') ?></h3>
                    </div>
                    <div class="card-body">
                      <!-- <p class="mb-0"><strong class="pr-1">Date of Birth:</strong>321000001</p> -->
                      <p class="mb-0"><strong class="pr-1">Employee ID:</strong><?php echo "10000" . $this->session->userdata('user_id') ?></p>
                      <p class="mb-0"><strong class="pr-1">Email ID:</strong><?php echo $this->session->userdata('email') ?></p>
                    </div>
                  </div>
                </div>

                <? if ($this->session->userdata('role') == 'employee') { ?>
                  <div class="col-lg-8">
                    <div class="card shadow-sm">
                      <div class="card-header bg-transparent border-0">
                        <h3 class="mb-0"><i class="far fa-clone pr-1"></i>Class Timings <a class="btn btn-sm btn-primary pull-right mr-5" data-toggle="modal" data-target="#myModal" href="javascript:void(0)">Edit</a></h3>
                      </div>
                      <div class="card-body pt-0">
                        <table class="table table-bordered">
                          <?
                          $days = ["Mon", "Tue", "Wed", "Thu", "Fri"];
                          foreach ($days as $d) {
                            $ctimings = $this->db->get_where("tbl_employee_class_timings", ["employee_id" => $this->session->userdata('user_id'), "day" => $d])->result();
                          ?>
                            <tr>
                              <th width="30%"><? echo $d; ?> </th>
                              <td width="2%">:</td>
                              <td><? foreach($ctimings as $ct){ echo ($ct->start_time !== '00:00:00') && ($ct->start_time !== null) ? date("h:i A", strtotime($ct->start_time)) . " - " . date("h:i A", strtotime($ct->end_time))."<br>" : '-'; } ?></td>
                            </tr>
                          <? } ?>
                        </table>
                      </div>
                    </div>
                  </div>
                <? } ?>

              </div>
            </div>
          </div>
          <!-- partial -->

        </div>
      </div>
    </div>
  </section>
</div>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="display: block;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Class Timings</h4>
      </div>
      <div class="modal-body">
        <form method="post" id="updateTimings">
          <?
          foreach ($days as $d1) {
            $ctimings1 = $this->db->get_where("tbl_employee_class_timings", ["employee_id" => $this->session->userdata('user_id'), "day" => $d1])->result();
          ?>
              <div class="row ml-auto">
                <label class="text-right col-md-6"><? echo $d1 ?></label>
                <div class="col-md-6">
                  <button type="button" day="<? echo $d1 ?>" class="btn btn-info btn-sm waves-effect waves-light float-right add_sheading">Add</button>
                </div>  
              </div>  
              <!-- <div class="row">
                <div class="col-md-6">
                  <label>Start Time</label>
                  <input type="time" class="form-control" name="<? //echo $d1 ?>startTime" value="<? //echo ($ct1->start_time !== '00:00:00') && ($ct1->start_time !== null) ? $ct1->start_time : '' ?>" />
                </div>
                <div class="col-md-6">
                  <label>End Time</label>
                  <input type="time" class="form-control" name="<? //echo $d1 ?>endTime" value="<? //echo ($ct1->end_time !== '00:00:00') && ($ct1->end_time !== null) ? $ct1->end_time : '' ?>" />
                </div>
              </div> -->
              <?
                if(count($ctimings1) > 0){ 
                foreach($ctimings1 as $ckey => $ct1){ 
                  if((count($ctimings1)-1) == $ckey){
              ?>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <? if($ckey == 0){ ?><label class="control-label">Start Time</label><? } ?>
                          <div class="row m-b-15 field_wrapper<? echo $d1 ?>">
                            <div class="col-md-12" style="margin-bottom: 10px">
                              <input type="time" name="starttime<? echo $d1 ?>[]" class="form-control col-md-10" value="<? echo ($ct1->start_time !== '00:00:00') && ($ct1->start_time !== null) ? $ct1->start_time : '' ?>">
                              <p class="remove_button" id="sub_p_rem1<? echo $ckey.$d1 ?>" align="right" style=""><button class="btn btn-danger waves-effect waves-light" type="button"><i class="fa fa-times"></i></button><br></p>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <? if($ckey == 0){ ?><label class="control-label">End Time</label><? } ?>
                          <div class="row m-b-15 sap_points<? echo $d1 ?>">
                            <div class="col-md-12 sub_p_rem1<? echo $ckey.$d1 ?>" style="margin-bottom: 10px">
                              <input type="time" name="endtime<? echo $d1 ?>[]" class="form-control" value="<? echo ($ct1->end_time !== '00:00:00') && ($ct1->end_time !== null) ? $ct1->end_time : '' ?>">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                <? }else{ ?>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                        <? if($ckey == 0){ ?><label class="control-label">Start Time</label><? } ?>
                          <div class="row m-b-15">
                            <? if($ckey == 0){ ?>
                              <div class="col-md-12" style="margin-bottom: 10px">
                                <input type="time" name="starttime<? echo $d1 ?>[]" class="form-control" value="<? echo ($ct1->start_time !== '00:00:00') && ($ct1->start_time !== null) ? $ct1->start_time : '' ?>">
                              </div>
                            <? }else{ ?>  
                              <div class="col-md-12">
                                <input type="time" name="starttime<? echo $d1 ?>[]" class="form-control col-md-10" value="<? echo ($ct1->start_time !== '00:00:00') && ($ct1->start_time !== null) ? $ct1->start_time : '' ?>"  required> 
                                <p class="remove_button" id="sub_p_rem1<? echo $ckey.$d1 ?>" align="right" style=""><button class="btn btn-danger waves-effect waves-light" type="button"><i class="fa fa-times"></i></button><br></p>
                              </div>
                            <? } ?>  
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                        <? if($ckey == 0){ ?><label class="control-label">End Time</label><? } ?>
                          <div class="row m-b-15">
                            <div class="col-md-12 sub_p_rem1<? echo $ckey.$d1 ?>" style="margin-bottom: 10px">
                              <input type="time" name="endtime<? echo $d1 ?>[]" class="form-control" value="<? echo ($ct1->end_time !== '00:00:00') && ($ct1->end_time !== null) ? $ct1->end_time : '' ?>">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
              <? }}}else{ ?>  

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Start Time</label>
                      <div class="row m-b-15 field_wrapper<? echo $d1 ?>">
                        <div class="col-md-12" style="margin-bottom: 10px">
                          <input type="time" name="starttime<? echo $d1 ?>[]" class="form-control">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">End Time</label>
                      <div class="row m-b-15 sap_points<? echo $d1 ?>">
                        <div class="col-md-12" style="margin-bottom: 10px">
                          <input type="time" name="endtime<? echo $d1 ?>[]" class="form-control">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              <? } ?>  
            
          <? } ?>
          <div class="form-group">
            <button class="btn btn-primary" type="submit">Update</button>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>

<?php
$this->load->view('includes/footer')
?>

<script>
  $(document).ready(function() {
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_sheading'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var spoints = $('.sub_points')


    var x = 1; //Initial field counter is 1
    var y = 1;

    //Once add button is clicked
    $(addButton).click(function() {
      var day = $(this).attr('day');
      //Check maximum number of input fields
      if (x < maxField) {
        x++; //Increment field counter
        $(".field_wrapper"+day).append('<div class="col-md-12"><input type="time" name="starttime'+day+'[]" class="form-control col-md-10"  required> <p class="remove_button" id="sub_p_rem' + x+day +'" align="right" style=""><button class="btn btn-danger waves-effect waves-light" type="button"><i class="fa fa-times"></i></button><br></p></div>'); //Add field html

        $(".sap_points"+day).append('<div class="col-md-12 sub_p_rem' + x+day + '" style="margin-bottom: 10px"><input type="time" name="endtime'+day+'[]" class="form-control col-md-12" required> </div>'); //Add field html

        y++;
      }
    });

    //Once remove button is clicked
    $(document).on('click', '.remove_button', function(e) {
      e.preventDefault();
      var id = $(this).attr('id');
      $(this).parent('div').remove(); //Remove field html
      $('.' + id).remove();
      x--; //Decrement field counter
    });


  });

  $("#updateTimings").submit(function(e) {
    e.preventDefault();
    var fdata = $(this).serialize();
    $.ajax({
      method: 'post',
      url: "<? echo base_url('dashboard/updateTimings') ?>",
      data: fdata,
      dataType: 'json',
      success: function(data) {
        console.log(data);
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
      error: function(data) {
        console.log(data);
      }
    })
  })
</script>