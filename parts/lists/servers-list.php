<?php
$results = $args['results'] ?? null;
?>

<?php if ($results) : ?>
    <table>
        <tr>
            <th>Name</th>
            <th>Domain</th>
            <th>Options</th>
        </tr>
        <?php foreach ($results as $item) : ?>
            <tr>
                <td><?= $item['name'] ?></td>
                <td><?= $item['domain'] ?></td>
                <td><button class="icon-btn"><i class="fa-solid fa-ellipsis"></i></button></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else : ?>
    <p>Error: Unable to retrieve results from database.</p>
<?php endif; ?>