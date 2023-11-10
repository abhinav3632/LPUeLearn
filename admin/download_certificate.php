<?php
session_start();
include('includes/config.php');

if ($_SESSION['alogin'] === null) {
    $_SESSION['msg'] = "You are not logged in as an admin.";
    header('location:index.php');
} else {
    if (!isset($_GET['certificate_name']) || !isset($_GET['student_regno'])) {
        $_SESSION['msg'] = "Invalid request.";
        header('location:enroll-history.php');
        exit;
    }
    $certificateName = $_GET['certificate_name'];
    $studentRegno = $_GET['student_regno'];
    $sourceDir = '../certificate_uploads/' . $studentRegno;
    $destinationDir = 'admin_certificate/' . $studentRegno;

    if (is_dir($sourceDir)) {
        if (!is_dir($destinationDir) || count(glob($destinationDir . '/*')) === 0) {
            copyDirectory($sourceDir, $destinationDir);
            $_SESSION['msg'] = "Certificate downloaded successfully.";
        } else {
            $_SESSION['msg'] = "Certificate folder already exists in the admin directory.";
        }
    } else {
        $_SESSION['msg'] = "Source directory not found.";
    }

    header('location:enroll-history.php');
}

function copyDirectory($source, $destination) {
    if (is_dir($source)) {
        @mkdir($destination);
        $files = glob($source . '/*');
        foreach ($files as $file) {
            $dest = $destination . '/' . basename($file);
            if (is_dir($file)) {
                copyDirectory($file, $dest);
            } else {
                copy($file, $dest);
            }
        }
    }
}
