<?php
session_start();
    require_once("../components/db_connect.php");
    
    if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
        header("Location: ../index.php");
        exit;
    }

    // saving user id
    if(@($_SESSION["adm"])){
        $user_id = $_SESSION["adm"];
    } elseif(@($_SESSION["user"])) {
        $user_id = $_SESSION["user"];
    }
    
    if(@$_GET["id"]){
        $id = $_GET["id"];
        $sql = "SELECT * FROM animals LEFT JOIN pet_adoption ON animals.animal_id = pet_adoption.pet_id WHERE animal_id = '{$id}'";
        $query = mysqli_query($connect, $sql);
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
        $display = "";

        if(mysqli_num_rows($query) == 1){
            foreach($result as $row){
                $display = "
                <div class='card my-5 mx-auto' style='min-width: 18rem; max-width: 540px'>
                    <img class='card-img-top img-fluid' src='../pictures/{$row["picture"]}' alt='Card image cap'>
                    <div class='card-body'>
                        <h3 class='card-title text-center mt-3'>{$row["name"]}
                        <span class='card-subtitle text-secondary'> | {$row["breed"]}</span></h3>
                        <p class='text-center my-0'><i class='bi bi-geo-alt'></i> {$row["location"]}
                        </p>
                        <hr class='mt-1'>
                        <p class='p-0 m-0'>
                        <span class='text-secondary fw-bold'>Age:</span> {$row["age"]} years old </p> 
                        <p class='p-0 m-0'><span class='text-secondary fw-bold'>Size:</span> {$row["size"]} cm </p> 
                        <p class='p-0 m-0'><span class='text-secondary fw-bold'>Hobbies:</span><br>{$row["hobbies"]}</p> 
                        
                        <hr>
                        <p class='card-text'><i class='bi bi-info-square'></i> <b class='text-secondary'>Description</b><br>{$row["description"]}</p>
                        <hr>
                        <p class='card-text text-center mb-0'>
                            <small'>
                            <a class='" . ($row['status'] == 'adopted'? 'd-none': '') . " btn btn-outline-primary  p-0 m-0 w-50' href='pet_adoption.php?id={$id}&user_id={$user_id}'><i class='bi bi-house-door-fill'></i> Take me home</a>
                            </small>
                        </p>
                        <p class='text-center p-0 m-0'>
                            <sub class='mt-2'>
                                <a class='btn btn-dark w-50' href='index.php'>Return to the pet list</a>
                            </sub>
                        </p>
                    </div>
                </div>
                ";
            }
        } else {
            header("error.php");
        }
    } else {
        echo "The record you are trying to see is not available";
        header("error.php");
    }
?>



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
    <?php 
    $url="../";
    require_once("../components/bootstrap.php");
    ?>
    <!-- CSS -->
    <link rel="stylesheet" href="../styles/style.css">
    <title>Code Review 11: Details</title>
</head>
<body class="bg-dark">
        <!-- [NAVBAR] -->
    <?php 
    $url = "";
    $img_url = "../";
    require_once("../components/navbar.php"); ?>

        <!-- [MAIN] -->
    <main class="bg-black">
    <?php echo ($display)?:"";?>
    </main>
    
        <!-- [FOOTER] -->
    <?php require_once("../components/footer.php"); ?>
</body>
</html>