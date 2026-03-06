<?php
include 'connect.php';
include 'header.php';

// make sure an id was actually passed in the URL
if (!isset($_GET['id'])) {
    echo "No review selected.";
    include 'footer.php';
    exit; // stop the page
}

$id = $_GET['id'];

// delete the review with this id
$sql = "DELETE FROM reviews WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);

// try to run the delete
if ($stmt->execute()) {
    echo "Review deleted successfully!";
} else {
    echo "Error deleting review.";
}
include 'footer.php';
?>