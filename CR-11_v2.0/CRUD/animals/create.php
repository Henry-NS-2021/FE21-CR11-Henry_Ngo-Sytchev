<?php
session_start();
require_once '../components/db_connect.php';

// if (isset($_SESSION['user']) != "") {
//    header("Location: ../home.php");
//    exit;
// }

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
   header("Location: ../login.php");
   exit;
}
?>


<!-- 
------------------------
        HTML
------------------------ 
-->

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
    <title>Code Review 11: Create new record</title>
</head>
<body id="dashboard_body">
    <!-- [MAIN] -->
    <main class="bg-transparent pt-5">
    <div class="container bg-muted rounded-3 text-dark border border-info border-3 py-5 px-4" style="max-width: 720px">
    <!-- [FORM] -->
    <form method="POST" action="actions/a_create.php" enctype="multipart/form-data" class="my-0">
        
        <table class="table m-0 text-muted fs-6 w-100">
                <tr>
                    <td colspan="2"><h2 class="display-5 mt-0 text-center text-info">Add New Animal</h2>
                    <hr class="bg-info shadow py-1 mb-5 mt-3 mx-auto w-75">
                    </td>
                </tr>
                <tr>
                    <td class="label">NAME</td>
                    <td><input class="form-control" type="text" name="name" placeholder="Name"></td>
                </tr>
                <tr>
                    <td class="label">BREED</td>
                    <td><input class="form-control" type="text" name="breed" placeholder="Breed"></td>
                </tr>
                <tr>
                    <td class="label">AGE</td>
                    <td><input class="form-control" type="number" name="age" placeholder="Age" step="any"></td>
                </tr>
                <tr>
                    <td class="label">SIZE</td>
                    <td><input class="form-control" type="number" name="size" placeholder="Size"></td>
                </tr>
                <tr>
                    <td class="label">LOCATION</td>
                    <td><input class="form-control" type="text" name="location" placeholder="Location"></td>
                </tr>
                <tr>
                    <td class="label">HOBBIES</td>
                    <td><input class="form-control" type="text" name="hobbies" placeholder="Hobbies"></td>
                </tr>
                <tr>
                    <td class="label">PICTURE</td>
                    <td>
                        <div class="input-group">
                            <label class="input-group-text" for="upload_picture"><i class="bi bi-camera-fill"></i></label>
                        <input class="form-control"  type="file" name="picture" id="upload_picture">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="label">DESCRIPTION</td>
                    <td>
                    <textarea class="form-control" name="description" rows="8" placeholder="Leave the description of the pet in here..."></textarea>
                    </td>
                </tr>
            </table>
                <div class="text-end">
                    <input class="btn btn-success px-5 py-3 mb-2 mt-4 fw-bold w-75" type="submit" name="name" placeholder="Name" value="Add Animal">
                    <a href="../dashBoard.php"><p class="btn btn-outline-light border border-1 px-5 py-0 mb-4 fw-bold mx-auto w-75">Dashboard</p></a>
                </div>                
    </form>
    </div>
    </main>

</body>
</html>