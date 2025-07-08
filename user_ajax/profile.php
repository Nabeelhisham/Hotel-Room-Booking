<?php
    require('../admin/admin_components/db_config.php');
    require('../admin/admin_components/essentials.php');
    
    date_default_timezone_set("Asia/Kolkata");

    if(isset($_POST['info_form'])) {
        $form_data = filteration($_POST);

        session_start();

        $user_exist = select("SELECT * FROM `user_details` WHERE `phone_num` = ? AND `id` != ? LIMIT 1",[$data['phone_num'],$_SESSION['U_Id']],"ss");

        if(mysqli_num_rows($user_exist)!=0) {
            echo 'phone_already';
            exit;
        }


        $query = "UPDATE `user_details` SET `name`=?, `address`=?, `phone_num`=?, `pincode`=?, `dob`=?  WHERE `id`=? LIMIT 1";
        $values = [$form_data['name'],$form_data['address'],$form_data['phone_num'],$form_data['pincode'],$form_data['dob'],$_SESSION['U_Id']];

        if(update($query,$values,'ssssss')) {
            $_SESSION['U_Name'] = $form_data['name'];
            echo 1;
        }
        else {
            echo 0;
        }

    }

    if(isset($_POST['profile_form'])) {

        session_start();

        $img = uploadUserImg($_FILES['profile']);

        if($img == 'inv_img') {
            echo 'inv_img';
            exit;
        }
        else if($img == 'upd_failed') {
            echo 'upd_failed';
            exit;
        }


        $user_exist = select("SELECT `profile` FROM `user_details` WHERE `id` = ? LIMIT 1",[$_SESSION['U_Pic']],"s");
        $user_fetch = mysqli_fetch_assoc($user_exist);

        deleteIMG($user_fetch['profile'],USERS_FOLDER);

        $query = "UPDATE `user_details` SET `profile`=?  WHERE `id`=?";
        $values = [$img,$_SESSION['U_Pic']];

        if(update($query,$values,'ss')) {
            $_SESSION['U_Pic'] = $img;
            echo 1;
        }
        else {
            echo 0;
        }

    }


    if(isset($_POST['pass_form'])) {

        $form_data = filteration($_POST);
        session_start();

        if($form_data['new_pass'] != $form_data['confirm_pass']) {
            echo 'mismatch';
            exit;
        }

        $enc_pass = password_hash($form_data['new_pass'],PASSWORD_BCRYPT);

        $query = "UPDATE `user_details` SET `password`=?  WHERE `id`=? LIMIT 1";
        $values = [$enc_pass,$_SESSION['U_Id']];

        if(update($query,$values,'si')) {
            echo 1;
        }
        else {
            echo 0;
        }

    }

?>