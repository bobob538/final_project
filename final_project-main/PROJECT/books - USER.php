<?php
session_start();
require_once "confing.php";

$sql = "SELECT id, title, author, year, category, pdf_path, images FROM books";
$books = [];

try {
    $stmt = $pdo->query($sql);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $books[] = $row;
    }
} catch (PDOException $e) {
    die("Error fetching books: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="ku" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>کتێبەکان - کتێبخانەی ئێمە</title>
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
            direction: rtl
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
        
        .books-header {
            text-align: center;
            padding: 30px 0;
            margin-bottom: 30px;
        }
        
        .books-header h1 {
            font-size: 36px;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .books-header p {
            font-size: 18px;
            color: #7f8c8d;
        }
        
        /* گرێی کتێبەکان */
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
        
        /* پێنجەرە */
        footer {
            background-color: #2c3e50;
            color: white;
            padding: 30px 0;
            text-align: center;
            margin-top: 50px;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .footer-links {
            display: flex;
            gap: 20px;
        }
        
        .footer-links a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: #3498db;
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
            
            .books-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
            
            .footer-content {
                flex-direction: column;
                gap: 15px;
            }
            
            .footer-links {
                flex-wrap: wrap;
                justify-content: center;
            }
        }
        
        @media (max-width: 480px) {
            .books-header h1 {
                font-size: 28px;
            }
            
            .books-header p {
                font-size: 16px;
            }
            
            .books-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- ناوبار -->
    <nav>
        <div class="container">
            <a href="index - USER.html" class="logo">کتێبخانە</a>
            <ul class="nav-links">
                 <li><a href="index - USER.html">پەرەی سەرەکی</a></li>
                <li><a href="books - USER.php"class="active">کتێبەکان</a></li>
                <li><a href="search - USER.html">گەڕان</a></li>
               <!-- <li><a href="add-book.html">زیادکردنی کتێب</a></li>-->
                <li><a href="login.php">چونەژورەوە</a></li>
            </ul>
        </div>
    </nav>
    
    <!-- بەشی سەرەکی -->
    <main class="container">
        <div class="books-header">
            <h1>کتێبەکانی ئێمە</h1>
            <p>هەموو کتێبەکانی بەردەست لە کتێبخانەکەمان</p>
        </div>
        
        <div class="books-grid">
            <?php if (empty($books)): ?>
                <p style="grid-column: 1/-1; text-align: center; padding: 30px; color: #7f8c8d;">هیچ کتێبێک نییە</p>
            <?php else: ?>
                <?php foreach ($books as $book): ?>
                    <div class="book-card">
                        <div class="book-cover">
    <!-- Display the book image -->
    <img
      src="image.php?id=<?= htmlspecialchars($book['id']) ?>"
      alt="عکسێکی <?= htmlspecialchars($book['title']) ?>"
      style="width:100%; height:100%; object-fit:cover;"
    />
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
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
    
    <!-- پێنجەرە -->
    <footer>
        <div class="footer-content">
            <p>&copy; 2023 کتێبخانە. هەموو مافەکان پارێزراون.</p>
            <div class="footer-links">
                <a href="about.html">دەربارەی ئێمە</a>
                <a href="contact.html">پەیوەندی</a>
                <a href="terms.html">مەرجەکان</a>
            </div>
        </div>
    </footer>
</body>
</html>