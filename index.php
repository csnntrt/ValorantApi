<?php
require 'vendor/autoload.php';
use \Csnntrt\ValorantApi\Store;

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Valorant Daily Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>
<body>
<?php

if (!isset($_POST['user'])) {
    include 'includes/login.php';
    exit();
}
$user = $_POST['user'];
$pass = $_POST['pass'];

?>
<div class="container">
    <div class="row align-items-center">
                <?php
                $store = new Store();
                $skins = $store->show($user,$pass);
                foreach ($skins as $skin){
                    ?>
            <div class="col-3">
                    <img src="<?=$skin['data']['displayIcon']?>" class="w-100 img-fluid">
                <div class="">
                    <div class="d-flex justify-content-between align-items-baseline"><strong><?=$skin['data']['displayName']?></strong></div>
                </div>
            </div>
                    <?php
                }
                    ?>
        </div>
</div>






<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>
