<?php
include_once 'db.php';
if(isset($_POST['submit']))
{    
     $name = $_POST['server-name'];
     $domain = $_POST['server-domain'];
     $sql = "INSERT INTO Servers (Name, Domain)
     VALUES ('$name','$domain')";
     if (mysqli_query($conn, $sql)) {
        echo "New record has been added successfully !";
     } else {
        echo "Error: " . $sql . ":-" . mysqli_error($conn);
     }
     mysqli_close($conn);
}
