<?php
require('user_components/link.php');
require('user_components/header.php');

if (!isset($_GET['order_id'])) {
    redirect('room.php');
}

$order_id = $_GET['order_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Confirmed</title>
</head>
<body class="bg-light">
    <div class="container my-5">
        <div class="card p-4 shadow-sm">
            <h3 class="text-success">Booking Confirmed!</h3>
            <p>Your booking ID is <strong><?php echo $order_id; ?></strong>.</p>
            <a href="bookings.php" class="btn btn-primary">Back to Bookings</a>
        </div>
    </div>
<?php require('user_components/footer.php'); ?>
</body>
</html>
