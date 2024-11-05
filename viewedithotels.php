    <?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }

    include 'db_connection.php';

    $id = $_GET['id'];
    $data = array();
    $sql = $conn->query("SELECT * FROM hotels WHERE id = '$id'");
    while($rows = mysqli_fetch_assoc($sql)){
        $data[] = $rows;
    }

    echo json_encode($data);
    ?>
