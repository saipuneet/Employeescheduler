<?php
$this->load->view('includes/header')
?>

<style>   

/* Float four columns side by side */
.column {
  float: left;
  width: 30%;
  padding: 0 10px;
}

/* Remove extra left and right margins, due to padding */
.row {margin: 0 -5px;}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive columns */
@media screen and (max-width: 600px) {
  .column {
    width: 100%;
    display: block;
    margin-bottom: 20px;
  }
}

/* Style the counter cards */
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  padding: 16px;
  text-align: center;
  background-color: #f1f1f1;
}
    </style>


<!-- page content starts -->
<div class="page-content" style="overflow: scroll;">
  
<div style="padding: 1% 0% 0% 20%">
        <div class="column">
          <div class="card">
            <img src="<? echo base_url('assets/images/') ?>w2.jpg" style="width:100%">
            <h3>Manager</h3>
            <pre>
 Name:Tiffiny Debral
 Email:Tiffineydebral@gmail.com
 Contact Number:2403393281
 Office Hours:MW 11AM-1PM
            </pre>
             </div>
        </div>
        
        <div class="column">
          <div class="card">
            <img src="<? echo base_url('assets/images/') ?>Men3.jpg" style="width:100%">
            <h3>Supervisor</h3>
            <pre>
 Name:kenny Mack
 Email:kennymack@gmail.com
 Contact Number:2403393282
 Office Hours:MW 1AM-5PM
            </pre>
           
          </div>
        </div>
        
        <div class="column">
          <div class="card">
            <img src="<? echo base_url('assets/images/') ?>w4.jpg" style="width:100%">
            <h3>Chef</h3>
            <pre>
 Name:Felisha White
 Email:felishawhite@gmail.com
 Contact Number:2403393283
 Office Hours:MW 1AM-5PM
            </pre>
           
          </div>
        </div>
      </div>

<?php
$this->load->view('includes/footer')
?>
