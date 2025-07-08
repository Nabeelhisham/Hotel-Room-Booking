<?php
require('admin/admin_components/db_config.php');
require('admin/admin_components/essentials.php');
session_start();
date_default_timezone_set("Asia/Kolkata");

// Only logged-in users
if (!(isset($_SESSION['user_login']) && $_SESSION['user_login'] == true)) {
    redirect('room.php');
}

// Sanitize input
$data = filteration($_POST);

// Room & User info from session
$room_id = $_SESSION['rooms']['id'];
$user_id = $_SESSION['U_Id'];
$room_price = $_SESSION['rooms']['price'];

$user_name = $_SESSION['U_Name'];
$user_phone = $_SESSION['U_Phone'];
$room_name = $_SESSION['rooms']['name'];

// Booking Dates
$check_in = $data['checkin'];
$check_out = $data['checkout'];

// Calculate number of days
$in_date = new DateTime($check_in);
$out_date = new DateTime($check_out);
$interval = $in_date->diff($out_date);
$days = $interval->days;

if ($days < 1) {
    redirect('room.php');
}

$total_payment = $room_price * $days;
$order_id = "BK_" . random_int(10000, 99999);

// Insert into `booking_order`
$query1 = "INSERT INTO `booking_order`(`user_id`, `room_id`, `check_in`, `check_out`, `order_id`,`booking_status`,`trans_status`,`order_date`,`total_pay`) VALUES (?,?,?,?,?,'booked','success',NOW(),?)";

$result1 = insert($query1,[$user_id,$room_id,$check_in,$check_out,$order_id,$total_payment],'iisssi');

$booking_id = mysqli_insert_id($con);

$query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total_pay`, `user_name`, `phone_num`, `address`) VALUES (?,?,?,?,?,?,?)";

$result2 = insert($query2,[$booking_id,$room_name,$room_price,$total_payment,$user_name,$user_phone,$data['address']],'isidsss');


if ($result1 == 1 && $result2 == 1) {
    // Success, redirect to confirmation page
    redirect("booking_confirmed.php?order_id=$order_id");
} else {
    echo "Booking failed. Try again.";
}
?>
