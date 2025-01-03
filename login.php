<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Periksa apakah input adalah email atau username
    $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    // Query untuk mencari pengguna berdasarkan email atau username
    $sql = "SELECT * FROM users WHERE $field = '$login'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Decrypt password yang diambil dari database
        $original_password = decryptPassword($user['password']);

        // Verifikasi password
        if ($password === $original_password) {

            // Simpan user_id ke dalam sesi
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user'] = $user['username'];
            $_SESSION['profile_picture'] = $row['profile_picture'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password. Please try again.";
        }
    } else {
        $error = "User not found, please check your email or username.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Login</title>
    <style>
        body {
            background-image: url('asetfoto/bgpolos.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .container2 {
            background: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 15px;
            max-width: 400px;
            margin: auto;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .container2 h1 {
            margin-bottom: 20px;
            color: #333;
        }
        .container2 input[type="text"], .container2 input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .container2 button {
            width: 90%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #333;
            color: white;
            cursor: pointer;
        }
        .container2 button:hover {
            background-color: #555;
        }
        .container2 .error {
            color: red;
            margin-bottom: 10px;
        }

        .container2 p a {
            color: black;
            text-decoration: none;
        }
        .container2 p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand fw-semibold text-dark" href="index.php">
      <img src="asetfoto/logo.png" alt="Logo" width="35" height="35" class="d-inline-block align-text-top">
      <i class="text-black ms-2"> Ruang Jurnal </i>
    </a>
      <ul class="nav justify-content-end me-auto">  
        <li class="nav-item">
          <a class="btn btn-dark" aria-current="page" href="home.php">Home</a>
        </li>
      </ul>
  </div>
</nav>
    <br>
    <br>
      <div class="container2">
          <h1>Login</h1>
          <br>
          <?php if (isset($error)): ?>
              <div class="error"><?php echo $error; ?></div>
          <?php endif; ?>
          <form action="login.php" method="post">
              <input type="text" name="login" placeholder="Email or Username" required>
              <input type="password" name="password" placeholder="Password" required>
              <button type="submit">Login</button>
          </form>
          <p class="mt-5 mb-2">Forgot your password? <strong><a href="forgot_password.php">Reset here</a></strong></p>
          <p>Don't have an account? <strong><a href="register.php">Register here</a></strong></p>
      </div>
</body>
</html>
