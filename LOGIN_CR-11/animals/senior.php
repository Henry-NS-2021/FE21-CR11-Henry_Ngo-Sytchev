<?php
    session_start();
    require_once("../components/db_connect.php");
    if (isset($_SESSION['user']) != "") {
    header("Location: ../home.php");
    exit;
    }
 
    if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
    }

   $sql = "SELECT * FROM animals WHERE age > 8 ORDER BY age DESC;";
   $query = mysqli_query($connect, $sql);
   $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
   $seniors = "";
   
   if(mysqli_num_rows($query) > 0){
       foreach($result as $row){
           $seniors .= "
           <tr class='align-middle text-center border-top border-bottom border-secondary'>
               <td>
               <img class='img-fluid' width='130px' src='../pictures/{$row["picture"]}'>
               </td>
               <td>{$row['name']}</td>
               <td>{$row['breed']}</td>
               <td>{$row['age']}</td>
               <td>{$row['location']}</td>
           </tr>
           ";
       }
   } else {
       $seniors = "<tr>
                <td class='text-center' colspan='5'>
                Sorry, there are currently no available records.
                </td>
            </tr>";
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
        <!-- [CSS] -->
        <style>
        main{
           min-height: 100vh;
       }
    </style>
    <title>Code Review 11: Adopt a pet - Seniors</title>
</head>
<body>
    <!-- [NAVBAR] -->
    <?php
    $url="";
    $img_url="../";
    require_once("../components/navbar.php"); 
    ?>
    
    <!-- [MAIN] -->
    <main class="bg-dark py-5">
    <div class="container mb-5">
    <h1 class="text-center text-light fw-light display-4">Our Vet* Pets</h1>
    <p class="text-center text-muted border-top border-secondary mx-auto w-50"><sub>*To this list belong Pets above 8 years of age</sub></p>
        <hr class="bg-success py-1 mb-5">
        <table class="table table-secondary table-striped border my-0 mx-auto w-75">
            <thead class="table-dark text-white text-center fw-light">
                <tr class="align-middle">
                    <td>Picture</td>
                    <td>Name</td>
                    <td>Breed</td>
                    <td>Age <small>(years)</small></td>
                    <td>Location</td>
                </tr>
            </thead>
            <tbody>
                <?= $seniors ?>
            </tbody>
        </table>
    </div>
    </main>

    <!-- [FOOTER] -->
    <?php require_once("../components/footer.php"); ?>
</body>
</html>