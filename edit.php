<?php
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];

    $sql = "SELECT * FROM testTable WHERE id='$edit_id'";
    $result = sqlsrv_query($conn, $sql) or die("Query error : " . sqlsrv_errors($result));

    $data = sqlsrv_fetch_array($result);

    $PackVolt = $data['PackVolt'];
    $PackCurrent = $data['PackCurrent'];
    $Temperature = $data['Temperature'];
}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "SELECT * FROM testTable WHERE id='$id'";
    $result = sqlsrv_query($conn, $sql) or die("Query error : " . sqlsrv_errors($result));
}
XXXXX