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

        $picture = file_upload($_FILES['picture'], 'animal');//file_upload() called  
        if($picture->error === 0){
            ($_POST["picture"] == "animal.png")?: unlink("../../pictures/$_POST[picture]");          
            $sql = "UPDATE animals SET name = '$name', breed = '$breed', age = '$age', size = '$size', hobbies = '$hobbies', location = '$location', description = '$description', picture = '$picture->fileName' WHERE animal_id = '{$id}'";
        }else{
            $sql = "UPDATE animals SET name = '$name', breed = '$breed', age = '$age', size = '$size', hobbies = '$hobbies', location = '$location', description = '$description' WHERE animal_id = '{$id}';";
        }    
        if (mysqli_query($connect, $sql) === TRUE) {
            $class = "success";
            $message = "<h2 class='display-6 my-3 fw-bold'>Notification</h2><hr class='bg-success py-1 mb-4 mx-auto w-75'>
            <p>The record was successfully updated</p>" ;
            $uploadError = ($picture->error !=0)? $picture->ErrorMessage :'' ;
        } else {
            $class = "danger";
            $message = "<h2 class='display-6 my-3 fw-bold'>Error while updating record</h2><hr class='bg-" . $class . " py-1 mb-4 mx-auto w-75'>
            <p class='fw-bolder my-5'>" . mysqli_error($connect) . "</p>";
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
    <!-- CSS -->
    <link rel="stylesheet" href="../../styles/style.css">
    <title>Code Review 11: Record updated</title>
</head>
<body class="dashboard_body">
    <!-- [MAIN] -->
    <main class="bg-transparent pb-5">
    <!-- CHECK THIS BLOCK -->
    <div class="container py-5">
            <div class="bg-none border border-3 border-<?=$class;?> text-<?=$class;?> text-center pt-2 pb-5 px-5 mb-5 mx-auto alert_notification"  role="alert">
                <p class="fs-3 mt-2 mb-5"><?php echo ($message) ?? ''; ?></p>
                <p><?php echo ($uploadError) ?? ''; ?></p>
                <a href='../../dashBoard.php' ><button class="btn btn-light border rounded-3 py-0 mt-3 mb-2 mx-auto w-50"  type='button'>Dashboard </button></a>
                <a href='../update.php?id=<?=$id;?>' ><button class="btn btn-outline-warning py-0 mx-auto w-50"  type='button'>Back </button></a>
           </div>
       </div>
    </main>

</body>
</html>