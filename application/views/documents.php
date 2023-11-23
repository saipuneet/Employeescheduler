<?php
$this->load->view('includes/header')
?>
<!-- page content starts -->
<div class="page-content">
  <div class="header">Employee Docments</div>
  <? if($this->session->userdata("role") == "admin"){ ?>
    <form method="post" action="<? echo base_url('documents/insertRequest') ?>">
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label>Employees</label>
            <select class="form-control" name="employee_id" required>
              <option value="">Select Employee</option>
              <? 
                $users = $this->db->order_by("id", "desc")->get_where("tbl_users", ["role" => "employee", "status" => "Active"])->result();
                foreach ($users as $k => $u) {
              ?>
                <option value="<? echo $u->id ?>"><? echo $u->first_name . " " . $u->last_name ?></option>
              <? } ?>  
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Document Type</label>
            <select class="form-control" name="document_type" required>
              <option value="">Select Document Type</option>
              <option value="I20">I20</option>
              <option value="Passport">Passport</option>
              <option value="SSN">SSN</option>
            </select>
          </div>
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
            <? if($this->session->userdata("role") == "admin"){ ?>
              <th>Employee Name</th>
            <? } ?>  
            <th>Document Type</th>
            <th>Document</th>
          </tr>
        </thead>
        <tbody>
          <? 
          if($this->session->userdata('role') == 'employee'){
            $this->db->where("employee_id", $this->session->userdata('user_id'));
          }
          $documents = $this->db->order_by("id", "desc")->get_where("tbl_documents")->result();
          foreach ($documents as $k => $d) {
            $udata = $this->db->order_by("id", "desc")->get_where("tbl_users", ["role" => "employee", "status" => "Active", "id"=> $d->employee_id])->row();
          ?>
          <tr>
            <td><? echo $k+1 ?></td>
            <? if($this->session->userdata("role") == "admin"){ ?>
              <td><? echo $udata->first_name . " " . $udata->last_name ?></td>
            <? } ?>  
            <td><? echo $d->document_type ?></td>
            <td>
              <? if($d->document !== ''){ ?>
                <a class="btn btn-info" href="<? echo base_url().$d->document ?>" download>Download</a>
              <? }elseif($this->session->userdata("role") == "employee"){ ?>  
                <a class="btn btn-info" data-target="#mymodal<? echo $d->id ?>" data-toggle="modal">Upload</a>
              <? } ?>  
            </td>
          </tr>
          <div id="mymodal<? echo $d->id ?>" class="modal fade" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header" style="display: block;">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Upload Document</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group" style="text-align: center;">
                  <form method="post" enctype="multipart/form-data" action="<? echo base_url('documents/uploadDocument') ?>">
                    <div class="row">
                      <div class="col-md-12">
                        <label>Select Document</label>
                        <input type="file" class="form-control" name="file" required/>
                        <input type="hidden" class="form-control" name="id" value="<? echo $d->id ?>" required/>
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