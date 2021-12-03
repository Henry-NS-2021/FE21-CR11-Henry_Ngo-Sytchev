<?php
session_start();
require_once 'components/db_connect.php';
// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
   header("Location: index.php");
   exit;
}
//if session user exist it shouldn't access dashboard.php
if (isset($_SESSION["user"])) {
   header("Location: home.php");
   exit;
}

$id = $_SESSION['adm'];
$status = 'adm';
$sql = "SELECT * FROM users WHERE status != '$status'";
$query = mysqli_query($connect, $sql);

//this variable will hold the body for the table
$sql_animals = "SELECT * FROM animals;";
$query_animals = mysqli_query($connect, $sql_animals);
$result = mysqli_fetch_all($query_animals, MYSQLI_ASSOC);
$animals = "";

if(mysqli_num_rows($query_animals) > 0){
    foreach($result as $row){
        $animals .= "
        <tr class='align-middle text-center border-top border-bottom border-secondary'>
            <td class='text-center'>
            <img class='img-fluid' width='130px' src='pictures/{$row["picture"]}'>
            </td>
            <td class='text-center'>{$row['name']}</td>
            <td class='text-center'>{$row['breed']}</td>
            <td class='text-center'>{$row['age']}</td>
            <td class='text-center'>{$row['location']}</td>
            <td class='text-center'>
            <a class='btn btn-outline-secondary w-50 py-0' href='animals/details.php?id={$row['animal_id']}'><span>Show more</span></a>
            <a class='btn btn-outline-secondary w-50 py-0' href='animals/update.php?id={$row['animal_id']}'><span>Update</span></a>
            <a class='btn btn-outline-secondary w-50 py-0' href='animals/delete.php?id={$row['animal_id']}'><span>Delete</span></a>
            </td>
        </tr>
        ";
    }
}


// Getting Admin Data
$adm = "SELECT * FROM users WHERE id='{$id}'";
$query_adm = mysqli_query($connect, $adm);
if ($query_adm){
    $adm_data = mysqli_fetch_assoc($query_adm);
    while($adm_data){
       $full_name = $adm_data["first_name"] . " " . $adm_data["last_name"];
    //    echo $full_name;
        break;
    }
    // var_dump($adm_data);
} else {
    echo "<h1>Fetching of the admin data failed!</h1>";
}
mysqli_close($connect);
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Adm-DashBoard</title>
   <!-- BOOTSTRAP -->
   <?php require_once 'components/bootstrap.php'?>
   <style type="text/css"> 
        body{
            background: url("https://cdn-images-1.medium.com/max/1200/1*5fz2sKKTKjUmlVkWjtIUnQ.jpeg") black center center;
            background-size: cover;
        }
   
       .img-thumbnail{
           width: 70px !important;
           height: 70px !important;
       }
       td
       {
           text-align: left;
           vertical-align: middle;
       }
       tr
       {
           text-align: center;
       }
       .userImage{
            width: 200px;
            height: auto;
            }
   </style>
</head>
<body>
<div class="container py-5">
   <!-- <section class="row"> -->
       <div class="row border border-info border-3 alert alert-info mb-5">
        <p class="text-end bg-dark">
            <a class="text-decoration-none text-info" href="update.php?id=<?php echo $_SESSION['adm'] ?>">Update your profile</a>
            <span class="text-warning"> | </span>
            <a class="text-decoration-none text-info" href="logout.php?logout"><small>Sign Out</small></a>
        </p>
           
           <div class="col-4 justify-content-center text-center ">    
               <img class="userImage mb-2" src="pictures/admin.png" alt="Adm avatar">
               <p class="text-center text-danger fw-bolder">Administrator</p>
            </div> 
            <div class="col-6 text-center align-self-center">
                <h2 class="fs-5 fw-bolder mb-3">Welcome to the Dashboard!</h2>
                <h2 class="fw-lighter text-danger"><?= $full_name ?></h2>
                <p class="text-center mt-5">
                    <a class="btn btn-outline-success fw-bolder py-0 my-1 text-decoration-none w-75" href="animals/create.php">Add a new Pet</a>
                    <a class="btn btn-outline-dark fw-bolder py-0 px-2 w-75" href="animals/index.php">Visit Pet Website</a>
                </p>
            </div>
            <hr class="bg-dark py-1 mt-3 mb-0">
       </div>
       <h1 class='display-5 text-center text-white mt-5'>Pet Registry</h1>
       <hr class="bg-info shadow py-1 w-50 mx-auto mb-4 mt-1">

       <div class="row w-75 border border-info border-2 rounded rounded-danger mt-3 mx-auto">
       <table class="table table-light table-striped my-0">
        <thead class="table-dark">
            <tr class="align-middle">
                <td class="text-center">Picture</td>
                <td class="text-center">Name</td>
                <td class="text-center">Breed</td>
                <td class="text-center">Age <small>(years)</small></td>
                <td class="text-center">Location</td>
                <td class="text-center">Actions</td>
            </tr>
        </thead>
        <tbody>
            <?= $animals ?>
        </tbody>
    </table>
       </div>
   </div>
<!-- </section> -->
<br><br><br><br>
</body>
</html>