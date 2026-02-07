/**
 * POS System JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    initPOS();
});

function initPOS() {
    // Initialize event listeners
    initBarcodeScanner();
    initTableSelection();
    initOrderManagement();
    initFullscreen();
}

/**
 * Initialize Barcode Scanner
 */
function initBarcodeScanner() {
    const barcodeInput = document.getElementById('barcodeInput');
    
    if (!barcodeInput) return;

    barcodeInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const barcode = this.value.trim();
            if (barcode) {
                searchItem(barcode);
                this.value = '';
            }
        }
    });
}

/**
 * Search for item by barcode
 */
function searchItem(barcode) {
    const token = document.querySelector('meta[name="csrf-token"]')?.content;
    
    fetch('/pos/search-item', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ barcode: barcode })
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            showAlert('خطأ: ' + data.error, 'danger');
        } else {
            addItemToOrder(data);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('حدث خطأ في البحث', 'danger');
    });
}

/**
 * Initialize Table Selection
 */
function initTableSelection() {
    const tableButtons = document.querySelectorAll('.table-btn');
    
    tableButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            tableButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const tableId = this.dataset.tableId;
            const tableName = this.dataset.tableName;
            
            console.log('Selected table:', tableId, tableName);
        });
    });
}

/**
 * Initialize Order Management
 */
function initOrderManagement() {
    const discountInput = document.getElementById('discountAmount');
    const saveOrderBtn = document.getElementById('saveOrderBtn');
    
    if (discountInput) {
        discountInput.addEventListener('change', updateNetAmount);
    }
    
    if (saveOrderBtn) {
        saveOrderBtn.addEventListener('click', saveOrder);
    }
}

/**
 * Add item to order
 */
function addItemToOrder(item) {
    // This will be implemented in the main POS view
    console.log('Adding item:', item);
}

/**
 * Update net amount
 */
function updateNetAmount() {
    const totalAmount = parseFloat(document.getElementById('totalAmount')?.textContent || 0);
    const discount = parseFloat(document.getElementById('discountAmount')?.value || 0);
    const net = totalAmount - discount;
    
    const netElement = document.getElementById('netAmount');
    if (netElement) {
        netElement.textContent = net.toFixed(2);
    }
}

/**
 * Save order
 */
function saveOrder() {
    const token = document.querySelector('meta[name="csrf-token"]')?.content;
    
    // Collect order data
    const orderData = {
        table_id: null,
        order_type: 1,
        items: [],
        total: parseFloat(document.getElementById('totalAmount')?.textContent || 0),
        discount: parseFloat(document.getElementById('discountAmount')?.value || 0),
        notes: ''
    };
    
    if (orderData.items.length === 0) {
        showAlert('يجب إضافة صنف واحد على الأقل', 'warning');
        return;
    }
    
    fetch('/pos/save-order', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify(orderData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('تم حفظ الطلب بنجاح', 'success');
            // Reset form
            resetOrder();
        } else {
            showAlert('خطأ: ' + data.error, 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('حدث خطأ في حفظ الطلب', 'danger');
    });
}

/**
 * Reset order
 */
function resetOrder() {
    const itemsList = document.getElementById('itemsList');
    if (itemsList) {
        itemsList.innerHTML = '<p class="text-center text-muted">لا توجد أصناف</p>';
    }
    
    const totalAmount = document.getElementById('totalAmount');
    if (totalAmount) {
        totalAmount.textContent = '0.00';
    }
    
    const discountAmount = document.getElementById('discountAmount');
    if (discountAmount) {
        discountAmount.value = '0';
    }
    
    updateNetAmount();
}

/**
 * Initialize Fullscreen
 */
function initFullscreen() {
    const fullscreenBtn = document.getElementById('fullscreenBtn');
    
    if (!fullscreenBtn) return;
    
    fullscreenBtn.addEventListener('click', function() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen().catch(err => {
                console.error('Error attempting to enable fullscreen:', err);
            });
        } else {
            document.exitFullscreen();
        }
    });
}

/**
 * Show alert message
 */
function showAlert(message, type = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.role = 'alert';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    const container = document.querySelector('.container-fluid');
    if (container) {
        container.insertBefore(alertDiv, container.firstChild);
        
        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
}

/**
 * Format currency
 */
function formatCurrency(value) {
    return parseFloat(value).toFixed(2);
}

/**
 * Format number
 */
function formatNumber(value) {
    return parseFloat(value).toLocaleString('ar-EG');
}
