<?php
require("dbConnection.php");

// Fetch all rows from the database
try {
    $sqlSelectAll = "SELECT * FROM crudtest";
    $stmtSelectAll = $db->query($sqlSelectAll);
    $rows = $stmtSelectAll->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching data: " . $e->getMessage();
    $rows = [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle Insert
    if (isset($_POST['first_name'], $_POST['surname'], $_POST['age']) && !isset($_POST['delete_id']) && !isset($_POST['update_id'])) {
        $fn = $_POST["first_name"];
        $sn = $_POST["surname"];
        $ag = $_POST["age"];
        try {
            $sqlInsert = "INSERT INTO crudtest (first_name, surname, age) VALUES (:fn, :sn, :ag)";
            $stmtInsert = $db->prepare($sqlInsert);
            $stmtInsert->bindParam(':fn', $fn);
            $stmtInsert->bindParam(':sn', $sn);
            $stmtInsert->bindParam(':ag', $ag);
            $stmtInsert->execute();
            echo "New record added!";
        } catch (PDOException $e) {
            echo "Error adding: " . $e->getMessage();
        }
    }

    // Handle Delete
    if (isset($_POST['delete_id']) && !isset($_POST['update_id'])) {
        $idToDelete = $_POST['delete_id'];
        try {
            $sqlDelete = "DELETE FROM crudtest WHERE ID = :id";
            $stmtDelete = $db->prepare($sqlDelete);
            $stmtDelete->bindParam(':id', $idToDelete);
            $stmtDelete->execute();
            echo "Record with ID " . $idToDelete . " deleted!";
        } catch (PDOException $e) {
            echo "Error deleting: " . $e->getMessage();
        }
    }

    // Handle Update
    if (isset($_POST['update_id'], $_POST['update_first_name'], $_POST['update_surname'], $_POST['update_age']) && !isset($_POST['delete_id'])) {
        $idToUpdate = $_POST['update_id'];
        $updatedFirstName = $_POST['update_first_name'];
        $updatedSurname = $_POST['update_surname'];
        $updatedAge = $_POST['update_age'];
        try {
            $sqlUpdate = "UPDATE crudtest SET first_name = :fn, surname = :sn, age = :ag WHERE ID = :id";
            $stmtUpdate = $db->prepare($sqlUpdate);
            $stmtUpdate->bindParam(':id', $idToUpdate);
            $stmtUpdate->bindParam(':fn', $updatedFirstName);
            $stmtUpdate->bindParam(':sn', $updatedSurname);
            $stmtUpdate->bindParam(':ag', $updatedAge);
            $stmtUpdate->execute();
            echo "Record with ID " . $idToUpdate . " updated!";
        } catch (PDOException $e) {
            echo "Error updating: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple CRUD</title>
</head>
<body>
    <h2>Add New Record</h2>
    <form method="post">
        First Name: <input type="text" name="first_name" required><br>
        Surname: <input type="text" name="surname" required><br>
        Age: <input type="number" name="age" required><br>
        <input type="submit" value="New">
    </form>

    <h2>Current Records:</h2>
    <?php if (!empty($rows)): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>id</th>
                    <th>First Name</th>
                    <th>Surname</th>
                    <th>Age</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['first_name']; ?></td>
                        <td><?php echo $row['surname']; ?></td>
                        <td><?php echo $row['age']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No records found.</p>
    <?php endif; ?>

    <h2>Delete Record</h2>
    <form method="post">
        ID to delete: <input type="number" name="delete_id" required><br>
        <input type="submit" value="Delete">
    </form>

    <h2>Update Record</h2>
    <form method="post">
        ID to update: <input type="number" name="update_id" required><br>
        New First Name: <input type="text" name="update_first_name" required><br>
        New Surname: <input type="text" name="update_surname" required><br>
        New Age: <input type="number" name="update_age" required><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>