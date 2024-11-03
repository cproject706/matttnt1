<?php

include 'db_connection.php'; 


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
    $hotel_id = $_POST['hotel_id'];
    $booked_dates = $_POST['booked_dates'];


    $response = ['success' => true, 'message' => 'Dates saved successfully'];

  
    $stmt = $conn->prepare("INSERT INTO fully_booked_dates (hotel_id, fully_booked_date) VALUES (?, ?)");
    if (!$stmt) {
        $response['success'] = false;
        $response['message'] = 'Database error: ' . $conn->error;
    } else {
        
        $stmt->bind_param("is", $hotel_id, $date);

        foreach ($booked_dates as $date) {
            $date = mysqli_real_escape_string($conn, $date); 
            if (!$stmt->execute()) {
                $response['success'] = false;
                $response['message'] = 'Error: ' . $stmt->error; 
                break; 
            }
        }
        $stmt->close();
    }

   
    echo json_encode($response);
}

// Close the database connection
mysqli_close($conn);
?>
