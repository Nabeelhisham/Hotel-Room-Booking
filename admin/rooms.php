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
    <title>rooms -Settings</title>
    <?php require('admin_components/link.php')?>
</head>
<body class="bg-light">

<?php require('admin_components/header.php')?>

<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">ROOMS</h3>

            <!-- feature -->
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <div class="text-end mb-4">
                       
                        <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#add-room">
                        <i class="bi bi-person-plus"></i>Add
                        </button>
                    </div>
                    
                    <div class="table-responsive-lg" style="height: 450px; overflow-y: scroll;">
                        <table class="table table-hover border text-center">
                            <thead>
                                <tr class="bg-dark text-light">
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Area</th>
                                <th scope="col">Guests</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="room-data">
                            </tbody>
                        </table>
                    </div>
                </div>                
            </div>          
        </div>
    </div>
</div>

            <!-- Add room modal-->
            <div class="modal fade" id="add-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                <form id="add_room_form" autocomplete="off">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title">Add Room</h5>
                        </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                            <label  class="form-label fw-sbold">Name</label>
                            <input type="text" name="name" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                            <label  class="form-label fw-sbold">Area</label>
                            <input type="number" min="1" name="area" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                            <label  class="form-label fw-sbold">Price</label>
                            <input type="number" min="1" name="price" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                            <label  class="form-label fw-sbold">Quantity</label>
                            <input type="number" min="1" name="quantity" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                            <label  class="form-label fw-sbold">Adult (Max.)</label>
                            <input type="number" min="1" name="adult" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                            <label  class="form-label fw-sbold">Children (Max.)</label>
                            <input type="number" min="1" name="children" class="form-control shadow-none" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label  class="form-label fw-bold">Features</label>
                                <div class="row">
                                    <?php
                                    $res = selectAll('hotel_features');
                                    while($opt= mysqli_fetch_assoc($res)){
                                        echo"
                                        <div class='col-md-3'>
                                        <label>
                                            <input type='checkbox' name='features' value='$opt[id]' class='form-check-input shadow-none'>
                                            $opt[name]
                                            </label>
                                        </div>

                                        ";
                                        
                                
                                    }
                                    ?>
                                </div>
                                
                            </div>
                             <div class="col-12 mb-3">
                                <label  class="form-label fw-sbold">Facilities</label>
                                <div class="row">
                                    <?php
                                    $res = selectAll('hotel_facilities');
                                    while($opt= mysqli_fetch_assoc($res)){
                                        echo"
                                        <div class='col-md-3'>
                                        <label>
                                            <input type='checkbox' name='facilities' value='$opt[id]' class='form-check-input shadow-none'>
                                            $opt[name]
                                            </label>
                                        </div>

                                        ";
                                        
                                
                                    }
                                    ?>
                                </div>
                                
                            </div>
                            <div class="col-12 mb-3">
                                    <label  class="form-label fw-bold">Description</label>
                                    <textarea name="desc" rows="4" class="form-control shadow-none" required></textarea>
                            </div>
                        </div>
                    

                    </div>
                        <div class="modal-footer">
                        <button type="reset"  class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">Submit</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>




<!-- edit room modal-->
            <div class="modal fade" id="edit-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                <form id="edit_room_form" autocomplete="off">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title">Edit Room</h5>
                        </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                            <label  class="form-label fw-sbold">Name</label>
                            <input type="text" name="name" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                            <label  class="form-label fw-sbold">Area</label>
                            <input type="number" min="1" name="area" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                            <label  class="form-label fw-sbold">Price</label>
                            <input type="number" min="1" name="price" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                            <label  class="form-label fw-sbold">Quantity</label>
                            <input type="number" min="1" name="quantity" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                            <label  class="form-label fw-sbold">Adult (Max.)</label>
                            <input type="number" min="1" name="adult" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                            <label  class="form-label fw-sbold">Children (Max.)</label>
                            <input type="number" min="1" name="children" class="form-control shadow-none" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label  class="form-label fw-bold">Features</label>
                                <div class="row">
                                    <?php
                                    $res = selectAll('hotel_features');
                                    while($opt= mysqli_fetch_assoc($res)){
                                        echo"
                                        <div class='col-md-3'>
                                        <label>
                                            <input type='checkbox' name='features' value='$opt[id]' class='form-check-input shadow-none'>
                                            $opt[name]
                                            </label>
                                        </div>

                                        ";
                                        
                                
                                    }
                                    ?>
                                </div>
                                
                            </div>
                             <div class="col-12 mb-3">
                                <label  class="form-label fw-sbold">Facilities</label>
                                <div class="row">
                                    <?php
                                    $res = selectAll('hotel_facilities');
                                    while($opt= mysqli_fetch_assoc($res)){
                                        echo"
                                        <div class='col-md-3'>
                                        <label>
                                            <input type='checkbox' name='facilities' value='$opt[id]' class='form-check-input shadow-none'>
                                            $opt[name]
                                            </label>
                                        </div>

                                        ";
                                        
                                
                                    }
                                    ?>
                                </div>
                                
                            </div>
                            <div class="col-12 mb-3">
                                    <label  class="form-label fw-bold">Description</label>
                                    <textarea name="desc" rows="4" class="form-control shadow-none" required></textarea>
                            </div>
                            <input type="hidden" name="room_id">
                        </div>
                    

                    </div>
                        <div class="modal-footer">
                        <button type="reset"  class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">Submit</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>



<!-- Manage room images modal -->

<div class="modal fade" id="room-images" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Room Name</h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="image-alert">

        </div>
        <div class="border-bottom border-3 pb-3 mb-3">
            <form id="add_image_form">
                <label  class="form-label fw-bold">Add Image</label>
                <input type="file" name="image" accept=".jpg, .png, .webp, .jpeg" class="form-control shadow-none mb-3" required>
                <button type="submit" class="btn custom-bg text-white shadow-none">Add</button>
                <input type="hidden" name="room_id">
            </form>
        </div>
           <div class="table-responsive-lg" style="height: 350px; overflow-y: scroll;">
                        <table class="table table-hover border text-center">
                            <thead>
                                <tr class="bg-dark text-light sticky-top">
                                <th scope="col" width="60%">Image</th>
                                <th scope="col">Thumb</th>
                                <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody id="room-image-data">
                            </tbody>
                        </table>
                    </div>

      </div>
    </div>
  </div>
</div>


<?php require('admin_components/scripts.php')?>
<script src="admin_scripts/rooms.js"></script>

</body>
</html>