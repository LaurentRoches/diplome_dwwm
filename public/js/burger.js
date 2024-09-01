document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menu-toggle');
    const mobileNav = document.getElementById('mobile-nav');

    menuToggle.addEventListener('click', function(e) {
        e.preventDefault();
        mobileNav.classList.toggle('show');
    });

    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768) {
            mobileNav.classList.remove('show');
        }
    });
});
