<?php

if (isset($_POST['save'])) {

    $sql_save = "INSERT INTO " . $table_name . " (`name`) VALUES (?)";
    $stmt = $conn->prepare($sql_save);
    $stmt->bind_param("s", $_POST['name']);
    $stmt->execute();
    
    $_SESSION['message'] = "Record has been saved";
    $_SESSION['msg_type'] = 'success';
   
    $stmt->close();
    mysqli_close($conn);
    header("Location: " . strtok($_SERVER['REQUEST_URI'], '&')); 

    die();
}
