<?php
require_once "connect.php";
if(isset($_GET["id"]))
{
    $article_id = $_GET["id"];
    $sql = "DELETE FROM articles WHERE id=$article_id"; 
    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully";
        header("Location: admin.php");
        exit;
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

}
?>