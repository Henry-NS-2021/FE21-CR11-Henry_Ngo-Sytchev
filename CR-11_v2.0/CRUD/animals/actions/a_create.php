<?php
session_start();

// if (isset($_SESSION['user']) != "") {
//    header("Location: ../../home.php");
//    exit;
// }

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
       $message = "<p class='my-2 fs-4'>The entry below was successfully created</p> <br>
            <table class='table table-success table-striped border border-2 border-light rounded w-100 m-auto'>
            <tr>
            <th>PICTURE</th><td> <img class='img-fluid' src='../../pictures/{$picture->fileName}'></td>
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
        <title>Code Review 11: Adopt a pet</title>
        <!-- [BOOTSTRAP] -->
        <?php require_once ("../../components/bootstrap.php")?>
    </head>
   <body>
       <!-- [NAVBAR] -->
       <?php 
        $url="../";
        $img_url="../../";
        require_once("../../components/navbar.php"); 
        ?>

    <main class="bg-dark h-100">
        <!-- [MESSAGE] -->
        <div class="container py-5">
            <div class="my-3">
            <div class="h2 display-1 py-3 mt-0 text-center text-warning">
                <h1 class="mt-4">Create request response</h1><hr>
            </div>

                <hr>
           </div>
            <div class="alert alert-<?=$class;?> text-center my-0 mx-auto w-75"  role="alert">
               <p><?php echo ($message) ?? ''; ?></p>
               <p><?php echo ($uploadError) ?? '' ; ?></p>
                <a href='../index.php'><button class="btn btn-outline-dark mt-3 mb-2 py-0 px-5 fw-bold w-100"  type='button'>Home</button></a>
            </div>
       </div>
    </main>
    <!-- [FOOTER] -->
    <?php require_once("../../components/footer.php"); ?>
   </body>
</html>