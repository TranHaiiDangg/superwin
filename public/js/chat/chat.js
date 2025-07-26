// Global functions for UI interactions
function sendPopupMessage() {
    const message = document.getElementById('popupInput').value;
    if (window.chatSystem && message.trim()) {
        window.chatSystem.sendMessage('popup', message);
        document.getElementById('popupInput').value = '';
    }
}

function sendMobileMessage() {
    const message = document.getElementById('mobileInput').value;
    if (window.chatSystem && message.trim()) {
        window.chatSystem.sendMessage('mobile', message);
        document.getElementById('mobileInput').value = '';
    }
}

function sendQuickReply(mode, message) {
    if (window.chatSystem) {
        window.chatSystem.sendMessage(mode, message);
    }
}

function handlePopupKeyPress(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        sendPopupMessage();
    }
}

function handleMobileKeyPress(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        sendMobileMessage();
    }
}

function showMobileMenu() {
    const choice = confirm('Bạn có muốn kết thúc cuộc trò chuyện không?');
    
    if (choice && window.chatSystem) {
        window.chatSystem.addMessage('mobile', 'Cuộc trò chuyện đã kết thúc. Cảm ơn bạn đã sử dụng dịch vụ!', 'bot');
        setTimeout(() => {
            window.chatSystem.closeMobile();
        }, 2000);
    }
}

// Handle back button on mobile
window.addEventListener('popstate', (event) => {
    if (window.chatSystem && window.chatSystem.currentMode === 'mobile') {
        event.preventDefault();
        window.chatSystem.closeMobile();
    }
});

// Prevent zoom on input focus (iOS)
document.addEventListener('touchstart', function(e) {
    if (e.target.tagName === 'INPUT') {
        e.target.style.fontSize = '16px';
    }
});