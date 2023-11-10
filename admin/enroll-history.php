<?php
session_start();
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{



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

    <?php if($_SESSION['alogin']!="")
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
                            <a href="download_certificate.php?certificate_name=<?php echo $row['certificate_name']; ?>&student_regno=<?php echo $row['certificate_studentRegNo']; ?>"
                            class="btn btn-primary">
                            <i class="fa fa-download"></i> Download Certificate
                        </a>
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
                                            <th>Student Name </th>
                                            <th>Student Reg no </th>
                                            <th>Course Name </th>
                                            <th>Department</th>
                                            <th>Session</th>
                                            <th>Semester</th>
                                            <th>Enrollment Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
$sql=mysqli_query($bd, "SELECT 
ce.course AS cid, 
c.courseName AS courname, 
s.session AS session, 
d.department AS dept, 
ce.enrollDate AS edate, 
se.semester AS sem, 
st.studentName AS sname, 
st.StudentRegno AS sregno, 
crt.studentRegNo AS certificate_studentRegNo
FROM courseenrolls ce
JOIN course c ON c.id = ce.course
JOIN session s ON s.id = ce.session
JOIN department d ON d.id = ce.department
JOIN semester se ON se.id = ce.semester
JOIN students st ON st.StudentRegno = ce.studentRegno
LEFT JOIN certificates crt ON crt.studentRegNo = st.StudentRegno
");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{
?>


                                        <tr>
                                            <td><?php echo $cnt;?></td>
                                            <td><?php echo htmlentities($row['sname']);?></td>
                                            <td><?php echo htmlentities($row['sregno']);?></td>
                                            <td><?php echo htmlentities($row['courname']);?></td>
                                            <td><?php echo htmlentities($row['dept']);?></td>
                                            <td><?php echo htmlentities($row['session']);?></td>
                                            <td><?php echo htmlentities($row['sem']);?></td>
                                            <td><?php echo htmlentities($row['edate']);?></td>
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