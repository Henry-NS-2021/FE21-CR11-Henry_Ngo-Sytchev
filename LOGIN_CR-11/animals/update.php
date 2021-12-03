<?php 
    session_start();
    require_once '../components/db_connect.php';

    if (isset($_SESSION['user']) != "") {
    header("Location: ../home.php");
    exit;
    }

    if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
    }



    if($_GET["id"]){
        $id = $_GET["id"];
        $sql = "SELECT * FROM animals WHERE animal_id = '{$id}';";
        $query = mysqli_query($connect, $sql);

        if(mysqli_num_rows($query) == 1){
            $result = mysqli_fetch_all($query, MYSQLI_ASSOC); //fetched row

            foreach($result as $data){//loop through array
            $name = $data['name'];
            $breed = $data['breed'];
            $age = $data['age'];
            $size = $data['size'];
            $hobbies = $data['hobbies'];
            $location = $data['location'];
            $description = $data['description'];
            $picture = $data['picture'];
            }
        } else {
            header("location: error.php");
        }
        mysqli_close($connect);
    } else {
        header("location: error.php");
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
        .label {
            font-weight: lighter;
            color: lightgrey;
        }
        /* PREWORK CSS */
        fieldset  {
               margin: auto;
               margin-top: 5vh;
               width: auto;
        }  

        .img-thumbnail{
            width: 70px !important;
            height: 70px !important;
        }    
    </style>
    <title>Code Review 11: Adopt a pet</title>
</head>
<body>
    <!-- [NAVBAR] -->
    <?php 
    $url="../";
    $img_url="../";
    require_once("../components/navbar.php"); 
    ?>
    
    <!-- [MAIN] -->
    <main class="bg-dark">
    <!-- [FORM] -->
    <legend  class="h2 display-1 py-3 mt-0 text-center text-warning">
        <h1 class="mt-4">Update request <img class="img-thumbnail rounded-circle" src="../pictures/<?php echo $picture; ?>" alt= "<?php echo $name ?>">
    </h1>
    <hr>
    </legend>
    <form class="w-75 mx-auto" method="POST" action="actions/a_update.php" enctype="multipart/form-data" class="rounded-3 bg-dark mx-5">
        
        <table class="table mx-0 mb-0 text-white fs-6">
                <tr>
                    <td colspan="2"><h2 class="display-1 my-5 text-center text-white my-4">Update Animal Record</h2>
                    </td>
                </tr>
                <tr>
                    <td class="label">NAME</td>
                    <td><input class="form-control" type="text" name="name" value="<?= $name?>" placeholder="Name"></td>
                </tr>
                <tr>
                    <td class="label">BREED</td>
                    <td><input class="form-control" type="text" name="breed" value="<?= $breed?>" placeholder="Breed"></td>
                </tr>
                <tr>
                    <td class="label">AGE</td>
                    <td><input class="form-control" type="number" name="age" value="<?= $age?>" placeholder="Age" step="any"></td>
                </tr>
                <tr>
                    <td class="label">SIZE</td>
                    <td><input class="form-control" type="number" name="size" value="<?= $size?>" placeholder="Size"></td>
                </tr>
                <tr>
                    <td class="label">LOCATION</td>
                    <td><input class="form-control" type="text" name="location" value="<?= $location?>" placeholder="Location"></td>
                </tr>
                <tr>
                    <td class="label">HOBBIES</td>
                    <td><input class="form-control" type="text" name="hobbies" value="<?= $hobbies?>" placeholder="hobbies"></td>
                </tr>
                <tr>
                    <td class="label">PICTURE</td>
                    <td>
                        <div class="input-group">
                            <label class="input-group-text" for="upload_picture"><i class="bi bi-camera-fill"></i></label>
                        <input class="form-control"  type="file" name="picture" value="../<?= $picture?>" id="upload_picture">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="label">DESCRIPTION</td>
                    <td>
                    <textarea class="form-control" name="description" rows="8" value="<?= $description?>" placeholder="Leave the description of the pet in here..."></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                    <input type="hidden"   name="id"   value="<?= $id ?>">

                    <input type="hidden" name="picture" value="<?= $picture ?>">
                    </td>
                </tr>
                <tr>
                    <td class="m-0 p-0">
                    </td>
                    <td>
                        <div>
                            <input class="btn btn-outline-success px-5 py-3 mb-2 mt-4 fw-bold w-100" type="submit" name="name" placeholder="Name" value="Save changes">
                        </div>
                        <a href="../dashBoard.php">
                        <p class="btn btn-outline-light py-0 mb-2 fw-bold w-100">Dashboard</p>
                        </a>
                    </td>
                </tr>
            </table>
    </form>
    </main>
    <!-- [FOOTER] -->
    <?php require_once("../components/footer.php"); ?>
</body>
</html>