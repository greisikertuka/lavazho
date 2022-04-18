<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once "config.php";

$sql = "SELECT * FROM kliente";
$result = $link->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><?= $row['emri']; ?></td>
            <td><?= $row['mbiemri']; ?></td>
            <td><?= $row['numriCel']; ?></td>
            <td><?= $row['email']; ?></td>
        </tr>
        <?php
    }
} else {
    echo "0 rezultate";
}

if ($_POST['action'] == 'ruaj') {
    $emri = mysqli_real_escape_string($link, $_POST['emri']);
    $mbiemri = mysqli_real_escape_string($link, $_POST['mbiemri']);
    $numri = mysqli_real_escape_string($link, $_POST['numri']);
    $email = mysqli_real_escape_string($link, $_POST['email']);

    $query = "INSERT INTO kliente SET emri = '" . $emri . "',
                                    mbiemri = '" . $mbiemri . "',
                                    numriCel = '" . $numri . "',
                                    email = '" . $email . "'
   ";
    $queryResult = mysqli_query($link, $query);

    echo json_encode(array('status' => '200', 'message' => 'sukses'));
}
?>