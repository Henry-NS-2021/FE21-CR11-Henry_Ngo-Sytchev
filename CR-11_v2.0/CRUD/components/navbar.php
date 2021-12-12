<!--     
        -------------------------------
            NAVBAR
        ------------------------------- 
    -->


        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Henry Ngo-Sytchev">
    <!-- [BOOTSTRAP] -->
    <?php require_once("bootstrap.php")?>
    <!-- [CSS] -->
    <style>
        .nav_link{
            vertical-align: middle;
            color: whitesmoke;
            font-weight: lighter;
            transition: color .25s, border-bottom .65s, font-weight .35s;
        }

        .nav_link:hover{
            color: black;
            font-weight: bold;
        }
    </style>
    <title>Code Review 11: Adopt a pet</title>
</head>
<body>

<!-- NAVBAR -->
<div class="d-flex sticky-top bg-success mb-0 justify-content-between align-items-center">
    <div>
        <a href="<?= ($url??""); ?>index.php">
            <img class="d-inline-block align-text-top rounded-circle mx-4 my-2" src="<?= ($img_url??""); ?>pictures/layout_img/logo_pets.jpg" alt="logo" width="50" height="50">
        </a>
    </div>    
    <div class="text-center pt-2 d-flex justify-content-between align-items-center">
        <section>
            <a class="nav_link text-decoration-none <?= (isset($_SESSION["adm"])?"d-none":""); ?>" href="<?= ($home_url??""); ?>../home.php">
                <span class="p-0 mb-1 mx-3">HOME</span>
            </a>
            <a class="nav_link text-decoration-none" href="<?= ($url??""); ?>index.php">
                <span class="p-0 mb-1 mx-3">PET LIST</span>
            </a>
            <a class="nav_link text-decoration-none" href="<?= ($url??""); ?>senior.php">
                <span class="p-0 mb-1 mx-3">SENIORS</span>
            </a>
            <a class="nav_link text-decoration-none <?= (isset($_SESSION["user"])?"d-none":""); ?>" href="<?= ($dashboard_url??""); ?>../dashboard.php">
                <span class="p-0 mb-1 mx-3">DASHBOARD</span>
            </a>
        </section>
        <section>
            <span class="ms-5 me-2"> | </span>
            <a class="nav_link text-decoration-none" href="<?= ($url??""); ?>../<?= (isset($_SESSION["user"])?"home.php":"dashBoard.php"); ?>">
                <small class="p-0 mb-1 mx-1"><i class="bi bi-person fs-4"></i></small>
            </a>
            <a class="nav_link text-decoration-none" href="<?= ($url??""); ?>../logout.php?logout">
                <span class="p-0 mb-1 mx-3">SIGN OUT</span>
            </a>
        </section>
    </div>
</div>

</body>
</html>