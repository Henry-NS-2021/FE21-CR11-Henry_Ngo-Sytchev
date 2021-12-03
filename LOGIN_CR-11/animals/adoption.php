<?php
    session_start();
    require_once '../components/db_connect.php';
echo "it works";
if (isset($_SESSION['user']) != "") {
   header("Location: ../home.php");
   exit;
}

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
   header("Location: ../login.php");
   exit;
}

if(isset($_GET["id"])){
    echo $pet_id=$_GET["id"];
    // $user_id = ;
    $date = date("Y-m-d");

    $sql="INSERT INTO pet_adoption (user_id, pet_id, adoption_status, adoption_date) VALUES ('$user_id', '$pet_id', 'adopted', $date);";

}

?>