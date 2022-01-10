<?php
session_start();
    require_once("../components/db_connect.php");
    
    if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
        header("Location: ../index.php");
        exit;
    }

    $sorry = "";
    $adoption = "";
    
    if( @($_GET["id"]) && @($_GET["user_id"]) ){
        // save user and pet IDs from the link
        $pet_id = $_GET["id"];
        $user_id = $_GET["user_id"];

        // verify if pet's status is NOT adopted, then allow or reject adoption
        $sql_pet = "SELECT * FROM pet_adoption WHERE pet_id = {$pet_id};";
        $query_pet = mysqli_query($connect, $sql_pet);

        if(mysqli_num_rows($query_pet) == 0){




            
            $sql_adoption = "INSERT INTO pet_adoption(user_id, pet_id, adoption_date, adoption_time, status) VALUES ($user_id, $pet_id, now(), now(), 'adopted');";
            $query_adoption = mysqli_query($connect, $sql_adoption);
            
            
            $sql = "SELECT * FROM animals JOIN pet_adoption ON animals.animal_id = pet_adoption.pet_id WHERE animal_id = '{$pet_id}'";
            $query = mysqli_query($connect, $sql);
            $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
            $adoption = "";
            
            if(mysqli_num_rows($query) == 1){
                foreach($result as $row){
                    $adoption = "
                    <div class='card my-5 mx-auto' style='min-width: 220px; width: 100%; max-width: 23rem'>
                    <img class='card-img-top img-fluid' src='../pictures/{$row["picture"]}' alt='Card image cap'>
                        <div class='card-body'>
                        <h3 class='card-title text-center mt-3'>{$row["name"]}
                        <span class='card-subtitle text-secondary'> | {$row["breed"]}</span></h3>
                        <p class='text-center fs-1 text-danger fw-bold mt-2 mb-2'><i class='bi bi-suit-heart-fill fs-3'></i> {$row["status"]}</p>
                        </p>
                        <hr class='bg-dark py-1 mt-1'>
                        <p class='text-center my-0'><b>{$row["name"]}</b> is looking forward to meeting you at:<br><i class='bi bi-geo-alt-fill text-success'></i> {$row["location"]}<br>
                        <hr class='bg-dark py-1 my-2'>
                        <hr class='bg-dark mt-0 mb-3'>
                        <p class='text-center py-0 m-0'>
                        <small class='p-0 m-0'>
                        <a class='btn btn-primary text-decoration-none' href='index.php'>Return to the pet list</a>
                        </small>
                        </p>
                        </div>
                        </div>
                        ";

                        $class = "success";
                        $notification = "
                                <h2 class='display-6 my-3 fw-bold'><i class='bi bi-emoji-smile fs-3'></i> Congratulations</h2><hr class='bg-success py-1 mb-4 mx-auto w-75'>            
                                <p class='fs-5 text-success'>You have just <b>adopted</b> a new companion.
                                </p>";
                    }
                    // header("refresh:3; url=index.php");
                } else {
                    header("refresh:0; url=error.php");
                }
                
            } else {
                $class = "danger";
                $notification = "
                <h1 class='mb-3'><i class='bi bi-emoji-frown fs-2'></i> Sorry</h1>
                <hr class='bg-danger py-1 mb-4 mx-auto w-75'>            
                <p class='fs-5'>This animal <b>has already been adopted</b>.<br> Have another look around. You might find a suitable companion for you.
                </p>
                    <a class='text-decoration-none' href='index.php'><p class='btn btn-danger mt-4 mx-auto py-0 w-50'>Return to Pet List</p>";
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
    <title>Code Review 11: Adoption</title>
</head>
<body>
        <!-- [NAVBAR] -->
    <?php 
    $url = "";
    $img_url = "../";
    require_once("../components/navbar.php"); ?>

        <!-- [MAIN] -->
    <main class="bg-dark py-5">
        <div class='alert-<?= $class ?> border border-<?= $class ?> text-<?= $class ?> text-center rounded-3 pt-2 pb-2 mb-5 mx-auto w-75' style='min-width: 220px; width: 100%; max-width: 720px'>
            <?= $notification ?>
        </div>
        <?= ($adoption)?:""; ?>
    </main>
    
        <!-- [FOOTER] -->
    <?php require_once("../components/footer.php"); ?>
</body>
</html>