<?php require_once("Includes/DB.php");?>

<?php require_once("Includes/Functions.php");?>

<?php require_once("Includes/Sessions.php");?>

<?php 

if (isset($_POST["submit"])) {
  $Username = $_POST["Username"];
  $Password = $_POST["Password"];
  if (empty($Username)||empty($Password)) {
    $_SESSION["ErrorMessage"]="All Fields must be filled out!";
    Redirect_to("Login.php");
  }else{
    //code for checking username and password from database
    $Found_Account=Login_attempt($Username,$Password);
    if ($Found_Account) {
      $_SESSION["UserId"] =$Found_Account["id"];
      $_SESSION["UserName"]=$Found_Account["username"];
      $_SESSION["AdminName"]=$Found_Account["aname"];
      $_SESSION["SuccessMessage"]="Welcome ".$_SESSION["AdminName"];
      if (isset($_SESSION["TrackingURL"])) {
        Redirect_to($_SESSION["TrackingURL"]);
      }else{
         Redirect_to("Dashboard.php");
      }

    }else{
      $_SESSION["ErrorMessage"]="Incorrect Username/password";
      Redirect_to("Login.php");
    }
  }
}

 ?>

<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
	<title>
		document
	</title>
	<link rel="stylesheet" type="text/css" href="Css/Styles.css">
</head>
<body>

  <!--Navbar Start-->

  <div style="height: 10px; background: #27aae1"></div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" >
	<div class="container">
	<a href="" class="navbar-brand">Forid.com</a>

    <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarcollapseCMS">

    
      </div>
    </div>

</nav>
  <div style="height: 10px; background: #27aae1"></div>

<!--Navbar End-->

<!--Header-->

<header class="bg-dark text-white py-3">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        
      </div>
    </div>
  </div>
</header>
<br>
<!--Header End-->

<!--Main Area Start-->

 <section class="container py-2 mb-4">
   <div class="row">
     <div class="offset-sm-3 col-sm-6" style="min-height: 400px;">
      <br>
      <?php 
           echo ErrorMessage();
           echo SuccessMessage();
         ?>
       <div class="card bg-secondary text-light">
         <div class="card-header">
           <h4>Wellcome Back</h4>
           </div>
           <div class="card-body bg-dark">
             
           
           <form class="" action="Login.php" method="post">
             <div class="form-group">
               <label for="username"><span class="FieldInfo">Username:</span></label>
               <div class="input-group mb-3">
                 <div class="input-group-prepend">
                   <span class="input-group-text text-white bg-info"><i class="fas fa-user"></i></span>
                 </div>
                 <input type="" class="form-control" name="Username" id="username">
               </div>
             </div>
             <div class="form-group">
               <label for="password"><span class="FieldInfo">Password:</span></label>
               <div class="input-group mb-3">
                 <div class="input-group-prepend">
                   <span class="input-group-text text-white bg-info"><i class="fas fa-lock"></i></span>
                 </div>
                 <input type="password" class="form-control" name="Password" id="password">
               </div>
               
             </div>
             <input type="submit" name="submit" class="btn btn-info btn-block " value="Login">
           </form>
         </div>
       </div>
     </div>
   </div>
 </section>

<!--Main Area End-->

<!--Footer-->
<footer class="bg-dark text-white">
  <div class="container">
    <p class="lead text-center">Theme By | learners flame | <span id="demo"></span> &copy; ----All rights reserved.</p>
  </div>
  <div style="height: 10px; background: #27aae1"></div>
</footer>

<!--Footer End-->


<script>
  const d = new Date();
  document.getElementById("demo").innerHTML = d.getFullYear();
</script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html> 