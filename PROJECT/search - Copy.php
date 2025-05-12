<!DOCTYPE html>
<html lang="ku" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>گەڕان - کتێبخانەی ئێمە</title>
    <style>
        /* ڕێگای گشتی */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
            padding: 0;
        }
        
        /* ناوبار */
        nav {
            background-color: #2c3e50;
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            direction: rtl;
        }
        
        nav .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .logo {
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
        }
        
        .nav-links {
            display: flex;
            list-style: none;
        }
        
        .nav-links li {
            margin-left: 30px;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            transition: color 0.3s;
            padding: 5px 10px;
            border-radius: 4px;
        }
        
        .nav-links a:hover {
            color: #3498db;
            background-color: rgba(255,255,255,0.1);
        }
        
        .nav-links a.active {
            color: #3498db;
            font-weight: bold;
        }
        
        /* بەشی سەرەکی */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .search-section {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 40px;
            margin-bottom: 30px;
        }
        
        .search-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .search-header h1 {
            font-size: 36px;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .search-header p {
            font-size: 18px;
            color: #7f8c8d;
        }
        
        .search-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .search-inputs {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        .form-group label {
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: bold;
        }
        
        .form-group input,
        .form-group select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        
        .search-btn {
            align-self: center;
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .search-btn:hover {
            background-color: #2980b9;
        }
        
        /* نمایشی ئەنجامەکان */
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            padding: 20px 0;
        }
        
        .book-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        
        .book-cover {
            height: 200px;
            background-color: #ecf0f1;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #7f8c8d;
            font-size: 24px;
            position: relative;
        }
        
        .book-pdf-icon {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #e74c3c;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .book-details {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .book-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #2c3e50;
        }
        
        .book-author {
            color: #7f8c8d;
            margin-bottom: 15px;
            font-size: 16px;
        }
        
        .book-meta {
            display: flex;
            justify-content: space-between;
            margin-top: auto;
            color: #7f8c8d;
            font-size: 14px;
        }
        
        .book-year, .book-category {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .book-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
        
        .view-btn, .download-btn {
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .view-btn {
            background-color: #3498db;
            color: white;
        }
        
        .view-btn:hover {
            background-color: #2980b9;
        }
        
        .download-btn {
            background-color: #ecf0f1;
            color: #2c3e50;
        }
        
        .download-btn:hover {
            background-color: #d5dbdb;
        }
        
        .no-results {
            text-align: center;
            color: #7f8c8d;
            padding: 50px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        /* پێنجەرە */
        footer {
            background-color: #2c3e50;
            color: white;
            padding: 30px 0;
            text-align: center;
            margin-top: 50px;
        }
        
        /* وەڵامدەرەوە */
        @media (max-width: 768px) {
            nav .container {
                flex-direction: column;
            }
            
            .nav-links {
                margin-top: 20px;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .nav-links li {
                margin: 5px 10px;
            }
            
            .search-section {
                padding: 20px;
            }
            
            .search-inputs {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- ناوبار -->
    <nav>
        <div class="container">
            <a href="index.html" class="logo">کتێبخانە</a>
            <ul class="nav-links">
                <li><a href="index.html">پەرەی سەرەکی</a></li>
                <li><a href="books.php">کتێبەکان</a></li>
                <li><a href="search.php" class="active">گەڕان</a></li>
                <li><a href="add-book.html">زیادکردنی کتێب</a></li>
                <li><a href="feedback.html">پێشنیار</a></li>
            </ul>
        </div>
    </nav>
    
    <!-- بەشی سەرەکی -->
    <main class="container">
        <section class="search-section">
            <div class="search-header">
                <h1>گەڕان بۆ کتێب</h1>
                <p>کتێبەکانی خۆت بدۆزەوە</p>
            </div>
            
            <form action="search.php" method="GET" class="search-form">
                <div class="search-inputs">
                    <div class="form-group">
                        <label for="title">ناوی کتێب</label>
                        <input type="text" id="title" name="title" placeholder="ناوی کتێب بنووسە">
                    </div>
                    <div class="form-group">
                        <label for="author">نوسەر</label>
                        <input type="text" id="author" name="author" placeholder="ناوی نوسەر بنووسە">
                    </div>
                    <div class="form-group">
                        <label for="category">کاتگۆری</label>
                        <select id="category" name="category">
                            <option value="">هەموو کاتگۆرییەکان</option>
                            <option value="وەرزش">وەرزش</option>
                            <option value="زانست">زانست</option>
                            <option value="مێژوو">مێژوو</option>
                            <option value="ئەدەب">ئەدەب</option>
                            <option value="تەکنەلۆژیا">تەکنەلۆژیا</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="year">ساڵ</label>
                        <input type="number" id="year" name="year" placeholder="ساڵی بڵاوکردنەوە">
                    </div>
                </div>
                <button type="submit" class="search-btn">گەڕان</button>
            </form>
        </section>
        
        <?php
        // Check if search parameters are set
        $title = isset($_GET['title']) ? trim($_GET['title']) : '';
        $author = isset($_GET['author']) ? trim($_GET['author']) : '';
        $category = isset($_GET['category']) ? trim($_GET['category']) : '';
        $year = isset($_GET['year']) ? trim($_GET['year']) : '';

        // Include database connection
        require_once 'confing.php'; // Ensure this matches your file name

        // Prepare search query
        $search_results = [];
        if (!empty($title) || !empty($author) || !empty($category) || !empty($year)) {
            $query = "SELECT * FROM books WHERE 1=1";
            $params = [];
            $types = '';

            if (!empty($title)) {
                $query .= " AND title LIKE ?";
                $params[] = "%{$title}%";
                $types .= 's';
            }
            if (!empty($author)) {
                $query .= " AND author LIKE ?";
                $params[] = "%{$author}%";
                $types .= 's';
            }
            if (!empty($category)) {
                $query .= " AND category = ?";
                $params[] = $category;
                $types .= 's';
            }
            if (!empty($year)) {
                $query .= " AND year = ?";
                $params[] = $year;
                $types .= 's';
            }

            // Use MySQLi for the query
            $stmt = $mysqli->prepare($query);
            if ($stmt) {
                if (!empty($params)) {
                    $stmt->bind_param($types, ...$params);
                }
                $stmt->execute();
                $result = $stmt->get_result();
                $search_results = $result->fetch_all(MYSQLI_ASSOC);
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $mysqli->error;
            }
        }
        ?>
        
        <?php if (!empty($search_results)): ?>
            <div class="books-grid">
                <?php foreach ($search_results as $book): ?>
                    <div class="book-card">
                        <div class="book-cover">
                            <span>وێنەی <?= htmlspecialchars($book['title']) ?></span>
                            <div class="book-pdf-icon">PDF</div>
                        </div>
                        <div class="book-details">
                            <h3 class="book-title"><?= htmlspecialchars($book['title']) ?></h3>
                            <p class="book-author">نوسەر: <?= htmlspecialchars($book['author']) ?></p>
                            <div class="book-meta">
                                <span class="book-year">📅 <?= htmlspecialchars($book['year']) ?></span>
                                <?php if (!empty($book['category'])): ?>
                                    <span class="book-category">🏷️ <?= htmlspecialchars($book['category']) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="book-actions">
                                <a href="<?= htmlspecialchars($book['pdf_path']) ?>" target="_blank" class="view-btn">بینین</a>
                                <a href="<?= htmlspecialchars($book['pdf_path']) ?>" download class="download-btn">داگرتن</a>
                            </div>
                        </div>
                                </div>
                                </body>
</html>
