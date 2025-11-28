import './bootstrap';

import AOS from 'aos';
import 'aos/dist/aos.css';
import Alpine from 'alpinejs';

// Initialize once on DOM ready
document.addEventListener('DOMContentLoaded', function () {
    // AOS animations (optional)
    try {
        AOS.init({ duration: 800, once: true, offset: 50 });
    } catch (e) {
        // ignore if AOS not available
    }

    // Alpine
    window.Alpine = Alpine;
    try { Alpine.start(); } catch (e) {}

    // Navbar scroll behavior: add white blurred background & shadow when scrolled
    const header = document.getElementById('main-header');
    if (header) {
        const SCROLLED = ['bg-white', 'bg-opacity-95', 'backdrop-blur-sm', 'shadow-sm', 'py-2'];
        const DEFAULT = ['bg-transparent', 'py-4'];

        function setScrolled() {
            header.classList.remove(...DEFAULT.filter(Boolean));
            header.classList.add(...SCROLLED.filter(Boolean));
        }

        function setDefault() {
            header.classList.remove(...SCROLLED.filter(Boolean));
            header.classList.add(...DEFAULT.filter(Boolean));
        }

        function onScroll() {
            if (window.scrollY > 20) {
                setScrolled();
                header.classList.add('scrolled-down');
                header.classList.remove('scrolled-up');
            } else {
                setDefault();
                header.classList.remove('scrolled-down');
                header.classList.add('scrolled-up');
            }
        }

        // initial
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    }

    // Mobile menu (dialog) handlers
    const mobileMenuButton = document.querySelector('[command="show-modal"]');
    const mobileMenuDialog = document.getElementById('mobile-menu');
    if (mobileMenuButton && mobileMenuDialog) {
        mobileMenuButton.addEventListener('click', () => {
            try { mobileMenuDialog.showModal(); } catch (e) { mobileMenuDialog.style.display = 'block'; }
        });
    }

    const mobileCloseButtons = document.querySelectorAll('[command="close"]');
    mobileCloseButtons.forEach(btn => btn.addEventListener('click', () => {
        try { mobileMenuDialog.close(); } catch (e) { mobileMenuDialog.style.display = 'none'; }
    }));

    // Category tab logic (if present)
    const buttonOrganik = document.getElementById('buttonOrganik');
    const buttonElektronik = document.getElementById('buttonElektronik');
    const buttonAnorganik = document.getElementById('buttonAnorganik');
    const contentOrganik = document.getElementById('organik');
    const contentElektronik = document.getElementById('elektronik');
    const contentAnorganik = document.getElementById('anorganik');

    const allButtons = [buttonOrganik, buttonElektronik, buttonAnorganik].filter(Boolean);
    const allContents = [contentOrganik, contentElektronik, contentAnorganik].filter(Boolean);

    if (allButtons.length && allContents.length) {
        const ACTIVE_BUTTON_CLASSES = ['bg-amber-400', 'text-green-900', 'shadow-inner'];
        const INACTIVE_BUTTON_CLASSES = ['text-white'];

        function hideAllContent() {
            allContents.forEach(c => c.style.display = 'none');
        }

        function setActiveButton(activeButton) {
            allButtons.forEach(button => {
                button.classList.remove(...ACTIVE_BUTTON_CLASSES);
                button.classList.add(...INACTIVE_BUTTON_CLASSES);
            });
            activeButton.classList.add(...ACTIVE_BUTTON_CLASSES);
            activeButton.classList.remove(...INACTIVE_BUTTON_CLASSES);
        }

        function handleCategoryClick(contentToShow, activeButton) {
            hideAllContent();
            contentToShow.style.display = 'grid';
            setActiveButton(activeButton);
        }

        // initialize
        hideAllContent();
        if (contentOrganik && buttonOrganik) handleCategoryClick(contentOrganik, buttonOrganik);

        if (buttonOrganik) buttonOrganik.addEventListener('click', () => handleCategoryClick(contentOrganik, buttonOrganik));
        if (buttonElektronik) buttonElektronik.addEventListener('click', () => handleCategoryClick(contentElektronik, buttonElektronik));
        if (buttonAnorganik) buttonAnorganik.addEventListener('click', () => handleCategoryClick(contentAnorganik, buttonAnorganik));
    }
});
