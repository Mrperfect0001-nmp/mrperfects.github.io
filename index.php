<?php
session_start();

// Fetch articles from the database
$conn = mysqli_connect('localhost', 'root', '', 'bookbox');
$sql = "SELECT id, title, image_path FROM articles ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="uploads/bookbox.png">
    <link rel="icon" type="image/png" href="uploads/bookbox.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookBox - Home</title>
    <style>

        /* Base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            color: #333;
            padding: 20px;
        }

        header {
            background-color: #4A90E2;
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
        }

        header h1 {
            margin-bottom: 10px;
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            background-color: #357ABD;
            padding: 8px 15px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        nav ul li a:hover {
            background-color: #2d6ca2;
        }

        main {
            max-width: 1200px;
            margin: 0 auto;
        }

        main h2 {
            margin-bottom: 20px;
            color: #2c3e50;
            text-align: center;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            width: 250px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s ease;
            text-align: center;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }

        .card h3 {
            margin: 0;
            padding: 15px;
            font-size: 18px;
            color: #333;
        }

        .card a {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            padding: 15px;
            font-size: 0.9rem;
            color: #777;
        }
    </style>
</head>
<body>
    <header style="background-color:#4A90E2;color:#fff;padding:0;border-radius:8px;margin-bottom:30px;position:relative;height:320px;min-height:320px;">
        <div style="position:absolute;top:0;left:0;width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;z-index:2;">
            <h1 style="margin-bottom:10px;font-size:3.2rem;font-weight:900;letter-spacing:2px;">Welcome to BookBox</h1>
            <div style="font-size:1.35rem;font-weight:500;color:#eaf3fb;margin-bottom:30px;letter-spacing:1px;">the coding language wiki</div>
            <?php if(isset($_SESSION["id"])){
                if($_SESSION["id"]==1){
            echo '<nav>
                <ul style="justify-content:center;display:flex;gap:25px;list-style:none;padding:0;margin:0;">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <li><a href="register.php">Register new user</a></li>
                    <li><a href="admin.php">Admin panel</a></li>
                </ul>
            </nav>';}else{
                echo '<nav>
                <ul style="justify-content:center;display:flex;gap:25px;list-style:none;padding:0;margin:0;">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <li><a href="register.php">Register new user</a></li>
                </ul>
            </nav>';
            }}
            else
            {
                echo '<nav>
                <ul style="justify-content:center;display:flex;gap:25px;list-style:none;padding:0;margin:0;">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register new user</a></li>
                </ul>';
            } ?>
        </div>
        <div style="position:absolute;top:50%;right:40px;transform:translateY(-50%);display:flex;justify-content:center;align-items:center;z-index:1;">
            <div style="width:160px;height:160px;border-radius:18px;background:radial-gradient(circle,#eaf3fb 60%,#4A90E2 100%);box-shadow:0 2px 12px rgba(74,144,226,0.10);display:flex;align-items:center;justify-content:center;overflow:hidden;">
                    <img src="uploads/bookbox.png" alt="BookBox Logo" class="logo-anim-img" style="width:160px;height:160px;object-fit:cover;object-position:center;display:block;border-radius:0;transition:transform 0.4s cubic-bezier(.4,.8,.4,1), box-shadow 0.3s;" />
            </div>
        </div>
            <style>
            .logo-anim-img {
                transition: box-shadow 0.3s;
            }
            .logo-anim-box:hover .logo-anim-img {
                box-shadow: 0 0 32px 0 #50D3C2, 0 2px 12px rgba(74,144,226,0.10);
            }
            </style>
    </header>
    
    <main>
        <h2>Articles</h2>
        <div style="text-align:center;font-size:1.2rem;margin-bottom:18px;color:#357ABD;font-weight:600;">
            Total Articles: <?php echo mysqli_num_rows($result); ?>
        </div>
        <div style="max-width:500px;margin:0 auto 24px auto;text-align:center;">
            <input type="text" id="searchInput" placeholder="Search articles..." style="width:70%;padding:10px 14px;border-radius:6px;border:1px solid #ccc;font-size:1rem;">
            <button id="searchBtn" style="padding:10px 18px;border-radius:6px;background:#4A90E2;color:#fff;border:none;font-size:1rem;cursor:pointer;margin-left:8px;">Search</button>
        </div>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="card-container" id="articleCards">
                <?php 
                // Reset result pointer for multiple fetches
                mysqli_data_seek($result, 0);
                while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="card" data-title="<?php echo htmlspecialchars($row['title']); ?>">
                        <a href="details.php?id=<?php echo $row['id']; ?>">
                            <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="Article Image">
                            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p style="text-align: center;">No articles found. Please check back later!</p>
        <?php endif; ?>
    </main>
    <script>
    // Interactive search: filters articles live
    function filterArticles() {
        var q = document.getElementById('searchInput').value.trim().toLowerCase();
        var cards = document.querySelectorAll('.card-container .card');
        cards.forEach(function(card) {
            var title = card.getAttribute('data-title') || card.querySelector('h3').innerText;
            if (!q || title.toLowerCase().includes(q)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }
    document.getElementById('searchInput').addEventListener('input', filterArticles);
    document.getElementById('searchBtn').addEventListener('click', filterArticles);

    // ...existing code...

    // Alert on logout
    document.querySelectorAll('a[href="logout.php"]').forEach(function(logoutLink) {
        logoutLink.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to logout?')) {
                e.preventDefault();
            }
        });
    });
    </script>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> BookBox. All rights reserved.</p>
            <div style="max-width:700px;margin:30px auto 0 auto;padding:20px;background:#fff;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.07);">
                <h3>About Us</h3>
                <p>BookBox is your go-to platform for sharing and discovering articles on books, authors, and literary trends. Our mission is to connect readers and writers in a vibrant online community.</p>
                <h3>Contact Details</h3>
                <p>Email: <a href="mailto:info@bookbox.com">info@bookbox.com</a><br>
                Phone: +1-234-567-8901<br>
                Address: 123 BookBox Lane, Library City, 45678</p>
            </div>
    </footer>
</body>
</html>

<?php
mysqli_close($conn);
?>
