<?php
include 'header.php';
include 'connect.php';

// get all reviews
$SQL = "SELECT * FROM reviews ORDER BY created_at DESC";
$stmt = $conn->prepare($SQL);
$stmt->execute();

// fetch everything as an associative array so we can loop it
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Admin - All Reviews</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Rating</th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($reviews as $review): ?>
    <tr>
        <!-- showing the data from each row -->
        <td><?php echo $review['id']; ?></td>
        <td><?php echo htmlspecialchars($review['title']); ?></td>
        <td><?php echo $review['rating']; ?></td>
        <td><?php echo $review['created_at']; ?></td>
        <td>

            <!-- links to edit and delete pages, passing the id in the URL -->
            <a href="edit.php?id=<?php echo $review['id']; ?>">Edit</a> |
            <a href="delete.php?id=<?php echo $review['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include 'footer.php'; ?>