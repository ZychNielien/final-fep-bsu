<?php
include "../../model/dbconnection.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetching the booking ID and faculty ID from the POST request
    $bookingId = $_POST['id'];
    $facultyId = $_POST['facultyId'];

    // Prepare the SQL statement to delete the booking
    $query = "DELETE FROM bookings WHERE id = ? AND faculty_Id = ?";

    // Initialize the response array
    $response = ['success' => false];

    // Prepare the statement
    if ($stmt = $con->prepare($query)) {
        // Bind the parameters
        $stmt->bind_param("si", $bookingId, $facultyId); // 's' for string, 'i' for integer

        // Execute the statement
        if ($stmt->execute()) {
            // Check if a row was deleted
            if ($stmt->affected_rows > 0) {
                $response['success'] = true; // Set success to true if deletion was successful
            } else {
                $response['message'] = "No booking found with the provided ID and Faculty ID.";
            }
        } else {
            $response['message'] = "Error executing query: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        $response['message'] = "Error preparing the statement: " . $con->error;
    }

    // Close the database connection
    $con->close();

    // Return the response in JSON format
    echo json_encode($response);
}
?>