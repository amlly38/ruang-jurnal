<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['Judul']; // Mengubah dari 'title' menjadi 'Judul'
    $author = $_SESSION['user'];
    $content = $_POST['content'];

    $faculty = isset($_POST['faculty']) ? implode(", ", $_POST['faculty']) : '';

    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('pdf');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            $fileNameNew = uniqid('', true) . "." . $fileActualExt;
            $fileDestination = 'uploads/' . $fileNameNew;
            move_uploaded_file($fileTmpName, $fileDestination);

            // Simpan nama asli file ke dalam kolom original_name
            $originalName = $_FILES['file']['name'];

            // Menggunakan parameterized query untuk mencegah SQL injection
            $sql = "INSERT INTO journals (title, author, content, file, original_name, faculty) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $title, $author, $content, $fileNameNew, $originalName, $faculty);
            $stmt->execute();

            header("Location: index.php");
            exit();
        } else {
            $error = "Error uploading file!";
        }
    } else {
        $error = "Only PDF files are allowed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Jurnal</title>
    <style>
        body {
            background-image: url('asetfoto/bgpolos.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Montserrat', sans-serif;
            color: #333;
        }
        .container2 {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .container2 h1 {
            margin-bottom: 20px;
            color: #333;
            font-size: 30px;
        }
        .container2 input[type="text"],
        .container2 textarea,
        .container2 select,
        .container2 input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }
        .container2 button {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 5px;
            background-color: #333;
            color: white;
            cursor: pointer;
            font-size: 16px;
            font-family: 'Montserrat', sans-serif;
        }
        .container2 button:hover {
            background-color: #555;
        }
        .container2 .error {
            color: red;
            margin-bottom: 10px;
        }
        .container2 a {
            color: #333;
            text-decoration: none;
        }
        .container2 a:hover {
            text-decoration: underline;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <br><br>
    <div class="container2">
        <h1>Upload Journal</h1>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="text" name="Judul" placeholder="Judul" required>
            <textarea name="content" placeholder="Keterangan" rows="4" required></textarea>
            <select class="form-select" name="faculty[]" id="fakultas" required>
                <option selected>Pilih Fakultas</option>
                <option value="Keguruan dan Ilmu Pendidikan">Keguruan dan Ilmu Pendidikan</option>
                <option value="Ilmu Komputer">Ilmu Komputer</option>
                <option value="Hukum">Hukum</option>
                <option value="Ekonomi dan Bisnis">Ekonomi dan Bisnis</option>
                <option value="Pertanian">Pertanian</option>
                <option value="Agama Islam">Agama Islam</option>
                <option value="Teknik">Teknik</option>
                <option value="Ilmu Sosial dan Ilmu Politik">Ilmu Sosial dan Ilmu Politik</option>
            </select>
            <input type="file" name="file" accept=".pdf" required>
            <button type="submit">Upload</button>
        </form>
        <br>
        <a href="index.php">Batalkan</a>
    </div>
</body>
</html>
