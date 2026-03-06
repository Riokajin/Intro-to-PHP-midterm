<?php
include 'connect.php';
include 'header.php';
?>

<h2>Submit a Book Review</h2>

<?php
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //1. Validation: required fields
    if (empty($_POST['title']) || empty($_POST['author']) || empty($_POST['rating'])) {
        echo "Please fill in all required fields";
        } else if (!is_numeric($_POST['rating'])) {
            echo "Rating has to be a number."
        } else {

        // sanitize inputs
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_STRING);
        $rating = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_NUMBER_INT);
        $review = filter_input(INPUT_POST, 'review', FILTER_SANITIZE_STRING);
        
        //2. Insert into database
        $sql = "INSERT INTO reviews (title, author, rating, review_text, created_at) VALUES (:title, :author, :rating, :review_text, NOW())";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':review_text', $review);

        if ($stmt->execute()) {
            echo "Review submitted successfully!";
        } else {
            echo "Error submitting review.";

        }
}




<?php
include 'footer.php';
?>