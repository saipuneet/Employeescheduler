<?php
$this->load->view('includes/header')
?>

<style>   

      #container {
        margin: 20px auto;
        max-width: 400px;
        padding: 20px;
      }

      .form-wrap {
        background: #fff;
        padding: 20px;
        color: #333;
      }

      .form-wrap .options {
        display: flex;
        justify-content: space-around;
      }

      .form-wrap .options .option {
        background: rgb(167, 170, 180);
        color: #333;
        padding: 10px;
        margin: 10px 0 10px 0;
      }

      .form-wrap .options .current {
        background: #5860bb;
        color: #fff;
        padding: 10px;
        margin: 10px 0 10px 0;
      }

      .form-wrap h1,
      .form-wrap p {
        text-align: center;
        padding: 5px;
      }

      .form-wrap .form-group {
        width: 100%;
      }

      .form-wrap .form-group label {
        display: block;
        color: #666;
      }

      .form-wrap .form-group input {
        width: 100%;
        border: #344a72 1px solid;
        padding: 10px;
        border-radius: 5px;
      }

      .form-wrap .form-group select {
        width: 100%;
        border: #344a72 1px solid;
        padding: 10px;
        border-radius: 5px;
      }

      .form-wrap button {
        display: block;
        width: 100%;
        background: #5860bb;
        padding: 10px;
        margin-top: 20px;
        cursor: pointer;
        color: #fff;
      }

      .form-wrap button:hover {
        background: #37a08e;
      }

      .form-wrap .bottom-text {
        font-size: 13px;
        margin-top: 20px;
      }

      footer {
        text-align: center;
        margin-top: 10px;
      }

      footer a {
        color: #49c1a2;
      }

      .form-group2{
        display: flex;
        padding: 5px;
        font-size: medium;
        flex-direction: row;
        justify-content: start;
      }

      .check1{
        display: flex;
        justify-content: space-evenly;

      }

      .check2{
        display: flex;
        justify-content: space-evenly;
      }

      .check1 label,input{
        margin-right: 10px;
      }

      .check2 label,input{
        margin-right: 10px;
      }
    </style>


<!-- page content starts -->
<div class="page-content" style="overflow: scroll;">
  
<div id="container">
        <div class="form-wrap">
          <h1>Manager request</h1>
          <div class="options">
            <a class="option student current" href="<? echo base_url('dashboard/mngrequests') ?>">Manager Request</a>
            <a class="option admin " href="<? echo base_url('dashboard/emprequests') ?>">Employee Request</a>
          </div>
          <form id="admin-register">
            <div class="form-group">
              <label for="name">Name Of Employee</label>
              <input type="text" name="name" id="name" required />
            </div>
            <div class="form-group2">
                <div class="check1">
                    <label for="vehicle1">Sub</label><br>
                    <input type="radio"  name="vehicle" value="Bike">
                </div>
                <div class="check2">
                    <label for="vehicle2">Swap</label><br>
                    <input type="radio" name="vehicle" value="Car">
                </div>
            </div>
            <div class="form-group">
                <label for="nameemp">Name Of Employee who is willing to accept</label>
                <input type="text" name="nameemp" id="nameemp" required />
              </div>

              <div class="form-group">
                <label for="empid">Emp Id</label>
                <input type="text" name="empid" id="empid" required />
              </div>

              <div class="form-group">
                <label for="date">Date Of Shift</label>
                <input type="date" name="date" id="date" required />
              </div>

              <div class="form-group">
                <label for="time">Time Of Shift</label>
                <input type="time" name="time" id="time" required />
              </div>
      
            <button type="submit" class="btn" id="sign-up">Send Request</button>
          </form>
        </div>
      </div>

</div>
<!--  -->
<!-- page content ends -->


<?php
$this->load->view('includes/footer')
?>
