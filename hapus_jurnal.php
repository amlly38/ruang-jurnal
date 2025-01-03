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

    public function getUserJournals() {
        $sql = "SELECT * FROM journals WHERE author=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    public function countLikes($journalId) {
        $sql = "SELECT COUNT(*) AS total_likes FROM likes WHERE journal_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $journalId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total_likes'];
    }

    public function deleteJournal($journalId) {
        // Start a transaction
        $this->conn->begin_transaction();

        try {
            // Delete likes
            $sqlDeleteLikes = "DELETE FROM likes WHERE journal_id=?";
            $stmt = $this->conn->prepare($sqlDeleteLikes);
            $stmt->bind_param("i", $journalId);
            $stmt->execute();

            // Delete journal
            $sqlDeleteJournal = "DELETE FROM journals WHERE id=?";
            $stmt = $this->conn->prepare($sqlDeleteJournal);
            $stmt->bind_param("i", $journalId);
            $stmt->execute();

            // Commit transaction
            $this->conn->commit();
        } catch (Exception $e) {
            // Rollback transaction if any error occurs
            $this->conn->rollback();
            throw $e;
        }
    }
}

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['user'];
$journal = new Journal($conn, $username);

if (isset($_POST['delete_journal'])) {
    $journalId = $_POST['journal_id'];
    try {
        $journal->deleteJournal($journalId);
        header("Location: hapus_jurnal.php");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

$resultJournals = $journal->getUserJournals();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Jurnal</title>
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

        .journal {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: left;
            background: #f8f9fa;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .journal h3 {
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        .journal p {
            margin: 5px 0;
        }

        .journal a {
            color: #007bff;
            text-decoration: none;
        }

        .journal a:hover {
            text-decoration: underline;
        }

        .delete-button {
            background-color: #dc3545;
            border: none;
            border-radius: 5px;
            color: white;
            padding: 5px 10px;
            cursor: pointer;
        }

        .delete-button:hover {
            background-color: #c82333;
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
        <h1 class="text-center fw-bold">Uploaded Journal</h1>
        <div class="row">
            <?php while ($row = $resultJournals->fetch_assoc()): ?>
                <div class="col-md-12">
                    <div class="journal">
                        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p><strong>Keterangan:</strong> <?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                        <p><strong>Nama File:</strong> <a href="uploads/<?php echo htmlspecialchars($row['file']); ?>" 
                        target="_blank"><?php echo htmlspecialchars($row['original_name']); ?></a></p>
                        <p><strong>Jumlah Likes:</strong> <?php echo $journal->countLikes($row['id']); ?></p>
                        <form action="hapus_jurnal.php" method="post" class="d-inline">
                            <input type="hidden" name="journal_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="delete_journal" class="delete-button">Hapus</button>
                        </form>
                        <form action="edit_jurnal.php" method="post" class="d-inline">
                        <input type="hidden" name="journal_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="edit_journal" class="btn btn-primary">Edit</button>
                       </form>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="text-center">
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</body>
</html>
