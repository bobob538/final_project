<?php
header('Content-Type: application/json');

// پەیوەندی بە داتابەیسەوە
try {
    $pdo = new PDO('mysql:host=localhost;dbname=کتێبخانە', 'بەکارهێنەر', 'تێپەڕەوشە');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'پەیوەندی بە داتابەیسەوە شکستی هێنا']);
    exit;
}

// پشکنینی زانیارییەکان
$required = ['title', 'author', 'year', 'pdf'];
foreach ($required as $field) {
    if (empty($_POST[$field]) {
        echo json_encode(['success' => false, 'message' => 'تکایە هەموو خانە پێویستەکان پڕ بکەرەوە']);
        exit;
    }
}

// فایلی PDF
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
    // تۆمارکردن لە داتابەیس
    try {
        $stmt = $pdo->prepare("INSERT INTO کتێبەکان (ناو, نوسەر, ساڵ, بەش, pdf) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['title'],
            $_POST['author'],
            $_POST['year'],
            $_POST['category'],
            $targetPath
        ]);
        
        echo json_encode(['success' => true, 'message' => 'کتێبەکە بە سەرکەوتوویی زیادکرا!']);
    } catch(PDOException $e) {
        unlink($targetPath); // سڕینەوەی فایل ئەگەر تۆمارکردن شکستی هێنا
        echo json_encode(['success' => false, 'message' => 'هەڵە لە تۆمارکردنی کتێب']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'هەڵە لە هەڵگرتنی فایل']);
}
?>