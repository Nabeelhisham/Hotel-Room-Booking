<?php
    require('../admin/admin_components/db_config.php');
    require('../admin/admin_components/essentials.php');
    require("../user_components/sendgrid/sendgrid-php.php");
    
    date_default_timezone_set("Asia/Kolkata");
    session_start();

    if(!(isset($_SESSION['user_login']) && $_SESSION['user_login'] == true)) {
            redirect('index.php');
    }

    if(isset($_POST['review_form'])) {
        $form_data = filteration($_POST);

        $upd_query ="UPDATE `booking_order` SET `rate_review`=?  WHERE `booking_id`=? AND `user_id`=? ";

        $upd_values = [1,$form_data['booking_id'],$_SESSION['U_Id']];

        $upd_result = update($upd_query,$upd_values,'iii');

        $ins_query ="INSERT INTO `rating_review`(`booking_id`, `room_id`, `user_id`, `rating`, `review`) VALUES (?,?,?,?,?)";

        $ins_values = [$form_data['booking_id'],$form_data['room_id'],$_SESSION['U_Id'],$form_data['rating'],$form_data['review']];

        $ins_result = insert($ins_query,$ins_values,'iiiis');

        echo $ins_result;
    }


    
?>