
For server-side validation errors on server form.
```
<?php if (isset($errors["server_name"]) || isset($errors["server_domain"])) : ?>
    <div>
        <?php if (isset($errors["server_name"])) : ?>
            <p class="error-msg"><?= $errors["server_name"] ?></p>
        <?php endif; ?>
        <?php if (isset($errors["server_domain"])) : ?>
            <p class="error-msg"><?= $errors["server_domain"] ?></p>
        <?php endif; ?>
    </div>
<?php endif; ?>
```