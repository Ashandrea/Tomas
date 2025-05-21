import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});

// Listen for order status changes
window.Echo.private(`App.Models.User.${window.userId}`)
    .notification((notification) => {
        if (notification.type === 'App\\Notifications\\OrderStatusNotification') {
            const orderElement = document.querySelector(`[data-order-id="${notification.order_id}"]`);
            if (orderElement) {
                // Update the order status in the UI
                const statusElement = orderElement.querySelector('.order-status');
                if (statusElement) {
                    statusElement.textContent = notification.new_status;
                    statusElement.className = `order-status ${notification.new_status}`;
                }
            }
        }
    });

function showNotification(message) {
    // Check if the browser supports notifications
    if (!("Notification" in window)) {
        console.log("This browser does not support desktop notification");
        return;
    }

    // Check if permission is already granted
    if (Notification.permission === "granted") {
        createNotification(message);
    }
    // Otherwise, ask for permission
    else if (Notification.permission !== "denied") {
        Notification.requestPermission().then(function (permission) {
            if (permission === "granted") {
                createNotification(message);
            }
        });
    }
}

function createNotification(message) {
    new Notification("Order Update", {
        body: message,
        icon: "/images/logo.png"
    });
}

function updateOrderStatus(element, newStatus) {
    const statusElement = element.querySelector('.order-status');
    if (statusElement) {
        statusElement.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
        statusElement.className = `order-status status-${newStatus}`;
    }
} 