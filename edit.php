<?php
include 'connect.php';
include 'header.php';
?>

<?php
// check if an id was passed in the URL
if (!isset($_GET['id'])) {
    echo "No review selected.";
    include 'footer.php';
    exit; // stop the page
}

$id = $_GET['id'];


// get the review with this id
$sql = "SELECT * FROM reviews WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

// review the row (should only be one)
$review = $stmt->fetch(PDO::FETCH_ASSOC);

// If no review found, the id doesn't exist
if (!$review) {
    echo "<p>Review not found.</p>";
    require 'footer.php';
    exit;
}
?>