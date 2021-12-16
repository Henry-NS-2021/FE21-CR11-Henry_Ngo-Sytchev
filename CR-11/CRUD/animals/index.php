<?php
    session_start();
    require_once("../components/db_connect.php");
    // if (isset($_SESSION['user']) != "") {
    //     header("Location: ../home.php");
    //     exit;
    //  }
     
     if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
        header("Location: ../index.php");
        exit;
     }
     
    $sql = "SELECT * FROM animals;";
    $query = mysqli_query($connect, $sql);
    $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    $animals = "";
    
    if(mysqli_num_rows($query) > 0){
        foreach($result as $row){
            $animals .= "
            <tr class='align-middle text-center border-top border-bottom border-secondary'>
                <td>
                <a href='details.php?id={$row["animal_id"]}'>
                <img class='img-fluid' width='200px' src='../pictures/{$row["picture"]}'>
                </a>
                </td>
                <td>{$row['name']}</td>
                <td>{$row['breed']}</td>
                <td>{$row['age']}</td>
                <td>
                    <a class='btn btn-outline-dark w-auto py-2' href='details.php?id={$row["animal_id"]}'><span>Show more</span>
                    </a>
                </td>
            </tr>
            ";
        }
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
    $url=$logout_url="";
    $img_url="../";
    require_once("../components/navbar.php"); 
    ?>

    <!-- [MAIN] -->
    <main class="bg-dark">
    <div class="container bg-dark py-5">
    <h1 class="text-center text-light fw-light display-4">Pets to Adopt</h1>
        <hr class="bg-success py-1 mb-5">
        <table class="table table-light table-striped border border-muted my-5 mx-auto w-75">
            <thead class="table-dark text-center">
                <tr class="align-middle">
                    <td>Picture</td>
                    <td>Name</td>
                    <td>Breed</td>
                    <td>Age <small>(years)</small></td>
                    <td>Details</td>
                </tr>
            </thead>
            <tbody>
                <?= $animals ?>
            </tbody>
        </table>
    </div>
    </main>
    <!-- [FOOTER] -->
    <?php require_once("../components/footer.php"); ?>
</body>
</html>