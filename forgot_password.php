<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Periksa apakah email ada di database
    $sql_check_email = "SELECT * FROM users WHERE email='$email'";
    $result_check_email = mysqli_query($conn, $sql_check_email);

    if (mysqli_num_rows($result_check_email) > 0) {
        // Periksa apakah password baru dan konfirmasi password cocok
        if ($new_password === $confirm_password) {
            // Enkripsi password baru
            $encrypted_password = encryptPassword($new_password);

            // Update password di database
            $sql_update_password = "UPDATE users SET password='$encrypted_password' WHERE email='$email'";
            mysqli_query($conn, $sql_update_password);

            // Redirect ke halaman login
            header("Location: login.php");
            exit();
        } else {
            $error_message = "Password baru dan konfirmasi password tidak cocok.";
        }
    } else {
        $error_message = "Email tidak ditemukan. Silakan periksa alamat email Anda.";
    }
}

// Fungsi untuk melakukan enkripsi password
function encryptPassword($password) {
    global $encryption_key;
    return openssl_encrypt($password, 'AES-128-ECB', $encryption_key);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Reset Password</title>
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
        .container2 input[type="email"], .container2 input[type="password"] {
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
        <h1>Forget Password</h1>
        <?php if(isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form action="forgot_password.php" method="post" style="margin-top:7%;">
            <input type="email" name="email" placeholder="Masukkan alamat email Anda" required>
            <input type="password" name="new_password" placeholder="Masukkan password baru" required>
            <input type="password" name="confirm_password" placeholder="Konfirmasi password baru" required>
            <button type="submit" style = "width: 90%;">Ganti Password</button>
        </form>
        <p class="mt-5 mb-2">Back to Login? <strong><a href="login.php">Login here</a></strong></p>
    </div>
</body>
</html>
