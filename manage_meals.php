<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: admin_login.php");
    exit();
}

include 'db_connection.php';

$sql = "SELECT * FROM meals";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Meals - Matt Travel and Tours</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Manage Meals</h2>
        <a href="add_meal.php" class="btn btn-primary mb-3">Add New Meal</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Meal Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($meal = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $meal['id'] . "</td>";
                        echo "<td>" . htmlspecialchars($meal['name']) . "</td>";
                        echo "<td>$" . number_format($meal['price'], 2) . "</td>";
                        echo "<td>" . htmlspecialchars(substr($meal['description'], 0, 50)) . "...</td>";
                        echo "<td><img src='" . htmlspecialchars($meal['image_url']) . "' alt='Meal Image' width='200'></td>";
                        echo "<td><a href='edit_meal.php?id=" . $meal['id'] . "' class='btn btn-warning btn-sm'>Edit</a> ";
                        echo "<a href='delete_meal.php?id=" . $meal['id'] . "' class='btn btn-danger btn-sm'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No meals found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>

