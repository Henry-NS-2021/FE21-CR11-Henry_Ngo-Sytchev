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
       $message = "<h2 class='display-6 my-3 fw-bold'>Congratulations</h2>
       <hr class='bg-success py-1 mb-4 mx-auto w-75'>
       <p class='my-2 fs-4'>The entry below was successfully created!</p> <br>
            <table class='table table-success table-striped border border-2 border-light align-middle rounded w-100 m-auto'>
            <tr>
            <th>PICTURE</th><td> <img class='img-fluid' width='80vw' src='../../pictures/{$picture->fileName}'></td>
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
            
            </table><hr>";
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
   <body>
    <main class="bg-dark h-100">
        <!-- [MESSAGE] -->
        <div class="container py-5">
            <div class="my-3">
                <div class="h2 display-1 py-3 mt-0 text-start text-warning">
                </div>
                <hr>
            </div>
            <div class="alert alert-<?=$class;?> text-center my-0 mx-auto w-75"  role="alert">
               <p><?php echo ($message) ?? ''; ?></p>
               <p><?php echo ($uploadError) ?? '' ; ?></p>
                <a href='../../dashBoard.php'><button class="btn btn-outline-dark mt-3 mb-2 py-0 px-5 fw-bold mx-auto w-50"  type='button'>Dashboard</button></a>
            </div>
       </div>
    </main>
   </body>
</html>