<?php
session_start();
require_once '../components/db_connect.php';


if (isset($_SESSION['user']) != "") {
   header("Location: ../home.php");
   exit;
}

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
    <style>
        input{
            width: 100%;
        }

        main{
            min-height: 100vh;
        }

        .label {
            font-weight: lighter;
            color: lightgrey;
        }
    </style>
    <title>Code Review 11: Adopt a pet</title>
</head>
<body>
    <!-- [MAIN] -->
    <main class="bg-dark">
    <legend  class="h2 display-1 py-3 mt-0 text-center text-warning">
        <h1 class="mt-4">Create request</h1><hr>
    </legend>
    <!-- [FORM] -->
    <form method="POST" action="actions/a_create.php" enctype="multipart/form-data" class=" mx-5 my-0">
        
        <table class=" bg-dark table m-0 text-muted fs-6">
                <tr>
                    <td colspan="2"><h2 class="display-1 mb-5 text-center text-white my-4">New animal record</h2>
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
                <tr>
                    <td>
                        
                    </td>
                    <td>
                        <input class="btn btn-outline-success px-5 py-3 mb-2 mt-4 fw-bold" type="submit" name="name" placeholder="Name" value="Confirm">
                        <a href="../dashBoard.php">
                            <p class="btn btn-outline-light py-0 mb-2 fw-bold w-100">Dashboard</p>
                        </a>
                    <br>
                    <br>
                    <br>
                </td>
                </tr>
            </table>
    </form>
    </main>
    <!-- [FOOTER] -->
    <?php require_once("../components/footer.php"); ?>
</body>
</html>