<?php
session_start();
require_once 'components/db_connect.php';

// if adm will redirect to dashboard
if (isset($_SESSION['adm'])) {
   header("Location: dashboard.php");
   exit;
}
// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
   header("Location: index.php");
   exit;
}

$adoptions = "";
$id = $_SESSION['user'];

// select logged-in users details - procedural style
$query = mysqli_query($connect, "SELECT * FROM users WHERE id=" . $_SESSION['user']);
$row = mysqli_fetch_array($query, MYSQLI_ASSOC);

// query for the adopted pets by the user
$sql_adopt = "SELECT animals.animal_id, animals.name, animals.age, animals.location, animals.picture, animals.size FROM animals INNER JOIN pet_adoption ON animals.animal_id = pet_adoption.pet_id INNER JOIN users ON pet_adoption.user_id = users.id WHERE users.id = $id";
$query_adopt = mysqli_query($connect, $sql_adopt);
$count = mysqli_num_rows($query_adopt);// number of adoptions by user

if(mysqli_num_rows($query_adopt) >= 1){
   $adopt_record = mysqli_fetch_all($query_adopt, MYSQLI_ASSOC);
   foreach($adopt_record as $adoption){
   $adoptions .=         
      "<tr class='align-middle my-3'>
         <td class='text-center'>
         <a href='animals/details.php?id={$adoption["animal_id"]}'><img class='img-fluid rounded-1' src='pictures/{$adoption["picture"]}' style='max-width: 150px'></a>
         </td>
         <td>
            <p id='adoption_font' class='align-middle p-0 text-secondary bg-transparent'>
            <b>{$adoption["name"]}</b><br>
            {$adoption["age"]} year(s), {$adoption["size"]} cm<br>
            {$adoption["location"]}<br><br>
            <a href='animals/details.php?id={$adoption["animal_id"]}'><span class='btn-sm btn-primary py-1'>details</span></a>
            </p>
         </td>
      </tr>"
      ;
   } 
} else {
      $adoptions =  "
         <tr>
            <td colspan='2'>
            <p class='text-muted text-center fs-5'>You have no adopted companions so far.</p>
            </td>
         </tr>";
   }

// query to count the amount of adoptions by user
// echo $sql_count = "SELECT COUNT(*) AS adoptions FROM animals INNER JOIN pet_adoption ON animals.animal_id = pet_adoption.pet_id INNER JOIN users ON pet_adoption.user_id = users.id WHERE users.id = $id";
// $query_count = mysqli_query($connect, $sql_count);
// var_dump($query_count);

mysqli_close($connect);
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- BOOTSTRAP -->
   <?php require_once 'components/bootstrap.php'?>
   <!-- CSS -->
   <link rel="stylesheet" href="styles/style.css">
   <!-- CSS -->
<style>
   main{
      min-height: 70vh;
      padding: 0 2.5vw;
   }
   
   .userImage{
      width: 15vw;
      border-radius: 50px
   }
   
   .hero {
      background: rgb(2,0,36);
      background: linear-gradient(24deg, rgba(2,0,36,1) 0%, rgba(0,212,255,1) 100%);  
   }
   
   #pets_link{
      color: whitesmoke;
      font-weight: lighter;
      font-size: 1.1em;
      transition: font-weight .35s, border-bottom .35s;
   }
   
   #pets_link:hover{
      font-weight: bold;
      color: black;
   }
   
   #cat_img{
      transition: transform .65s;
   }
   
   #cat_img:hover{
      transform: scale(1.15);
   }
   
   #homepage{
      max-width: 1440px;
   }
   
   #my_adoptions{
      max-width: 520px;
   } 

#adoption_font{
   font-size: 1rem;
}

</style>
   <title>Welcome - <?php echo $row['first_name']; ?></title>
</head>
<body>
   <!-- [HEADER] -->
   <header class="hero row alert-warning bg-muted m-0">
      <p class="bg-dark text-light text-end pb-2">
         <sub>
            <span class="text-warning mx-1"> Here you can...</span>
            <a class="text-decoration-none text-light mx-2" href="user_update.php?id=<?php echo $_SESSION['user'] ?>">Update profile <i class="bi bi-person fs-6"></i></a> 
            <span class="text-warning"> | </span>
            <a class="text-decoration-none text-light mx-2" href="logout.php?logout">Sign Out <i class="bi bi-box-arrow-right"></i></a>
         </sub>
      </p>
      <!-- user image and name -->
      <div class="col-4 justify-content-center align-self-center text-center ">    
         <img class="userImage my-2" src="pictures/<?php echo $row['picture']; ?>" alt="<?php echo $row['first_name']; ?>">
         <h5 class="fw-lighter text-info fw-lighter mb-1"><?php echo $row['first_name'] . " " . $row['last_name']; ?></h5>
         <p class="text-center text-light fw-bold">User</p>
      </div>
      <!-- welcome message for user -->
      <div class="col-5 offset-md-1 text-center align-self-center">
         <h2 class="fw-lighter text-info mt-4 mb-3">Hi, <?php echo $row['first_name']; ?></h2>
         <h1 class="display-4 text-light fw-bolder mb-3 lh-1">Welcome to<br> <span class="fw-lighter display-2">Pet Storey</span></h1>
      </div>
      <hr class="bg-warning py-1 mt-3 mb-0">
   </header>
   <!-- [NAVBAR] -->
   <nav class="bg-success py-3">
         <p class="text-center py-2 px-5 m-0"><a  id="pets_link" class="nav_link text-decoration-none btn-lg btn-warning py-3" href="animals/index.php">VISIT PETS</a></p>
      
   </nav>
   <!-- [MAIN] -->
   <main class="bg-dark text-light">
      <div class="container overflow-hidden justify-content-center">
      <!-- Content: welcome and adoptions -->
      <section id="homepage" class="row py-3 mx-auto">
         <!-- welcome display -->
         <div id="welcome_msg" class="col-sm-12 col-md-6 col-lg-6 alert-info text-center text-dark fs-5 border border-1 border-success rounded-1 mb-3 mx-1 py-5 px-4">
            <p class="text-center">
               <a href="animals/index.php"><img id="cat_img" class="img-fluid mx-auto mt-2 mb-2" width="250vw" src="pictures/layout_img/home.png" alt="animal"></a>
            </p>
            <p class="py-2"><b class="fs-1">Hey!</b><br><br>
            <b>Would you like to get some fluffy company in your life?</b></p>
            
            <p class="mt-3 mb-5 fw-lighter ">That is Great, because we definitely have something for you! Visit our <a class="text-success text-decoration-none" href="animals/index.php"><span>Pet Shelter</span></a> to find a "daily partner in crime".</p>
         </div>

         <!-- adoptions display -->
         <div id="my_adoptions" class="col-sm-12 col-md-5 col-lg-5 align-self-start border border-primary rounded-1 mb-3 mx-1 px-2">
            <h2 class="fw-lighter text-center border-bottom border-primary py-4 px-1">My Adoptions (<?php echo $count; ?>)</h2>
            <!-- table -->
            <div class="table-responsive">
               <table class="table table-borderless table-muted">
                  <tbody>
                  <?= $adoptions ?>
                  </tbody>
               </table>
            </div>
         </div>
      </section>
      </div>
   </main>

   
   <!-- [FOOTER] -->
   <?php 
   $url = "";
   require_once("components/footer.php"); ?>
</body>
</html>