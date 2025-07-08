<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php require('user_components/link.php'); ?>
    <title><?php echo $settings_r['site_title'] ?> - Contact</title>
   
</head>

<body class="bg-light">

<?php require('user_components/header.php'); ?>


<div class="my-5 px-4">
  <h2 class="fw-bold h-font text-center"> CONTACT US</h2>
  <div class="h-line bg-dark"></div>
  <p class="text-center mt-3">
    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Praesentium nobis voluptatibus officiis, rem porro rerum nisi tenetur provident nihil voluptatem.
  </p>
</div>

<div class="container">
  <div class="row">
    <div class="col-lg-6 col-md-6 mb-5 px-4">
        <div class="bg-white rounded shadow p-4 ">
          <iframe class="w-100 rounded mb-4" height="320" src="<?php echo $contact_r['cd_iframe'] ?>"   loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          <h5>Address</h5>
          <a href="<?php echo $contact_r['cd_map'] ?>" target="_blank" class="d-inline-block text-decoration-none text-dark mb-2">
             <i class="bi bi-geo-alt-fill"></i> <?php echo $contact_r['cd_address'] ?>
          </a>
           <h5 class="mt-4">call us</h5>
          <a href="tel: +<?php echo $contact_r['phone_no_1'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
           <i class="bi bi-telephone-fill"></i>+<?php echo $contact_r['phone_no_1'] ?></a><br>

          <?php
            if($contact_r['phone_no_2']!='') {
              echo<<<data
                <a href="tel: +$contact_r[phone_no_2]" class="d-inline-block mb-2 text-decoration-none text-dark">
                <i class="bi bi-telephone-fill"></i>+$contact_r[phone_no_2]</a>
              data;
            } 
          ?>
            <h5 class="mt-4">Email</h5>
            <a href="<?php echo $contact_r['cd_email'] ?>" class="d-inline-block text-decoration-none text-dark" >
               <i class="bi bi-envelope"></i> <?php echo $contact_r['cd_email'] ?>
            </a>
            <h5 class="mt-4">Follow us</h5>
            <?php 
              if($contact_r['cd_tw']!=''){
                echo<<<data
                  <a href="$contact_r[cd_tw]" class="d-inline-block  fs-5 me-2 text-dark">
                  <i class="bi bi-twitter-x me-1"></i></a>
                data;
              }
            ?>
            <a href="<?php echo $contact_r['cd_fb'] ?>" class="d-inline-block  fs-5 me-2 text-dark">
            <i class="bi bi-facebook me-1"></i></a>         
            <a href="<?php echo $contact_r['cd_insta'] ?>" class="d-inline-block fs-5  text-dark ">         
            <i class="bi bi-instagram me-1"></i></a>
        </div>
    </div>
      <div class="col-lg-4 col-md-6 px-4">
         <div class="bg-white rounded shadow p-4 ">
           <form method="POST">
              <h5>Send a Message</h5>
              <div class="mt-3">
                    <label class="form-label" style="font-weight:500;">Name</label>
                    <input name="ur_name" type="text" class="form-control shadow-none" required >
              </div>
              <div class="mt-3">
                    <label  class="form-label" style="font-weight:500;">Email</label>
                    <input name="ur_email" type="email" class="form-control shadow-none" required >
              </div>
              <div class="mt-3">
                    <label  class="form-label" style="font-weight:500;">subject</label>
                    <input name="ur_subject" type="text" class="form-control shadow-none" required >
              </div>
              <div class="mt-3">
                    <label  class="form-label" style="font-weight:500;">Message</label>
                    <textarea name="ur_message" type="email" class="form-control shadow-none" rows="5" style="resize:none;" required ></textarea>
              </div>
              <button type="submit" name="ur_send" class="btn text-white custom-bg mt-3">SEND</button>
           </form>
         </div>
      </div>
  </div>
</div>

<?php 
  if(isset($_POST['ur_send'])) {
    $form_data = filteration($_POST);

    $q = "INSERT INTO `user_reviews`(`ur_name`, `ur_email`, `ur_subject`, `ur_message`) VALUES (?,?,?,?)";
    $values = [$form_data['ur_name'],$form_data['ur_email'],$form_data['ur_subject'],$form_data['ur_message']];


    $res = insert($q,$values,'ssss');
    if($res==1) {
      alert('success','Review Sent!');
    }
    else {
      alert('error','Server Down!');
    }  
  }
?>
<?php require('user_components/footer.php'); ?>

</body>
</html>