<?php

require('admin/admin_components/essentials.php');
session_start();
session_destroy();
redirect('index.php');


?>