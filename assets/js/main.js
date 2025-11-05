/**
 * Main JavaScript File
 * Kiihabwemi Development Company Ltd
 */

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize all components
    initBackToTop();
    initSmoothScroll();
    initNavbarScroll();
    initLazyLoading();
    initFormValidation();
    
});

/**
 * Back to Top Button
 */
function initBackToTop() {
    const backToTopBtn = document.getElementById('backToTop');
    
    if (backToTopBtn) {
        // Show/hide button based on scroll position
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopBtn.style.display = 'block';
            } else {
                backToTopBtn.style.display = 'none';
            }
        });
        
        // Scroll to top when clicked
        backToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
}

/**
 * Smooth Scrolling for Anchor Links
 */
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            // Only apply smooth scroll if it's not just "#"
            if (href !== '#' && href !== '') {
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
}

/**
 * Navbar Behavior on Scroll
 */
function initNavbarScroll() {
    const navbar = document.querySelector('.navbar');
    let lastScroll = 0;
    
    if (navbar) {
        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;
            
            // Add shadow when scrolled
            if (currentScroll > 50) {
                navbar.classList.add('shadow');
            } else {
                navbar.classList.remove('shadow');
            }
            
            lastScroll = currentScroll;
        });
    }
}

/**
 * Lazy Loading for Images
 */
function initLazyLoading() {
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        observer.unobserve(img);
                    }
                }
            });
        });
        
        // Observe all images with data-src attribute
        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
}

/**
 * Form Validation Enhancement
 */
function initFormValidation() {
    const forms = document.querySelectorAll('.needs-validation');
    
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
    
    // Real-time email validation
    const emailInputs = document.querySelectorAll('input[type="email"]');
    emailInputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateEmail(this);
        });
    });
    
    // Real-time phone validation
    const phoneInputs = document.querySelectorAll('input[type="tel"]');
    phoneInputs.forEach(input => {
        input.addEventListener('blur', function() {
            validatePhone(this);
        });
    });
}

/**
 * Email Validation
 */
function validateEmail(input) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const value = input.value.trim();
    
    if (value && !emailRegex.test(value)) {
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
        showFieldError(input, 'Please enter a valid email address');
    } else if (value) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        hideFieldError(input);
    }
}

/**
 * Phone Validation
 */
function validatePhone(input) {
    const phoneRegex = /^[\d\s\-\+\(\)]+$/;
    const value = input.value.trim();
    
    if (value && !phoneRegex.test(value)) {
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
        showFieldError(input, 'Please enter a valid phone number');
    } else if (value) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        hideFieldError(input);
    }
}

/**
 * Show Field Error
 */
function showFieldError(input, message) {
    let errorDiv = input.nextElementSibling;
    if (!errorDiv || !errorDiv.classList.contains('invalid-feedback')) {
        errorDiv = document.createElement('div');
        errorDiv.classList.add('invalid-feedback');
        input.parentNode.insertBefore(errorDiv, input.nextSibling);
    }
    errorDiv.textContent = message;
}

/**
 * Hide Field Error
 */
function hideFieldError(input) {
    const errorDiv = input.nextElementSibling;
    if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
        errorDiv.textContent = '';
    }
}

/**
 * Show Toast Notification
 */
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} position-fixed top-0 end-0 m-3 shadow fade-in`;
    toast.style.zIndex = '9999';
    toast.style.minWidth = '300px';
    toast.innerHTML = `
        <div class="d-flex align-items-center justify-content-between">
            <span><i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>${message}</span>
            <button type="button" class="btn-close btn-close-white ms-3" onclick="this.parentElement.parentElement.remove()"></button>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 5000);
}

/**
 * Confirm Dialog
 */
function confirmAction(message, callback) {
    if (confirm(message)) {
        callback();
    }
}

/**
 * Format Currency
 */
function formatCurrency(amount) {
    return 'UGX ' + parseFloat(amount).toLocaleString('en-UG', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    });
}

/**
 * Debounce Function
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Copy to Clipboard
 */
function copyToClipboard(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
            showToast('Copied to clipboard!', 'success');
        }).catch(err => {
            console.error('Failed to copy:', err);
            showToast('Failed to copy to clipboard', 'danger');
        });
    } else {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.left = '-999999px';
        document.body.appendChild(textArea);
        textArea.select();
        try {
            document.execCommand('copy');
            showToast('Copied to clipboard!', 'success');
        } catch (err) {
            console.error('Failed to copy:', err);
            showToast('Failed to copy to clipboard', 'danger');
        }
        document.body.removeChild(textArea);
    }
}

/**
 * Get URL Parameter
 */
function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    const regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    const results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

/**
 * Local Storage Helper
 */
const Storage = {
    set: function(key, value) {
        try {
            localStorage.setItem(key, JSON.stringify(value));
            return true;
        } catch (e) {
            console.error('Error saving to localStorage:', e);
            return false;
        }
    },
    
    get: function(key) {
        try {
            const item = localStorage.getItem(key);
            return item ? JSON.parse(item) : null;
        } catch (e) {
            console.error('Error reading from localStorage:', e);
            return null;
        }
    },
    
    remove: function(key) {
        try {
            localStorage.removeItem(key);
            return true;
        } catch (e) {
            console.error('Error removing from localStorage:', e);
            return false;
        }
    },
    
    clear: function() {
        try {
            localStorage.clear();
            return true;
        } catch (e) {
            console.error('Error clearing localStorage:', e);
            return false;
        }
    }
};

/**
 * Image Preloader
 */
function preloadImages(urls) {
    urls.forEach(url => {
        const img = new Image();
        img.src = url;
    });
}

/**
 * Scroll to Element
 */
function scrollToElement(element, offset = 0) {
    const elementPosition = element.getBoundingClientRect().top + window.pageYOffset;
    const offsetPosition = elementPosition - offset;
    
    window.scrollTo({
        top: offsetPosition,
        behavior: 'smooth'
    });
}

/**
 * Check if Element is in Viewport
 */
function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

/**
 * Handle Search/Filter
 */
function filterItems(searchTerm, items, searchProperty) {
    searchTerm = searchTerm.toLowerCase().trim();
    
    items.forEach(item => {
        const text = item.dataset[searchProperty] || item.textContent;
        if (text.toLowerCase().includes(searchTerm)) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
}

/**
 * Toggle Password Visibility
 */
function togglePasswordVisibility(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (input && icon) {
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
}

/**
 * Format Date
 */
function formatDate(date, format = 'long') {
    const d = new Date(date);
    const options = format === 'long' 
        ? { year: 'numeric', month: 'long', day: 'numeric' }
        : { year: 'numeric', month: '2-digit', day: '2-digit' };
    
    return d.toLocaleDateString('en-UG', options);
}

/**
 * Truncate Text
 */
function truncateText(text, maxLength, suffix = '...') {
    if (text.length <= maxLength) return text;
    return text.substring(0, maxLength).trim() + suffix;
}

// Export functions for use in other files
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        showToast,
        confirmAction,
        formatCurrency,
        debounce,
        copyToClipboard,
        getUrlParameter,
        Storage,
        preloadImages,
        scrollToElement,
        isInViewport,
        filterItems,
        togglePasswordVisibility,
        formatDate,
        truncateText
    };
}
