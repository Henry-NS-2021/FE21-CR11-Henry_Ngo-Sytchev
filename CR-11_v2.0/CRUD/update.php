<?php
session_start();
require_once 'components/db_connect.php';
require_once 'components/file_upload.php';
// if session is not set this will redirect to login page
if( !isset($_SESSION['adm']) && !isset($_SESSION['user']) ) {
   header("Location: index.php");
   exit;
  }
 
$backBtn = '';
//if it is a user it will create a back button to home.php
if(isset($_SESSION["user"])){
   $backBtn = "home.php";    
}
//if it is a adm it will create a back button to dashboard.php
if(isset($_SESSION["adm"])){
   $backBtn = "dashBoard.php";    
}

//fetch and populate form
if (isset($_GET['id'])) {
   $id = $_GET['id'];
   $sql = "SELECT * FROM users WHERE id = {$id}";
   $result = mysqli_query($connect, $sql);
   if (mysqli_num_rows($result) == 1) {
       $data = mysqli_fetch_assoc($result);
       $f_name = $data['first_name'];
       $l_name = $data['last_name'];
       $email = $data['email'];
       $phone_number = $data['phone_number'];
       $address = $data['address'];
       $picture = $data['picture'];
   }  
}

//update
$class = 'd-none';
if (isset($_POST["submit"])) {
   $f_name = $_POST['first_name'];
   $l_name = $_POST['last_name'];
   $email = $_POST['email'];
   $phone_number = $data['phone_number'];
   $address = $data['address'];
   $id = $_POST['id'];
   //variable for upload pictures errors is initialized
   $uploadError = '';    
   $pictureArray = file_upload($_FILES['picture']); //file_upload() called
   $picture = $pictureArray->fileName;
   if ($pictureArray->error === 0) {      
       ($_POST["picture"] == "avatar.png") ?: unlink("pictures/{$_POST["picture"]}");
       $sql = "UPDATE users SET first_name = '$f_name', last_name = '$l_name', email = '$email', phone_number = '$phone_number', address = '$address', picture = '$pictureArray->fileName' WHERE id = {$id}";
   } else {
       $sql = "UPDATE users SET first_name = '$f_name', last_name = '$l_name', email = '$email', phone_number = '$phone_number', address = '$address', WHERE id = {$id}";
   }
   if (mysqli_query($connect, $sql) === true) {    
       $class = "alert alert-success";
       $message = "The record was successfully updated";
       $uploadError = ($pictureArray->error != 0) ? $pictureArray->ErrorMessage : '';
       header("refresh:3;url=update.php?id={$id}");
   } else {
       $class = "alert alert-danger";
       $message = "Error while updating record : <br>" . $connect->error;
       $uploadError = ($pictureArray->error != 0) ? $pictureArray->ErrorMessage : '';
       header("refresh:3;url=update.php?id={$id}");
   }
}
mysqli_close($connect);
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit User</title>
  <!-- BOOTSTRAP -->
  <?php require_once 'components/bootstrap.php'?>
  <style type= "text/css">
      fieldset {
           margin: auto;
           margin-top: 100px;
           width: 60% ;
       }
       .img-thumbnail{
           width: 70px !important;
           height: 70px !important;
       }

       main{
           height: 100vh;
       }
  </style>
</head>
<body>

<!-- [MAIN] -->
<main class="bg-dark">
<div class="container w-75 py-5 rounded-3">
   <div class="<?php echo $class; ?>" role="alert">
       <p><?php echo ($message) ?? ''; ?></p>
       <p><?php echo ($uploadError) ?? ''; ?></p>       
   </div>
       <h2 class="text-warning text-center">Update</h2>   
       <hr class="bg-warning py-1 mb-3 mx-auto w-75">    
       <p class="text-center"><img class='rounded-circle border border-3 border-warning' height="200px" src='pictures/<?php echo $data['picture'] ?>' alt="<?php echo $f_name ?>"></p>
       <form class="rounded-3" method="post" enctype="multipart/form-data">
           <table class="table table-striped table-light rounded-3">
               <tr>
                   <th>First Name</th>
                   <td><input class="form-control" type="text"  name="first_name" placeholder ="First Name" value="<?php echo $f_name ?>"  /></td>
               </tr>
               <tr>
                   <th>Last Name</th>
                   <td><input class="form-control" type= "text" name="last_name"  placeholder="Last Name" value ="<?php echo $l_name ?>" /></td>
               </tr>
               <tr>
                   <th>Email</th>
                   <td><input class="form-control" type="email" name="email" placeholder= "Email" value= "<?php echo $email ?>" /></td>
               </tr>
               <tr>
                   <th>Phone Number</th>
                   <td>
                    <input class='form-control mb-1 py-1' placeholder="Phone number" type="text"  name="phone_number" value ="<?php echo $phone_number ?>"/>                   
                </td>
               </tr>
               <tr>
                   <th>Address</th>
                   <td>
                    <input class='form-control mb-1 py-1' placeholder="Address" type="text"  name="address" value ="<?php echo $address ?>"/>
                    </td>
               </tr>
               <tr>
                   <th>Picture</th>
                   <td><input class="form-control" type="file" name="picture" /></td>
               </tr>
               <tr>
                   <input type= "hidden" name= "id" value= "<?php echo $data['id'] ?>" />
                   <input type= "hidden" name= "picture" value= "<?php echo $picture ?>" />
                   <td><a href= "<?php echo $backBtn?>"><button class="btn btn-warning py-0 px-3 w-100" type="button">Back</button></a></td>
                   <td class="text-center"><button name="submit" class="btn btn-success py-0 w-75" type= "submit">Save Changes</button></td>
               </tr>
           </table>
       </form>   
</div>
</main>
</body>
</html>