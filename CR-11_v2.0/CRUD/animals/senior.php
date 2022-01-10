<?php
    session_start();
    require_once("../components/db_connect.php");
 
    if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
    }

   $sql = "SELECT * FROM animals LEFT JOIN pet_adoption ON animals.animal_id = pet_adoption.pet_id WHERE age > 8 AND pet_adoption.pet_id is NULL ORDER BY age DESC;";
   $query = mysqli_query($connect, $sql);
   $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
   $seniors = "";
   
   if(mysqli_num_rows($query) > 0){
       foreach($result as $row){
        // diplays only non-adopted pets in the seniors' list
           $seniors .= "
           <tr class='" . ($row['status'] == 'adopted'? 'd-none': '') . " align-middle text-center border-top border-bottom border-secondary'>
               <td>
               <img class='img-fluid' width='130px' src='../pictures/{$row["picture"]}'>
               </td>
               <td>{$row['name']}</td>
               <td>{$row['breed']}</td>
               <td>{$row['age']}</td>
               <td>{$row['location']}</td>
               <td>
               <a class='btn btn-outline-dark w-auto py-0 m-1' href='details.php?id={$row["animal_id"]}'><span>Show more</span>
               </a>
           </td>
           </tr>
           ";
       }
   } else {
       $seniors = "<tr>
                    <td class='text-center' colspan='6'>
                    <p class='py-3 fs-4 lh-md'>Sorry, there are currently no Senior pets at the moment.<br> <span class='text-success'>Please, come again later.<span></p>
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
    <!-- CSS -->
    <link rel="stylesheet" href="../styles/style.css">
    <title>Code Review 11: Adopt a pet - Seniors</title>
</head>
<body>
    <!-- [NAVBAR] -->
    <?php
    $url = "";
    $logout_url = "../";
    $img_url="../";
    require_once("../components/navbar.php"); 
    ?>
    
    <!-- [MAIN] -->
    <main class="bg-dark py-5">
    <div class="container mb-5">
    <h1 class="text-center text-light fw-light display-4 mb-0">Our Vet* Pets</h1>
    <p class="text-center text-muted text-decoration-overline lh-1 mt-0 mb-4 mx-auto w-50"><sub>*To this list belong Pets above 8 years of age</sub></p>
        <hr class="bg-success py-1 mb-5 mx-auto w-75">
        <!-- table -->
        <div class="table-responsive">
            <table class="table table-secondary table-striped border my-0 mx-auto w-75">
                <thead class="table-dark text-white text-center fw-light">
                    <tr class="align-middle">
                        <td>Picture</td>
                        <td>Name</td>
                        <td>Breed</td>
                        <td>Age <small>(years)</small></td>
                        <td>Location</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    <?= $seniors ?>
                </tbody>
            </table>
        </div>
    </div>
    </main>

    <!-- [FOOTER] -->
    <?php require_once("../components/footer.php"); ?>
</body>
</html>