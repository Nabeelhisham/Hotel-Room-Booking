<?php 

    require('admin_components/essentials.php');
    adminLogin();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Setiings</title>
    <?php require('admin_components/link.php')?>
</head>
<body class="bg-light">

<?php require('admin_components/header.php')?>

<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">SETTINGS</h3>

            <!-- general settings -->
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="card-title m-0">General Settings</h5>
                        <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#general-s">
                        <i class="bi bi-pencil-square"></i>Edit
                        </button>
                    </div>
                    <h6 class="card-subtitle mb-1 fw-bold">Site Title</h6>
                    <p class="card-text" id="site_title"></p>
                    <h6 class="card-subtitle mb-1 fw-bold">About Us</h6>
                    <p class="card-text" id="site_about"></p>  
                </div>
            </div>

            <!-- general settings modal-->
            <div class="modal fade" id="general-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">

                <form id="general_settings_form">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title">General Settings</h5>
                        </div>
                    <div class="modal-body">
                        <div class="mb-3">
                        <label  class="form-label fw-sbold">Site Title</label>
                        <input type="text" name="site_title" id="site_title_inp" class="form-control shadow-none" required>
                        </div>
                        <div class="mb-3">
                        <label  class="form-label fw-bold">About Us</label>
                        <textarea name="site_about" id="site_about_inp" class="form-control shadow-none mb-3"  rows="6" required></textarea>                
                        </div>
                    </div>
                        <div class="modal-footer">
                        <button type="button" onclick="site_title.value = general_data.site_title , site_about.value = general_data.site_about" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">Submit</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>

            <!-- Shutdown Section -->
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="card-title m-0">Shutdown Website</h5>

                        <div class="form-check form-switch">
                            <form>
                                <input onchange="update_shutdown(this.value)" class="form-check-input" type="checkbox" id="shutdown-toggle">
                            </form>
                        </div>
                    </div>
 
                    <p class="card-text">
                        No customers will be allowed to book hotel room , when shutdown is turned on.
                    </p>  
                </div>
            </div>

            <!-- Contact Details -->
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="card-title m-0">Contacts Settings</h5>
                        <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#contacts-section">
                        <i class="bi bi-pencil-square"></i>Edit
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <h6 class="card-subtitle mb-1 fw-bold">Address</h6>
                                <p class="card-text" id="cd_address"></p>
                            </div>
                            <div class="mb-4">
                                <h6 class="card-subtitle mb-1 fw-bold">Google Map</h6>
                                <p class="card-text" id="cd_map"></p>
                            </div>
                            <div class="mb-4">
                                <h6 class="card-subtitle mb-1 fw-bold">Phone Numbers</h6>
                                <p class="card-text mb-1">
                                <i class="bi bi-telephone-fill"></i>
                                <span id="phone_no_1"></span>
                                </p>
                                <p class="card-text">
                                <i class="bi bi-telephone-fill"></i>
                                <span id="phone_no_2"></span>
                                </p>
                            </div>
                            <div class="mb-4">
                                <h6 class="card-subtitle mb-1 fw-bold">E-mail</h6>
                                <p class="card-text" id="cd_email"></p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <h6 class="card-subtitle mb-1 fw-bold">Social Media</h6>
                                <p class="card-text mb-1">
                                <i class="bi bi-facebook me-1"></i>
                                <span id="cd_fb"></span>
                                </p>
                                <p class="card-text mb-1">
                                <i class="bi bi-instagram me-1"></i>
                                <span id="cd_insta"></span>
                                </p>
                                <p class="card-text">
                                <i class="bi bi-twitter-x me-1"></i>
                                <span id="cd_tw"></span>
                                </p>
                            </div>
                            <div class="mb-4">
                                <h6 class="card-subtitle mb-1 fw-bold">iframe</h6>
                                <iframe id="cd_iframe" class="border p-2 w-100" loading="lazy"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contacts Modal -->
            <div class="modal fade" id="contacts-section" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                <form id="contacts_section_form">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title">Contact Settings</h5>
                        </div>
                    <div class="modal-body">
                        <div class="container-fluid p-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                    <label  class="form-label fw-sbold">Address</label>
                                    <input type="text" name="cd_address" id="cd_address_inp" class="form-control shadow-none" required>
                                    </div>
                                    <div class="mb-3">
                                    <label  class="form-label fw-sbold">Google Map</label>
                                    <input type="text" name="cd_map" id="cd_map_inp" class="form-control shadow-none" required>
                                    </div>
                                    <div class="mb-3">
                                    <label  class="form-label fw-sbold">Phone Numbers (with Country Code)</label>
                                        <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-telephone-fill"></i></span>
                                        <input type="number" name="phone_no_1" id="phone_no_1_inp" class="form-control shadow-none" required>
                                        </div>
                                        <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-telephone-fill"></i></span>
                                        <input type="number" name="phone_no_2" id="phone_no_2_inp" class="form-control shadow-none" >
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                    <label  class="form-label fw-sbold">E-mail</label>
                                    <input type="text" name="cd_email" id="cd_email_inp" class="form-control shadow-none" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                    <label  class="form-label fw-sbold">Social Media</label>
                                        <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-facebook"></i></span>
                                        <input type="text" name="cd_fb" id="cd_fb_inp" class="form-control shadow-none" required>
                                        </div>
                                        <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-instagram"></i></span>
                                        <input type="text" name="cd_insta" id="cd_insta_inp" class="form-control shadow-none" required>
                                        </div>
                                        <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-twitter-x"></i></span>
                                        <input type="text" name="cd_tw" id="cd_tw_inp" class="form-control shadow-none" >
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                    <label  class="form-label fw-sbold">iframe</label>
                                    <input type="text" name="cd_iframe" id="cd_iframe_inp" class="form-control shadow-none" required>
                                    </div>
                                </div>
                            </div>
                        </div>                     
                    </div>
                        <div class="modal-footer">
                        <button type="button" onclick="contacts_inp(contacts_data)" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">Submit</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>

            <!-- Management team settings -->
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="card-title m-0">Management Team</h5>
                        <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#team-section">
                        <i class="bi bi-person-plus"></i>Add
                        </button>
                    </div>

                    <div class="row" id="team_data">
                        
                    </div>
                    
                </div>
            </div>

            <!-- Management Team modal-->
            <div class="modal fade" id="team-section" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                <form id="team_section_form">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title">Add Team Member</h5>
                        </div>
                    <div class="modal-body">
                        <div class="mb-3">
                        <label  class="form-label fw-sbold">Name</label>
                        <input type="text" name="team_member_name" id="team_member_name_inp" class="form-control shadow-none" required>
                        </div>
                        <div class="mb-3">
                        <label  class="form-label fw-bold">Profile Picture</label>
                        <input type="file" name="team_member_pic" id="team_member_pic_inp" accept=".jpg, .png, .webp, .jpeg" class="form-control shadow-none" required>
                        </div>
                    </div>
                        <div class="modal-footer">
                        <button type="button" onclick="team_member_name.value='', team_member_pic.value=''" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
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
<script src="admin_scripts/settings.js"></script>

</body>
</html>