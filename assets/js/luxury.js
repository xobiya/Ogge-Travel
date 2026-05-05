document.addEventListener('DOMContentLoaded', () => {
    // Scroll Reveal
    const revealElements = document.querySelectorAll('.reveal');
    if (revealElements.length > 0) {
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) { e.target.classList.add('active'); obs.unobserve(e.target); }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });
        revealElements.forEach(el => obs.observe(el));
    }

    // Header scroll state
    const header = document.getElementById('mainHeader');
    if (header) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 80) { header.classList.add('header-scrolled'); }
            else { header.classList.remove('header-scrolled'); }
        }, { passive: true });
    }

    // Parallax
    const parallaxEls = document.querySelectorAll('[data-parallax]');
    if (parallaxEls.length > 0) {
        window.addEventListener('scroll', () => {
            const s = window.scrollY;
            parallaxEls.forEach(el => {
                el.style.transform = `translateY(${s * (el.dataset.parallax || 0.3)}px)`;
            });
        }, { passive: true });
    }

    // Stagger children
    const staggerContainers = document.querySelectorAll('[data-stagger]');
    if (staggerContainers.length > 0) {
        const sObs = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    Array.from(entry.target.children).forEach((child, i) => {
                        child.style.transitionDelay = `${i * 0.12}s`;
                        child.classList.add('active');
                    });
                    sObs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        staggerContainers.forEach(el => sObs.observe(el));
    }
});
