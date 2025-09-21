<?php


$conn = mysqli_connect('localhost', 'root', '', 'bookbox');

$query = '';
$result = null;

if (isset($_GET['query'])) {
    $query = mysqli_real_escape_string($conn, $_GET['query']);
    $sql = "SELECT * FROM articles WHERE title LIKE '%$query%' OR content LIKE '%$query%'";
    $result = mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="uploads/bookbox.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search - BookBox</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 40px 20px;
        }

        .container {
            max-width: 800px;
            background-color: #fff;
            margin: 0 auto;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 30px;
        }

        input[type="text"] {
            padding: 10px;
            font-size: 16px;
            width: 60%;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            padding: 10px 20px;
            background-color: #4A90E2;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #357ABD;
        }

        ul {
            list-style-type: none;
            padding-left: 0;
        }

        ul li {
            background-color: #eef2f7;
            margin-bottom: 10px;
            padding: 12px 16px;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        ul li:hover {
            background-color: #dce6f1;
        }

        ul li a {
            text-decoration: none;
            color: #1a3f7c;
            font-weight: bold;
        }

        p {
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Search Articles</h1>

        <form action="search.php" method="get">
            <input type="text" name="query" placeholder="Search for articles..." required value="<?php echo htmlspecialchars($query); ?>">
            <button type="submit">Search</button>
        </form>

        <?php if ($query !== ''): ?>
            <h2>Search Results for "<?php echo htmlspecialchars($query); ?>"</h2>
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <ul>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <li>
                            <a href="details.php?id=<?php echo $row['id']; ?>">
                                <?php echo htmlspecialchars($row['title']); ?>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No articles found.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
