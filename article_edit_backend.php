<?php
require_once "connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = $_POST['description'] ?? '';
    $author = $_POST['author'] ?? '';
    $title = $_POST['title'] ?? '';
    $date = date("Y-m-d H:i:s");
    $id = intval($_POST['id'] ?? 0);
    if ($id <= 0) {
        echo "<div class='error'>Invalid article ID.</div>";
        exit;
    }

    $image_path = $_POST['filename']; // default old image path
    // CASE 1: New file uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $image_path = $targetFile; // overwrite with new path
            } else {
                echo "<div class='error'>Error uploading your file.</div>";
                exit;
            }
        } else {
            echo "<div class='error'>Invalid image file.</div>";
            exit;
        }
    }
    // CASE 2: No new file → $image_path stays as old filename

    $stmt = $conn->prepare("UPDATE articles 
                            SET title=?, content=?, image_path=?, author_name=?, created_at=? 
                            WHERE id=?");
    $stmt->bind_param("sssssi", $title, $description, $image_path, $author, $date, $id);

    if ($stmt->execute()) {
            // Redirect to admin panel after update
            header("Location: admin.php");
            exit;
    } else {
        echo "<div class='error'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
    $conn->close();

}
?>
