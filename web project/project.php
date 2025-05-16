
<head>

   
<title>rejestration</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<meta name="viewport"contenr="width=device-width,intial-scalw=1.0">
<style>
   /* ڕێگای گشتی */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Zain/Zain-Bold.ttf', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
            padding: 0;
            width: 1270px;
            
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
    .bd{
        height: 600px;
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
            <a href="index.html" class="logo">کتێبخانە</a> <!-- لوگۆ لەدەرەوەی <ul> -->
            <ul class="nav-links">
                <li><a href="index.html">پەرەی سەرەکی</a></li>
                <li><a href="books.php">کتێبەکان</a></li>
                <li><a href="search.html">گەڕان</a></li>
                <li><a href="add-book.html">زیادکردنی کتێب</a></li>
                <li><a href="web project/login.php">چونەژورەوە</a></li>
            </ul>
        </div>
    </nav>
<section class="bd">
<div class="container">
   <?php
 



if(isset($_POST["submit"])){
$fullname = $_POST["fullname"];
$email = $_POST["email"];
$Password = $_POST["Password"];
$PasswordRepeat = $_POST["Repeat_Password"];
$phone = $_POST["phone"];
$city = $_POST["city"];
$Password_Hash = password_hash($Password,PASSWORD_DEFAULT);

$errors = array();
//empty bo zaniny away ka hamu fieldakan prkrawnatawa yan na
if (empty($fullname) or empty($email) or empty($Password) or empty($PasswordRepeat) or empty($phone) or empty($city)){
array_push($errors,"all fields are required");
}
//bo dlnia bunawa la emalaka
if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
   array_push($errors,"Email is not valid");
}
if (strlen($Password)<8) {//boi passwordaka la 8 pit kamtr nabet
array_push($errors,"password must be 8 charecters long enogh");
}
if ($Password!==$PasswordRepeat) {//boi bzanin passwordaka yaksana yan na
array_push($errors,"password does not match");
}
require_once "database.php";
$sql ="SELECT * FROM users WHERE email ='$email'";//boi emaly dubara war nagret
$result = mysqli_query($conn, $sql);
$rowCount = mysqli_num_rows($result);
if ($rowCount) {
   array_push($errors,"Email already exists!");
}

if (count($errors)>0) {
   foreach ($errors as  $errors) {
echo "<div class ='alert alert-danger'>$errors</div>";
      
}
}
else{
   //we will insert the data into database
 
   $sql ="INSERT INTO users (full_name, email, password, phone, city)VALUES (?,?,?,?,?)";//($fullname, $email, $Password, $phone, $city) amashian akret bas bo sql injection asantra shkani
$stmt = mysqli_stmt_init($conn);
$preparestmt = mysqli_stmt_prepare($stmt,$sql);
if ($preparestmt) {
   mysqli_stmt_bind_param($stmt,"sssss", $fullname, $email, $Password_Hash, $phone, $city);
   mysqli_stmt_execute($stmt);
  // echo "<div class ='alert alert-success'>you are regestered successfuly.</div>";
  echo "<div class='alert alert-success'>You are registered successfully. Redirecting to login...</div>";
  header("refresh: 2; url=login.php");// Redirect after 2 seconds
  exit(); 

}
else {
   die("somthing went worng 2");
}
}

}
   ?>
    <form action="project.php" method="post">
        <div class="form-gruop">
         <label class="form-control">Name
            <input type="text" class="form-control" name="fullname"> 
            </label>
         </div>
         <div class="form-gruop">
            <label class="form-control">Email
           <input type="email" class="form-control" name="email" > 
           </label>
         </div>
         <div class="form-gruop">
            <label class="form-control">password
            <input type="password" class="form-control" name="Password" > 
            </label>
         </div>
         <div class="form-gruop">
            <label class="form-control">Repeat Password
            <input type="password" class="form-control" name="Repeat_Password" > 
            </label>
         </div>
         <div class="form-gruop">
            <label class="form-control">Phone
            <input type="tel" class="form-control" name="phone" > 
            </label>
         </div>
         <div class="form-gruop">
            <label class="form-control">City
            <input type="text" class="form-control" name="city" > 
            </label>
         </div><br>
         <div class="form-btn">
            <input type="submit" class="btn btn-primary" value="Resister" name="submit" > 
         </div>
         <div class="form-gruop">
            <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a></p>
         </div>
    </form>
</div>
</section>
 <footer>
        <div class="container">
            <p>&copy; 2025 کتێبخانەی ئێمە. هەموو مافەکان پارێزراون.</p>
        </div>
    </footer>
</body>
</html>