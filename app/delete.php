<?php
// session_start();
#DELETE
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $sql_delete = "DELETE FROM " . $table_name . " WHERE id = " . $id;
    $stmt = $conn->prepare($sql_delete);
    $stmt->execute();
    
    // ob_start();
    $_SESSION['message'] = "Record has been deleted";
    $_SESSION['msg_type'] = "danger";
    ob_clean();
    ob_start();
    header("Location: index.php?path=" . $_GET['path']);
    ob_flush();
    exit;
}