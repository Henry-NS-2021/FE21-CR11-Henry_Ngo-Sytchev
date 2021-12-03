<?php 
    $connect = mysqli_connect("localhost", "root", "", "fswd13_cr11_petadoption_henryngosytchev");

    if(!$connect){
        die("Connection error" . mysqli_connect_error());
    } 
//     else {
//         echo "<p>db_connect: Connection is successful!</p>";
//     }
// ?>