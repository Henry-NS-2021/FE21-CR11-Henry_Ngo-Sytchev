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

//animals table rows
$sql_animals = "SELECT * FROM animals;";
$query_animals = mysqli_query($connect, $sql_animals);
$result_animals = mysqli_fetch_all($query_animals, MYSQLI_ASSOC);
$animals = "";

if(mysqli_num_rows($query_animals) > 0){
    foreach($result_animals as $row){
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
            <a class='btn btn-outline-secondary w-100 py-0' href='animals/details.php?id={$row['animal_id']}'><span>Show more</span></a>
            <a class='btn btn-outline-secondary w-100 py-0' href='animals/update.php?id={$row['animal_id']}'><span>Update</span></a>
            <a class='btn btn-outline-secondary w-100 py-0' href='animals/delete.php?id={$row['animal_id']}'><span>Delete</span></a>
            </td>
        </tr>
        ";
    }
}

//users table rows
$sql_users = "SELECT * FROM users;";
$query_users = mysqli_query($connect, $sql_users);
$result_users = mysqli_fetch_all($query_users, MYSQLI_ASSOC);
$users = "";

if(mysqli_num_rows($query_users) > 0){
    foreach($result_users as $row_user){
        $users .= "
        <tr class='align-middle text-center border-top border-bottom border-secondary'>
            <td class='text-center'>
            <img id='user_img' src='pictures/{$row_user["picture"]}'>
            </td>
            <td class='text-center'>{$row_user['first_name']} {$row_user['last_name']}</td>
            <td class='text-center'>{$row_user['email']}</td>
            <td class='text-center'>{$row_user['user_status']}</td>
            <td class='text-center'>
            <a class='btn btn-outline-secondary w-50 py-0' href='user_details.php?id={$row_user['id']}'><span>more</span></a>
            <a class='btn btn-outline-secondary w-50 py-0' href='user_update.php?id={$row_user['id']}'><span>edit</span></a>
            <a class='btn btn-outline-secondary w-50 py-0' href='user_delete.php?id={$row_user['id']}'><span>drop</span></a>
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
       $picture = $adm_data["picture"];
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
   <!-- BOOTSTRAP -->
   <?php require_once 'components/bootstrap.php'?>
   <!-- CSS -->
   <link rel="stylesheet" href="styles/style.css">
   <title>Adm-DashBoard</title>
</head>
<body id="dashboard_body">
    <!-- [MAIN] -->
<main  class="bg-transparent">
    <!-- <div id="admin_panel" class="container pb-5 mx-auto w-100"> -->
        <!-- [DASHBOARD] -->
        <div class="row alert alert-light mb-1">
                <!-- navigation bar with sign out, update profile functions -->
                <p class="bg-dark text-light text-end pb-2">
                <sub>
                    <span class="text-light mx-1"> Here you can...</span>
                    <a class="text-decoration-none text-info mx-2" href="user_update.php?id=<?php echo $_SESSION['adm'] ?>">Update Profile</a> 
                    <span class="text-light"> | </span>
                    <a class="text-decoration-none text-info mx-2" href="logout.php?logout">Sign Out</a>
                </sub>
                </p>
                <!-- admin picture and buttons -->
            <div class="col-4 justify-content-center text-center ">    
                <img id="admin_img" class="mb-2" src="pictures/<?= $row_user['picture'] ?>" alt="Adm avatar">
                <h2 class="fw-lighter text-danger mb-3"><?= $full_name ?></h2>
                <p class="text-center text-danger fw-bolder">Administrator</p>
            </div> 
            <!-- welcome message -->
            <div class="col-6 text-center align-self-center">
                <h2 class="fs-5 fw-bolder mb-3">Welcome to the Dashboard!</h2>
                <p class="text-center mt-2">
                    <a class="btn btn-outline-dark fw-bolder py-0 px-2 w-75" href="animals/index.php">View Website</a>
                    <a class="btn btn-outline-success fw-bolder py-0 my-1 text-decoration-none w-75" href="animals/create.php">Add Pet</a>
                    <a class="btn btn-outline-success fw-bolder py-0 text-decoration-none w-75" href="user_create.php">Add User</a>
                </p>
                
                </div>
                <hr class="bg-dark py-1 mt-3 mb-0">
        </div>

        <!-- [Navigation Tabs for animals and users] -->
        <!-- tabs -->
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <!-- pets' button -->
                    <button class="nav-link py-0 mx-1 fw-bold active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Pets</button>
                    <!-- users' button -->
                    <button class="nav-link py-0 mx-1 fw-bold" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Users</button>
                </div>
            </nav>
            <!-- tabs' content -->
            <div class="tab-content pb-5" id="nav-tabContent">
                <!-- content pets -->
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <!-- [Pet list with CRUD commands: 
                    ATTENTION: create function is at the top page] -->
                    <h1 class='display-5 text-center text-white mt-5'>Pet Records</h1>
                    <hr class="bg-info shadow py-1 w-50 mx-auto mb-4 mt-1">

                    <div class="row w-75 table-responsive border border-info border-2 rounded rounded-danger mt-3 mx-auto">
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
                <!-- content users -->
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <!-- [User list with CRUD commands: the add user button is at the top of the page] -->
                    <h1 class='display-5 text-center text-white mt-5'>Users Records</h1>
                    <hr class="bg-info shadow py-1 w-50 mx-auto mb-4 mt-1">

                    <div class="row w-75 table-responsive border border-info border-2 rounded rounded-danger mt-3 mx-auto">
                    <table class="table table-light table-striped my-0">
                        <thead class="table-dark">
                            <tr class="align-middle">
                                <td class="text-center">Picture</td>
                                <td class="text-center">Name</td>
                                <td class="text-center">Email</td>
                                <td class="text-center">Status</td>
                                <td class="text-center">Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?= $users ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
















        <!-- End of navigation tabs code -->





    <!-- </div> -->
</main>

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>