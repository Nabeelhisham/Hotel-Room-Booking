<?php 

    require('../admin_components/db_config.php');
    require('../admin_components/essentials.php');
    adminLogin();

    if(isset($_POST['get_general'])) {
        $q = "SELECT * FROM `admin_settings` WHERE `sl_no`=?";
        $values =[1];
        $res = select($q,$values,"i");
        $data = mysqli_fetch_assoc($res);
        $json_data = json_encode($data);
        echo $json_data;
    }


    if(isset($_POST['update_general'])) {
        $form_data = filteration($_POST);
        $q = "UPDATE `admin_settings` SET `site_title`=?, `site_about`=?  WHERE `sl_no`=?";
        $values = [$form_data['site_title'],$form_data['site_about'],1];
        $res = update($q,$values,'ssi');
        echo $res;
    }


    if(isset($_POST['update_shutdown'])) {
        
        $form_data = ($_POST['update_shutdown']==0) ? 1 : 0;
        $q = "UPDATE `admin_settings` SET `shutdown`=?  WHERE `sl_no`=?";
        $values = [$form_data,1];
        $res = update($q,$values,'ii');
        echo $res;
    }

    if(isset($_POST['get_contacts'])) {
        $q = "SELECT * FROM `admin_contact_details` WHERE `sl_no`=?";
        $values =[1];
        $res = select($q,$values,"i");
        $data = mysqli_fetch_assoc($res);
        $json_data = json_encode($data);
        echo $json_data;
    }

    if(isset($_POST['update_contacts'])) {

        $form_data = filteration($_POST);
        $q = "UPDATE `admin_contact_details` SET `cd_address`=?, `cd_map`=?, `phone_no_1`=?, `phone_no_2`=?, `cd_email`=?, `cd_fb`=?, `cd_insta`=?, `cd_tw`=?, `cd_iframe`=? WHERE `sl_no`=?";
        $values = [$form_data['cd_address'],$form_data['cd_map'],$form_data['phone_no_1'],$form_data['phone_no_2'],$form_data['cd_email'],$form_data['cd_fb'],$form_data['cd_insta'],$form_data['cd_tw'],$form_data['cd_iframe'],1];
        $res = update($q,$values,'sssssssssi');
        echo $res;
    }

    if(isset($_POST['add_team_member'])) {
        $form_data = filteration($_POST);
        $img_r = uploadImage($_FILES['picture'],ABOUT_FOLDER);

        if($img_r == 'inv_img') {
            echo $img_r;
        }
        else if($img_r == 'inv_size') {
            echo $img_r;
        }
        else if($img_r == 'upd_failed') {
            echo $img_r;
        }
        else {
            $q = "INSERT INTO `management_team_details` (`name`, `picture`) VALUES (?,?)";
            $values = [$form_data['name'],$img_r];
            $res = insert($q,$values,'ss');
            echo $res;
        }
    }

    if(isset($_POST['get_team_members'])) {
        $res = selectAll('management_team_details');
        while($row = mysqli_fetch_assoc($res)) {
            $path = ABOUT_IMG_PATH;
            echo <<< data
                <div class="col-md-2 mb-3">
                    <div class="card bg-dark text-white">
                        <img src="$path$row[picture]" class="card-img">
                        <div class="card-img-overlay">
                            <button type="button" onclick="del_team_member($row[sl_no])" class="btn btn-danger btn-sm shadow-none">
                                <i class="bi bi-trash3"></i>Delete
                            </button>
                        </div>
                        <p class="card-text text-center px-3 py-2">$row[name]</p>
                    </div>
                </div>
            data;
        }
    }

    if(isset($_POST['del_team_member'])) {
        $form_data = filteration($_POST);
        $values = [$form_data['del_team_member']];

        $sel_q = "SELECT * FROM `management_team_details` WHERE `sl_no`=?";
        $res = select($sel_q,$values,'i');
        $img = mysqli_fetch_assoc($res);

        if(deleteIMG($img['picture'],ABOUT_FOLDER)){
            $q = "DELETE FROM `management_team_details` WHERE `sl_no`=?";
            $res = delete($q,$values,'i');
            echo $res;
            
        }
        else {
            echo 0;
        }
        

    }
?>