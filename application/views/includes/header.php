<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ShiftMate</title>
  <link rel="stylesheet" href="<? echo base_url('assets/css/') ?>styles.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  
<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
</head>

<body>
  <div class="task-manager">
    <!-- left bar starts -->
    <div class="left-bar">
      <div class="upper-part">
        <div class="actions">
          <!--<div class="circle"></div> -->
          <!-- <div class="circle-2"></div> -->
        </div>
      </div>

      <!-- left content starts -->
      <div class="left-content">

        <ul class="category-list">
          <li class="item">
            <img class="feather feather-users" src="<? echo base_url('assets/') ?>svg/profile.svg" alt="" />
            <!--<span>My Profile</span>-->
            <a href="<? echo base_url('dashboard') ?>">Dashboard</a>

          </li>
          <li class="item">
            <img class="feather feather-users" src="<? echo base_url('assets/') ?>svg/profile.svg" alt="" />
            <!--<span>My Profile</span>-->
            <a href="<? echo base_url('dashboard/profile') ?>">My Profile</a>

          </li>
          <?php if ($this->session->userdata('role') == "employee") { ?>

            <li class="item">
              <img class="feather feather-users" src="<? echo base_url('assets/') ?>svg/Sv.jpg" alt="" />
              <!--<span>My Profile</span>-->
              <a href="<? echo base_url('dashboard/schedules') ?>">My Schedules</a>
            </li>
            <li class="item">
              <img class="feather feather-users" src="<? echo base_url('assets/') ?>svg/doc.jpg" alt="" />
              <!--<span>My Profile</span>-->
              <a href="<? echo base_url('dashboard/requests') ?>">Requests (Sub/Swap)</a>
            </li>
            <li class="item">
              <img class="feather feather-users" src="<? echo base_url('assets/') ?>svg/doc.jpg" alt="" />
              <!--<span>My Profile</span>-->
              <a href="<? echo base_url('dashboard/documents') ?>">Documents</a>
            </li>
            <li class="item">
              <img class="feather feather-users" src="<? echo base_url('assets/') ?>svg/profile.svg" alt="" />
              <a href="<? echo base_url('dashboard/help') ?>">Help</a>
            </li>
            <?php } ?>

            </li>
            <?php if ($this->session->userdata('role') == "admin") { ?>
              <li class="item">
                <img class="feather feather-trending-up" src="<? echo base_url('assets/') ?>svg/edit.svg" alt="" />
                <!--<span>Edit</span>-->
                <a href="<? echo base_url('dashboard/employees') ?>">Employees</a>

              </li>
              <li class="item">
                <img class="feather feather-trending-up" src="<? echo base_url('assets/') ?>svg/update.svg" alt="" />
                <!--<span>Edit</span>-->
                <a href="<? echo base_url('dashboard/schedules') ?>">Schedules</a>

              </li>

              <li class="item">
                <img class="feather feather-trending-up" src="<? echo base_url('assets/') ?>svg/delete.svg" alt="" />
                <!--<span>Edit</span>-->
                <a href="<? echo base_url('dashboard/requests') ?>">Requests</a>

              </li>
              <li class="item">
                <img class="feather feather-trending-up" src="<? echo base_url('assets/') ?>svg/delete.svg" alt="" />
                <!--<span>Edit</span>-->
                <a href="<? echo base_url('dashboard/documents') ?>">Documents</a>

              </li>

            <?php } ?>
            <li class="item">
              <img class="feather feather-zap" src="<? echo base_url('assets/') ?>svg/logout.svg" alt="" />
              <!--<span>Delete</span>-->
              <a href="<? echo base_url('home/logout') ?>">Logout</a>

            </li>
        </ul>
      </div>
      <!-- left content ends -->
    </div>
    <!--  -->
    <!-- left bar ends -->