<?php
session_start();
include '../db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login-yms.php");
    exit;
}

// Add a student
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if 'username' and 'password' are set in $_POST
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $working_student = isset($_POST['working_student']) ? $_POST['working_student'] : null;
        $section = isset($_POST['section']) ? $_POST['section'] : null;
        $gender = isset($_POST['gender']) ? $_POST['gender'] : null;

        $sql = "INSERT INTO users (username, password, working_student, section, gender) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $username, $password, $working_student, $section, $gender);
        $stmt->execute();
    }
}

// Fetch all students
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// Add an admin account
if (isset($_POST['add_admin'])) {
    if (isset($_POST['admin_username']) && isset($_POST['admin_password'])) {
        $admin_username = $_POST['admin_username'];
        $admin_password = password_hash($_POST['admin_password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO admin (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $admin_username, $admin_password);
        $stmt->execute();
    }
}

// Fetch all admins
$sql = "SELECT * FROM admin";
$admin_result = $conn->query($sql);

// Delete student or admin
if (isset($_GET['delete_user'])) {
    $user_id = $_GET['delete_user'];
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    header("Location:manage-students-yms.php");
    exit;
}

if (isset($_GET['delete_admin'])) {
    $admin_id = $_GET['delete_admin'];
    $sql = "DELETE FROM admin WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    header("Location: manage-students-yms.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Manage Accounts</title>
    <style>
        .logout-button {
            margin-left: 1200px;
            padding: 10px 20px;
            background-color: #ff4d4d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .logout-button:hover {
            background-color: #ff1a1a;
        }
    </style>
</head>
<body>
    <header>
        <h1>Manage Accounts</h1>
        <a href="admin-dashboard-yms.php" class="logout-button">Back</a>
    </header>
    <div class="container">
        <h2>Add Student Accounts</h2>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <label for="working_student">Working Student:</label>
            <select name="working_student" required>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
            <input type="text" name="section" placeholder="Section" required>
            <label for="gender">Gender:</label>
            <select name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
            <button type="submit">Add Student</button>
        </form>

        <h2>Manage Student Accounts</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Working Student</th>
                <th>Section</th>
                <th>Gender</th>
                <th>Action</th>
            </tr>
            <?php while ($user = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['working_student']; ?></td>
                    <td><?php echo $user['section']; ?></td>
                    <td><?php echo $user['gender']; ?></td>
                    <td>
                        <a href="?delete_user=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <h2>Add Admin Accounts</h2>
        <form method="post">
            <input type="text" name="admin_username" placeholder="Admin Username" required>
            <input type="password" name="admin_password" placeholder="Admin Password" required>
            <button type="submit" name="add_admin">Add Admin</button>
        </form>

        <h2>Manage Admin Accounts</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Action</th>
            </tr>
            <?php while ($admin = $admin_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $admin['id']; ?></td>
                    <td><?php echo $admin['username']; ?></td>
                    <td>
                        <a href="?delete_admin=<?php echo $admin['id']; ?>" onclick="return confirm('Are you sure you want to delete this admin?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
