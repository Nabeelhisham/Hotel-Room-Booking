<?php 

    require('admin_components/essentials.php');
    require('admin_components/db_config.php');
    adminLogin();


    if(isset($_GET['ur_seen'])) {
        $form_data = filteration($_GET);
        if($form_data['ur_seen']== 'all') {
            $q = "UPDATE `user_reviews` SET `ur_seen`=?";
            $values = [1];
            if(update($q,$values,'i')) {
                alert('success','Marked all as read!');
            }
            else {
                alert('error','Operation Failed!');
            }
        }
        else {
            $q = "UPDATE `user_reviews` SET `ur_seen`=? WHERE `sl_no`=?";
            $values = [1,$form_data['ur_seen']];
            if(update($q,$values,'ii')) {
                alert('success','Marked as read!');
            }
            else {
                alert('error','Operation Failed!');
            }
        }
    }

    if(isset($_GET['del'])) {
        $form_data = filteration($_GET);
        if($form_data['del']== 'all') {
            $q = "DELETE FROM `user_reviews`";
            if(mysqli_query($con,$q)) {
                alert('success','All Reviews Deleted');
            }
            else {
                alert('error','Operation Failed!');
            }

        }
        else {
            $q = "DELETE FROM `user_reviews` WHERE `sl_no`=?";
            $values = [$form_data['del']];
            if(delete($q,$values,'i')) {
                alert('success','Review Deleted');
            }
            else {
                alert('error','Operation Failed!');
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Review Settings</title>
    <?php require('admin_components/link.php')?>
</head>
<body class="bg-light">

<?php require('admin_components/header.php')?>

<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">User Reviews</h3>

            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <div class="text-end mb-4">
                        <a href="?ur_seen=all" class="btn btn-dark rounded-pill shadow-none btn-sm"><i class="bi bi-check2-all"></i> Mark all read</a>
                        <a href="?del=all" class="btn btn-danger rounded-pill shadow-none btn-sm"><i class="bi bi-trash3"></i> Delete all</a>
                    </div>
                    <div class="table-responsive-md" style="height: 500px; overflow-y: scroll;">
                        <table class="table table-hover border">
                            <thead class="sticky-top ">
                                <tr class="bg-dark text-light">
                                <th scope="col">Sl_no</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col" width="20%">Subject</th>
                                <th scope="col" width="20%">Message</th>
                                <th scope="col">Date</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $q = "SELECT * FROM `user_reviews` ORDER BY `sl_no` DESC ";
                                    $data = mysqli_query($con,$q);
                                    $i = 1;
                                    while($row = mysqli_fetch_assoc(($data))) {
                                        $date = date('d-m-Y',strtotime($row['ur_date']));
                                        $ur_seen = '';
                                        if($row['ur_seen']!= 1) {
                                            $ur_seen = "<a href='?ur_seen=$row[sl_no]' class ='btn btn-sm rounded-pill btn-primary'>Read</a>";
                                        }

                                        $ur_seen.="<a href='?del=$row[sl_no]' class ='btn btn-sm rounded-pill btn-danger'>Delete</a>";
                                    
                                        echo<<<query
                                            <tr>
                                                <td>$i</td>
                                                <td>$row[ur_name]</td>
                                                <td>$row[ur_email]</td>
                                                <td>$row[ur_subject]</td>
                                                <td>$row[ur_message]</td>
                                                <td>$date</td>
                                                <td>$ur_seen</td>
                                            <tr>
                                        query;
                                        $i++;
                                    }
                                
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>

<?php require('admin_components/scripts.php')?>

</body>
</html>