<?php 

    require('../admin_components/db_config.php');
    require('../admin_components/essentials.php');
    adminLogin();

    if(isset($_POST['add_feature'])) {
        $form_data = filteration($_POST);
        $q = "INSERT INTO `hotel_features` (`name`) VALUES (?)";
        $values = [$form_data['name']];
        $res = insert($q,$values,'s');
        echo $res;

    }

    if(isset($_POST['get_features_data'])) {
        $res = selectAll('hotel_features');
        $i = 1;
        while($row = mysqli_fetch_assoc($res)) {
            echo <<< data
                <tr>
                    <td>$i</td>
                    <td>$row[name]</td>
                    <td>
                    <button type="button" onclick="del_feature_data($row[id])" class="btn btn-danger btn-sm shadow-none">
                                <i class="bi bi-trash3"></i>Delete
                    </button>
                    </td>
                </tr>
            data;
            $i++;
        }
    }

    if(isset($_POST['del_feature_data'])) {

        $form_data = filteration($_POST);
        $values = [$form_data['del_feature_data']];
        $check_q = select('SELECT * FROM `room_features` WHERE `features_id` =?',[$form_data['del_feature_data']],'i');
        if(mysqli_num_rows($check_q)==0){
        $q = "DELETE FROM `hotel_features` WHERE `id`=?";
        $res = delete($q,$values,'i');
        echo $res;  
        }
        else{
            echo 'room_added';
        }


    }

    if(isset($_POST['add_facility'])) {
        $form_data = filteration($_POST);
        $img_r = uploadSVG($_FILES['icon'],FACILITIES_FOLDER);

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
            $q = "INSERT INTO `hotel_facilities`(`icon`, `name`, `description`) VALUES (?,?,?)";
            $values = [$img_r,$form_data['name'],$form_data['description']];
            $res = insert($q,$values,'sss');
            echo $res;
        }
    }

    if(isset($_POST['get_facilities_data'])) {
        $res = selectAll('hotel_facilities');
        $i = 1;
        $path = FACILITIES_IMG_PATH;
        while($row = mysqli_fetch_assoc($res)) {
            echo <<< data
                <tr class='align-middle'>
                    <td>$i</td>
                    <td><img src="$path$row[icon]" width=30px"></td>
                    <td>$row[name]</td>
                    <td>$row[description]</td>
                    <td>
                    <button type="button" onclick="del_facility_data($row[id])" class="btn btn-danger btn-sm shadow-none">
                        <i class="bi bi-trash3"></i>Delete
                    </button>
                    </td>
                </tr>
            data;
            $i++;
        }
    }

    if(isset($_POST['del_facility_data'])) {

        $form_data = filteration($_POST);
        $values = [$form_data['del_facility_data']];
         $check_q = select('SELECT * FROM `room_facilities` WHERE `facilities_id` =?',[$form_data['del_facility_data']],'i');

        if(mysqli_num_rows(($check_q))==0){

        
        $sel_q = "SELECT * FROM `hotel_facilities` WHERE `id`=?";
        $res = select($sel_q,$values,'i');
        $img = mysqli_fetch_assoc($res);

        if(deleteIMG($img['icon'],FACILITIES_FOLDER)){
            $q = "DELETE FROM `hotel_facilities` WHERE `id`=?";
            $res = delete($q,$values,'i');
            echo $res;
            
        }
        else {
            echo 0;
        }
    }

    else{
        echo 'room_added';
    }
    }
?>