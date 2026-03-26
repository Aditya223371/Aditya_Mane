// ============= MAISON FURNITURE — MAIN JS =============

document.addEventListener('DOMContentLoaded', function () {

    // --- HEADER SCROLL ---
    const header = document.getElementById('site-header');
    if (header) {
        window.addEventListener('scroll', () => {
            header.classList.toggle('scrolled', window.scrollY > 50);
            const btn = document.getElementById('backToTop');
            if (btn) btn.classList.toggle('visible', window.scrollY > 400);
        });
    }

    // --- SEARCH TOGGLE ---
    const searchToggle = document.getElementById('searchToggle');
    const searchBar    = document.getElementById('searchBar');
    const searchClose  = document.getElementById('searchClose');
    const searchInput  = document.getElementById('searchInput');
    if (searchToggle && searchBar) {
        searchToggle.addEventListener('click', () => {
            searchBar.classList.toggle('active');
            if (searchBar.classList.contains('active') && searchInput) searchInput.focus();
        });
        if (searchClose) searchClose.addEventListener('click', () => searchBar.classList.remove('active'));
    }

    // --- MOBILE MENU ---
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mainNav       = document.getElementById('mainNav');
    const mobileOverlay = document.getElementById('mobileOverlay');
    if (mobileMenuBtn && mainNav) {
        mobileMenuBtn.addEventListener('click', () => {
            mainNav.classList.toggle('open');
            if (mobileOverlay) mobileOverlay.classList.toggle('active');
            document.body.style.overflow = mainNav.classList.contains('open') ? 'hidden' : '';
        });
        if (mobileOverlay) mobileOverlay.addEventListener('click', () => {
            mainNav.classList.remove('open');
            mobileOverlay.classList.remove('active');
            document.body.style.overflow = '';
        });
    }

    // --- BACK TO TOP ---
    const backToTop = document.getElementById('backToTop');
    if (backToTop) backToTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

    // ─── CART — uses direct form POST to cart-handler.php ────────────────────
    // No AJAX, no localStorage. A hidden form is submitted directly to PHP.
    // This guarantees the PHP session is always updated correctly.

    window.addToCart = function (productId) {
        // Create a hidden form and submit it to cart-handler.php
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = '/furniture-website/cart-handler.php';
        form.style.display = 'none';

        var fields = {
            action:     'add',
            product_id: productId,
            color:      'Default',
            ref:        window.location.pathname  // come back to current page
        };

        Object.keys(fields).forEach(function(key) {
            var input = document.createElement('input');
            input.type  = 'hidden';
            input.name  = key;
            input.value = fields[key];
            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit(); // page redirects → comes back → cart is updated
    };
    // ─────────────────────────────────────────────────────────────────────────

    // --- TOAST (kept for wishlist feedback) ---
    function showToast(msg) {
        var toast = document.getElementById('cartToast');
        if (!toast) return;
        var msgEl = toast.querySelector('.toast-msg');
        if (msgEl) msgEl.textContent = msg;
        toast.classList.add('show');
        setTimeout(function() { toast.classList.remove('show'); }, 2500);
    }

    // --- WISHLIST ---
    document.querySelectorAll('.product-wishlist').forEach(function(btn) {
        btn.addEventListener('click', function () {
            this.textContent = this.textContent === '\u2661' ? '\u2665' : '\u2661';
            this.style.color = this.textContent === '\u2665' ? '#E05252' : '';
            showToast(this.textContent === '\u2665' ? 'Added to wishlist!' : 'Removed from wishlist');
        });
    });

    // --- SCROLL REVEAL ---
    var revealObserver = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry, i) {
            if (entry.isIntersecting) {
                setTimeout(function() {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, i * 80);
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.product-card, .category-card, .testimonial-card, .craft-feature').forEach(function(el) {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        revealObserver.observe(el);
    });

    // --- NEWSLETTER ---
    var nlForm = document.querySelector('.nl-form');
    if (nlForm) {
        nlForm.addEventListener('submit', function(e) {
            e.preventDefault();
            var input = this.querySelector('input[type="email"]');
            showToast('Thank you for subscribing!');
            if (input) input.value = '';
        });
    }

    // --- CONTACT FORM ---
    var contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            var btn = this.querySelector('[type="submit"]');
            btn.textContent = 'Sending...'; btn.disabled = true;
            setTimeout(function() {
                var s = document.getElementById('formSuccess');
                if (s) s.style.display = 'block';
                contactForm.reset();
                btn.textContent = 'Send Message'; btn.disabled = false;
            }, 1500);
        });
    }

    // --- ACCOUNT DROPDOWN ---
    var accountToggle   = document.getElementById('accountToggle');
    var accountDropdown = document.getElementById('accountDropdown');
    if (accountToggle && accountDropdown) {
        accountToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            accountDropdown.classList.toggle('open');
        });
        document.addEventListener('click', function() {
            accountDropdown.classList.remove('open');
        });
    }

});
