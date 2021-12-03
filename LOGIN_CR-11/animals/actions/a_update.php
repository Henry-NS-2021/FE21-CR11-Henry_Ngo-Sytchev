<!-- 
----------------------
CHECK THE WHOLE SCRIPT
---------------------- 
-->
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
    
    if ($_POST) {    
        $name = $_POST['name'];
        $breed = $_POST['breed'];
        $age = $_POST['age'];
        $size = $_POST['size'];
        $hobbies = $_POST['hobbies'];
        $location = $_POST['location'];
        $description = $_POST['description'];
        $id = $_POST['id'];
        //variable for upload pictures errors is initialized
        $uploadError = '';

        $picture = file_upload($_FILES['picture']);//file_upload() called  
        if($picture->error === 0){
            ($_POST["picture"] == "animal_avatar.png")?: unlink("../../pictures/$_POST[picture]");          
            $sql = "UPDATE animals SET name = '$name', breed = '$breed', age = '$age', size = '$size', hobbies = '$hobbies', location = '$location', description = '$description', picture = '$picture->fileName' WHERE animal_id = '{$id}'";
        }else{
            $sql = "UPDATE animals SET name = '$name', breed = '$breed', age = '$age', size = '$size', hobbies = '$hobbies', location = '$location', description = '$description' WHERE animal_id = '{$id}'";
        }    
        if (mysqli_query($connect, $sql) === TRUE) {
            $class = "success";
            $message = "The record was successfully updated" ;
            $uploadError = ($picture->error !=0)? $picture->ErrorMessage :'' ;
        } else {
            $class = "danger";
            $message = "Error while updating record : <br>" . mysqli_connect_error();
            $uploadError = ($picture->error != 0)? $picture->ErrorMessage :'';
        }
        mysqli_close($connect);    
        } else {
        header("location: ../error.php");
    }
?>



<!-- 
------------------------
        HTML
------------------------ 
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
    <title>Code Review 11: Adopt a pet</title>
</head>
<body>
    <!-- [NAVBAR] -->
    <?php 
    $url="../";
    $img_url="../../";
    require_once("../../components/navbar.php"); 
    ?>
   
    <main class="bg-dark my-0">
    <!-- CHECK THIS BLOCK -->
    <div class="container py-5 m-0 mx-auto w-75">
            <div class="my-3">
                <div class="h2 display-1 py-3 mt-0 text-center text-warning">
                    <h1 class="mt-4">Update request response</h1><hr>
                </div>
                <hr>
           </div>
            <div class="alert alert-<?php echo $class;?> text-center"  role="alert">
                <p class="fs-3 mt-2 mb-5"><?php echo ($message) ?? ''; ?></p>
                <p><?php echo ($uploadError) ?? ''; ?></p>
                <a href='../update.php?id=<?=$id;?>' ><button class="btn btn-warning py-0 w-100"  type='button'>Back </button></a>
                <a href='../../dashBoard.php' ><button class="btn btn-outline-dark py-0 w-100 mt-1"  type='button'>Dashboard </button></a>
           </div>
       </div>
    </main>
    <!-- [FOOTER] -->
    <?php require_once("../../components/footer.php"); ?>
</body>
</html>