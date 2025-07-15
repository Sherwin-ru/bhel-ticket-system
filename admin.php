<?php
session_start();
include("db/db_config.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.html");
    exit();
}

$filter = "1";

if (!empty($_GET['q'])) {
    $q = $conn->real_escape_string($_GET['q']);
    $filter .= " AND (u.name LIKE '%$q%' OR t.title LIKE '%$q%')";
}

if (!empty($_GET['status'])) {
    $status = $_GET['status'];
    $filter .= " AND t.status = '$status'";
}

$tickets = $conn->query("SELECT t.*, u.name FROM tickets t JOIN users u ON t.user_id = u.id WHERE $filter ORDER BY t.created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - BHEL</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            background: linear-gradient(135deg, #ff416c, #ff4b2b, #1e90ff, #32cd32, #9400d3);
            background-size: 400% 400%;
            animation: gradientBG 12s ease infinite;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            background-color: rgba(255, 255, 255, 0.95);
            margin: 40px;
            padding: 30px;
            border-radius: 15px;
            width: 90%;
            max-width: 1200px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
        }

        h2, h3 {
            text-align: center;
            color: #1e1e1e;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"], select, button {
            padding: 10px;
            font-size: 14px;
            margin: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #1e90ff;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #3742fa;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffcc;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #ff9933;
            color: white;
        }

        td form {
            margin: 0;
        }

        a {
            color: #1e90ff;
            text-decoration: none;
            display: block;
            text-align: right;
            margin-top: 20px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Admin Dashboard</h2>
    <h3>All Complaints</h3>

    <!-- Search and Filter Form -->
    <form method="GET" action="admin.php">
        <input type="text" name="q" placeholder="Search title or user" value="<?= $_GET['q'] ?? '' ?>">
        <select name="status">
            <option value="">-- Status --</option>
            <option value="Open" <?= ($_GET['status'] ?? '') == 'Open' ? 'selected' : '' ?>>Open</option>
            <option value="In Progress" <?= ($_GET['status'] ?? '') == 'In Progress' ? 'selected' : '' ?>>In Progress</option>
            <option value="Resolved" <?= ($_GET['status'] ?? '') == 'Resolved' ? 'selected' : '' ?>>Resolved</option>
        </select>
        <button type="submit">Search</button>
    </form>

    <table>
        <tr>
            <th>User</th>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Raised On</th>
        </tr>
        <?php while ($row = $tickets->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td>
                <form method="POST" action="update_status.php">
                    <input type="hidden" name="ticket_id" value="<?= $row['id'] ?>">
                    <select name="status" onchange="this.form.submit()">
                        <option value="Open" <?= $row['status'] == 'Open' ? 'selected' : '' ?>>Open</option>
                        <option value="In Progress" <?= $row['status'] == 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                        <option value="Resolved" <?= $row['status'] == 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                    </select>
                </form>
            </td>
            <td><?= $row['created_at'] ?></td>
        </tr>
        <?php } ?>
    </table>

    <a href="logout.php">Logout</a>
</div>
</body>
</html>
