<?php
    require('../admin_components/db_config.php');
    require('../admin_components/essentials.php');
    adminLogin();

    if(isset($_POST['booking_analytics'])) {
        $form_data = filteration($_POST);

        $condition="";

        if($form_data['period'] == 1) {
            $condition = "WHERE order_date BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
        }
        else if($form_data['period'] == 2) {
            $condition = "WHERE order_date BETWEEN NOW() - INTERVAL 90 DAY AND NOW()";
        }
        else if($form_data['period'] == 3) {
            $condition = "WHERE order_date BETWEEN NOW() - INTERVAL 1 YEAR AND NOW()";
        }

        $result = mysqli_fetch_assoc(mysqli_query($con,"SELECT
        COUNT(booking_id) AS `total_bookings`,
        SUM(total_pay) AS `total_amt`,
        COUNT(CASE WHEN booking_status='booked' AND arrival=1 THEN 1 END) AS `active_bookings`,
        SUM(CASE WHEN booking_status='booked' AND arrival=1 THEN total_pay END) AS `active_amt`,
        COUNT(CASE WHEN booking_status='cancelled' AND refund=1 THEN 1 END) AS `cancelled_bookings`,
        SUM(CASE WHEN booking_status='cancelled' AND refund=1 THEN total_pay END) AS `cancelled_amt`
        FROM `booking_order` $condition "));

        $output = json_encode($result);

        echo $output;

    }


   if(isset($_POST['user_analytics'])) {
    $form_data = filteration($_POST);

    // Date conditions
    $user_cond = $query_cond = $review_cond = "";

    if($form_data['period'] == 1) {
        $user_cond = "WHERE date_and_time BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
        $query_cond = "WHERE ur_seen BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
        $review_cond = "WHERE date_and_time BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
    }
    else if($form_data['period'] == 2) {
        $user_cond = "WHERE date_and_time BETWEEN NOW() - INTERVAL 90 DAY AND NOW()";
        $query_cond = "WHERE ur_seen BETWEEN NOW() - INTERVAL 90 DAY AND NOW()";
        $review_cond = "WHERE date_and_time BETWEEN NOW() - INTERVAL 90 DAY AND NOW()";
    }
    else if($form_data['period'] == 3) {
        $user_cond = "WHERE date_and_time BETWEEN NOW() - INTERVAL 1 YEAR AND NOW()";
        $query_cond = "WHERE ur_seen BETWEEN NOW() - INTERVAL 1 YEAR AND NOW()";
        $review_cond = "WHERE date_and_time BETWEEN NOW() - INTERVAL 1 YEAR AND NOW()";
    }
    // else (All time): leave conditions blank

    // Fetch counts
    $total_reviews = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(sl_no) AS `count` FROM `rating_review` $review_cond"));

    $total_queries = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(sl_no) AS `count` FROM `user_reviews` $query_cond"));

    $total_new_reg = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(id) AS `count` FROM `user_details` $user_cond"));

    $output = [
        'total_queries' => $total_queries['count'],
        'total_reviews' => $total_reviews['count'],
        'total_new_reg' => $total_new_reg['count']
    ];

    echo json_encode($output);
}






































 
   

    if(isset($_POST['remove_user'])){
         $frm_data = filteration($_POST);
         $res = delete("DELETE FROM `user_details` WHERE `id`=? AND `is_verified`=?",[$frm_data['user_id'],0],'ii');

        if($res){
            echo 1;
        }
        else{
            echo 0;
        }
    }

    if(isset($_POST['search_user']))
    {  
        $form_data = filteration($_POST);
        $query = "SELECT * FROM `user_details` WHERE `name` LIKE ?";

        $res = select($query,["%$form_data[name]%"],'s');
        $i=1;
        $path = USERS_IMG_PATH;      
        $data ="";

        while($row = mysqli_fetch_assoc($res)){
        $del_btn ="<button type='button' onclick='remove_user($row[id])' class='btn btn-danger shadow-none'>
            <i class='bi bi-trash'></i>
            </button>";

        $verified = "<span class='badge bg-warning'><i class='bi bi-x-lg'></i></span>";

        if($row['is_verified']) {
        $verified = "<span class='badge bg-success'><i class='bi bi-check-lg'></i></span>";
        $del_btn = "";
        }

        $status ="<button onclick='toggle_status($row[id],0)' class='btn btn-dark btn-sm shadow-none'> active </button>";

        if(!$row['status']){
        $status ="<button onclick='toggle_status($row[id],1)' class='btn btn-danger btn-sm shadow-none'> inactive </button>";
        }

        $date = date("d-m-Y",strtotime($row['date_and_time']));

        $data .="
        <tr>
            <td>$i</td>
            <td>
                <img src='$path$row[profile]' width='55px'>
                <br>
                $row[name]
            </td>
            <td>$row[email]</td>
            <td>$row[phone_num]</td>
            <td>$row[address] | $row[pincode]</td>
            <td>$row[dob]</td>
            <td>$verified</td>
            <td>$status</td>
            <td>$date</td>
            <td>$del_btn</td>
        </tr>
         ";
         $i++;
       }
        echo $data;
    }





?>

