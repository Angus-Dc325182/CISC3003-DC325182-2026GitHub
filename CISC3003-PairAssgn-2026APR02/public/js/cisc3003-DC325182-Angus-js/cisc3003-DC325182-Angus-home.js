/* =========================================
   CISC3003 Portfolio - Angus Che
   JavaScript Functions
   ========================================= */

document.addEventListener('DOMContentLoaded', function() {
    
    // ===== ELEMENTS =====
    const navbar = document.getElementById('navbar');
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');
    const progressBar = document.getElementById('progressBar');
    const backToTop = document.getElementById('backToTop');
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-menu li');
    
    // ===== 1. MOBILE NAVIGATION =====
    if (navToggle && navMenu) {
        navToggle.addEventListener('click', function() {
            navToggle.classList.toggle('active');
            navMenu.classList.toggle('active');
            document.body.style.overflow = navMenu.classList.contains('active') ? 'hidden' : '';
        });
        
        // Close menu on link click
        document.querySelectorAll('.nav-menu a').forEach(link => {
            link.addEventListener('click', function() {
                navToggle.classList.remove('active');
                navMenu.classList.remove('active');
                document.body.style.overflow = '';
            });
        });
        
        // Close menu on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && navMenu.classList.contains('active')) {
                navToggle.click();
            }
        });
    }
    
    // ===== 2. NAVBAR SCROLL EFFECT =====
    window.addEventListener('scroll', function() {
        // Add scrolled class
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
    
    // ===== 3. PROGRESS BAR =====
    window.addEventListener('scroll', function() {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        progressBar.style.width = scrolled + '%';
    });
    
    // ===== 4. ACTIVE NAV HIGHLIGHTING =====
    function highlightNavLink() {
        const scrollY = window.pageYOffset;
        
        sections.forEach(section => {
            const sectionHeight = section.offsetHeight;
            const sectionTop = section.offsetTop - 150;
            const sectionId = section.getAttribute('id');
            
            const navLink = document.querySelector(`.nav-menu a[href="#${sectionId}"]`);
            
            if (navLink) {
                if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
                    navLinks.forEach(li => li.classList.remove('active'));
                    navLink.parentElement.classList.add('active');
                }
            }
        });
    }
    
    window.addEventListener('scroll', highlightNavLink);
    
    // ===== 5. SMOOTH SCROLL =====
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            
            if (targetId === '#') return;
            
            const target = document.querySelector(targetId);
            
            if (target) {
                const headerOffset = 80;
                const elementPosition = target.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // ===== 6. BACK TO TOP =====
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 500) {
            backToTop.classList.add('visible');
        } else {
            backToTop.classList.remove('visible');
        }
    });
    
    backToTop.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    // ===== 7. SCROLL REVEAL ANIMATION =====
    const revealElements = document.querySelectorAll(
        '.skill-card, .interest-card, .project-card, .info-item, ' +
        '.timeline-item, .learning-card, .accomplish-card, .blog-card, ' +
        '.goal-card, .reflection-card, .award-card, .lang-card, .gallery-item, .photo-item'
    );
    
    function revealOnScroll() {
        const windowHeight = window.innerHeight;
        const revealPoint = 100;
        
        revealElements.forEach((element, index) => {
            const elementTop = element.getBoundingClientRect().top;
            
            if (elementTop < windowHeight - revealPoint && !element.classList.contains('revealed')) {
                setTimeout(() => {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                    element.classList.add('revealed');
                }, index * 30);
            }
        });
    }
    
    // Set initial state
    revealElements.forEach(element => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(30px)';
        element.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    });
    
    // Trigger
    revealOnScroll();
    window.addEventListener('scroll', revealOnScroll);
    
    // ===== 8. HERO ROLES ANIMATION =====
    const roles = document.querySelectorAll('.role');
    
    roles.forEach((role, index) => {
        role.style.opacity = '0';
        role.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            role.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            role.style.opacity = '1';
            role.style.transform = 'translateY(0)';
        }, 500 + (index * 200));
    });
    
    // ===== 9. CONTACT FORM =====
    const contactForm = document.getElementById('contactForm');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = this.querySelector('input[name="name"]').value.trim();
            const email = this.querySelector('input[name="email"]').value.trim();
            const message = this.querySelector('textarea[name="message"]').value.trim();
            
            // Validation
            if (!name || !email || !message) {
                showNotification('Please fill in all fields!', 'error');
                return;
            }
            
            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showNotification('Please enter a valid email address!', 'error');
                return;
            }
            
            // Success
            showNotification(`Thank you, ${name}! Your message has been sent successfully.`, 'success');
            contactForm.reset();
        });
    }
    
    // ===== 10. NOTIFICATION SYSTEM =====
    function showNotification(message, type = 'success') {
        // Remove existing notification
        const existing = document.querySelector('.notification');
        if (existing) existing.remove();
        
        // Create notification
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <i class="bx ${type === 'success' ? 'bx-check-circle' : 'bx-error-circle'}"></i>
            <span>${message}</span>
        `;
        
        // Style
        notification.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            background: ${type === 'success' ? 'var(--primary)' : '#ff4757'};
            color: ${type === 'success' ? 'var(--bg-dark)' : '#ffffff'};
            padding: 1rem 1.5rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-weight: 600;
            font-size: 0.95rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            z-index: 10000;
            animation: slideIn 0.3s ease;
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    // Add animation keyframes
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(400px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(400px); opacity: 0; }
        }
    `;
    document.head.appendChild(style);
    
    // ===== 11. SKILL CARD HOVER EFFECT =====
    const skillCards = document.querySelectorAll('.skill-card');
    
    skillCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            const items = this.querySelectorAll('.skill-list li');
            items.forEach((item, index) => {
                setTimeout(() => {
                    item.style.transform = 'translateX(5px)';
                    item.style.color = 'var(--primary)';
                }, index * 50);
            });
        });
        
        card.addEventListener('mouseleave', function() {
            const items = this.querySelectorAll('.skill-list li');
            items.forEach(item => {
                item.style.transform = 'translateX(0)';
                item.style.color = '';
            });
        });
    });
    
    // ===== 12. COPY EMAIL =====
    const emailLinks = document.querySelectorAll('a[href^="mailto:"]');
    
    emailLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Don't prevent default - allow mailto to work
            const email = this.href.replace('mailto:', '');
            
            // Also copy to clipboard
            navigator.clipboard.writeText(email).then(() => {
                showNotification(`Email copied: ${email}`, 'success');
            }).catch(() => {
                // Clipboard failed, mailto will still work
            });
        });
    });
    
    // ===== 13. GALLERY LIGHTBOX (Simple) =====
    const galleryItems = document.querySelectorAll('.gallery-item img, .photo-item img');
    
    galleryItems.forEach(img => {
        img.style.cursor = 'pointer';
        
        img.addEventListener('click', function() {
            const overlay = document.createElement('div');
            overlay.style.cssText = `
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.9);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 10000;
                cursor: pointer;
                animation: fadeIn 0.3s ease;
            `;
            
            const largeImg = document.createElement('img');
            largeImg.src = this.src;
            largeImg.style.cssText = `
                max-width: 90%;
                max-height: 90%;
                border-radius: 12px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            `;
            
            overlay.appendChild(largeImg);
            document.body.appendChild(overlay);
            document.body.style.overflow = 'hidden';
            
            overlay.addEventListener('click', function() {
                this.style.animation = 'fadeOut 0.3s ease';
                setTimeout(() => {
                    this.remove();
                    document.body.style.overflow = '';
                }, 300);
            });
        });
    });
    
    // Add fade keyframes
    const fadeStyle = document.createElement('style');
    fadeStyle.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    `;
    document.head.appendChild(fadeStyle);
    
    // ===== CONSOLE MESSAGE =====
    console.log('%c🎓 Angus Che\'s Portfolio', 'color: #00d4ff; font-size: 20px; font-weight: bold;');
    console.log('%cCISC3003 Web Programming - University of Macau', 'color: #a855f7; font-size: 12px;');
    
});