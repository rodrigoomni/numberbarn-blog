/**
 * NumberBarn Blog — Theme JS
 */
document.addEventListener('DOMContentLoaded', function () {

    // ── HAMBURGER / MOBILE MENU ──────────────────────────────────
    const hamburger  = document.getElementById('nav-hamburger');
    const mobileMenu = document.getElementById('mobile-menu');

    if (hamburger && mobileMenu) {
        hamburger.addEventListener('click', function () {
            const isOpen = mobileMenu.classList.toggle('open');
            hamburger.classList.toggle('open', isOpen);
            hamburger.setAttribute('aria-expanded', isOpen);
            mobileMenu.setAttribute('aria-hidden', !isOpen);
            document.body.style.overflow = isOpen ? 'hidden' : '';
        });

        // Close on backdrop click (clicking outside drawer)
        mobileMenu.addEventListener('click', function (e) {
            if (e.target === mobileMenu) {
                mobileMenu.classList.remove('open');
                hamburger.classList.remove('open');
                hamburger.setAttribute('aria-expanded', 'false');
                mobileMenu.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
            }
        });

        // Close on ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && mobileMenu.classList.contains('open')) {
                mobileMenu.classList.remove('open');
                hamburger.classList.remove('open');
                hamburger.setAttribute('aria-expanded', 'false');
                mobileMenu.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
            }
        });
    }

    // ── SEARCH TOGGLE ────────────────────────────────────────────
    const searchToggle = document.getElementById('nav-search-toggle');
    const searchForm   = document.getElementById('nav-search-form');

    if (searchToggle && searchForm) {
        searchToggle.addEventListener('click', function (e) {
            const isOpen = searchForm.classList.toggle('open');
            if (isOpen) {
                searchForm.querySelector('input[type="search"]').focus();
            }
        });

        // Submit when input is open and enter is pressed
        searchForm.querySelector('input').addEventListener('keydown', function (e) {
            if (e.key === 'Enter') searchForm.submit();
        });

        // Close search when clicking outside
        document.addEventListener('click', function (e) {
            if (!searchForm.contains(e.target)) {
                searchForm.classList.remove('open');
            }
        });
    }

    // ── AUTHORS SLIDER ───────────────────────────────────────────
    const slider   = document.getElementById('authors-slider');
    const prevBtn  = document.getElementById('authors-prev');
    const nextBtn  = document.getElementById('authors-next');
    const dotsWrap = document.getElementById('authors-dots');

    if (slider && prevBtn && nextBtn && dotsWrap) {
        const cards = Array.from(slider.querySelectorAll('.author-card'));
        let current = 0;

        function getVisible() {
            const w = slider.parentElement.offsetWidth;
            if (w < 480) return 1;
            if (w < 900) return 2;
            return 4;
        }

        function getMaxIndex() {
            return Math.max(0, cards.length - getVisible());
        }

        // Build dots
        cards.forEach((_, i) => {
            const dot = document.createElement('button');
            dot.className = 'slider-dot' + (i === 0 ? ' active' : '');
            dot.setAttribute('aria-label', 'Go to author ' + (i + 1));
            dot.addEventListener('click', () => goTo(i));
            dotsWrap.appendChild(dot);
        });

        function updateDots() {
            dotsWrap.querySelectorAll('.slider-dot').forEach((d, i) => {
                d.classList.toggle('active', i === current);
            });
        }

        function updateArrows() {
            prevBtn.disabled = current <= 0;
            nextBtn.disabled = current >= getMaxIndex();
        }

        function goTo(index) {
            current = Math.max(0, Math.min(index, getMaxIndex()));
            const card = cards[current];
            if (card) {
                slider.scrollTo({ left: card.offsetLeft, behavior: 'smooth' });
            }
            updateDots();
            updateArrows();
        }

        prevBtn.addEventListener('click', () => goTo(current - 1));
        nextBtn.addEventListener('click', () => goTo(current + 1));

        // Sync on manual scroll (debounced)
        let scrollTimer;
        slider.addEventListener('scroll', () => {
            clearTimeout(scrollTimer);
            scrollTimer = setTimeout(() => {
                const scrollLeft = slider.scrollLeft;
                let closest = 0;
                let minDist  = Infinity;
                cards.forEach((card, i) => {
                    const dist = Math.abs(card.offsetLeft - scrollLeft);
                    if (dist < minDist) { minDist = dist; closest = i; }
                });
                if (closest !== current) {
                    current = closest;
                    updateDots();
                    updateArrows();
                }
            }, 80);
        }, { passive: true });

        // Init
        updateArrows();
    }

    // ── TOC: highlight active section on scroll ──────────────────
    const tocLinks = document.querySelectorAll('.toc-list a');
    const headings = document.querySelectorAll('.article-content h2');

    headings.forEach((h, i) => {
        if (!h.id) h.id = 'section-' + (i + 1);
    });

    if (tocLinks.length && headings.length) {
        const onScroll = () => {
            let current = '';
            headings.forEach(h => {
                if (window.scrollY >= h.offsetTop - 120) current = h.id;
            });
            tocLinks.forEach(a => {
                a.classList.toggle('active', a.getAttribute('href') === '#' + current);
            });
        };
        window.addEventListener('scroll', onScroll, { passive: true });
    }

    // ── BACK TO TOP ──────────────────────────────────────────────
    const backToTop = document.getElementById('back-to-top');
    if (backToTop) {
        window.addEventListener('scroll', () => {
            backToTop.classList.toggle('visible', window.scrollY > 200);
        }, { passive: true });
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // ── SHARE: copy link ─────────────────────────────────────────
    document.querySelectorAll('.share-btn[aria-label="Copy link"]').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            navigator.clipboard.writeText(window.location.href).then(() => {
                const orig = btn.innerHTML;
                btn.innerHTML = '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>';
                setTimeout(() => { btn.innerHTML = orig; }, 1500);
            });
        });
    });

});
