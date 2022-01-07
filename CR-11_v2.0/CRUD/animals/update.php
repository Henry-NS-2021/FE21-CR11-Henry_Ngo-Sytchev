<?php 
    session_start();
    require_once '../components/db_connect.php';

    // if (isset($_SESSION['user']) != "") {
    // header("Location: ../home.php");
    // exit;
    // }

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
    <link rel="stylesheet" href="../styles/style.css">
    <title>Code Review 11: Update animal record</title>
</head>
<body id="dashboard_body"> 
    <!-- [MAIN] -->
    <main class="bg-transparent pb-5">
        <div class="container" style="max-width: 720px">

        <!-- [FORM] -->
        <form class="rounded-3 bg-muted" method="POST" action="actions/a_update.php" enctype="multipart/form-data"  style="max-width: 720px">
            <!-- table -->
            <div class="table-responsive">
            <table class="table mx-0 mb-0 text-white fs-6">
                    <tr>
                        <td colspan="2"><h2 class="display-5 text-center text-info my-4">Change Animal Records<br>
                        <hr class="bg-info shadow py-1 mb-2 mt-3 mx-auto w-75">
                        <img class="img-fluid rounded-3 mt-4 mb-0" width="175px" src="../pictures/<?php echo $picture; ?>" alt= "<?php echo $name ?>"></h2>
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
                        <textarea class="form-control" name="description" rows="8"><?= $description ?></textarea>
                        </td>
                    </tr>
                    <tr class="d-none">
                        <td>
                            <input class="form-control" type="hidden" name="id" value="<?= $id ?>">

                            <input class="form-control" type="hidden" name="picture" value="<?= $picture ?>">
                        </td>
                        <td></td>
                    </tr>
                </table>
                <!-- buttons -->
                    <div class="text-end">
                        <input class="btn btn-outline-success px-5 py-2 mb-2 mt-4 fw-bold mx-auto w-75" type="submit" value="Save changes">
                        
                        <a href="../dashBoard.php">
                        <p class="btn btn-outline-light py-0 mb-2 fw-bold mx-auto w-75">Dashboard</p>
                        </a>
                    </div>
                </div>
        </form>
</div>
    </main>
</body>
</html>