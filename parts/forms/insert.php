<?php
// include_once 'db.php';
// if(isset($_POST['submit']))
// {    
//      $name = $_POST['server-name'];
//      $domain = $_POST['server-domain'];
//      $sql = "INSERT INTO Servers (Name, Domain)
//      VALUES ('$name','$domain')";
//      if (mysqli_query($conn, $sql)) {
//         echo "New record has been added successfully !";
//      } else {
//         echo "Error: " . $sql . ":-" . mysqli_error($conn);
//      }
//      mysqli_close($conn);
// }

function my_save_custom_form() {
    global $wpdb;
	$name = $_POST['server-name'];
	$domain = $_POST['server-domain'];
    $wpdb->insert(
        'Servers',
        array( 'server-name' => $name, 
		'server-domain' => $domain ),
        array( '%s', '%s' ),
    );

    wp_redirect( site_url('/server/') ); // <-- here goes address of site that user should be redirected after submitting that form
    die;
}
