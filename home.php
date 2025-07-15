<?php
session_start();
include("db/db_config.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$tickets = $conn->query("SELECT * FROM tickets WHERE user_id = $user_id ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Home - BHEL</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            background: linear-gradient(135deg, #ff416c, #ff4b2b, #1e90ff, #32cd32, #9400d3);
            background-size: 400% 400%;
            animation: gradientBG 10s ease infinite;
            color: #333;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            max-width: 900px;
            margin: auto;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 30px;
            margin-top: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        h2, h3 {
            color: #1e1e1e;
        }

        form {
            margin-bottom: 25px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        button {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #1e90ff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #3742fa;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ccc;
        }

        th {
            background-color: rgb(255, 204, 102);
        }

        td {
            background-color: #fff8dc;
        }

        a {
            color: #1e90ff;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .logout {
            display: inline-block;
            margin-top: 20px;
            background-color: #ff4b2b;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
        }

        .logout:hover {
            background-color: #ff1c1c;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>  Welcome </h2>

    <!-- Raise Complaint Form -->
    <form action="submit_ticket.php" method="POST">
        <label for="title">Problem Title:</label>
        <input type="text" name="title" placeholder="Enter a short title" required>

        <label for="description">Description:</label>
        <textarea name="description" rows="4" placeholder="Describe your issue in detail..." required></textarea>

        <button type="submit">Raise Complaint</button>
    </form>

    <h3>Your Complaints</h3>
    <table>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Raised On</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $tickets->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><?= $row['status'] ?></td>
            <td><?= $row['created_at'] ?></td>
            <td>
                <?php if ($row['status'] != 'Resolved') { ?>
                    <a href="edit_ticket.php?id=<?= $row['id'] ?>">Edit</a> |
                    <a href="delete_ticket.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                <?php } else { echo 'Locked'; } ?>
            </td>
        </tr>
        <?php } ?>
    </table>

    <a class="logout" href="logout.php">Logout</a>
</div>
</body>
</html>
