<?php /* Template Name: Server */ ?>
<html>
<section class="server-container">
    <div class="server-container__header">
        <div id="server-heading">
            <h1>Manage Servers</h1>
        </div>
        <button id="add-server-btn" class="display-modal-btn">Add Server</button>
    </div>
    <div class="modal">
        <?php echo get_template_part('parts/forms/server-form'); ?>
        <?php include 'server-form.php' ?>
    </div>
</section>

</html>

<script>
    const addServerBtn = document.getElementById('add-server-btn');
    const modal = document.querySelector('.modal')

    addServerBtn.addEventListener('click', function() {
        modal.classList.add('active');
    })

    // const displayModalBtns = document.querySelectorAll('.display-modal-btn');
    // const modal = document.querySelector('.modal');

    // displayModalBtns.forEach(btn => {
    //     btn.addEventListener('click', function() {
    //         modal.classList.add('active')
    //     });
    // })
</script>