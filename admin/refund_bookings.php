<?php 
    require('admin_components/essentials.php');
    require('admin_components/db_config.php');
    adminLogin();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Bookings</title>
    <?php require('admin_components/link.php')?>
</head>
<body class="bg-light">

<?php require('admin_components/header.php')?>

<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">Refund Bookings</h3>

            <!-- feature -->
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <div class="text-end mb-4">   
                        <input type="text" oninput="get_bookings(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Type to search.">
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover border" style="min-width: 1200px;">
                            <thead>
                                <tr class="bg-dark text-light">
                                <th scope="col">#</th>
                                <th scope="col">User details</th>
                                <th scope="col">Room details</th>
                                <th scope="col">Bookings details</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="table-data">
                            </tbody>
                        </table>
                    </div>
                </div>                
            </div>          
        </div>
    </div>
</div>

<?php require('admin_components/scripts.php')?>
<script src="admin_scripts/refund_bookings.js"></script>

</body>
</html>