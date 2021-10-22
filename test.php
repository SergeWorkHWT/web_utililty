<?php
ob_start(); // open cache
include("connect.php");
$id = 0;
$PackVolt = '';
$PackCurrent = '';
$Temperature = '';
$update = false;
function getData()
{
    $data = array();
    $data[1] = $_POST['PackVolt'];
    $data[2] = $_POST['PackCurrent'];
    $data[3] = $_POST['Temperature'];
    return $data;
}
if (isset($_POST['insert'])) {
    $info = getData();
    $sql = "INSERT INTO [testTable] ([PackVolt],[PackCurrent],[Temperature]) 
    VALUES('$info[1]','$info[2]','$info[3]')";
    // $params = array(1, "A");  sqlsrv_query supposed have $params but it works
    $result = sqlsrv_query($conn, $sql);
} else {
    echo "Insert Fail";
}


if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];

    $sql = "SELECT * FROM testTable WHERE id='$edit_id'";
    $result = sqlsrv_query($conn, $sql) or die("Query error : " . sqlsrv_errors($result));

    $data = sqlsrv_fetch_array($result);

    $id = $data['ID'];
    $PackVolt = $data['PackVolt'];
    $PackCurrent = $data['PackCurrent'];
    $Temperature = $data['Temperature'];
    $update = true;
}

if (isset($_POST['update'])) {
    $id = $_POST['update'];

    $id = $_POST['id'];
    $PackVolt = $_POST['PackVolt'];
    $PackCurrent = $_POST['PackCurrent'];
    $Temperature = $_POST['Temperature'];
    $sql = "UPDATE testTable SET PackVolt='$PackVolt',PackCurrent='$PackCurrent',Temperature='$Temperature'WHERE id='$id'";

    $result = sqlsrv_query($conn, $sql) or die("Query error : " . sqlsrv_errors($result));
    $id = '';
    $PackVolt = '';
    $PackCurrent = '';
    $Temperature = '';
    header('test.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>CRUD Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="jumbotron text-center">
        <h1>My First Bootstrap Page</h1>
        <p>Resize this responsive page to see the effect!</p>
    </div>

    <div class="row justify-content-center">
        <form method="POST" action="test.php">


            <div class="form-group">
                <input type="hidden" name="id" value="<?php echo $id ?>">
            </div>

            <div class="form-group">
                <label for="usr">PackVolt:</label>
                <input type="text" class="form-control" id="PackVolt" name="PackVolt" value="<?php echo $PackVolt ?>">
            </div>


            <div class="form-group">
                <label for="usr">PackCurrent:</label>
                <input type="text" class="form-control" id="PackCurrent" name="PackCurrent" value="<?php echo $PackCurrent ?>">
            </div>


            <div class="form-group">
                <label for="usr">Temperature:</label>
                <input type="text" class="form-control" id="Temperature" name="Temperature" value="<?php echo $Temperature ?>">
            </div>

            <?php
            if ($update == true) :
            ?>
                <button type="submit" class="btn btn-info" name="update">Update</button>
            <?php else : ?>
                <button type="submit" class="btn btn-primary" name="insert">insert</button>
            <?php endif; ?>
        </form>
    </div>
    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <table class="table table-bordered table-responsive">
                <tr>
                    <td>ID</td>
                    <td>PackVolt</td>
                    <td>PackCurrent</td>
                    <td>Temperature</td>
                </tr>
                <?php
                $sql = "SELECT * FROM testTable";
                $result = sqlsrv_query($conn, $sql) or die("Query error : " . sqlsrv_errors($result));
                $i = 0;
                while ($data = sqlsrv_fetch_array($result)) {
                    $id = $data['ID'];
                    $PackVolt = $data['PackVolt'];
                    $PackCurrent = $data['PackCurrent'];
                    $Temperature = $data['Temperature'];
                    $i++;

                ?>

                    <tr align="center">
                        <td><?php echo $id; ?></td>
                        <td><?php echo $PackVolt; ?></td>
                        <td><?php echo $PackCurrent; ?></td>
                        <td><?php echo $Temperature; ?></td>
                        <td><a href="test.php?edit=<?php echo $id; ?>" class="btn btn-info">edit</a></td>
                        <td><a href="test.php?delete=<?php echo $id; ?>" class="btn btn-danger">delete</a></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <?php
    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        $sql = "DELETE FROM testTable WHERE id='$delete_id'";
        $result = sqlsrv_query($conn, $sql) or die("Query error : " . sqlsrv_errors($result));
        // if ($result) {
        //     echo "";
        // }
        header("location:test.php");
        ob_end_flush();
    }
    ?>
</body>

</html>