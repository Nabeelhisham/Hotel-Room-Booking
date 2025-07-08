<?php 

    require('../admin_components/db_config.php');
    require('../admin_components/essentials.php');
    adminLogin();

    if(isset($_POST['add_carousel_img'])) {
        $img_r = uploadImage($_FILES['picture'],CAROUSEL_FOLDER);

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
            $q = "INSERT INTO `carousel_images`(`img`) VALUES (?)";
            $values = [$img_r];
            $res = insert($q,$values,'s');
            echo $res;
        }
    }

    if(isset($_POST['get_carousel_img'])) {
        $res = selectAll('carousel_images');
        while($row = mysqli_fetch_assoc($res)) {
            $path = CAROUSEL_IMG_PATH;
            echo <<< data
                <div class="col-md-2 mb-3">
                    <div class="card bg-dark text-white">
                        <img src="$path$row[img]" class="card-img">
                        <div class="card-img-overlay">
                            <button type="button" onclick="del_carousel_img($row[sl_no])" class="btn btn-danger btn-sm shadow-none">
                                <i class="bi bi-trash3"></i>Delete
                            </button>
                        </div>
                    </div>
                </div>
            data;
        }
    }

    if(isset($_POST['del_carousel_img'])) {
        $form_data = filteration($_POST);
        $values = [$form_data['del_carousel_img']];

        $sel_q = "SELECT * FROM `carousel_images` WHERE `sl_no`=?";
        $res = select($sel_q,$values,'i');
        $img = mysqli_fetch_assoc($res);

        if(deleteIMG($img['img'],CAROUSEL_FOLDER)){
            $q = "DELETE FROM `carousel_images` WHERE `sl_no`=?";
            $res = delete($q,$values,'i');
            echo $res;
            
        }
        else {
            echo 0;
        }
        

    }
?>