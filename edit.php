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

<h2>Edit Review</h2>

<!-- form pre-filled with the existing values -->
<form method="POST" action="update.php">
    <!-- keep track of which review we're updating -->
    <input type="hidden" name="id" value="<?php echo $review['id']; ?>">
    
    <label>Title:</label><br>
    <input type="text" name="title" value="<?php echo htmlspecialchars($review['title']); ?>"><br><br>

    <label>Author:</label><br>
    <input type="text" name="author" value="<?php echo htmlspecialchars($review['author']); ?>"><br><br>

    <label>Rating:</label><br>
    <input type="number" name="rating" value="<?php echo $review['rating']; ?>"><br><br>

    <label>Review:</label><br>
    <textarea name="review" required><?php echo htmlspecialchars($review['review_text']); ?></textarea><br><br>

    <button type="submit">Save Changes</button>
</form>