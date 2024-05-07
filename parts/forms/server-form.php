
<div class="form-container">
    <h3 class="form-container__title">Add Server</h3>
    <form action="insert.php" method="post" class="form-container__form">
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
            <button class="form__cancel-btn toggle-modal-btn">Cancel</button>
            <input type="submit" class="form__submit-btn" name="submit" value="Create">
        </div>
    </form>
</div>