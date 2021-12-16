<!-- ------------------------
        HTML
------------------------ -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Henry Ngo-Sytchev">
    <!-- [BOOTSTRAP] -->
    <?php require_once("../components/bootstrap.php")?>
    <!-- [CSS] -->
    <style>
        main{
           min-height: 100vh;
       }
    </style>
    <title>Code Review 11: Adopt a pet</title>
</head>
<body>
    <!-- [NAVBAR] -->
    <?php 
    $url="../";
    $img_url="../";
    require_once("../components/navbar.php"); 
    ?>

    <!-- [MAIN] -->
    <main>
    <article class="p-3 border border-3 rounded-pill border-danger text-center my-5 mx-auto fs-3 w-50">
        <h1 class="text-danger mt-2 mb-3 display-1 fw-bold"><i class="bi bi-envelop"></i>ERROR!</h1><hr>
        <p>There is an issue with the action you have performed.</p><p> Please, try again.</p>
        <p class="text-center my-2"><a  href="index.php"><span class="btn btn-danger rounded-pill mt-3 px-5 fw-bold w-50">OK</span></a> </p>
     </p>
    </article>
    </main>
    <!-- [FOOTER] -->
    <?php require_once("../components/footer.php"); ?>
</body>
</html>