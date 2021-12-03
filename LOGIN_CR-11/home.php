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

// select logged-in users details - procedural style
$query = mysqli_query($connect, "SELECT * FROM users WHERE id=" . $_SESSION['user']);
$row = mysqli_fetch_array($query, MYSQLI_ASSOC);


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
<style>
   main{
      height: 100vh;
   }

   .userImage{
   width: 100px;
   height: 100px;
   }

   .hero {
      background: rgb(2,0,36);
      background: linear-gradient(24deg, rgba(2,0,36,1) 0%, rgba(0,212,255,1) 100%);  
   }
</style>
</head>
<body>
<main>


<div class="row alert-warning bg-muted m-0">
            <p class="bg-dark text-light text-end pb-2">
               <sub>
                  <span class="text-warning mx-1"> Here you can...</span>
                  <a class="text-decoration-none text-light mx-2" href="update.php?id=<?php echo $_SESSION['user'] ?>">Update your profile</a> 
                  <span class="text-warning"> | </span>
                  <a class="text-decoration-none text-light mx-2" href="logout.php?logout">Sign Out</a>
               </sub>
            </p>
   
            <div class="col-4 justify-content-center text-center ">    
                <img class="userImage my-2" src="pictures/avatar.png" alt="<?php echo $row['first_name']; ?>">
                <p class="text-center text-dark fw-bolder">User</p>
            </div>
            <div class="col-6 text-center align-self-center">
               <h2 class="fw-lighter text-info mt-4">Hi, <?php echo $row['first_name']; ?></h2>
                <h2 class="fs-3 fw-bolder mb-3">Welcome to Pet Storey!</h2>
            </div>
            <hr class="bg-warning py-1 mt-3 mb-0">
       </div>

       <!-- [NAVBAR] -->
      <?php
      $url="animals/";
      $img_url="";
      require_once("components/navbar.php"); 
      ?>

      <div class="container container-fluid text-center fs-3 py-5 mx-auto w-75">
         <p class="text-center">
            <a href="animals/index.php"><img class="img-fluid mx-auto mt-2 mb-2" width="250vw" src="pictures/layout_img/home.png" alt="animal"></a>
         </p>
         <p class="pb-3"><b class="fs-1">Hey!</b><br><br>Do you need some fluffy company in your life?
         That is Great, because we definitely have something for you!</p>
         <p class="mt-3 mb-5">Visit our <a class="text-success text-decoration-none" href="animals/index.php"><span>Pet Shelter</span></a> to find a "daily partner in crime".</p>
      </div>
   <!-- </div> -->
   <!-- [FOOTER] -->
   <?php require_once("components/footer.php"); ?>
</body>
</html>