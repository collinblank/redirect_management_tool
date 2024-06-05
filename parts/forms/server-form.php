<?php
// This may be what is slowing down the modal popup:
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

$action = $_GET['action'];
$item_id = intval($_GET['item_id']) ?? null;
$server_name = "";
$server_domain = "";

if ($action === 'edit' && isset($_GET['table_name']) && isset($item_id)) {
    global $wpdb;
    $table_name = $_GET['table_name'];
    $sql = $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $item_id);
    $server = $wpdb->get_row($sql, ARRAY_A);

    if ($server) {
        $server_name = $server['name'];
        $server_domain = $server['domain'];
    }
}
?>


<div class="form-container server-form-container">
    <div class="form-container__heading">
        <h3 class="form-container__title"><?php echo ucfirst($action) . " Server" ?></h3>
    </div>
    <form role="form" method="POST" class="form">
        <ul class="form__inputs-container">
            <li class="form__input-item">
                <label for="server-name">Server Name<span>*</span></label>
                <input type="text" id="server-name" name="server_name" placeholder="ex. Classical Conversations Production" value="<?php echo $server_name ?>" minlength="4" maxlength="50" pattern="^[A-Za-z]+$" required>
            </li>
            <li class="form__input-item">
                <label for="server-domain">Server Domain<span>*</span></label>
                <input type="text" id="server-domain" name="server_domain" placeholder="ex. https://classicalconversations.com:7080/login.php" value="<?php echo $server_domain ?>" required>
            </li>
        </ul>
        <div class="form__btns-container">
            <button class="default-btn cancel-btn">Cancel</button>
            <?php if ($item_id) : ?>
                <input type="hidden" name="item_id" value=<?php echo $item_id ?>>
            <?php endif; ?>
            <input type="submit" class="default-btn form__submit-btn" name="<?php echo $action . "_server" ?>" value="<?php echo $action === 'edit' ? 'Done' : 'Create' ?>" />
        </div>
    </form>
</div>

<script>
    // Form validation
    const serverNameInput = document.getElementById('server-name');
    const serverDomainInput = document.getElementById('server-domain');

    function checkServerName() {
        if (!serverNameInput.validity.valid) {
            console.log('Invalid input')
            if (serverNameInput.validity.patternMismatch) {
                console.log('Pattern mismatch');
            }
            if (serverNameInput.validity.tooLong) {
                console.log('Too long');
            }
            if (serverNameInput.validity.tooShort) {
                console.log('Too short');
            }
            if (serverNameInput.validity.valueMissing) {
                console.log('Value missing on required element');
            }
        } else {
            console.log('Input valid!')
        }
    }

    serverNameInput.addEventListener('input', checkServerName)
</script>