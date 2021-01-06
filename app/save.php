<?php
// session_start();

if (isset($_POST['save'])) {

    $sql_save = "INSERT INTO " . $table_name . " (`name`) VALUES (?)";
    $stmt = $conn->prepare($sql_save);
    $stmt->bind_param("s", $_POST['name']);
    $stmt->execute();
    
    $_SESSION['message'] = "Record has been saved";
    $_SESSION['msg_type'] = 'success';
    ob_clean();
    ob_start();
    header("Location: index.php?path=" . $_GET['path']);
    ob_flush();
    exit;
    
}
