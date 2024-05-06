<?php
// $servername = DB_HOST;
// $username = DB_USER;
// $password = DB_PASSWORD;
// $dbname = DB_NAME;
// $sql = "mysql:host=$servername;dbname=$dbname;";
// $dsn_Options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
// // Create a new connection to the MySQL database using PDO, $my_Db_Connection is an object
// try {
//     $my_Db_Connection = new PDO($sql, $username, $password, $dsn_Options);
//     echo "Connected successfully";
// } catch (PDOException $error) {
//     echo 'Connection error: ' . $error->getMessage();
// }
// // Set the variables for the person we want to add to the database
// $name = filter_input(INPUT_POST, 'server_name', FILTER_SANITIZE_STRING);
// $domain = filter_input(INPUT_POST, 'server_domain', FILTER_SANITIZE_STRING);

// // Here we create a variable that calls the prepare() method of the database object
// // The SQL query you want to run is entered as the parameter, and placeholders are written like this :placeholder_name
// $my_Insert_Statement = $my_Db_Connection->prepare("INSERT INTO Servers (Name, Domain) VALUES (:name, :domain)");
// // Now we tell the script which variable each placeholder actually refers to using the bindParam() method
// // First parameter is the placeholder in the statement above - the second parameter is a variable that it should refer to
// $my_Insert_Statement->bindParam(":name", $name);
// $my_Insert_Statement->bindParam(":domain", $domain);
// // Execute the query using the data we just defined
// // The execute() method returns TRUE if it is successful and FALSE if it is not, allowing you to write your own messages here
// if ($my_Insert_Statement->execute()) {
//     echo "New record created successfully";
// } else {
//     echo "Unable to create record";
// }
?>

<div class="form-container">
    <h3 class="form-container__title">Add Server</h3>
    <form class="form-container__form">
        <ul class="form__inputs-container">
            <li class="form__input-item">
                <label for="server-name"><span>*</span>Server Name</label>
                <input type="text" id="server-name" name="server-name" placeholder="ex. Classical Conversations Production" required>
            </li>
            <li class="form__input-item">
                <label for="server-domain"><span>*</span>Server Domain</label>
                <input type="text" id="server-domain" name="server-domain" placeholder="ex. https://classicalconversations.com:7080/login.php" required>
            </li>
        </ul>
        <div class="form__btns-container">
            <button class="form__cancel-btn">Cancel</button>
            <button type="submit" class="form__submit-btn">Create</button>
        </div>
    </form>
</div>

<script>
    const cancelBtn = document.querySelector('.form__cancel-btn');
    const modal = document.querySelector('.modal')

    cancelBtn.addEventListener('click', () => {
        modal.classList.remove('active');
    })
</script>