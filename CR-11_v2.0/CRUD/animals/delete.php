<?php
session_start();
require_once '../components/db_connect.php';

// if (isset($_SESSION['user']) != "") {
//    header("Location: ../home.php");
//    exit;
// }

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
   header("Location: ../index.php");
   exit;
}

    $delete = "";

    if($_GET["id"]){
        $id = $_GET["id"];
        $sql = "SELECT * FROM animals WHERE animal_id = '{$id}';";
        $query = mysqli_query($connect, $sql);

        if(mysqli_num_rows($query) == 1){
            $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
            
            foreach($result as $data){
                $delete .= "
                <div class='alert alert-muted border border-danger border-3 my-5 text-center text-danger fs-4 mx-auto w-100'>
                    <h2 class='display-6 my-3 fw-bold'>Attention!</h2>
                    <hr class='bg-danger py-1 mb-4 mx-auto w-75'>
                    <p>You are about to <b>delete</b> this record. <br>Would you REALLY like to do it?</p>

                    <form class='mt-5 p-0' action='actions/a_delete.php' method='POST'>
                        <input type='hidden' name='animal_id' value='{$data['animal_id']}'>
                        <input type='hidden' name='picture' value='{$data['picture']}'>
                        <p class='text-center mt-0 mb-3'>
                            <button class='btn btn-outline-danger py-0 px-3 mx-2 w-25' type='submit'>YES, please</button>
                            <a href='../dashBoard.php'><span class='btn btn-outline-primary py-0 px-3 mx-2 w-25'>NO, keep it</span></a>
                        </p>
                    </form> 
                </div>
                
                <div class='card mb-3 mx-auto w-75' style='min-width: 25vw;'>
                <div class='row g-0'>
                    <div class='col-sm-12 col-md-5 align-self-center'>
                        <div><img class='img-fluid align-middle' src='../pictures/" .$data['picture'] . "'></div>
                    </div>
                    <div class='col-sm-12 col-md-7'>
                        <article class='card-body'>
                            <h1 class='card-title display-5 fw-bold mt-3 mb-2 text-center'>{$data['name']} </h1>

                            <h3 class='card-subtitle text-secondary text-center mb-3'>{$data['breed']}</h3><hr>

                            <p class='card-text mt-4 mb-0'><small class='text-muted'>AGE: </small><i>{$data['age']} years old</i></p>

                            <p class='card-text mt-0 mb-0'><small class='text-muted'>SIZE: </small><i>{$data['size']} cm</i></p>

                            <p class='card-text mt-0 mb-3'><small class='text-muted'>HOBBIES: </small><i>{$data['hobbies']}</i></p>
                        </article>
                    </div>
                    <div class='card-footer pt-1 m-0'>
                        <p class='card-text text-center my-0'><small class='text-muted'><i class='bi bi-geo-alt-fill fs-3 text-dark'></i> </small><i>{$data['location']}</i></p>
                    </div>
                </div>
                </div>";
            }
        } else {
        echo "<div class='alert alert-info m-5 p-3 text-dark text-center fs-4'><h1 class='mt-4 mb-3 pb-0'>SORRY!</h1>
        <p>No record could be identified.</p></div>";
        }
        mysqli_close($connect);
    } else {
        header("location: error.php");
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
    <?php require_once("../components/bootstrap.php")?>
    <!-- CSS -->
    <link rel="stylesheet" href="../styles/style.css">
    <title>Code Review 11: Adopt a pet</title>
</head>
<body>

    <!-- [MAIN] -->
    <main class="bg-dark">
        <div class="container">
        <section class="container-fluid m-0 mx-auto py-5">
        
        <!-- [Here comes a selected item to be deleted or an Message] -->
            <?= $delete?>
        </section>
        </div>
    </main>

</body>
</html>