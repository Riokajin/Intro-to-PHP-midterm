<?php
include 'connect.php';
include 'header.php';

// make sure the form was actually submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // grab the id from the hidden input
    $id = $_POST['id'];

    // basic validation again (just like create)
    if (empty($_POST['title']) || empty($_POST['author']) || empty($_POST['rating'])) {
        echo "Please fill in all required fields.";
    } else if (!is_numeric($_POST['rating'])) {
        echo "Rating must be a number.";
    } else {

        // sanitize everything before updating
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_SPECIAL_CHARS);
        $rating = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_NUMBER_FLOAT);
        $review = filter_input(INPUT_POST, 'review', FILTER_SANITIZE_SPECIAL_CHARS);

        // SQL to update the row
        $sql = "UPDATE reviews 
                SET title = :title, author = :author, rating = :rating, review_text = :review_text 
                WHERE id = :id";

        // prepare the statement
        $stmt = $conn->prepare($sql);

        // bind the values
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':review_text', $review);
        $stmt->bindParam(':id', $id);

        // try to run it
        if ($stmt->execute()) {
            echo "Review updated successfully!";
        } else {
            echo "Error updating review.";
        }
    }
} else {
    // if someone tries to load this page without submitting the form
    echo "Invalid request.";
}

include 'footer.php';
?>

    

