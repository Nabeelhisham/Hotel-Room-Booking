<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <?php require('user_components/link.php'); ?>
    <title><?php echo $settings_r['site_title'] ?> - About</title>
<style>
    .box{
        border-top-color:var(--teal) !important;
    }
</style>
</head>

<body class="bg-light">

<?php require('user_components/header.php'); ?>


<div class="my-5 px-4">
  <h2 class="fw-bold h-font text-center"> ABOUT US</h2>
  <div class="h-line bg-dark"></div>
  <p class="text-center mt-3">
    Welcome to Novotel Your Home Away From Home

At Novotel, we believe that a great stay begins with genuine hospitality, comfort, and personalized service. Nestled in the heart of Vijayawada, our hotel offers the perfect blend of modern luxury and warm ambiance for both business and leisure travelers.
  </p>
</div>


<div class="container">
  <div class="row justify-content-between align-items-center">
    <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
        <h3 class="mb-3">Lorem ipsum dolor sit.</h3>
        <p>
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Rem, error!
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Rem, error!
        </p>
    </div>
    <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
         <img src="images/about/about.jpg" class="w-100">
    </div>
  </div>
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4 px-4">
           <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                <img src="images/about/hotel.svg" width="70px">
                <h4 class="mt-3">100+ Rooms</h4>
           </div>
        </div>
         <div class="col-lg-3 col-md-6 mb-4 px-4">
           <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                <img src="images/about/rating.svg" width="70px">
                <h4 class="mt-3">100+ Reviews</h4>
           </div>
        </div>
         <div class="col-lg-3 col-md-6 mb-4 px-4">
           <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                <img src="images/about/customers.svg" width="70px">
                <h4 class="mt-3">200+ Customers</h4>
           </div>
        </div>
         <div class="col-lg-3 col-md-6 mb-4 px-4">
           <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                <img src="images/about/staff.svg" width="70px">
                <h4 class="mt-3">150+ Staff</h4>
           </div>
        </div>
         
    </div>
</div>


<h3 class="my-5 fw-bold h-front text-center">Management Team</h3>

<div class="container px-4">
     <div class="swiper mySwiper">
    <div class="swiper-wrapper mb-5">

      <?php
        $about_r = selectAll('management_team_details');
        $path = ABOUT_IMG_PATH;

        while($row = mysqli_fetch_assoc($about_r)) {
          echo<<<data
            <div class="swiper-slide bg-white text-center overflow-hidden rounded">
              <img src="$path$row[picture]" class="w-100">
              <h5 class="mt-2">$row[name]</h5>
            </div>
          data;
        }
      ?>
    </div>
    <div class="swiper-pagination"></div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  
  <script>
    var swiper = new Swiper(".mySwiper", {
      
      spaceBetween:40,
      pagination: {
        el: ".swiper-pagination",
      },
      
      breakpoints:{
        320: {
          slidesPerView:1,
        },
         640: {
          slidesPerView:1,
        },
         768: {
          slidesPerView:3,
        },
         1024: {
          slidesPerView:3,
        },
      }
    });
  </script>

<?php require('user_components/footer.php'); ?>

</body>
</html>