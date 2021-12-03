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
    <title>Code Review 11: Adopt a pet</title>
</head>
<body>

<!-- NAVBAR -->
<div class="text-start bg-success mb-0 d-flex align-items-center">
        <a href="<?= ($url??""); ?>index.php">
            <img class="d-inline-block align-text-top rounded-circle mx-3 my-2" src="<?= ($img_url??""); ?>pictures/layout_img/logo_pets.jpg" alt="logo" width="50" height="50">
        </a>
        <p class="text-center pt-2 d-flex justify-content-between">
        <a class="text-decoration-none text-light fs-3" href="<?= ($url??""); ?>index.php">
            <span class="px-2 py-0 mb-1 mx-1 display-6 fs-4">PET LIST</span>
        </a>
        <a class="text-decoration-none text-light fs-3" href="<?= ($url??""); ?>senior.php">
            <span class="px-2 py-0 mb-1 mx-1 display-6 fs-4">SENIORS</span>
        </a>
        <a class="text-decoration-none text-light fs-3 <?= (isset($_SESSION["user"])?"d-none":""); ?>" href="<?= ($dashboard_url??""); ?>../dashboard.php">
            <span class="px-2 py-0 mb-1 mx-1 display-6 fs-4">DASHBOARD</span>
        </a>
        <a class="text-decoration-none text-light fs-3" href="<?= ($logout_url??""); ?>../logout.php">
            <span class="px-2 py-0 mb-1 mx-1 display-6 fs-4">LOG OUT</span>
        </a>
        </p>
</div>

</body>
</html>