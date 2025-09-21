<?php


$conn = mysqli_connect('localhost', 'root', '', 'bookbox');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid article ID.");
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM articles WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Article not found.");
}

$article = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="uploads/bookbox.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article['title']); ?> - BookBox</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            padding: 40px 20px;
            margin: 0;
        }

        .container {
            max-width: 800px;
            background-color: #fff;
            margin: 0 auto;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
            color: #2c3e50;
        }

        .article-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .content {
            font-size: 16px;
            line-height: 1.7;
            color: #444;
        }

        .meta {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-bottom: 10px;
        }

        a.back-link {
            display: block;
            margin-top: 30px;
            text-align: center;
            color: #4A90E2;
            text-decoration: none;
            font-weight: bold;
        }

        a.back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($article['title']); ?></h1>

        <?php if (!empty($article['image_path'])): ?>
            <img class="article-image" src="<?php echo htmlspecialchars($article['image_path']); ?>" alt="Article Image">
        <?php endif; ?>

        <div class="meta">
            Posted by <?php echo htmlspecialchars($article['author_name']); ?> on <?php echo date("F j, Y, g:i a", strtotime($article['created_at'])); ?>
        </div>

        <div class="content">
            <?php echo nl2br(htmlspecialchars($article['content'])); ?>
        </div>

        <a class="back-link" href="index.php">← Back to Articles</a>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
