<?php
session_start();
require_once "dabase.php";

$error = "";

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        $error = "Email and password are required";
    } else {
        // Determine which table to use based on checkbox
        $table = isset($_POST['use_table_a']) ? 'admin' : 'users';
        $sql = "SELECT * FROM $table WHERE email = ?";
        $stmt = mysqli_prepare($coon, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['ID'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['full_name'];
            
            // Redirect based on table
            if ($table === 'admin') {
                header("Location: index.html");
            } else {
                header("Location: index - USER.html");
            }
            exit();
        } else {
            $error = "Invalid email or password";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ku">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
/* ڕێگای گشتی */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Zain/Zain-Bold.ttf', ;
        }
        
        html, body {
    height: 100%;
    margin: 0;
    padding: 0;
}

body {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

main, .bd {
    flex: 1 0 auto;
}

footer {
    flex-shrink: 0;
}
        
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
            padding: 0;
            /* Remove the fixed width */
            /* width: 1300px; */
            min-height: 100vh; /* Ensure the body takes at least the full height of the viewport */
        }
        
        /* ناوبار */
       
nav {
    background-color: #2c3e50;
    padding: 15px 0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    direction: rtl; /* یان لەسەر <body> */
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
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
    .bd{
        height: 400px;
    }
    .form-group {
    margin-bottom: 20px;
}

.alert {
    margin-top: 20px;
}

h1, h2 {
    color: #333;
    margin-bottom: 30px;
}

.card {
    margin-top: 20px;
    border: none;
    box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px;
}

.text-end {
    text-align: right;
    margin-bottom: 20px;
}
  /* پێنجەرە */
        footer {
            background-color: #2c3e50;
            color: white;
            padding: 15px 0;
            text-align: center;
            
        }
     .btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            display: block;
            width: 100%;
            transition: background-color 0.3s;
        }
        
        .btn:hover {
            background-color: #2980b9;
        }
</style>
</head>
<body>
      <!-- ناوبار -->
    <nav>
        <div class="container">
            <a href="index - FIRST.html" class="logo">کتێبخانە</a> <!-- لوگۆ لەدەرەوەی <ul> -->
            <ul class="nav-links">
             <!--    <li><a href="index.html">پەرەی سەرەکی</a></li>
                <li><a href="books.php">کتێبەکان</a></li>
                <li><a href="search.html">گەڕان</a></li>
                <li><a href="add-book.html">زیادکردنی کتێب</a></li> -->
               <!-- <li><a href="login.php">چونەژورەوە</a></li>-->
            </ul>
        </div>
    </nav>
    <section class="bd">
        <div class="container">
            <h2 class="text-center mb-4">چونەژورەوە</h2>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" name="use_table_a" id="use_table_a" value="1">
                    <label class="form-check-label" for="use_table_a">Admin Login</label>
                </div>
                <div class="form-group">
                    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                </div>
            </form>
            <p class="text-center mt-3">Don't have an account? <a href="project.php">Register here</a></p>
        </div>
    </section>
     <footer>
        <div class="container">
            <p>&copy; 2025 کتێبخانەی ئێمە. هەموو مافەکان پارێزراون.</p>
        </div>
    </footer>
</body>
</html>