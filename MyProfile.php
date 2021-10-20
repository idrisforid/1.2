<?php require_once("Includes/DB.php");?>

 <?php require_once("Includes/Functions.php");?>

 <?php require_once("Includes/Sessions.php");?>
 <?php 
 $_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
 Confirm_Login(); ?>
<?php

//Fetching the existing Admin Data

$AdminId= $_SESSION["UserId"];
global $ConnectingDB;
$sql = "SELECT * FROM admins WHERE id='$AdminId'";
$stmt= $ConnectingDB->query($sql);
while ($DataRows=$stmt->fetch()) {
      $ExistingName=$DataRows['aname'];
}
//Fetching the existing Admin Data


if (isset($_POST["submit"])) {
  $PostTitle= $_POST["PostTitle"];
  $Category = $_POST["Category"];
  $Image = $_FILES["Image"]["name"];
  $Target   = "Uploads/".basename($_FILES["Image"]["name"]);
  $PostText = $_POST["PostDescription"];
  $Admin ="admin";

  date_default_timezone_set("Asia/Dhaka");
  $CurrentTime=time();
  $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
  

  if (empty($PostTitle)) {
    $_SESSION["ErrorMessage"]= "Title!";
     Redirect_to("AddNewPost.php");
  }
  else if (strlen($PostTitle)<3) {
    $_SESSION["ErrorMessage"]= "Post title should be greater than 3 characters";
     Redirect_to("AddNewPost.php");
  }
  else if (strlen($PostText)>1000) {
    $_SESSION["ErrorMessage"]= "Post text should be less than 50 characters";
     Redirect_to("AddNewPost.php");
  }
  else{
    //Query to insert post to DB when everything fine

     global $ConnectingDB;

    $sql = "INSERT INTO posts(datetime,title,category,author,image,post)";
    $sql.= "VALUES(:dateTime,:postTitle,:categoryName,:adminName,:imageName,:postDescription)";
    $stmt= $ConnectingDB->prepare($sql);
    $stmt->bindValue(':dateTime',$DateTime);
    $stmt->bindValue(':postTitle',$PostTitle); 
    $stmt->bindValue(':categoryName',$Category);
    $stmt->bindValue(':adminName',$Admin);
    $stmt->bindValue(':imageName',$Image);
    $stmt->bindValue(':postDescription',$PostText);

    $Execute=$stmt->execute();
    move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
    if ($Execute) {
      $_SESSION["SuccessMessage"]="Post with id: ".$ConnectingDB->lastInsertId()." Added Successfully";
      Redirect_to("AddNewPost.php");
    }
    else{
      $_SESSION["ErrorMessage"]="Category Added Fail. Try again.";
      Redirect_to("AddNewPost.php");
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
		My Profile
	</title>
	<link rel="stylesheet" type="text/css" href="Css/Styles.css">
</head>
<body>

  <!--Navbar Start-->

  <div style="height: 10px; background: #27aae1"></div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<div class="container">
	<a href="#" class="navbar-brand">Forid.com</a>

    <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarcollapseCMS">

    <ul class="navbar-nav ml-auto">
          <li class="nav-item">
          	<a href="MyProfile.php" class="nav-link"> <i class="fas fa-user text-success"></i> My Profile</a>
          </li> 
          <li class="nav-item">
          	<a href="Dashboard.php" class="nav-link">Dashboard</a>
          </li>
          <li class="nav-item">
          	<a href="post.php" class="nav-link">post</a>
          </li>
          <li class="nav-item">
          	<a href="categories.php" class="nav-link">categories</a>
          </li>
          <li class="nav-item">
          	<a href="Admins.php" class="nav-link">Manage Admins</a>
          </li>
          <li class="nav-item">
          	<a href="Comments.php" class="nav-link">Comments</a>
          </li>
          <li class="nav-item">
          	<a href="Blog.php" class="nav-link">Live Blog</a>
          </li>   
    </ul>
    <ul class="navbar-nav ml-auto">
            <li class="nav-item">
            <a href="Logout.php" class="nav-link text-danger"> <i class="fas fa-user-times"></i> Logout</a>
            </li>
    </ul>
      </div>
    </div>
</nav>
  <div style="height: 10px; background: #27aae1"></div>

<!--Navbar End-->

<!--Header-->

<header class="bg-dark text-white py-3">
  <div class="container">
    <div class="row">
      <h1> <i class="fas fa-user mr-2" style="color: #27aae1;"></i> My Profile</h1>
    </div>
  </div>
</header>

<!--Header End-->

<!--Main area-->
<section class="container py-2 mb-4">
  <div class="row" >

   <!--Left Area-->
   <div class="col-md-3">
     <div class="card">
       <div class="card-header bg-dark text-light">
         <h3><?php echo $ExistingName; ?></h3>
       </div>
       <div class="card-body">
         <img src="Images/avatar-bg.png" class="block img-fluid mb-3">
         <div class="">
           Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi at tellus finibus, pretium ante sed, suscipit nisl. Suspendisse ornare placerat lorem eu blandit. Praesent at volutpat ante. Sed vehicula turpis et hendrerit varius. 
         </div>
       </div>
     </div>
   </div>


    <!--Right Area-->
    <div class="col-md-9" style="min-height: 340px;">

        <?php 
           echo ErrorMessage();
           echo SuccessMessage();
         ?>

        <form class="" action="MyProfile.php" method="post" enctype="multipart/form-data">
           <div class="card bg-dark text-light mb-3">
             <div class="card-header bg-secondary text-light">
               <h4>Edit Profile</h4>
             </div>
             <div class="card-body bg-dark">
               <div class="form-group">
                 <input class="form-control" type="text" name="Name" id="title" placeholder="Your name here" >
                 
               </div>
               <div class="form-group">
                <input class="form-control" type="text" id="title" placeholder="headline" name="headline" >
                 <small class="text-muted">Add a professional headline like, 'Engineer' at XYZ or 'Architect'</small>
                 <span class="text-danger">Not more than 12 characters</span>
               </div>

               <div class="mb-3">
                 <textarea class="form-control" placeholder="Bio" id="Post" name="PostDescription" rows="8" cols="80"></textarea>
               </div>
               
               <div class="form-group">
                 <div class="custom-file">
                 <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                 <label for="imageSelect" class="custom-file-label">Select Image</label>
                 </div>
               </div>
               

               <div class="row">
                 <div class="col-lg-6 mb-2">
                   <a href="Dashboard.php" class="btn btn-warning btn-block"> <i class="fas fa-arrow-left"></i> Back Dashboard</a>
                 </div>

                 <div class="col-lg-6 mb-2">
                   <button type="submit" name="submit" class="btn btn-success btn-block"> <i class="fas fa-check"></i> Publish </button>
                 </div>
               </div>
             </div>
           </div>
        </form>
    </div>
  </div>
</section>

<!--Main area end-->

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