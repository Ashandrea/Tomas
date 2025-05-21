import './bootstrap';
require('./notifications');

// Set the current user's ID for real-time notifications
window.userId = document.querySelector('meta[name="user-id"]')?.content;
