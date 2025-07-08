<link rel="stylesheet" href="user_css/common.css">

<!-- footer -->
<div class="container-fluid bg-white mt-5 bgcolor-nav">
    <div class="row">
        <div class="col-lg-4 p-4">
         <h3 class="h-font fw-bold fs-3 mb-2"><?php echo $settings_r['site_title'] ?></h3>
         <p>
          <?php echo $settings_r['site_about'] ?>
          </p>
        </div>
        <div class="col-lg-4 p-4">
          <h5 class=mb-3>Links </h5>
          <a href="index.php" class="d-inline-block mb-2 text-dark text-decoration-none">Home</a><br>
          <a href="room.php" class="d-inline-block mb-2 text-dark text-decoration-none">Room</a><br>
          <a href="facilities.php" class="d-inline-block mb-2 text-dark text-decoration-none">Facilities</a><br>
          <a href="contact.php" class="d-inline-block mb-2 text-dark text-decoration-none">Contact Us</a><br>
          <a href="about.php" class="d-inline-block mb-2 text-dark text-decoration-none">About Us</a>
        </div>
        <div class="col-lg-4 p-4">
           <h5>Follow Us</h5>
           <?php 
            if($contact_r['cd_tw']!=''){
              echo<<<data
              <a href="$contact_r[cd_tw]" class="d-inline-block text-dark text-decoration-none mb-2"><i class="bi bi-twitter-x me-1"></i> X </a><br>
              data;
            }
           ?>
           <a href="<?php echo $contact_r['cd_fb'] ?>" class="d-inline-block text-dark text-decoration-none mb-2"><i class="bi bi-facebook me-1"></i> Facebook</a><br>
           <a href="<?php echo $contact_r['cd_insta'] ?>" class="d-inline-block text-dark text-decoration-none "><i class="bi bi-instagram me-1"></i> Instagrem</a>
        </div>
    </div>
</div>

<h6 class="text-center bg-dark text-white p-3 m-0"> Design and Devloped by PK</h6>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>
  function alert(type,msg,position='body') {
        let alert_class =  (type == 'success') ? 'alert-success' : 'alert-danger';
        let element = document.createElement('div');
        element.innerHTML = `
            <div class="alert ${alert_class} alert-dismissible fade show " role="alert">
                <strong class="me-3">${msg}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        if(position=='body'){
        document.body.append(element);
        element.classList.add('custom-alert');
        }
        else{
            document.getElementById(position).appendChild(element);
        }
        setTimeout(() => {
        element.remove();
        }, 2000);
    } 

  function setActive() {
    navbar = document.getElementById('nav-bar');
    let a_tags = navbar.getElementsByTagName('a');

    for(i=0;i<a_tags.length;i++) {
      let file = a_tags[i].href.split('/').pop();
      let file_name = file.split('.')[0];

      if(document.location.href.indexOf(file_name)>=0) {
        a_tags[i].classList.add('active');
      }
    }
  }

  let register_form = document.getElementById('register-form');
  register_form.addEventListener('submit',(e)=> {
    e.preventDefault();

    let data = new FormData();
    data.append('name',register_form.elements['name'].value);
    data.append('email',register_form.elements['email'].value);
    data.append('phone_num',register_form.elements['phone_num'].value);
    data.append('address',register_form.elements['address'].value);
    data.append('pincode',register_form.elements['pincode'].value);
    data.append('dob',register_form.elements['dob'].value);
    data.append('password',register_form.elements['password'].value);
    data.append('confirm_pass',register_form.elements['confirm_pass'].value);
    data.append('profile',register_form.elements['profile'].files[0]);
    data.append('register','');


    var myModal = document.getElementById('registerModal');
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    let xhr = new XMLHttpRequest();
    xhr.open("POST","user_ajax/login_register.php",true);

    xhr.onload = function() {
      if(this.responseText == 'pass_mismatch') {
        alert('error',"password not matched");
      }
      else if(this.responseText == 'email_already'){
        alert('error',"This Email is Already Registered");       
      }
      else if(this.responseText == 'phone_already'){
        alert('error',"This Phone Number is Already Registered");       
      }
      else if(this.responseText == 'inv_img') {
        alert('error',"Only JPG, WEBP and PNG images are allowed");       
      }
      else if(this.responseText == 'upd_failed') {
        alert('error',"Image Upload Failed");       
      }
      else if(this.responseText == 'mail_failed') {
        alert('error',"Cannot send confirmation mail! server down! try agaain later");       
      }
      else if(this.responseText == 'ins_failed') {
        alert('error',"Registration Failed");       
      }
      else {
        alert('success',"Registration Successfull. confirmation Link Sent to Registered Email.");
        register_form.reset();
      }
    }
    xhr.send(data);
  });

  let login_form = document.getElementById('login-form');
  login_form.addEventListener('submit',(e)=> {
    e.preventDefault();

    let data = new FormData();
    data.append('email_num',login_form.elements['email_num'].value);
    data.append('pass',login_form.elements['pass'].value);
    data.append('user_login','');


    var myModal = document.getElementById('loginModal');
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    let xhr = new XMLHttpRequest();
    xhr.open("POST","user_ajax/login_register.php",true);

    xhr.onload = function() {
      if(this.responseText == 'inv_email_mob') {
        alert('error',"Invalid Email or Mobile Number");
      }
      else if(this.responseText == 'not_verified'){
        alert('error',"This Email is not verified!");       
      }
      else if(this.responseText == 'inactive'){
        alert('error',"Account Inactive! Contact admin");       
      }
      else if(this.responseText == 'invalid_password'){
        alert('error',"Invalid password");       
      }     
      else {
        let fileurl = window.location.href.split('/').pop().split('?').shift();
        if(fileurl == 'room_details.php') {
        window.location = window.location.href;
        }
        else
        {
          window.location = window.location.pathname;
        }
      }
    }
    xhr.send(data);
  });


    let forgot_form = document.getElementById('forgot-form');
    forgot_form.addEventListener('submit',(e)=> {
    e.preventDefault();

    let data = new FormData();
    data.append('email',forgot_form.elements['email'].value);
    data.append('forgot_pass','');


    var myModal = document.getElementById('forgotModal');
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    let xhr = new XMLHttpRequest();
    xhr.open("POST","user_ajax/login_register.php",true);

    xhr.onload = function() {
      if(this.responseText == 'inv_email') {
        alert('error',"Invalid Email");
      }
      else if(this.responseText == 'not_verified'){
        alert('error',"This Email is not verified!");       
      }
      else if(this.responseText == 'inactive'){
        alert('error',"Account Inactive! Contact admin");       
      }
      else if(this.responseText == 'mail_failed'){
        alert('error',"Cannot Send mail");       
      }     
      else if(this.responseText == 'upd_failed'){
        alert('error',"Account Recovery Failed");       
      }     
      else {
        alert('success',"Reset link sent to email!");
        forgot_form.reset();       
      }
    }
    xhr.send(data);
  });


  function checkLogintoBook(status,room_id) {
    if(status) {
      window.location.href = 'confirm_booking.php?id='+room_id;
    }
    else {
      alert('error','Please Login to book room!');
    }

  }


  setActive();
</script>