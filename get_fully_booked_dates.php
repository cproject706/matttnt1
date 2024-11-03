<?php

include 'db_connection.php';

$response = ['success' => false, 'dates' => [], 'message' => ''];


if (isset($_GET['hotel_id'])) {
    $hotel_id = intval($_GET['hotel_id']);


    $sql = "SELECT fully_booked_date FROM fully_booked_dates WHERE hotel_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $hotel_id);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $response['dates'][] = $row['fully_booked_date'];
        }
        $response['success'] = true;
    } else {
        $response['message'] = 'Query error: ' . $stmt->error;
    }

    $stmt->close();
} else {
    $response['message'] = 'No hotel ID provided.';
}


header('Content-Type: application/json');
echo json_encode($response);


mysqli_close($conn);
?>
