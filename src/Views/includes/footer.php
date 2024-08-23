
</body>
<footer>
    <script> const HOME_URL = "<?= HOME_URL ?>"; </script>
    <?php if (isset($_SESSION['connected']) && $_SESSION['connected']) { ?>
    <script src="<?= HOME_URL ?>js/dashboard.js" defer></script>
    <?php } else {?>
    <script src="<?= HOME_URL ?>js/login.js"></script>
    <script src="<?= HOME_URL ?>js/register.js"></script>
    <?php } ?>
</footer>
</html>
