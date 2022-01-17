<?php
session_start();
    require_once("components/db_connect.php");
    
    if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
        header("Location: index.php");
        exit;
    }

    // saving user id
    if(@($_SESSION["adm"])){
        $user_id = $_SESSION["adm"];
    } elseif(@($_SESSION["user"])) {
        $user_id = $_SESSION["user"];
    }
    
    if(@$_GET["id"]){
        $id = $_GET["id"];
        $sql = "SELECT * FROM users WHERE id = '{$id}'";
        
        $query = mysqli_query($connect, $sql);
        $result = mysqli_fetch_assoc($query);
        $display_user = "";
        // var_dump($result);

        if(mysqli_num_rows($query) == 1){
            // foreach($result as $record){
                // echo $result["first_name"];
                // echo $record["first_name"];
                // echo $record;
                $display_user = "
                <div class='container my-5 p-3 mx-auto' style='min-width: 18rem; max-width: 540px;'>
                    <div class='row justify-content-center align-items-center bg-muted text-light border border-2 border-info rounded-3 py-3 shadow'>
                        <div class='col-sm-8 col-md-5 text-center'>
                            <img class='img-fluid' max-width='420px' width='100%' src='pictures/{$result["picture"]}'>
                        </div>

                        <div class='col-sm-12 col-md-7 border-start border-1 ps-3'>
                            <h2 class='card-title text-center mt-3 mb-3'>{$result["first_name"]} {$result["last_name"]} </h2>
                            <hr class='py-1 bg-info'>
                            <p class='lh-lg'>
                            <span class='fw-bold text-muted'>Status: </span>" . (($result['user_status']) == 'adm'? 'Administrator':'User') . "<br>
                            <span class='fw-bold text-muted'>Phone :</span> {$result["phone_number"]} <br>
                            <span class='fw-bold text-muted'>Email :</span> {$result["email"]} <br>
                            <span class='fw-bold text-muted'>Address :</span> {$result["address"]} <br>
                            </p>
                        </div>
                            <div class='col-12 bg-info text-end py-0'><a href='dashBoard.php'><span class='btn btn-light border shadow fw-bold py-0 my-1'>Dashboard</span></a></div>
                    </div>
                </div>
                ";
            // }
        } else {
            header("error.php");
        }
    } else {
        echo "The record you are trying to see is not available";
        header("error.php");
    }
?>



<!-- ------------------------
        HTML
------------------------ -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Henry Ngo-Sytchev">
    <!-- [BOOTSTRAP] -->
    <?php 
    $url="";
    require_once("components/bootstrap.php");
    ?>
    <!-- CSS -->
    <link rel="stylesheet" href="styles/style.css">
    <title>User details</title>
</head>
<body class="dashboard_body">

        <!-- [MAIN] -->
    <main class="bg-transparent">
    <?php echo ($display_user)?:"";?>
    </main>

</body>
</html>