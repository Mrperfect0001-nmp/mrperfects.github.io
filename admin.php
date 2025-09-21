<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'bookbox');

$sql = "SELECT id, title FROM articles ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="uploads/bookbox.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - BookBox</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f2f3f7;
            margin: 0;
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .article-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 28px;
            margin-top: 30px;
            justify-items: center;
        }
        .article-card {
            background-color: #eaf3fb;
            border-radius: 18px;
            box-shadow: 0 4px 18px rgba(74,144,226,0.13), 0 1.5px 6px rgba(0,0,0,0.07);
            width: 220px;
            height: 220px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 18px 12px 12px 12px;
            position: relative;
            transition: transform 0.25s cubic-bezier(.4,.8,.4,1), box-shadow 0.25s;
        }
        .article-card:hover {
            transform: translateY(-8px) scale(1.04);
            box-shadow: 0 8px 32px rgba(74,144,226,0.18), 0 2px 12px rgba(0,0,0,0.10);
        }
        .article-img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 12px;
            box-shadow: 0 2px 8px rgba(74,144,226,0.10);
        }
        .article-title {
            font-size: 1.1rem;
            color: #222;
            font-weight: 700;
            text-align: center;
            margin-bottom: 10px;
            flex: 0 0 auto;
        }
        .actions {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: auto;
        }

        .btn {
            padding: 7px 16px;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            font-size: 15px;
            color: white;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(74,144,226,0.10);
            transition: background 0.2s, transform 0.2s;
        }
        .btn-edit:hover {
            background-color: #218838;
            transform: scale(1.08);
        }
        .btn-delete:hover {
            background-color: #c82333;
            transform: scale(1.08);
        }

        .btn-edit {
            background-color: #28a745;
        }

        .btn-delete {
            background-color: #dc3545;
        }


        .btn-add {
            background-color: #007bff;
            color: white;
            text-decoration: none;
            padding: 10px 16px;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 25px;
            transition: background 0.2s;
        }

        .btn-add.home {
            background-color: #6c757d;
        }
        .btn-add.home:hover {
            background-color: #343a40;
        }
        .btn-add:not(.home):hover {
            background-color: #0056b3;
        }

        .center {
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Admin Panel</h1>

        <div class="center" style="display:flex;justify-content:center;gap:18px;align-items:center;">
            <a href="article.php" class="btn-add">+ Add Article</a>
            <a href="index.php" class="btn-add home">Go to Home Page</a>
        </div>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="article-grid">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="article-card">
                    <?php
                        // Try to get image for article, fallback to default
                        $imgPath = "uploads/" . strtolower(str_replace(' ', '', $row['title'])) . ".png";
                        if (!file_exists($imgPath)) {
                            $imgPath = "uploads/bookbox.png";
                        }
                    ?>
                    <img src="<?php echo $imgPath; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" class="article-img" />
                    <div class="article-title"><?php echo htmlspecialchars($row['title']); ?></div>
                    <div class="actions">
                        <a href="article_edit.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">Edit</a>
                        <a href="delete_article.php?id=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this article?');">Delete</a>
                    </div>
                </div>
            <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="center">No articles found.</p>
        <?php endif; ?>
    </div>


        <div class="center" style="margin-top:30px;">
            <a href="index.php" class="btn-add home">Go to Home Page</a>
        </div>

</body>
</html>

<?php mysqli_close($conn); ?>
