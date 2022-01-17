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
       $user_status = $data['user_status'];
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
   $user_status = $_POST['user_status'];
   $email = $_POST['email'];
   $phone_number = $_POST['phone_number'];
   $address = $_POST['address'];
   $id = $_POST['id'];
   //variable for upload pictures errors is initialized
   $uploadError = '';    
   $pictureArray = file_upload($_FILES['picture']); //file_upload() called
   $picture = $pictureArray->fileName;
   if ($pictureArray->error === 0) {      
       ($_POST["picture"] == "avatar.png") ?: unlink("pictures/{$_POST["picture"]}");
       $sql = "UPDATE users SET first_name = '$f_name', last_name = '$l_name', user_status = '$user_status', email = '$email', phone_number = '$phone_number', address = '$address', picture = '$pictureArray->fileName' WHERE id = {$id}";
   } else {
       $sql = "UPDATE users SET first_name = '$f_name', last_name = '$l_name',  user_status = '$user_status', email = '$email', phone_number = '$phone_number', address = '$address' WHERE id = {$id}";
   }

   if (mysqli_query($connect, $sql) === true) {    
       $class = "alert alert-light border border-3 border-success text-success";
       $message = "
       <hr class='bg-success py-1 mb-4 w-100'>
       <p class='my-2 fs-4'><i class='bi bi-check-circle'></i> The record was successfully updated</p>";
       $uploadError = ($pictureArray->error != 0) ? $pictureArray->ErrorMessage : '';
       header("refresh:2;url=dashBoard.php");
   } else {
       $class = "alert alert-light border border-3 border-danger text-danger";
       $message = "
       <hr class='bg-danger py-1 mb-4 w-100'>
       <p class='my-2 fs-4'><i class='bi bi-x-circle'></i> Error while updating record :</p><p>" . $connect->error . "</p>";
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
   <!-- BOOTSTRAP -->
   <?php require_once 'components/bootstrap.php'?>
   <!-- CSS -->
   <link rel="stylesheet" href="styles/style.css">
   <title>Update Profile</title>
</head>
<body class="dashboard_body">

<!-- [MAIN] -->
<main class="bg-transparent">
<div class="container py-5 rounded-3" style="max-width: 720px">
    <!-- notification after updating the profile -->
   <div class="<?php echo $class; ?>" role="alert">
       <p><?php echo ($message) ?? ''; ?></p>
       <p><?php echo ($uploadError) ?? ''; ?></p>       
   </div>

 
       <p class="text-center"></p>
       <!-- form -->
       <form class="rounded-3" method="post" enctype="multipart/form-data">
           <div class="table-responsive">
           <table class="table table-striped table-muted rounded-3">
                <tr>
                    <td colspan="2"><h2 class="display-3 fw-light mt-2 mb-5 text-center text-info my-4">
                    Update Profile
                    <hr class="bg-info shadow py-1 mt-3 mb-4 mx-auto w-75">
                    <img class='rounded-3 mb-0' height="155px" src='pictures/<?php echo $data['picture'] ?>' alt="<?php echo $f_name ?>"><br></h2>
                    
                    </td>
                </tr>
               <tr>
                   <th>First Name</th>
                   <td><input class="form-control" type="text"  name="first_name" placeholder ="First Name" value="<?php echo $f_name ?>"></td>
               </tr>
               <tr>
                   <th>Last Name</th>
                   <td><input class="form-control" type= "text" name="last_name"  placeholder="Last Name" value ="<?php echo $l_name ?>"></td>
               </tr>
               <tr>
                   <th class="text-danger">User Status</th>
                   <td>
                       <select class="form-control fw-bold text-danger" class="form-control" name="user_status">
                       <option value="<?php echo $user_status ?>"><?php echo ($user_status == 'adm')? 'adm': 'user' ?></option>
                       <option value="<?php echo ($user_status == 'adm')? 'user': 'adm' ?>">
                        <?php echo ($user_status == 'adm')? 'user': 'adm' ?>
                        </option>
                   </select>
                   <!-- <input class="form-control" type="text" name="user_status" placeholder= "Status of the user" value= "<?php echo $user_status?>"></td> -->
               </tr>
               <tr>
                   <th>Email</th>
                   <td><input class="form-control" type="email" name="email" placeholder= "Email" value= "<?php echo $email ?>"></td>
               </tr>
               <tr>
                   <th>Phone Number</th>
                   <td>
                    <input class='form-control mb-1 py-1' placeholder="Phone number" type="text"  name="phone_number" value ="<?php echo $phone_number ?>">                   
                </td>
               </tr>
               <tr>
                   <th>Address</th>
                   <td>
                    <input class='form-control mb-1 py-1' placeholder="Address" type="text"  name="address" value ="<?php echo $address ?>">
                    </td>
               </tr>
               <tr>
                <!-- new -->
                <!-- old -->
                <th>Picture</th>
                <td>
                    <div class="input-group">
                    <label class="input-group-text" for="upload_picture"><i class="bi bi-camera-fill"></i></label>
                    <input class="form-control"  type="file" name="picture" id="upload_picture">
                    </div>
                </td>
               </tr>
            </table>
            <div class="text-end">
                <!-- hidden picture and id -->
                <input type= "hidden" name= "id" value= "<?php echo $data['id'] ?>">
                <input type= "hidden" name= "picture" value= "<?php echo $picture ?>">
                <!-- buttons -->
                 <button class="btn btn-success py-2 mb-2 w-75" name="submit"  type= "submit">Save Changes</button>
                 <a href= "<?php echo $backBtn?>"><button class="btn btn-outline-light py-0 px-3 w-75" type="button">Dashboard</button></a>
            </div>
           </div>
       </form>   
</div>
</main>
</body>
</html>