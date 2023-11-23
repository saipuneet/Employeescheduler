<?php
$this->load->view('includes/header')
?>
<!-- page content starts -->
<div class="page-content">
  <div class="header">Employees</div>
  <div class="" style="margin-top:20px;">
    <div class="table-responsive">
      <table id="example" class="display" style="width:100%;">
        <thead>
          <tr>
            <th>Sl.No</th>
            <th>Employee Name</th>
            <th>Email</th>
            <th>Station</th>
            <th>Class Timings</th>
            <th>Created date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <? $users = $this->db->order_by("id", "desc")->get_where("tbl_users", ["role" => "employee", "status" => "Active"])->result();
          foreach ($users as $k => $u) {
          ?>
            <tr>
              <td><? echo ($k + 1) ?></td>
              <td><? echo $u->first_name . " " . $u->last_name ?></td>
              <td><? echo $u->email ?></td>
              <td><? echo $u->station ?></td>
              <td align="center">
                <a href="javascript:void(0)" data-toggle="modal" data-target="#mymodal<? echo $u->id ?>" class="btn btn-primary btn-sm">View</a>
              </td>
              <td><? echo date("m-d-Y", strtotime($u->created_date)) ?></td>
              <td>
                <a href="javascript:void(0)" class="editEmp" eid="<? echo $u->id ?>"><i class="fa fa-pencil" style="margin-right: 10px;"></i></a>
                <a href="javascript:void(0)" onclick="archiveFunction(<? echo $u->id ?>)"><i class="fa fa-trash"></i></a>
              </td>
            </tr>
            <div id="mymodal<? echo $u->id ?>" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header" style="display: block;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Class Timings</h4>
                      </div>
                      <div class="modal-body">
                          <?
                          $days1 = ["Mon", "Tue", "Wed", "Thu", "Fri"];
                          foreach ($days1 as $d1) {
                            $ctimings1 = $this->db->get_where("tbl_employee_class_timings", ["employee_id" => $u->id, "day" => $d1])->result();
                          ?>
                            <div class="form-group" style="text-align: center;">
                              <label><? echo $d1 ?></label>
                              <? foreach($ctimings1 as $ct1){ ?>
                                <div class="row">
                                  <div class="col-md-6">
                                    <label>Start Time</label>
                                    <input type="time" class="form-control" readonly value="<? echo ($ct1->start_time !== '00:00:00') && ($ct1->start_time !== null) ? $ct1->start_time : '' ?>" />
                                  </div>
                                  <div class="col-md-6">
                                    <label>End Time</label>
                                    <input type="time" class="form-control" readonly value="<? echo ($ct1->end_time !== '00:00:00') && ($ct1->end_time !== null) ? $ct1->end_time : '' ?>" />
                                  </div>
                                </div>
                              <? } ?>  
                            </div>
                          <? } ?>
                      </div>
                    </div>

                  </div>
                </div>
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

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="display: block;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Station</h4>
      </div>
      <div class="modal-body">
        <form method="post" id="updateStation">
          <div class="form-group">
            <label>Station</label>
            <select class="form-control" name="station" id="station" required>
              <option value="">Select Station</option>
              <option value="Mooyah">Mooyah</option>
              <option value="Dining">Dining</option>
              <option value="Zen">Zen</option>
            </select>
            <input type="hidden" name="eid" id="eid" />
          </div>
          <div class="form-group">
            <button class="btn btn-primary" type="submit">Update</button>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>


<script>
  $(document).ready(function() {
    $("#example").dataTable();
  });

  $(".editEmp").click(function() {
    $("#myModal").modal('show');
    var eid = $(this).attr('eid');
    $("#eid").val(eid);
  })

  function archiveFunction(id) {

    Swal.fire({
      title: 'Do you want to delete the employee?',
      showDenyButton: true,
      // showCancelButton: true,
      confirmButtonText: 'Yes',
      denyButtonText: `No`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        Swal.fire('Employee Deleted Successfully', '', 'success')
        $.ajax({
          method: 'POST',
          data: {
            'id': id
          },
          url: '<?php echo base_url() ?>dashboard/deleteEmployee/' + id,
          success: function(data) {
            location.reload();
          }
        });
      } else if (result.isDenied) {
        Swal.fire('Your Selected employee is safe :)', '', 'info')
      }
    })

  }

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