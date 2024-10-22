<?php
session_start();
include '../db.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: student-login-yms.php");
    exit;
}

$student_id = $_SESSION['student_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Student Dashboard</title>
    <style>
        .logout-button {
    margin-left: 1200px; /* This will push the button to the right */
    padding: 10px 20px;
    background-color: #ff4d4d; /* Example button color */
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.logout-button:hover {
    background-color: #ff1a1a; /* Darker shade on hover */
}
        </style>
</head>
<body>
    <header>
        <h1>Student Dashboard</h1>
        <a href="student-login-yms.php" class="logout-button">logout</a>
    </header>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($student['username']); ?></h2>
        
        <p>Your Information:</p>
        <ul>
            <li><strong>Working Student:</strong> <?php echo htmlspecialchars($student['working_student']); ?></li>
            <li><strong>Section:</strong> <?php echo htmlspecialchars($student['section']); ?></li>
            <li><strong>Gender:</strong> <?php echo htmlspecialchars($student['gender']); ?></li>
        </ul>

        <p>Edit your information:</p>
        <form method="post" action="update-profile-yms.php">
            <input type="text" name="username" value="<?php echo htmlspecialchars($student['username']); ?>" required>
            <label for="working_student">Working Student:</label>
            <select name="working_student" required>
                <option value="Yes" <?php echo $student['working_student'] == 'Yes' ? 'selected' : ''; ?>>Yes</option>
                <option value="No" <?php echo $student['working_student'] == 'No' ? 'selected' : ''; ?>>No</option>
            </select>
            <input type="text" name="section" value="<?php echo htmlspecialchars($student['section']); ?>" placeholder="Section" required>
            <label for="gender">Gender:</label>
            <select name="gender" required>
                <option value="Male" <?php echo $student['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo $student['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                <option value="Other" <?php echo $student['gender'] == 'Other' ? 'selected' : ''; ?>>Other</option>
            </select>
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>
