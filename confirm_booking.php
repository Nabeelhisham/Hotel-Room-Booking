<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php require('user_components/link.php'); ?>
    <title><?php echo $settings_r['site_title'] ?> Confirm Booking</title>
   
   <style>
   
   </style>

</head>

<body class="bg-light">

<?php require('user_components/header.php'); ?>

<?php

    if(!isset($_GET['id']) || $settings_r['shutdown'] == true ) {
        redirect('room.php');
    }
    else if(!(isset($_SESSION['user_login']) && $_SESSION['user_login'] == true)) {
        redirect('room.php');
    }

    // filter and get room data

    $data = filteration($_GET);
    
    $room_res = select("SELECT * FROM `rooms` WHERE `id`=? AND  `status`=? AND `removed`=?",[$data['id'],1,0],'iii');

    if(mysqli_num_rows($room_res)==0) {
        redirect('room.php');
    }

    $roomdata = mysqli_fetch_assoc($room_res);

    $_SESSION['rooms'] = [
        "id" => $roomdata['id'],
        "name" => $roomdata['name'],
        "price" => $roomdata['price'],
        "payment" => null,
        "available" => false,
    ];

    $user_res = select("SELECT * FROM `user_details` WHERE `id`=? LIMIT 1",[$_SESSION['U_Id']],"i");
    $user_data = mysqli_fetch_assoc($user_res);


?>


<div class="container">
  <div class="row">
    <div class="col-12 my-5 mb-4 px-4">
        <h2 class="fw-bold">Confirm Booking</h2>
        <div style="font-size: 14px;">
            <a href="index.php" class="text-secondary text-decoration-none">Home</a>
            <span class="text-secondary"> > </span>
            <a href="room.php" class="text-secondary text-decoration-none">Rooms</a>
            <span class="text-secondary"> > </span>
            <a href="#" class="text-secondary text-decoration-none">Confirm</a>
        </div>
    </div>

    <div class="col-lg-7 col-md-12 px-4">
        <?php 
            $room_thumb = ROOMS_IMG_PATH."thumbnail.jpg";
            $thumb_q = mysqli_query($con,"SELECT * FROM `room_images` WHERE `room_id` = '$roomdata[id]' AND `thumb` = '1'");


            if(mysqli_num_rows($thumb_q)>0) {
                $thumb_res = mysqli_fetch_assoc($thumb_q);
                $room_thumb = ROOMS_IMG_PATH.$thumb_res['image'];
            }

            echo <<<data

                <div class="card p-3 shadow-sm rounded">
                    <img src="$room_thumb" class="img-fluid rounded mb-3">
                    <h5>$roomdata[name]</h5>
                    <h6>₹$roomdata[price] per night</h6>

                </div>

            data;
        ?>
    </div>

    <div class="col-lg-5 col-md-12 px-4">
        <div class="card mb-4 border-0 shadow-sm rounded-3">
            <div class="card-body">
                <form action="book_now.php" method="POST" id="booking_form">
                    <h6 class="mb-3">Booking Details</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label  class="form-label">Name</label>
                            <input name="name" type="text" value="<?php echo $user_data['name'] ?>" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label  class="form-label">Phone</label>
                            <input name="phone_num" type="number" value="<?php echo $user_data['phone_num']?>" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label  class="form-label">Address</label>
                            <textarea name="address" class="form-control shadow-none mb-3"  rows="1" required><?php echo $user_data['address'] ?></textarea>                
                        </div>
                        <div class="col-md-6 mb-3">
                            <label  class="form-label">Check in</label>
                            <input name="checkin" onchange="check_availability()" type="date" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label  class="form-label">Check out</label>
                            <input name="checkout" onchange="check_availability()" type="date" class="form-control shadow-none" required>
                        </div>
                        <div class="col-12">
                            <div class="spinner-border text-info mb-3 d-none" id="info_loader" role="status">
                             <span class="visually-hidden">Loading...</span>
                            </div>
                            <h6 class="mb-3 text-danger" id="pay_info">Provide check in & check out date</h6>
                            <button name="pay_now" class="btn w-100 text-white custom-bg shadow-none mb-1" disabled>Pay now</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
</div>

<?php require('user_components/footer.php'); ?>
<script>
    let booking_form = document.getElementById('booking_form');
    let info_loader = document.getElementById('info_loader');
    let pay_info = document.getElementById('pay_info');

    function check_availability() {

        let checkin_val = booking_form.elements['checkin'].value;
        let checkout_val = booking_form.elements['checkout'].value;
        booking_form.elements['pay_now'].setAttribute('disabled',true);

        if(checkin_val != '' && checkout_val != '') {

            pay_info.classList.add('d-none');
            pay_info.classList.replace('text-dark','text-danger');
            info_loader.classList.remove('d-none');

            let data = new FormData();

            data.append('check_availability','');
            data.append('check_in',checkin_val);
            data.append('check_out',checkout_val);

            let xhr = new XMLHttpRequest();
            xhr.open("POST","user_ajax/confirm_booking.php",true);

            xhr.onload = function() {
                let data = JSON.parse(this.responseText);
                if(data.status =='check_in_out_equal') {
                    pay_info.innerText = "You cannot check out on same day";
                }
                else if(data.status =='check_out_earlier') {
                    pay_info.innerText = "Check out date earlier than checkout date";
                }
                else if(data.status =='check_in_earlier') {
                    pay_info.innerText = "Check in date earlier than today's date";
                }
                else if(data.status =='unavailable') {
                    pay_info.innerText = "Room not available";
                }
                else {
                    pay_info.innerHTML = "No.of days: "+ data.days+"<br>Total Amount to pay: ₹"+data.payment;
                    pay_info.classList.replace('text-danger','text-dark');
                    booking_form.elements['pay_now'].removeAttribute('disabled');
                }

                pay_info.classList.remove('d-none');
                info_loader.classList.add('d-none');

            }
            xhr.send(data);
        }

    }
</script>

</body>
</html>