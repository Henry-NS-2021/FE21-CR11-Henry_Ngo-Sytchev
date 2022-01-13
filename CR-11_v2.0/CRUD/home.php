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

$sql_adopt = "SELECT animals.name, animals.age, animals.location, animals.picture, animals.size FROM animals INNER JOIN pet_adoption ON animals.animal_id = pet_adoption.pet_id INNER JOIN users ON pet_adoption.user_id = users.id WHERE users.id = $id";
$query_adopt = mysqli_query($connect, $sql_adopt);


if(mysqli_num_rows($query_adopt) >= 1){
   $adopt_record = mysqli_fetch_all($query_adopt, MYSQLI_ASSOC);
   foreach($adopt_record as $adoption){
   $adoptions .= "
      <div class='py-1 px-2 mb-2 alert-info border border-white rounded-3'
         <p class='my-2'><img class='img-fluid' src='pictures/{$adoption["picture"]}'></p>
         <p class='my-2'><span class='fw-bold text-info bg-transparent'>Name: </span>{$adoption["name"]}</p>
         <p class='my-2'><span class='fw-bold text-info bg-transparent'>Age: </span>{$adoption["age"]}</p>
         <p class='my-2'><span class='fw-bold text-info bg-transparent'>Size: </span>{$adoption["size"]}</p>
         <p class='my-2'><span class='fw-bold text-info bg-transparent'>Location: </span>{$adoption["location"]}</p>
      </div>";

      echo $adoption["adoption_id"] . "<br>";
      // var_dump($adoption);
   }
}


mysqli_close($connect);
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Welcome - <?php echo $row['first_name']; ?></title>
<!-- BOOTSTRAP -->
<?php require_once 'components/bootstrap.php'?>
<!-- CSS -->
<style>
main{
   min-height: 70vh;
   padding: 0 2.5vw;
}

.userImage{
   width: 25vw;
   border-radius: 50px
}

.hero {
   background: rgb(2,0,36);
   background: linear-gradient(24deg, rgba(2,0,36,1) 0%, rgba(0,212,255,1) 100%);  
}

a #pets_link{
   color: whitesmoke;
   font-weight: lighter;
   transition: font-weight .25s, border-bottom .35s;
}

a #pets_link:hover{
   font-weight: normal;
   color: gold;
}

#cat_img{
   transition: transform .65s;
}

#cat_img:hover{
   transform: scale(1.15);
}

#homepage{
   max-width: 2440px;
} 

#welcome_msg, #my_adoptions{
   margin: 25px 10px; 
   width: 100%;

}

#welcome_msg{
   min-width: 320px;
   max-width: 720px;
}

#my_adoptions{
   min-width: 320px;
   max-width: 420px;
}  
    
</style>
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
      
      <div class="col-4 justify-content-center text-center ">    
         <img class="userImage my-2" src="pictures/<?php echo $row['picture']; ?>" alt="<?php echo $row['first_name']; ?>">
         <h5 class="fw-lighter text-info fw-lighter mb-1"><?php echo $row['first_name'] . " " . $row['last_name']; ?></h5>
         <p class="text-center text-light fw-bold">User</p>
      </div>
      <div class="col-5 offset-md-1 text-center align-self-center">
         <h2 class="fw-lighter text-info mt-4">Hi, <?php echo $row['first_name']; ?></h2>
         <h1 class="display-3 text-light fw-bolder mb-3">Welcome to Pet Storey!</h1>
      </div>
      <hr class="bg-warning py-1 mt-3 mb-0">
   </header>
   <!-- [NAVBAR] -->
   <nav class="bg-success py-1">
      <a class="nav_link text-decoration-none" href="animals/index.php">
         <p id="pets_link" class="text-start fs-4 px-5 m-0">VISIT PETS</p>
      </a>
   </nav>
   <!-- [MAIN] -->
   <main class="bg-dark text-light">
      <!-- Content: welcome and adoptions -->
      <section id="homepage" class="d-flex justify-content-center align-items-start flex-wrap-reverse">
         <div id="welcome_msg" class="flex-grow-1 alert-success text-center text-dark fs-5 border border-1 border-success rounded-1 py-4 px-4">
            <p class="text-center">
               <a href="animals/index.php"><img id="cat_img" class="img-fluid mx-auto mt-2 mb-2" width="250vw" src="pictures/layout_img/home.png" alt="animal"></a>
            </p>
            <p class="pt-3 pb-2"><b class="fs-1">Hey!</b><br><br>
            <b>Would you like to get some fluffy company in your life?</b></p>
            
            <p class="mt-3 fw-lighter ">That is Great, because we definitely have something for you! Visit our <a class="text-success text-decoration-none" href="animals/index.php"><span>Pet Shelter</span></a> to find a "daily partner in crime".</p>
         </div>
         <!-- adoptions display -->
         <div id="my_adoptions" class="align-self-end border border-info rounded-1 px-3">
            <h2 class="fw-lighter text-center border-bottom border-success py-4 px-2">My Adoptions</h2>
            <div class="table-responsive">
               <div class="table table-borderless table-success text-light">
                  <?= $adoptions ?>
               </div>
            </div>
         </div>
      </section>
   </main>
   <!-- [FOOTER] -->
   <?php 
   $url = "";
   require_once("components/footer.php"); ?>
</body>
</html>