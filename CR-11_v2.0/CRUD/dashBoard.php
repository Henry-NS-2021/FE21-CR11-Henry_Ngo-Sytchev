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
            <div class='row'>
            <div class='col-12'><a class='btn btn-outline-secondary mx-auto w-100 py-0' href='animals/details.php?id={$row['animal_id']}'>Details</a></div>
            <div class='col-12'><a class='btn btn-outline-secondary mx-auto w-100 py-0' href='animals/update.php?id={$row['animal_id']}'>Update</a></div>
            <div class='col-12'><a class='btn btn-outline-secondary mx-auto w-100 py-0' href='animals/delete.php?id={$row['animal_id']}'>Delete</a></div>
            </div>
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
            <div class=''>
            <abbr class='text-decoration-none' title='View User'><a class='btn btn-sm btn-outline-primary py-0' href='user_details.php?id={$row_user['id']}'><i class='bi bi-eye-fill'></i></a></abbr>
            <abbr class='text-decoration-none' title='Edit User'><a class='btn btn-sm btn-outline-warning py-0' href='user_update.php?id={$row_user['id']}'><i class='bi bi-pencil-square'></i></a></abbr>
            <abbr class='text-decoration-none' title='Remove User'><a class='" . (($row_user['user_status'] == 'adm')? 'd-none': '') . " btn btn-sm btn-outline-danger py-0' href='user_delete.php?id={$row_user['id']}'><i class='bi bi-trash'></i></a></abbr>
            </div>
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
        <!-- [DASHBOARD] -->
        <div class="row alert alert-light mx-auto w-100 pt-1">
                <!-- navigation bar with sign out, update profile functions -->
            <div class="row py-0 mx-auto bg-dark">
                <p id="navigation_user" class="text-light text-end">
                    <sub>
                        <span class="align-middle text-light mx-1"> Here you can...</span>
                        <a class="align-middle text-decoration-none text-info mx-2" href="user_update.php?id=<?php echo $_SESSION['adm'] ?>">Update Profile</a> 
                        <span class="align-middle text-light"> | </span>
                        <a class="align-middle text-decoration-none text-info mx-2" href="logout.php?logout">Sign Out</a>
                    </sub>
                </p>
            </div>
            <div class="row pt-3 mx-auto border">
                <!-- admin picture and buttons -->
                <div class="col justify-content-center align-self-center text-center ">    
                    <div><img id="admin_img" class="my-2" src="pictures/<?= $row_user['picture'] ?>" alt="Adm avatar"></div>
                    <h5 class="fw-lighter text-info fw-lighter mb-1"><?= $full_name ?></h5>
                    <p class="text-center text-danger fw-bold"><sup>Administrator</sup></p>
                </div> 
                <!-- welcome message -->
                <div class="col text-center align-self-center">
                    <h2 class="fs-5 mb-3">Welcome to the Dashboard!</h2>
                    <p class="text-center mt-2">
                        <a class="btn btn-outline-dark py-0 px-2 w-50" href="animals/index.php">View Website</a>
                        <a class="btn btn-outline-success py-0 my-1 text-decoration-none w-50" href="animals/create.php">Add Pet</a>
                        <a class="btn btn-outline-success py-0 text-decoration-none w-50" href="user_create.php">Add User</a>
                    </p>  
                </div>
            </div>
                <hr class="bg-secondary py-1 mt-0">
        </div>

        <!-- [NAVIGATION TABS for animals and users] -->
        <!-- tabs -->
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <!-- pets' button -->
                    <button class="nav-link py-0 mx-1 fw-bold active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Pet records</button>
                    <!-- users' button -->
                    <button class="nav-link py-0 mx-1 fw-bold" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">User records</button>
                </div>
            </nav>
            <!-- TABS' CONTENT -->
            <div class="tab-content pb-5" id="nav-tabContent">
                <!-- content pets -->
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <!-- [Pet list with CRUD commands: 
                    ATTENTION: create function is at the top page] -->
                    <h1 class='display-5 text-center text-white mt-5'>Pet Records</h1>
                    <hr class="bg-info shadow py-1 w-50 mx-auto mb-4 mt-1">

                    <div class="row w-75 table-responsive border border-info border-2 rounded-3 mt-3 mx-auto">
                    <table class="table table-secondary table-striped my-0">
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

                    <div class="row w-75 table-responsive border border-info border-2 rounded-3 mt-3 mx-auto">
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