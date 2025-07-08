<?php 
    require('admin_components/essentials.php');
    require('admin_components/db_config.php');
    session_start();
    if((isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
        redirect('dashboard.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Panel</title>
    <?php require('admin_components/link.php'); ?>
    <style>

        body {
            background-image: url("https://img.freepik.com/free-vector/abstract-geometric-wireframe-background_52683-59421.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
        }

        div.login-form {
            border: 1px solid black;
            border-radius: 20px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            height: 500px;
            width: 700px;
        }

        .admin_login_details {
            position: absolute;
            width: 450px;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%)

        }

        .admin_login_details input  {
            height: 40px;
            text-align: center;
            width: 340px;
            border-style: solid;
            border-radius: 50px;
            border-width: 2px;
        }

        .admin_login_details button {
            height: 35px;
            color: white;
            border-style: solid;
            border-radius: 50px;
            border-width: 1px;
            width: 200px;
            background-color:rgb(39, 30, 24);
        }


        .admin_login_details button:hover {
            color:rgb(39, 30, 24);
            background-color: white;
            transition: 1s;
            transition-duration: 1s;
        }

        form h4 {
            background-color:rgb(39, 30, 24);
            padding-top:10px;
            padding-bottom: 3px;
            height: 50px;
            text-align: center;
            color: white;
        }

    </style>
</head>
<body class="bg-light">

    <div class="login-form text-center rounded-bg-white shadow overflow-hidden">
        <form method="POST">
            <h4 >ADMIN LOGIN PANEL</h4>
     
            <div class="admin_login_details p-4">
                <div class="mb-3">
                <input name="admin_username" required type="text" placeholder="Username">
                </div>
                <div class="mb-4">
                <input name="admin_password" required type="password" placeholder="Password" >
                </div>
                <button name="admin_login" type="submit">LOGIN</button>
            </div>

        </form>
    </div>

    <?php

    if(isset($_POST['admin_login'])) {
        $form_data = filteration($_POST);

        $query = "SELECT * FROM `admin_details` WHERE `admin_username`=? AND `admin_password`=?";
        $values = [$form_data['admin_username'],$form_data['admin_password']];
        $res = select($query,$values,"ss");
        if($res->num_rows==1) {
            $row = mysqli_fetch_assoc($res);
            $_SESSION['adminLogin'] = true;
            $_SESSION['adminID'] = $row['sl_no'];
            redirect('dashboard.php');
        }
        else {
            alert('error','Invalid Credentials');
        }
    }
    ?>

    <?php require('admin_components/scripts.php'); ?>
</body>
</html>