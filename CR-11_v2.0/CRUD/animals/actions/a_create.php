<?php
session_start();

if (isset($_SESSION['user']) != "") {
   header("Location: ../../home.php");
   exit;
}

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
   header("Location: ../../index.php");
   exit;
}

require_once '../../components/db_connect.php';
require_once '../../components/file_upload.php';

if ($_POST){  
   $name = $_POST['name'];
   $breed = $_POST['breed'];
   $age = $_POST['age'];
   $size = $_POST['size'];
   $location = $_POST['location'];
   $hobbies = $_POST['hobbies'];
   $description = $_POST['description'];
   //this function exists in the service file upload.
   $picture = file_upload($_FILES['picture'], 'animal');  
   
   $uploadError = '';
   
   $sql = "INSERT INTO animals (name, breed, age, size, location, hobbies, picture) VALUES ('$name', '$breed', '$age', '$size', '$location', '$hobbies', '$picture->fileName')" ;

   if (mysqli_query($connect, $sql) === true) {
       $class = "success";
       $message = "<h2 class='display-6 mt-5 mb-3 fw-bold'>Congratulations</h2>
       <hr class='bg-success py-1 mb-4 mx-auto w-75'>
       <p class='my-2 fs-4'>The entry below was successfully created!</p> <br>
            <div class='table-responsive px-5 m-0'>
            <table class='table border border-1 border-secondary align-middle text-light custom_table'>
            <tr>
            <th>PICTURE</th><td> <img class='img-fluid rounded-3' width='50%' src='../../pictures/{$picture->fileName}'></td>
            </tr>
            <tr>
            <th>NAME</th><td> $name </td>
            </tr>
            <tr>
            <th>BREED</th><td> $breed </td>
            </tr>
            <tr>
            <th>LOCATION</th><td> $location </td>
            </tr>
            <tr>
            <th>AGE <small class='fw-light'>(years)</small></th><td> $age </td>
            </tr>
            <tr>
            <th>SIZE <small class='fw-light'>(cm)</small></th><td>$size</td>
            </tr>
            <tr>
            <th>HOBBIES</th><td> $hobbies </td>
            </tr>
            <th>DESCRIPTION</th><td> $description </td>
            </tr>
            
            </table>
            </div><hr>";
       $uploadError = ($picture->error != 0)? $picture->ErrorMessage :'';
   } else {
       $class = "danger";
       $message = "Error while creating record. Try again: <br>" . $connect->error;
       $uploadError = ($picture->error != 0)? $picture->ErrorMessage :'';
   }
   mysqli_close($connect);
} else  {
   header("location: ../error.php");
}
?>


<!DOCTYPE html>
<html lang= "en">
   <head>
        <meta charset="UTF-8">
        <meta name="author" content="Henry Ngo-Sytchev">
        <!-- [BOOTSTRAP] -->
        <?php require_once ("../../components/bootstrap.php")?>
        <!-- CSS -->
        <link rel="stylesheet" href="../../styles/style.css">
        <title>Code Review 11: Record created</title>
    </head>
   <body class="dashboard_body">
    <main class="bg-transparent py-5 px-0">
        <!-- [MESSAGE] -->
        <div class="container">
            <div class="border border-3 border-<?php echo $class ?> text-center text-<?php echo $class ?> mx-auto alert_notification" role="alert">
               <p><?php echo ($message) ?? ''; ?></p>
               <p><?php echo ($uploadError) ?? '' ; ?></p>
                <a href='../../dashBoard.php'><button class="btn btn-outline-light mt-3 mb-5 py-0 px-5 fw-bold mx-auto w-50"  type='button'>Dashboard</button></a>
            </div>
       </div>
    </main>
   </body>
</html>