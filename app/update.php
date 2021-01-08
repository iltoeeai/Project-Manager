<?php
if (isset($_POST['update'])) {
    $id = $_GET['edit'];
    $name = $_POST['name'];
    $select_name = $_POST['select_name'];

    if ($_GET['path'] == 'employees' or $_GET['path'] == '') {
        $sql_update = "UPDATE employees SET id=".$id.", name='" .$name. (isset($select_name)? "', project_id = '" . $select_name : "") . "' WHERE id = '$id'" or die($mysqli->error);

    } else if ($_GET['path'] == 'projects') {
        $sql_update = "UPDATE projects p SET p.name='$name' WHERE p.id = '$id'" or die($mysqli->error);
    }

    $stmt = $conn->prepare($sql_update);
    $stmt->execute();

    $_SESSION['message'] = "Record has been updated";
    $_SESSION['msg_type'] = "warning";

    $stmt->close();
    mysqli_close($conn);
    header("Location: " . strtok($_SERVER['REQUEST_URI'], '&'));
    die();
}
