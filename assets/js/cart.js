/**
 * Shopping Cart JavaScript
 * Kiihabwemi Development Company Ltd
 * Handles cart operations with localStorage
 */

// Cart class
class ShoppingCart {
    constructor() {
        this.cartKey = 'kdc_cart';
        this.init();
    }
    
    init() {
        this.loadCart();
        this.updateCartUI();
        this.attachEventListeners();
    }
    
    // Load cart from localStorage
    loadCart() {
        const cartData = localStorage.getItem(this.cartKey);
        this.items = cartData ? JSON.parse(cartData) : [];
    }
    
    // Save cart to localStorage
    saveCart() {
        localStorage.setItem(this.cartKey, JSON.stringify(this.items));
        this.updateCartUI();
    }
    
    // Add item to cart
    addItem(id, name, price, image, quantity = 1) {
        const existingItem = this.items.find(item => item.id === id);
        
        if (existingItem) {
            existingItem.quantity += quantity;
        } else {
            this.items.push({
                id: id,
                name: name,
                price: parseFloat(price),
                image: image,
                quantity: quantity
            });
        }
        
        this.saveCart();
        this.showNotification('Product added to cart!', 'success');
    }
    
    // Remove item from cart
    removeItem(id) {
        this.items = this.items.filter(item => item.id !== id);
        this.saveCart();
        this.showNotification('Product removed from cart', 'info');
    }
    
    // Update item quantity
    updateQuantity(id, quantity) {
        const item = this.items.find(item => item.id === id);
        if (item) {
            item.quantity = parseInt(quantity);
            if (item.quantity <= 0) {
                this.removeItem(id);
            } else {
                this.saveCart();
            }
        }
    }
    
    // Clear entire cart
    clearCart() {
        if (confirm('Are you sure you want to clear your cart?')) {
            this.items = [];
            this.saveCart();
            this.showNotification('Cart cleared', 'info');
        }
    }
    
    // Get cart total
    getTotal() {
        return this.items.reduce((total, item) => total + (item.price * item.quantity), 0);
    }
    
    // Get cart item count
    getItemCount() {
        return this.items.reduce((count, item) => count + item.quantity, 0);
    }
    
    // Update cart UI elements
    updateCartUI() {
        // Update cart count badge
        const cartCountElements = document.querySelectorAll('#cartCount, .cart-count');
        cartCountElements.forEach(element => {
            element.textContent = this.getItemCount();
            element.style.display = this.getItemCount() > 0 ? 'inline-block' : 'none';
        });
        
        // Update cart page if we're on it
        if (document.getElementById('cartTableBody')) {
            this.renderCartPage();
        }
    }
    
    // Render cart page
    renderCartPage() {
        const cartTableBody = document.getElementById('cartTableBody');
        const emptyCartMessage = document.getElementById('emptyCartMessage');
        const cartItemsContainer = document.getElementById('cartItemsContainer');
        const continueShoppingBtn = document.getElementById('continueShoppingBtn');
        const checkoutBtn = document.getElementById('checkoutBtn');
        const clearCartBtn = document.getElementById('clearCartBtn');
        
        if (this.items.length === 0) {
            emptyCartMessage.style.display = 'block';
            cartItemsContainer.style.display = 'none';
            continueShoppingBtn.style.display = 'none';
            checkoutBtn.disabled = true;
            clearCartBtn.disabled = true;
        } else {
            emptyCartMessage.style.display = 'none';
            cartItemsContainer.style.display = 'block';
            continueShoppingBtn.style.display = 'block';
            checkoutBtn.disabled = false;
            clearCartBtn.disabled = false;
            
            // Render cart items
            cartTableBody.innerHTML = this.items.map(item => `
                <tr class="border-bottom">
                    <td class="ps-4 py-3">
                        <div class="d-flex align-items-center">
                            <img src="${window.location.origin}/coffee_farm/assets/images/products/${item.image}" 
                                 alt="${item.name}" 
                                 class="rounded me-3" 
                                 style="width: 80px; height: 80px; object-fit: cover;">
                            <div>
                                <h6 class="mb-0 fw-bold">${item.name}</h6>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="fw-bold">UGX ${this.formatNumber(item.price)}</span>
                    </td>
                    <td>
                        <div class="input-group" style="width: 120px;">
                            <button class="btn btn-sm btn-outline-secondary decrease-qty" data-id="${item.id}">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" 
                                   class="form-control form-control-sm text-center cart-quantity" 
                                   value="${item.quantity}" 
                                   min="1" 
                                   data-id="${item.id}">
                            <button class="btn btn-sm btn-outline-secondary increase-qty" data-id="${item.id}">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </td>
                    <td>
                        <span class="fw-bold text-coffee">UGX ${this.formatNumber(item.price * item.quantity)}</span>
                    </td>
                    <td class="pe-4">
                        <button class="btn btn-sm btn-outline-danger remove-item" data-id="${item.id}" title="Remove item">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            `).join('');
            
            // Attach quantity change events
            this.attachQuantityEvents();
        }
        
        // Update summary
        this.updateSummary();
    }
    
    // Update cart summary
    updateSummary() {
        const subtotal = this.getTotal();
        const itemCount = this.getItemCount();
        
        document.getElementById('cartSubtotal').textContent = 'UGX ' + this.formatNumber(subtotal);
        document.getElementById('cartItemCount').textContent = itemCount;
        document.getElementById('cartTotal').textContent = 'UGX ' + this.formatNumber(subtotal);
    }
    
    // Attach quantity change events
    attachQuantityEvents() {
        // Increase quantity
        document.querySelectorAll('.increase-qty').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const id = e.currentTarget.dataset.id;
                const input = document.querySelector(`.cart-quantity[data-id="${id}"]`);
                input.value = parseInt(input.value) + 1;
                this.updateQuantity(id, input.value);
            });
        });
        
        // Decrease quantity
        document.querySelectorAll('.decrease-qty').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const id = e.currentTarget.dataset.id;
                const input = document.querySelector(`.cart-quantity[data-id="${id}"]`);
                if (parseInt(input.value) > 1) {
                    input.value = parseInt(input.value) - 1;
                    this.updateQuantity(id, input.value);
                }
            });
        });
        
        // Direct quantity input
        document.querySelectorAll('.cart-quantity').forEach(input => {
            input.addEventListener('change', (e) => {
                const id = e.target.dataset.id;
                this.updateQuantity(id, e.target.value);
            });
        });
        
        // Remove item
        document.querySelectorAll('.remove-item').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const id = e.currentTarget.dataset.id;
                this.removeItem(id);
            });
        });
    }
    
    // Attach event listeners
    attachEventListeners() {
        // Add to cart buttons
        document.querySelectorAll('.add-to-cart').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const id = e.currentTarget.dataset.id;
                const name = e.currentTarget.dataset.name;
                const price = e.currentTarget.dataset.price;
                const image = e.currentTarget.dataset.image;
                const quantity = e.currentTarget.dataset.quantity || 1;
                
                this.addItem(id, name, price, image, parseInt(quantity));
            });
        });
        
        // Clear cart button
        const clearCartBtn = document.getElementById('clearCartBtn');
        if (clearCartBtn) {
            clearCartBtn.addEventListener('click', () => this.clearCart());
        }
        
        // Checkout button
        const checkoutBtn = document.getElementById('checkoutBtn');
        if (checkoutBtn) {
            checkoutBtn.addEventListener('click', () => this.checkout());
        }
    }
    
    // Checkout via WhatsApp
    checkout() {
        if (this.items.length === 0) {
            alert('Your cart is empty!');
            return;
        }
        
        // Generate WhatsApp message
        let message = 'Hello KDC! I want to order:%0A%0A';
        
        this.items.forEach(item => {
            message += `- ${encodeURIComponent(item.name)} x${item.quantity} (UGX ${this.formatNumber(item.price * item.quantity)})%0A`;
        });
        
        message += `%0ATotal: UGX ${this.formatNumber(this.getTotal())}`;
        message += '%0A%0APlease confirm my order. Thank you!';
        
        // Get WhatsApp number from config (passed via data attribute or window object)
        const whatsappNumber = window.WHATSAPP_NUMBER || '256779767250';
        const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${message}`;
        
        window.open(whatsappUrl, '_blank');
    }
    
    // Format number with commas
    formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }
    
    // Show notification
    showNotification(message, type = 'success') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} position-fixed top-0 end-0 m-3 shadow`;
        notification.style.zIndex = '9999';
        notification.style.minWidth = '300px';
        notification.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
}

// Initialize cart when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.cart = new ShoppingCart();
});
