<?php
session_start();

require_once 'connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = $_POST['description'];
    $author = $_POST['author'];
    $title = $_POST['title']; // Fixed: title wasn't defined
    $date = date("Y-m-d H:i:s");

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is an actual image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                // Save article details to the database
                $stmt = $conn->prepare("INSERT INTO articles (title, content, image_path, author_name, created_at) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $title, $description, $targetFile, $author, $date);

                if ($stmt->execute()) {
                    echo "<div class='success'>The article has been uploaded successfully.</div>";
                } else {
                    echo "<div class='error'>Error: " . $stmt->error . "</div>";
                }

                $stmt->close();
                $conn->close();
            } else {
                echo "<div class='error'>Sorry, there was an error uploading your file.</div>";
            }
        } else {
            echo "<div class='error'>File is not an image.</div>";
        }
    } else {
        echo "<div class='error'>No file uploaded or there was an upload error.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="uploads/bookbox.png">
    <title>Upload Article</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f3f5;
            padding: 20px;
            margin: 0;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 25px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        input[type="text"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            margin-top: 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .success {
            max-width: 600px;
            margin: 20px auto;
            padding: 15px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
        }

        .error {
            max-width: 600px;
            margin: 20px auto;
            padding: 15px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h2>Upload Article</h2>
    <?php  if(isset($_GET["id"]))
        {
            $id=$_GET["id"];
            $sql="SELECT * FROM articles WHERE id=$id";
            $result=mysqli_query($conn,$sql);
            $row=mysqli_fetch_assoc($result);
            // Use $row to pre-fill the form fields if needed   
            $title=$row["title"];
            $description=$row["content"];
            $author=$row["author_name"]; 
        } ?>
    <form action="article.php" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required>

        <label for="author">Author Name:</label>
        <input type="text" id="author" name="author" required>

        <input type="submit" value="Upload Article">
        </form>
        <br>
        <div style="text-align:center;">
            <a href="index.php"><button type="button" style="background-color:#6c757d;color:white;padding:10px 20px;border:none;border-radius:4px;cursor:pointer;">Back to Home Page</button></a>
        </div>
    </form>
</body>
</html>
