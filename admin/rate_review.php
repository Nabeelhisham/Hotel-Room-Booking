<?php 

    require('admin_components/essentials.php');
    require('admin_components/db_config.php');
    adminLogin();


    if(isset($_GET['seen'])) {
        $form_data = filteration($_GET);
        if($form_data['seen']== 'all') {
            $q = "UPDATE `rating_review` SET `seen`=?";
            $values = [1];
            if(update($q,$values,'i')) {
                alert('success','Marked all as read!');
            }
            else {
                alert('error','Operation Failed!');
            }
        }
        else {
            $q = "UPDATE `rating_review` SET `seen`=? WHERE `sl_no`=?";
            $values = [1,$form_data['seen']];
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
            $q = "DELETE FROM `rating_review`";
            if(mysqli_query($con,$q)) {
                alert('success','All Reviews Deleted');
            }
            else {
                alert('error','Operation Failed!');
            }

        }
        else {
            $q = "DELETE FROM `rating_review` WHERE `sl_no`=?";
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
    <title>Ratings and Reviews</title>
    <?php require('admin_components/link.php')?>
</head>
<body class="bg-light">

<?php require('admin_components/header.php')?>

<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">Rating and Reviews</h3>

            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <div class="text-end mb-4">
                        <a href="?seen=all" class="btn btn-dark rounded-pill shadow-none btn-sm"><i class="bi bi-check2-all"></i> Mark all read</a>
                        <a href="?del=all" class="btn btn-danger rounded-pill shadow-none btn-sm"><i class="bi bi-trash3"></i> Delete all</a>
                    </div>
                    <div class="table-responsive-md">
                        <table class="table table-hover border">
                            <thead >
                                <tr class="bg-dark text-light">
                                <th scope="col">Sl_no</th>
                                <th scope="col">Room Name</th>
                                <th scope="col">User Name</th>
                                <th scope="col">Rating</th>
                                <th scope="col" width="30%">Review</th>
                                <th scope="col">Date</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $q = "SELECT rr.*,ud.name AS uname,r.name AS rname FROM `rating_review` rr
                                     INNER JOIN `user_details` ud ON rr.user_id = ud.id
                                     INNER JOIN `rooms` r ON rr.room_id = r.id
                                     ORDER BY `sl_no` DESC ";
 
                                    $data = mysqli_query($con,$q);
                                    $i = 1;
                                     
                                    while($row = mysqli_fetch_assoc(($data))) {
                                        $date = date('d-m-Y',strtotime($row['date_and_time']));

                                        $seen = '';
                                        if($row['seen']!= 1) {
                                            $seen = "<a href='?seen=$row[sl_no]' class ='btn btn-sm rounded-pill btn-primary'>Read</a>";
                                        }

                                        $seen.="<a href='?del=$row[sl_no]' class ='btn btn-sm rounded-pill btn-danger'>Delete</a>";
                                    
                                        echo<<<query
                                            <tr>
                                                <td>$i</td>
                                                <td>$row[rname]</td>
                                                <td>$row[uname]</td>
                                                <td>$row[rating]</td>
                                                <td>$row[review]</td>
                                                <td>$date</td>
                                                <td>$seen</td>
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