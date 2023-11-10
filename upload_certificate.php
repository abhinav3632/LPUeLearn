<?php
session_start();
include('includes/config.php');

// Check if the certificate is already uploaded
$studentRegno = $_SESSION['login'];
$course_id = $_POST['course_id'];
$certificate_uploaded = mysqli_query($bd, "SELECT certificate_name FROM certificates WHERE studentRegno='$studentRegno' AND course_id='$course_id'");

// Disable the upload button if the certificate is already uploaded
if (mysqli_num_rows($certificate_uploaded) > 0) {
    $disableButton = true;
} else {
    $disableButton = false;
}

if (isset($_POST['upload_certificate'])) {
    if (!$disableButton) {
        $course_id = $_POST['course_id'];
        $studentRegno = $_SESSION['login'];
        $upload_dir = 'certificate_uploads/';

        // Create a subfolder for each student's certificates based on their registration number
        $student_folder = $upload_dir . $studentRegno;
        if (!is_dir($student_folder)) {
            mkdir($student_folder);
        }

        $targetFile = $student_folder . '/' . basename($_FILES["certificate_file"]["name"]);
        $uploadOk = 1;

        // Check if the file already exists
        if (file_exists($targetFile)) {
            $_SESSION['msg'] = "Sorry, this certificate already exists.";
            $uploadOk = 0;
        }

        // Check the file size (you can adjust the limit)
        if ($_FILES["certificate_file"]["size"] > 5000000) {
            $_SESSION['msg'] = "Sorry, your certificate file is too large.";
            $uploadOk = 0;
        }

        // Allow only specific file types(e.g, jpg, png, pdf)
        $allowedExtensions = array("jpg", "jpeg","png","pdf");
        $fileExtension = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedExtensions)) {
            $_SESSION['msg'] = "Sorry, only JPG, JPEG, PNG, and PDF certificates are allowed.";
            $uploadOk = 0;
        }

        // If no errors, attempt to upload the certificate file
        if ($uploadOk == 0) {
            $_SESSION['msg'] = "Sorry, your certificate file was not uploaded. ";
            if (file_exists($targetFile)) {
                $_SESSION['msg'] .= "Certificate already exists.";
            } else if ($_FILES["certificate_file"]["size"] > 5000000) {
                $_SESSION['msg'] .= "File size is too large.(5mb)";
            } else if (!in_array($fileExtension, $allowedExtensions)) {
                $_SESSION['msg'] .= "Invalid file type. Only JPG, JPEG, PNG, and PDF certificates are allowed.";
            }
        } else {
            if (move_uploaded_file($_FILES["certificate_file"]["tmp_name"], $targetFile)) {
                $certificate_name = basename($_FILES["certificate_file"]["name"]);

                // Insert the certificate record into the database
                $query = "INSERT INTO certificates (studentRegno, course_id, certificate_name, upload_date) 
                VALUES ('$studentRegno', '$course_id', '$certificate_name', NOW())";
                mysqli_query($bd, $query);

                $_SESSION['msg'] = "Certificate uploaded successfully!";
            } else {
                $_SESSION['msg'] = "Sorry, there was an error uploading your certificate file.";
            }
        }
    }
}

header('Location: enroll-history.php');
?>