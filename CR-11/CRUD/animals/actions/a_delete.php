<?php
session_start();
require_once '../../components/db_connect.php';

if (isset($_SESSION['user']) != "") {
   header("Location: ../../home.php");
   exit;
}

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
   header("Location: ../../index.php");
   exit;
}

    if($_POST){
        $id = $_POST["animal_id"];
        $picture = $_POST["picture"];
        ($picture == "animal.png")?: unlink("../../pictures/".$picture);

        $sql = "DELETE FROM animals WHERE animal_id = '{$id}';";
        
        if(mysqli_query($connect, $sql) === true){
            $class = "success";
            $message = "<h2 class='display-6 my-3 fw-bold'>Congratulations</h2>
            <hr class='bg-success py-1 mb-4 mx-auto w-75'>
            <p class='mt-4 mb-5 fs-5'>The Record has been successfully <b>Deleted</b>!</p>";
        } else  {
            $class = "danger";
            $message = "<h2>ATTENTION:</h2>
            <p class='mt-3 mb-5'>The record has not been deleted due to: <br>"
              . $connect->error . "</p>";
        }
        mysqli_close($connect);

        } else {
        header("location: ../error.php" );
    }

?>


<!-- 
------------------
    HTML
------------------ 
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Henry Ngo-Sytchev">
    <!-- [BOOTSTRAP] -->
    <?php require_once("../../components/bootstrap.php")?>
    <!-- CSS -->
    <link rel="stylesheet" href="../../styles/style.css">
    <title>Code Review 11: Record deleted</title>
</head>
<body class="dashboard_body">
    <main class="bg-transparent py-5">
        <div class="container mb-3">
            <div class="bg-none border border-3 border-<?=$class;?> text-<?=$class;?> text-center pt-4 pb-4 mb-5 mx-auto alert_notification"  role="alert">
                <p><?=$message;?></p>
               <a href ='../../dashBoard.php    '><button class ="btn btn-success mb-2 py-0 px-5 fw-bold mx-auto w-50" type='button'>Dashboard</button></a >
           </div>
       </div>
    </main>

</body>
</html>