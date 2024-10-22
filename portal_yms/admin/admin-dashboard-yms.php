<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Admin Dashboard</title>
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

.manage-students-button {
    display: inline-block;
    padding: 10px 15px;
    background-color: #007bff; /* Example button color */
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.manage-students-button:hover {
    background-color: #0056b3; /* Darker shade on hover */
}

    </style>
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
        <a href="admin-login-yms.php" class="logout-button">Logout</a>
    </header>
    <div class="container">
        <h2>Welcome, Admin!</h2>
        <a href="manage-students-yms.php" class="manage-students-button">Manage Students</a>
    </div>
</body>
</html>
