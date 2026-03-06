<?php
include 'connect.php'; // connect to the database
include 'header.php'; // basic page header
?>

<h2>Submit a Book Review</h2>

<?php
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //1. Validation: required fields
    if (empty($_POST['title']) || empty($_POST['author']) || empty($_POST['rating'])) {
        echo "Please fill in all required fields";

        // make sure rating is a number
        } else if (!is_numeric($_POST['rating'])) {
            echo "Rating has to be a number.";
        } else {

        // sanitize inputs to avoid characters that could break the query
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_SPECIAL_CHARS);
        $rating = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_NUMBER_FLOAT);
        $review = filter_input(INPUT_POST, 'review', FILTER_SANITIZE_SPECIAL_CHARS);
        
        //2. Insert into database
        $sql = "INSERT INTO reviews (title, author, rating, review_text, created_at) VALUES (:title, :author, :rating, :review_text, NOW())";

        // Prepare the SQL so we can safely insert the values
        $stmt = $conn->prepare($sql);

        // bind the values to the placeholders
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':review_text', $review);


        // Run the SQL and check if it worked
        if ($stmt->execute()) {
            echo "Review submitted successfully!";
        } else {
            echo "Error submitting review.";
        }
    }
}
?>

<h2> Add a Review</h2>
<!-- The form for actually adding a review -->
<form method="POST" action="create.php">
    <label for="title">Book Title:</label><br>
    <input type="text" id="title" name="title" required><br><br>

    <label for="author">Author:</label><br>
    <input type="text" id="author" name="author" required><br><br>

    <label for="rating">Rating (1-5):</label><br>
    <input type="number" id="rating" name="rating" min="1" max="5" required><br><br>

    <label for="review">Review:</label><br>
    <textarea id="review" name="review"></textarea><br><br>

    <button type="submit">Submit</button>
</form>



<?php
include 'footer.php';
?>