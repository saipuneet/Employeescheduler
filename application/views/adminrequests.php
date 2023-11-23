<?php
$this->load->view('includes/header')
?>


<!-- page content starts -->
<div class="page-content" style="overflow: scroll;">
  <div class="container1">


    <div class="row1" style="padding-left: 100px;padding-right: 100px;">
      <div class="form-group">
        <label for="fname"><b>Employee Id</b></label>
        <input class="form-control" type="text" id="Eid" name="Eid">
      </div>
      <div class="form-group">
        <label for="fname"><b>Select Station</b></label><br>
        <input type="radio" id="Sub" name="station_selection" value="Sub">
        <label for="html">Sub</label>&nbsp;
        <input type="radio" id="Swap" name="station_selection" value="Swap">
        <label for="css">Swap</label>
      </div>
      <div class="form-group">
        <label for="fname"><b>Co worker Id </b> (who is willing to sub/swap)</label>
        <input class="form-control" type="text" id="Eid" name="Eid">
      </div>
      <div class="form-group">
        <input type="button" onclick="Submit()" value="Update">
      </div>

    </div>

  </div>
  <!--  -->
  <!-- page content ends -->


  <?php
  $this->load->view('includes/footer')
  ?>