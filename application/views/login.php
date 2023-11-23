<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<? echo base_url('assets/css/') ?>style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <title>ShiftMate | Login & Registration</title>
</head>

<body>
    <div class="wrapper">
        <nav class="nav">
            <div class="nav-logo">
                <p>SHIFTMATE</p>
            </div>
            <div class="nav-menu" id="navMenu">

            </div>
            <div class="nav-button">
                <button class="btn white-btn" id="loginBtn" onclick="login()">Sign In</button>
                <button class="btn" id="registerBtn" onclick="register()">Sign Up</button>
            </div>
            <div class="nav-menu-btn">
                <i class="bx bx-menu" onclick="myMenuFunction()"></i>
            </div>
        </nav>

        <!----------------------------- Form box ----------------------------------->
        <div class="form-box">

            <!------------------- login form -------------------------->
            <div class="login-container" id="login">
                <form id="login_form" method="post">
                    <div class="top">
                        <header>Login</header>
                    </div>
                    <div class="input-box">
                        <input type="text" class="input-field" placeholder=" Email" name="email" required>
                        <i class="bx bx-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" class="input-field" placeholder="Password" name="password" required>
                        <i class="bx bx-lock-alt"></i>
                    </div>
                    <div class="input-box" style="color:white;font-weight:bold;text-align: center; margin-bottom:10px;">
                        <span style="color:white;font-weight:bold;text-align: center;">Login As Admin ? <label class="switch">
                                <input type="checkbox" checked name="role">
                                <span class="slider round"></span>
                            </label></span>
                    </div>
                    <div class="input-box">
                        <input type="submit" id="login" class="submit" name="login" value="Sign In">
                    </div>
                    <div class="two-col">
                        <div class="one">
                            <!-- <input type="checkbox" id="login-check">
                            <label for="login-check"> Remember Me</label> -->
                        </div>
                        <div class="two">
                            <label><a href="#">Forgot password?</a></label>
                        </div>
                    </div>
                    <!-- 
                    <div class="bottom" style="text-align: center;">
                        <span style="color:white;font-weight:bold;text-align: center;">Not An Employee? <a
                                href="../../Admin/Sign Up/Adminsignup.php" onclick="">Sign In</a> For Admin!</span>

                    </div> -->
                </form>
            </div>

            <!------------------- registration form -------------------------->
            <div class="register-container" id="register" style="display: none;">
                <form id="signup_form" method="post">
                    <div class="top">
                        <header>Sign Up</header>
                    </div>
                    <div class="two-forms">
                        <div class="input-box">
                            <input type="text" class="input-field" placeholder="Firstname" name="first_name" required>
                            <i class="bx bx-user"></i>
                        </div>
                        <div class="input-box">
                            <input type="text" class="input-field" placeholder="Lastname" name="last_name" required>
                            <i class="bx bx-user"></i>
                        </div>
                    </div>
                    <div class="input-box">
                        <input type="email" class="input-field" placeholder="Email" name="email" required>
                        <i class="bx bx-envelope"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" class="input-field" placeholder="Password" name="password" required>
                        <i class="bx bx-lock-alt"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" class="input-field" placeholder="Confirm Password" name="cpassword" required>
                        <i class="bx bx-lock-alt"></i>
                    </div>
                    <!-- <hr />
                    <p  style="color: white; text-align: center"><label><strong>Class Timings</strong></label></p>
                    <div class="row" style="display: flex; margin-bottom: 10px;">
                        <div class="input-box" style="width: 49%; margin-right: 10px">
                            <label style="color: white">Start Time</label>
                            <input type="time" class="input-field" name="class_start_time" required>
                        </div>
                        <div class="input-box" style="width: 50%;">
                            <label style="color: white">End Time</label>
                            <input type="time" class="input-field" name="class_end_time" required>
                        </div>
                    </div> -->


                    <!-- <div class="input-box" style="color:white;font-weight:bold;text-align: center; margin-bottom:10px;">
                        <span style="color:white;font-weight:bold;text-align: center;">Register As Admin ? <label
                                class="switch">
                                <input type="checkbox" checked name="adminlog">
                                <span class="slider round"></span>
                            </label></span>
                    </div> -->

                    <div class="input-box">
                        <input type="submit" id="signup" class="submit" name="register" value="Register">
                    </div>
                    <div class="two-col">
                        <div class="one">
                            <!--                            <input type="checkbox" id="register-check">
                            <label for="register-check"> Remember Me</label> -->
                        </div>
                        <div class="two">
                            <label><a href="#">Terms & conditions</a></label>
                        </div>
                    </div>
                    <!-- <div class="bottom" style="text-align: center;">
                        <span style="color:white;font-weight:bold;text-align: center;">Not An Employee? <a
                                href="../../Admin/Sign Up/Adminsignup.php" onclick="">Sign In</a> For Admin!</span>
                    </div> -->
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">
    <script>
        function myMenuFunction() {
            var i = document.getElementById("navMenu");

            if (i.className === "nav-menu") {
                i.className += " responsive";
            } else {
                i.className = "nav-menu";
            }
        }
    </script>

    <script>
        var a = document.getElementById("loginBtn");
        var b = document.getElementById("registerBtn");
        var x = document.getElementById("login");
        var y = document.getElementById("register");

        function login() {
            x.style.left = "4px";
            y.style.right = "-520px";
            a.className += " white-btn";
            b.className = "btn";
            x.style.opacity = 1;
            y.style.opacity = 0;
            $("#login").show();
            $("#register").hide();
        }

        function register() {
            x.style.left = "-510px";
            y.style.right = "5px";
            a.className = "btn";
            b.className += " white-btn";
            x.style.opacity = 0;
            y.style.opacity = 1;
            $("#login").hide();
            $("#register").show();
        }
    </script>

</body>

</html>

<script>
    function dashboard() {
        window.location.href = "<? echo base_url('dashboard') ?>";
    }

    function reload() {
        location.reload();
    }

    $("#login_form").submit(function(e) {
        e.preventDefault();
        var fdata = $(this).serialize();
        $.ajax({
            "url": "<?php echo base_url("home/do_login") ?>",
            "type": "POST",
            "data": fdata,
            "dataType": 'json',
            "success": function(data) {
                if (data.status == 200) {
                    Swal.fire(
                        'Success',
                        data.message,
                        'success'
                    )
                    setTimeout(dashboard, 3000);
                } else {
                    Swal.fire(
                        'Error',
                        data.message,
                        'error'
                    )
                }
            },
            "error": function(data) {
                console.log(data);
            }
        })
    })

    $("#signup_form").submit(function(e) {
        e.preventDefault();
        var fdata = $(this).serialize();
        $.ajax({
            "url": "<?php echo base_url("home/insertUser") ?>",
            "type": "POST",
            "data": fdata,
            "dataType": 'json',
            "success": function(data) {
                console.log(data);
                if (data.status == 200) {
                    Swal.fire(
                        'Success',
                        data.message,
                        'success'
                    )
                    setTimeout(reload, 3000);
                } else {
                    Swal.fire(
                        'Error',
                        data.message,
                        'error'
                    )
                }
            },
            "error": function(data) {
                console.log(data);
            }
        })
    })
</script>

<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 26px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>