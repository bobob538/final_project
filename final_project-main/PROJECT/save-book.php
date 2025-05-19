<?php
header('Content-Type: application/json');

// پەیوەندی بە داتابەیسەوە
try {
    $pdo = new PDO('mysql:host=localhost;dbname=library', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'پەیوەندی بە داتابەیسەوە شکستی هێنا: ' . $e->getMessage()]);
    exit;
}

// پشکنینی زانیارییەکان
$required = ['title', 'author', 'year'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        echo json_encode(['success' => false, 'message' => 'تکایە هەموو خانە پێویستەکان پڕ بکەرەوە']);
        exit;
    }
}

// فایلی PDF
if (!isset($_FILES['pdf']) || $_FILES['pdf']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'تکایە فایلێکی دروست هەڵبگرە']);
    exit;
}

$pdf = $_FILES['pdf'];
$allowedTypes = ['application/pdf'];
$maxSize = 10 * 1024 * 1024; // 10MB

// پشکنینی فایل
if (!in_array($pdf['type'], $allowedTypes)) {
    echo json_encode(['success' => false, 'message' => 'تکایە تەنها فایلی PDF هەڵبگرە']);
    exit;
}

if ($pdf['size'] > $maxSize) {
    echo json_encode(['success' => false, 'message' => 'قەبارەی فایل زۆر گەورەە (کەمتر لە 10MB)']);
    exit;
}

// دروستکردنی بوخچەی uploads ئەگەر بوونی نەبوو
if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}

// ناوی تایبەتی فایل
$filename = uniqid() . '_' . basename($pdf['name']);
$targetPath = 'uploads/' . $filename;

// هەڵگرتنی فایل
if (move_uploaded_file($pdf['tmp_name'], $targetPath)) {
    // پەیوەندیدانی وێنە (اختیاری)
    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image'];
        $allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxImageSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($image['type'], $allowedImageTypes)) {
            echo json_encode(['success' => false, 'message' => 'تکایە تەنها وێنەی JPG, PNG یان GIF هەڵبگرە']);
            exit;
        }
        if ($image['size'] > $maxImageSize) {
            echo json_encode(['success' => false, 'message' => 'قەبارەی وێنە زۆر گەورەە (کەمتر لە 5MB)']);
            exit;
        }

        if (!file_exists('uploads/images')) {
            mkdir('uploads/images', 0777, true);
        }
        $imageFilename = uniqid() . '_' . basename($image['name']);
        $imagePath = 'uploads/images/' . $imageFilename;
        if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
            echo json_encode(['success' => false, 'message' => 'هەڵە لە هەڵگرتنی وێنە']);
            exit;
        }
    }

    // تۆمارکردن لە داتابەیس
    try {
        $stmt = $pdo->prepare("INSERT INTO books (title, author, year, category, pdf_path, image_path) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['title'],
            $_POST['author'],
            $_POST['year'],
            $_POST['category'] ?? null,
            $targetPath,   // PDF path
            $imagePath     // Image path (or null)
        ]);
        
        echo json_encode(['success' => true, 'message' => 'کتێبەکە بە سەرکەوتوویی زیادکرا!']);
    } catch (PDOException $e) {
        unlink($targetPath); // سڕینەوەی فایل ئەگەر تۆمارکردن شکستی هێنا
        if ($imagePath) unlink($imagePath);
        echo json_encode(['success' => false, 'message' => 'هەڵە لە تۆمارکردنی کتێب: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'هەڵە لە هەڵگرتنی فایل']);
}
?>