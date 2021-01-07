<?php
$update = false;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $result = $conn->query("SELECT * FROM " . $table_name . " WHERE " . $table_name . ".id=$id") or die($conn->error);
    if (count(array($result))==1){
        $row = $result->fetch_array();
        $first_en = $row['name'];
    }
}