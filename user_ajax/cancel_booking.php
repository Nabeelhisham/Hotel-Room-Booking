<?php
    require('../admin/admin_components/db_config.php');
    require('../admin/admin_components/essentials.php');
    
    date_default_timezone_set("Asia/Kolkata");
    session_start();

    if(!(isset($_SESSION['user_login']) && $_SESSION['user_login'] == true)) {
            redirect('index.php');
    }

    if(isset($_POST['cancel_booking'])) {
        $form_data = filteration($_POST);

        $query ="UPDATE `booking_order` SET `booking_status`=? , `refund`=? WHERE `booking_id`=? AND `user_id`=? ";

        $values = ['cancelled',0,$form_data['id'],$_SESSION['U_Id']];

        $result = update($query,$values,'siii');

        echo $result;
    }


    
?>