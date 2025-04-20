// Sample data for recent orders
const recentOrders = [
    {
        id: "1",
        customer: "John Doe",
        items: 3,
        total: 1880.00,
        status: "pending"
    },
    {
        id: "2",
        customer: "Jane Smith",
        items: 2,
        total: 2800.00,
        status: "preparing"
    },
    {
        id: "3",
        customer: "Mike Johnson",
        items: 4,
        total: 470.00,
        status: "completed"
    }
];

// Sample data for popular items
const popularItems = [
    {
        name: "Fish Pattis",
        category: "Short Eats",
        price: 120.00,
        orders: 420,
        revenue: 584.55
    },
    {
        name: "Margherita Pizza",
        category: "Pizzas",
        price: 2599.00,
        orders: 67,
        revenue: 569.62
    },
    {
        name: "Chocolate Cake",
        category: "Desserts",
        price: 340.00,
        orders: 500,
        revenue: 223.68
    }
];

// Function to get status badge HTML
function getStatusBadge(status) {
    const statusClasses = {
        pending: 'status-pending',
        preparing: 'status-preparing',
        delivering: 'status-delivering',
        completed: 'status-completed',
        cancelled: 'status-cancelled'
    };
    
    return `<span class="status-badge ${statusClasses[status]}">${status.charAt(0).toUpperCase() + status.slice(1)}</span>`;
}

// Load recent orders
function loadRecentOrders() {
    const ordersContainer = $('#recent-orders');
    ordersContainer.empty();
    
    recentOrders.forEach(order => {
        const row = $(`
            <tr>
                <td>${order.id}</td>
                <td>${order.customer}</td>
                <td>${order.items} items</td>
                <td>$${order.total.toFixed(2)}</td>
                <td>${getStatusBadge(order.status)}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary btn-icon" onclick="viewOrder('${order.id}')">
                        <i class="fas fa-eye"></i>
                    </button>
                </td>
            </tr>
        `);
        
        ordersContainer.append(row);
    });
}

// Load popular items
function loadPopularItems() {
    const itemsContainer = $('#popular-items');
    itemsContainer.empty();
    
    popularItems.forEach(item => {
        const row = $(`
            <tr>
                <td>${item.name}</td>
                <td>${item.category}</td>
                <td>$${item.price.toFixed(2)}</td>
                <td>${item.orders}</td>
                <td>$${item.revenue.toFixed(2)}</td>
            </tr>
        `);
        
        itemsContainer.append(row);
    });
}

// View order details
function viewOrder(orderId) {
    // Implement order viewing functionality
    console.log(`Viewing order ${orderId}`);
}

// Initialize dashboard
$(document).ready(function() {
    loadRecentOrders();
    loadPopularItems();
});