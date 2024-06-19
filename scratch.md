
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

for server form:
```
 action="../../functions/form-handlers/<?php echo $action ?>-server.php"
```

for website list search feature
```
            <?php if ($websites_search && (str_contains(strtolower($item['name']), $websites_search) || str_contains(strtolower($item['domain']), $websites_search))) : ?>
<?php endif; ?>
```