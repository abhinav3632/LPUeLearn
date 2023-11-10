<?php
session_start();
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Enroll History</title>
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
                    <h1 class="page-head-line">Enroll History </h1>
                </div>
            </div>
            <div class="row">

                <div class="col-md-12">
    
                    <div class="card card-default">
                        <div class="card-header">
                            Enroll History
                        </div>

                        <div class="card-body">
                        <font color="green" align="center">
                            <?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?>
                        </font>
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Course Name </th>
                                            <th>Session </th>
                                            <th> Department</th>
                                            <th>Level</th>
                                            <th>Semester</th>
                                            <th>Enrollment Date</th>
                                            <th>Link</th>
                                            <th>Certificate</th>
                                            <th>Uploaded</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
$sql=mysqli_query($bd, "select courseenrolls.course as cid, course.courseName as courname,session.session as session,department.department as dept,level.level as level,courseenrolls.enrollDate as edate ,semester.semester as sem,course.moocLink AS moocLink from courseenrolls join course on course.id=courseenrolls.course join session on session.id=courseenrolls.session join department on department.id=courseenrolls.department join level on level.id=courseenrolls.level  join semester on semester.id=courseenrolls.semester  where courseenrolls.studentRegno='".$_SESSION['login']."'");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{
?>


                                        <tr>
                                            <td><?php echo $cnt;?></td>
                                            <td><?php echo htmlentities($row['courname']);?></td>
                                            <td><?php echo htmlentities($row['session']);?></td>
                                            <td><?php echo htmlentities($row['dept']);?></td>
                                            <td><?php echo htmlentities($row['level']);?></td>
                                            <td><?php echo htmlentities($row['sem']);?></td>
                                            <td><?php echo htmlentities($row['edate']);?></td>
                                            <td>
                                                <a href="<?php echo $row['moocLink']; ?>" target="_blank">
                                                    <button class="btn btn-primary"><i class="fa fa-print "></i> Open
                                                        MOOC Link</button>
                                                </a>
                                            </td>
                                            <td>
                                                <form action="upload_certificate.php" method="post"
                                                    enctype="multipart/form-data">
                                                    <input type="file" name="certificate_file" />
                                                    <input type="hidden" name="course_id"
                                                        value="<?php echo $row['cid']; ?>" />
                                                    <button type="submit" name="upload_certificate"
                                                        class="btn btn-secondary">
                                                        <i class="fa fa-upload"></i> Upload Certificate
                                                    </button>
                                                </form>
                                            </td>
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