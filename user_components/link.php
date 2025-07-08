<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Merienda:wght@400;700&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Merienda:wght@400;700&family=Poppins:wght@400;500&display=swap" rel="stylesheet">

<link rel="stylesheet" href="user_css/common.css"> 


<?php
  session_start();
  date_default_timezone_set("Asia/Kolkata");


  require('admin/admin_components/db_config.php');
  require('admin/admin_components/essentials.php');

  $contact_sql = "SELECT * FROM `admin_contact_details` WHERE `sl_no`=?";
  $settings_sql = "SELECT * FROM `admin_settings` WHERE `sl_no`=?";
  $values = [1];
  $contact_r =  mysqli_fetch_assoc(select($contact_sql,$values,'i'));
  $settings_r =  mysqli_fetch_assoc(select($settings_sql,$values,'i'));

  if($settings_r['shutdown']) {
    echo<<<alertbar
      <div class='bg-danger text-center p-2 fw-bold'>
        Bookings are temporarily closed! Come back Again
      </div>
    alertbar;

  }
?>