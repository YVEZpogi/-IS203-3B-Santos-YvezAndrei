<?php
session_start();
include '../db.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: student-login-yms.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_SESSION['student_id'];
    $username = $_POST['username'];
    $working_student = $_POST['working_student'];
    $section = $_POST['section'];
    $gender = $_POST['gender'];

    $sql = "UPDATE users SET username = ?, working_student = ?, section = ?, gender = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $username, $working_student, $section, $gender, $student_id);
    
    if ($stmt->execute()) {
        // Redirect to dashboard on success
        header("Location: student-dashboard-yms.php");
        exit;
    } else {
        // Handle error (optional)
        echo "Error updating record: " . $conn->error;
    }
}
?>
