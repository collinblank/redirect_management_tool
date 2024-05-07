</main>
<?php get_sidebar(); ?>
</div>
<footer id="footer" role="contentinfo">
    <script>
        const modal = document.querySelector(".modal");
        const toggleModalBtns = document.querySelectorAll(".toggle-modal-btn");
        console.log("script called!");

        toggleModalBtns.forEach((btn) => {
            btn.addEventListener("click", function() {
                toggleModal(modal);
                console.log("button click works!");
            });
        });

        function toggleModal(modal) {
            if (modal.classList.contains("active")) {
                modal.classList.remove("active");
            } else {
                modal.classList.add("active");
            }
        }
    </script>
    <div id="copyright">
        &copy; <?php echo esc_html(date_i18n(__('Y', 'grant-branch'))); ?> <?php echo esc_html(get_bloginfo('name')); ?>
    </div>
</footer>
</div>
<?php wp_footer(); ?>
</body>

</html>