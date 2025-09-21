<?php
session_start();

require_once 'connect.php';
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
    <a href="admin.php" style="
        display:inline-block;
        margin:18px 0 0 18px;
        padding:8px 18px;
        background:#4A90E2;
        color:#fff;
        border-radius:6px;
        text-decoration:none;
        font-weight:600;
        box-shadow:0 2px 8px rgba(0,0,0,0.08);
        transition:background 0.2s;
    " onmouseover="this.style.background='#357ABD'" onmouseout="this.style.background='#4A90E2'">&larr; Back to Admin panel</a>
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
            $image=$row["image_path"];
        } ?>
    <form action="article_edit_backend.php" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo $title; ?>" required>

        <label for="description">Description:</label>
<textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($description); ?></textarea>

        <img src="<?php echo $image; ?>" alt="img" height="100" width="100">
        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*" >
        <input type="hidden" value="<?php echo $image; ?>" name="filename"/>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="author">Author Name:</label>
        <input type="text" id="author" name="author" value="<?php echo $author; ?>" required>

        <input type="submit" value="Update Article">
    </form>
</body>
</html>
