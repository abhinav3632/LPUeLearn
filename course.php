<?php
session_start();
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
    {   
header('location:index.php');
}
else{

if(isset($_POST['submit']))
{
    $coursecode = $_POST['coursecode'];
    $coursename = $_POST['coursename'];
    $semester = $_POST['semester'];
    $courseunit = $_POST['courseunit'];
    $moocCourseName = $_POST['moocCourseName'];
    $moocLink = $_POST['moocLink'];
    $details = $_POST['details'];


    $ret = mysqli_query($bd, "insert into course(courseCode, courseName, courseUnit, semester, moocCourseName, moocLink, details) 
    values('$coursecode', '$coursename', '$semester', '$courseunit', '$moocCourseName', '$moocLink', '$details')");

    if ($ret) {
        $_SESSION['msg'] = "Course Created Successfully !!";
    } else {
        $_SESSION['msg'] = "Error: Course not created";
    }
}
if(isset($_GET['del']))
      {
              mysqli_query($bd, "delete from course where id = '".$_GET['id']."'");
                  $_SESSION['delmsg']="Course deleted !!";
      }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin | Course</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/fontawesome.css" rel="stylesheet" />
    <link href="assets/css/styles.css" rel="stylesheet" />
</head>

<body>
    <?php include('includes/header.php');?>

    <?php if($_SESSION['login']!="")
    {
     include('includes/menubar.php');
    }
     ?>

    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line">Course </h1>
                </div>
            </div>
            <font color="red" align="center">
                <?php echo htmlentities($_SESSION['delmsg']);?><?php echo htmlentities($_SESSION['delmsg']="");?></font>
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        Courses Details
                    </div>

                    <div class="card-body">
                        <div class="table-responsive table-bordered">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Course Code</th>
                                        <th>Course Name</th>
                                        <th>Semester</th>
                                        <th>Grade</th>
                                        <th>MOOC Course Name</th>
                                        <th>MOOC Link</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
$sql=mysqli_query($bd, "select * from course");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{
?>
                                    <tr>
                                        <td><?php echo $cnt; ?></td>
                                        <td><?php echo htmlentities($row['courseCode']); ?></td>
                                        <td><?php echo htmlentities($row['courseName']); ?></td>
                                        <td><?php echo htmlentities($row['semester']); ?></td>
                                        <td><?php echo htmlentities($row['courseUnit']); ?></td>
                                        <td><?php echo htmlentities($row['moocCourseName']); ?></td>
                                        <td><?php echo htmlentities($row['moocLink']); ?></td>
                                        <td><?php echo htmlentities($row['details']); ?></td>
                                    </tr>
                                    <?php 
$cnt++;
} ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>





    </div>
    </div>

    <?php include('includes/footer.php');?>

    <script src="assets/js/jquery-1.11.1.js"></script>

    <script src="assets/js/bootstrap.js"></script>
</body>

</html>
<?php } ?>