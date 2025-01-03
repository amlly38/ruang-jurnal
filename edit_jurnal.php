<?php
session_start();
include 'config.php';

class Journal {
    private $conn;
    private $username;

    public function __construct($dbConnection, $username) {
        $this->conn = $dbConnection;
        $this->username = $username;
    }

    public function getJournal($journalId) {
        $sql = "SELECT * FROM journals WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $journalId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateJournal($journalId, $title, $content) {
        $sql = "UPDATE journals SET title=?, content=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $title, $content, $journalId);
        $stmt->execute();
    }
}

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['user'];
$journal = new Journal($conn, $username);

if (isset($_POST['edit_journal'])) {
    $journalId = $_POST['journal_id'];
    $journalData = $journal->getJournal($journalId);
}

if (isset($_POST['update_journal'])) {
    $journalId = $_POST['journal_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $journal->updateJournal($journalId, $title, $content);
    header("Location: hapus_jurnal.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jurnal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Protest+Guerrilla&display=swap');

        body {
            background-image: url('asetfoto/bgpolos.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Montserrat', sans-serif;
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            max-width: 800px;
            margin: auto;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-dark {
            background-color: #343a40;
            border: none;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }

        .btn-dark:hover {
            background-color: #23272b;
            color: white;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center fw-bold">Edit Jurnal</h1>
        <form action="edit_jurnal.php" method="post">
            <input type="hidden" name="journal_id" value="<?php echo $journalData['id']; ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Judul</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $journalData['title']; ?>">
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Keterangan</label>
                <textarea class="form-control" id="content" name="content" rows="5"><?php echo $journalData['content']; ?></textarea>
            </div>
            <button type="submit" name="update_journal" class="btn btn-dark">Update</button>
        </form>
    </div>
</body>
</html>
