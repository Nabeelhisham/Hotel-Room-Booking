<?php 

    require('admin_components/essentials.php');
    adminLogin();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Carousel</title>
    <?php require('admin_components/link.php')?>
</head>
<body class="bg-light">

<?php require('admin_components/header.php')?>

<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">Carousel</h3>

            <!-- Carousel settings -->
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="card-title m-0">Images</h5>
                        <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#carousel-section">
                        <i class="bi bi-person-plus"></i>Add
                        </button>
                    </div>
                    <div class="row" id="carousel_data">
                        
                    </div>
                </div>
            </div>

            <!-- Carousel modal-->
            <div class="modal fade" id="carousel-section" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                <form id="carousel_section_form">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title">Add Image</h5>
                        </div>
                    <div class="modal-body">
                        <div class="mb-3">
                        <label  class="form-label fw-bold">Carousel Image</label>
                        <input type="file" name="carousel_pic" id="carousel_pic_inp" accept=".jpg, .png, .webp, .jpeg" class="form-control shadow-none" required>
                        </div>
                    </div>
                        <div class="modal-footer">
                        <button type="button" onclick="carousel_pic.value=''" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">Submit</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require('admin_components/scripts.php')?>
<script src="admin_scripts/carousel.js"></script>

</body>
</html>