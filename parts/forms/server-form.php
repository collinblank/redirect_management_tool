<div class="form-container">
    <h3 class="form-container__title">Add New Server</h3>
    <form role="form" method="POST" class="form">
        <ul class="form__inputs-container">
            <li class="form__input-item">
                <label for="server-name">Server Name<span>*</span></label>
                <input type="text" id="server-name" name="server-name" placeholder="Classical Conversations Production" required>
            </li>
            <li class="form__input-item">
                <label for="server-domain">Server Domain<span>*</span></label>
                <input type="text" id="server-domain" name="server-domain" placeholder="https://classicalconversations.com:7080/login.php" required>
            </li>
        </ul>
        <div class="form__btns-container">
            <button class="default-btn form__cancel-btn cancel-btn">Cancel</button>
            <input type="submit" class="default-btn form__submit-btn" name="submitserver" value="Create" />
        </div>
    </form>
</div>