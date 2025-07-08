<?php
    require('../admin/admin_components/db_config.php');
    require('../admin/admin_components/essentials.php');
    require("../user_components/sendgrid/sendgrid-php.php");
    
    date_default_timezone_set("Asia/Kolkata");

    function send_mail($uemail,$token,$type) {
        if($type == "email_confirmation"){
            $page = 'email_confirm.php';
            $subject = "Account Verification Link";
            $content = "Confirm Your email";
        }
        else {
            $page = 'index.php';
            $subject = "Account Reset Link";
            $content = "Reset Your account";
        }
        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom(SENDGRID_EMAIL, SENDGRID_NAME);
        $email->setSubject($subject);
        $email->addTo($uemail);
        $email->addContent(
            "text/html", "Click the link to $content: <br>
            <a href='".SITE_URL."$page?$type&email=$uemail&token=$token"."'>
                CLICK ME
            </a>
            "
        );

        $sendgrid = new \SendGrid(SENDGRID_API_KEY);

            if($sendgrid->send($email)){
            return 1;
        }
        else {
            return 0;
        }
    }

    if(isset($_POST['register'])) {
        $data = filteration($_POST);

        // mathc and confirm pass
        if($data['password'] != $data['confirm_pass']) {
            echo 'pass_mismatch';
            exit;
        }

        // chech user exists
        $user_exist = select("SELECT * FROM `user_details` WHERE `email` = ? OR `phone_num` = ? LIMIT 1",[$data['email'],$data['phone_num']],"ss");

        if(mysqli_num_rows($user_exist)!=0) {
            $user_exist_fetch = mysqli_fetch_assoc($user_exist);
            echo ($user_exist_fetch['email'] == $data['email']) ? 'email_already' : 'phone_already';
            exit;
        }

        // upload user image
        $img = uploadUserImg($_FILES['profile']);
        if($img == 'inv_img') {
            echo 'inv_img';
            exit;
        }
        else if($img == 'img_create_failed') {
            echo 'upd_failed';
            exit;
        }

        // send confirmation link
        $token = bin2hex(random_bytes(16));

        if(!send_mail($data['email'],$token,"email_confirmation")) {
            echo 'mail_failed';
            exit;
        }

        $enc_pass = password_hash($data['password'],PASSWORD_BCRYPT);
        $query = "INSERT INTO `user_details` (`name`, `email`, `address`, `phone_num`, `pincode`, `dob`,`password`, `token`,`profile`) VALUES (?,?,?,?,?,?,?,?,?)";

        $values = [$data['name'],$data['email'],$data['address'],$data['phone_num'],$data['pincode'],$data['dob'],$enc_pass,$token,$img];

        if(insert($query,$values,'sssssssss')){
            echo 1;
        } else {
            echo 'ins_failed';
        }
    }

    if(isset($_POST['user_login'])) {
        $data = filteration($_POST);

        $user_exist = select("SELECT * FROM `user_details` WHERE `email` = ? OR `phone_num` = ? LIMIT 1",[$data['email_num'],$data['email_num']],"ss");

        if(mysqli_num_rows($user_exist) == 0) {
            echo 'inv_email_mob';
        }
        else {
            $user_fetch = mysqli_fetch_assoc($user_exist);
            if($user_fetch['is_verified'] == 0) {
                echo 'not_verified';
            }
            else if($user_fetch['status'] == 0) {
                echo 'inactive';
            }
            else {
                if(!password_verify($data['pass'],$user_fetch['password'])) {
                    echo 'invalid_password';
                }
                else {
                    session_start();
                    $_SESSION['user_login'] = true;
                    $_SESSION['U_Id'] = $user_fetch['id'];
                    $_SESSION['U_Name'] = $user_fetch['name'];
                    $_SESSION['U_Pic'] = $user_fetch['profile'];
                    $_SESSION['U_Phone'] = $user_fetch['phone_num'];
                    echo 1;
                }
            }
        }
    }
    
    if(isset($_POST['forgot_pass'])) {
        $data = filteration($_POST);

        $user_exist = select("SELECT * FROM `user_details` WHERE `email` = ? LIMIT 1",[$data['email']],"s");

        if(mysqli_num_rows($user_exist) == 0) {
            echo 'inv_email';
        }
        else {
            $user_fetch = mysqli_fetch_assoc($user_exist);
            if($user_fetch['is_verified'] == 0) {
                echo 'not_verified';
            }
            else if($user_fetch['status'] == 0) {
                echo 'inactive';
            }
            else {
                // send reset email
                $token = bin2hex(random_bytes(16));
                if(!send_mail($data['email'],$token,'account_recovery')) {
                    echo 'mail_failed';
                }
                else {
                    $date = date("Y-m-d");
                    $query = mysqli_query($con,"UPDATE `user_details` SET `token`='$token',`t_expire`='$date' WHERE `id`='$user_fetch[id]'");

                    if($query) {
                        echo 1;
                    }                 
                    else {
                        echo 'upd_failed';
                    }
                }
            }
        }
    }

    if(isset($_POST['recover_user'])) {
        $data = filteration($_POST);
        $enc_pass = password_hash($data['pass'],PASSWORD_BCRYPT);

        $query = "UPDATE `user_details` SET `password`=?, `token`=?, `t_expire`=?  WHERE `email`=? AND `token`=?";

        $values = [$enc_pass,null,null,$data['email'],$data['token']];

        if(update($query,$values,'sssss')) {
            echo 1;
        }
        else {
            echo 'failed';
        }
    }
    
?>