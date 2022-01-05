<?php 
session_start();
require_once 'components/db_connect.php';
// if session is not set this will redirect to login page
if( !isset($_SESSION['adm']) && !isset($_SESSION['user']) ) {
   header("Location: index.php");
   exit;
  }
if(isset($_SESSION["user"])){
   header("Location: home.php");
   exit;
  }
  
//initial bootstrap class for the confirmation message
  $class = 'd-none';
//the GET method will show the info from the user to be deleted
  if ($_GET['id']) {
  $id = $_GET['id'];
  $sql = "SELECT * FROM users WHERE id = {$id}" ;
  $result = mysqli_query($connect, $sql);
  $data = mysqli_fetch_assoc($result);
  if (mysqli_num_rows($result) == 1) {
   $f_name = $data['first_name'];
   $l_name = $data['last_name'];
   $user_status = $data['user_status'];
   $email = $data['email'];
   $phone_number = $data['phone_number'];
   $address = $data['address'];
   $picture = $data['picture'];
} }
//the POST method will actually delete the user permanently
if ($_POST) {
   $id = $_POST['id'];
   $picture = $_POST['picture'];
   ($picture =="avatar.png")?: unlink("pictures/$picture");

  $sql = "DELETE FROM users WHERE id = {$id}";
  if ($connect->query($sql) === TRUE) {
   $class = "alert alert-success";
   $message = "Successfully Deleted!";
   header("refresh:3;url=dashboard.php");
} else {
   $class = "alert alert-danger";
   $message = "The entry was not deleted due to: <br>" . $connect->error;
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
   <title>Delete User</title>
</head>
<body id="dashboard_body">
   <!-- [MAIN] -->
   <main class="bg-transparent">
      <div class="<?php echo $class; ?>" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>           
      </div>

      <div class='container my-5 p-3 mx-auto text-danger text-center' style='min-width: 18rem; max-width: 540px;'>
         <div class='row justify-content-center align-items-center bg-light text-danger border border-2 border-danger rounded-3 py-4 shadow'>
                     <h1 class="text-danger"><i class="bi bi-exclamation-triangle-fill"></i> ATTENTION</h1>
                     <hr class='bg-danger py-1 mb-4 mx-auto w-75'>
                     <p class='mt-2 mb-0 fs-4'>You are about to delete the user below:</p>
                     <div class="col-sm-8 col-md-5">
                           <!-- <img class='img-fluid' max-width='420px' width='100%' src='pictures/<?= $picture ?>'> -->
                     </div>
                        
                     <table class="table text-dark w-75 mt-1 px-2">
                        <tr class="mx-3 align-middle border border-muted bg-white">
                           <td><img class="img-fluid" width="50px" src="pictures/<?php echo $picture?>"></td>
                           <td><?php echo "$f_name $l_name"?></td>
                           <td><?php echo $email?></td>
                        </tr>
                     </table>

                     <h3 class="mb-3">Do you really want to delete this user?</h3>
                     <div class='col-sm-12 col-md-7 border-start border-1 ps-3'>

                     </div>
                     <div class='col-12 py-0 my-2'>
                        <!-- post method with hidden id and picture data -->
                     <form method="post">
                        <input type="hidden" name="id" value="<?php echo $id ?>" />
                        <input type="hidden" name="picture" value="<?php echo $picture ?>" />
                        <button class="btn btn-outline-danger fw-bold py-0 my-1" type="submit">Yes, please!</button >
                        <a href="dashboard.php">
                        <button class="btn btn-primary fw-bold py-0 my-1" type="button">No, return!</button></a>
                     </form>
                     </div>
                    </div>
                </div>

               
</body>
</html>