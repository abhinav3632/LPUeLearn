<?php
session_start();
error_reporting(1);
include("includes/config.php");
if(isset($_POST['submit']))
{
    $regno=$_POST['regno'];
    $password=md5($_POST['password']);
$query=mysqli_query($bd, "SELECT * FROM students WHERE StudentRegno='$regno' and password='$password'");
if(mysqli_num_rows($query)>0)
{
$num=mysqli_fetch_array($query);
$extra="change-password.php";//
$_SESSION['login']=$_POST['regno'];
$_SESSION['id']=$num['studentRegno'];
$_SESSION['sname']=$num['studentName'];
$uip=$_SERVER['REMOTE_ADDR'];
$status=1;
$log=mysqli_query($bd, "insert into userlog(studentRegno,userip,status) values('".$_SESSION['login']."','$uip','$status')");
$host=$_SERVER['HTTP_HOST'];
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}
else
{
$_SESSION['errmsg']="Invalid Reg no or Password";
$extra="index.php";
$host  = $_SERVER['HTTP_HOST'];
$uri  = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title>Student Login</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet"  />
    <link href="assets/css/fontawesome.css" rel="stylesheet" />
    <link href="assets/css/styles.css" rel="stylesheet" v=<?php echo time(); ?>/>
</head>
<body>
    <section class="vh-100" style="background-color: #f78c30">
  <div class="container py-5 vh-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block"style="background-color: #82181A; border-radius: 1rem 0 0 1rem;">
              <img src="assets/img/naac.webp"
                alt="login form" class="img-fluid" style="height:100%; width:auto; border-radius: 1rem 0 0 1rem;" />
              <div id="space">
                <div class="stars"></div>
                <div class="stars"></div>
                <div class="stars"></div>
                <div class="stars"></div>
                <div class="stars"></div>
              </div>
            </div>
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

                <form name="admin" method="post">
                <div class="d-flex align-items-center justify-content-center mb-3 pb-1">
                <img src="assets/img/seal.svg" alt="login form" class="img-fluid me-3" style="width: 80px; height: 80px; margin: 1rem;"/>
                <i class="fa-solid fa-3x fa-graduation-cap" style="color: #171717;"></i>
                <span class="h1 mb-0" style="font-weight: bold;">LPUeLearn</span>
            </div>
                  <h5 class="fw-normal mb-2 pb-2" style="letter-spacing: 1px;">Sign into your account</h5>
                  <span style="color:red;" ><?php echo htmlentities($_SESSION['errmsg']); ?><?php echo htmlentities($_SESSION['errmsg']="");?></span>

                  <div class="form-outline mb-4">
                    <input type="text" name="regno" class="form-control form-control-lg" />
                    <label>Registration number </label>
                  </div>

                  <div class="form-outline mb-4">
                    <input type="password" name="password"  class="form-control form-control-lg" />
                    <label>Password </label>
                  </div>

                  <div class="pt-1 mb-4">
                    <button class="btn btn-light btn-lg btn-block" type="submit" name="submit" style="background-color:#fd9b46; border-radius: 0.5rem;
                    color:white; ">Login</button>
                  </div>

                  <a href="#!" class="small text-muted">Terms of use.</a>
                  <a href="#!" class="small text-muted">Privacy policy</a>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
 
    <?php include('includes/footer.php');?>
   
    <script src="assets/js/jquery-1.11.1.js"></script>

    <script src="assets/js/bootstrap.js"></script>
</body>
</html>
