
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

server-form.php server name input html validation:
```
minlength="4" maxlength="50" pattern="^[A-Za-z]+(?: [A-Za-z]+)*$" required
```

server-form.php server domain input html validation:
```
maxlength="100" pattern="^https?://.*$" required 
<!-- (could include optional minlength but not really necessary) -->
```

also removed the default disabled attr on server-form submit btn
