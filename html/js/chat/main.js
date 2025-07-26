class ResponsiveChatSystem {
    constructor() {
        this.chatIcon = document.getElementById('chatIcon');
        this.chatPopup = document.getElementById('chatPopup');
        this.mobileChatPage = document.getElementById('mobileChatPage');
        this.popupClose = document.getElementById('popupClose');
        this.mobileBack = document.getElementById('mobileBack');
        
        this.popupInput = document.getElementById('popupInput');
        this.mobileInput = document.getElementById('mobileInput');
        this.popupMessages = document.getElementById('popupMessages');
        this.mobileMessages = document.getElementById('mobileMessages');
        
        this.isTyping = false;
        this.currentMode = null; // 'popup' or 'mobile'
        
        this.init();
    }

    init() {
        // Event listeners
        this.chatIcon.addEventListener('click', () => this.toggleChat());
        this.popupClose.addEventListener('click', () => this.closePopup());
        this.mobileBack.addEventListener('click', () => this.closeMobile());
        
        // Close popup when clicking outside
        document.addEventListener('click', (e) => {
            if (!this.chatPopup.contains(e.target) && !this.chatIcon.contains(e.target)) {
                this.closePopup();
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', () => this.handleResize());
        
        // Initialize welcome messages
        this.initWelcomeMessages();
    }

    toggleChat() {
        const isMobile = window.innerWidth <= 768;
        
        // Hide chat icon with animation
        this.chatIcon.classList.add('hidden');
        
        // Remove notification after first click
        this.chatIcon.classList.remove('has-notification');
        
        if (isMobile) {
            this.openMobile();
        } else {
            this.openPopup();
        }
    }

    openPopup() {
        this.chatPopup.style.display = 'flex';
        this.currentMode = 'popup';
        setTimeout(() => {
            this.popupInput.focus();
        }, 400);
    }

    closePopup() {
        this.chatPopup.style.display = 'none';
        this.currentMode = null;
        
        // Show chat icon again with animation
        setTimeout(() => {
            this.chatIcon.classList.remove('hidden');
        }, 100);
    }

    openMobile() {
        this.mobileChatPage.style.display = 'flex';
        this.mobileChatPage.classList.add('animate-in');
        this.currentMode = 'mobile';
        document.body.style.overflow = 'hidden'; // Prevent background scroll
        
        setTimeout(() => {
            this.mobileInput.focus();
        }, 400);
    }

    closeMobile() {
        this.mobileChatPage.style.display = 'none';
        this.mobileChatPage.classList.remove('animate-in');
        this.currentMode = null;
        document.body.style.overflow = 'auto'; // Restore background scroll
        
        // Show chat icon again with animation
        setTimeout(() => {
            this.chatIcon.classList.remove('hidden');
        }, 100);
    }

    handleResize() {
        const isMobile = window.innerWidth <= 768;
        
        if (isMobile && this.chatPopup.style.display === 'flex') {
            this.closePopup();
            setTimeout(() => {
                this.openMobile();
            }, 200);
        } else if (!isMobile && this.mobileChatPage.style.display === 'flex') {
            this.closeMobile();
            setTimeout(() => {
                this.openPopup();
            }, 200);
        }
    }

    initWelcomeMessages() {
        const welcomeMessage = 'Xin chào! Tôi là trợ lý ảo của bạn. Tôi có thể giúp gì cho bạn hôm nay?';
        
        // Add to popup
        this.addMessage('popup', welcomeMessage, 'bot');
        
        // Add to mobile
        this.addMessage('mobile', welcomeMessage, 'bot');
    }

    // THÊM PHƯƠNG THỨC SENDMESSAGE
    sendMessage(mode, message) {
        if (!message.trim() || this.isTyping) return;
        
        this.addMessage(mode, message, 'user');
        
        // Hide quick replies after first user message
        const quickReplies = mode === 'popup' ? 
            document.getElementById('popupQuickReplies') : 
            document.getElementById('mobileQuickReplies');
        if (quickReplies) {
            quickReplies.style.display = 'none';
        }
        
        // Show typing indicator and simulate response
        this.showTypingIndicator(mode);
        setTimeout(() => {
            this.hideTypingIndicator(mode);
            this.addBotResponse(mode, message);
        }, 1500 + Math.random() * 1000);
    }

    addMessage(mode, message, type) {
        const container = mode === 'popup' ? this.popupMessages : this.mobileMessages;
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${type}`;
        
        const currentTime = new Date().toLocaleTimeString('vi-VN', {
            hour: '2-digit',
            minute: '2-digit'
        });
        
        messageDiv.innerHTML = `
            ${message}
            <div class="message-time">${currentTime}</div>
        `;
        
        container.appendChild(messageDiv);
        this.scrollToBottom(mode);
    }

    scrollToBottom(mode) {
        const container = mode === 'popup' ? this.popupMessages : this.mobileMessages;
        setTimeout(() => {
            container.scrollTop = container.scrollHeight;
        }, 100);
    }

    // THÊM CÁC PHƯƠNG THỨC HỖ TRỢ
    showTypingIndicator(mode) {
        this.isTyping = true;
        const container = mode === 'popup' ? this.popupMessages : this.mobileMessages;
        const typingDiv = document.createElement('div');
        typingDiv.className = 'typing-indicator';
        typingDiv.id = `typingIndicator-${mode}`;
        typingDiv.innerHTML = `
            <div class="typing-dots">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
            <span style="margin-left: 10px; font-size: 0.9rem; color: #666;">Đang nhập...</span>
        `;
        container.appendChild(typingDiv);
        this.scrollToBottom(mode);
    }

    hideTypingIndicator(mode) {
        this.isTyping = false;
        const typingIndicator = document.getElementById(`typingIndicator-${mode}`);
        if (typingIndicator) {
            typingIndicator.remove();
        }
    }

    addBotResponse(mode, userMessage) {
        const responses = [
            "Cảm ơn bạn đã nhắn tin! Tôi đang xử lý yêu cầu của bạn.",
            "Tôi hiểu rồi. Bạn có thể cung cấp thêm thông tin chi tiết không?",
            "Đây là phản hồi tự động. Nhân viên hỗ trợ sẽ liên hệ với bạn sớm nhất có thể.",
            "Rất vui được hỗ trợ bạn! Bạn còn cần giúp gì khác không?",
            "Tôi đã ghi nhận thông tin của bạn. Chúng tôi sẽ phản hồi trong vòng 24 giờ."
        ];
        
        let response;
        if (userMessage.toLowerCase().includes('cảm ơn')) {
            response = "Rất vui được giúp đỡ bạn! Nếu có thêm câu hỏi nào, đừng ngần ngại hỏi nhé.";
        } else if (userMessage.toLowerCase().includes('tạm biệt') || userMessage.toLowerCase().includes('kết thúc')) {
            response = "Cảm ơn bạn đã liên hệ với chúng tôi. Chúc bạn một ngày tốt lành!";
        } else if (userMessage.toLowerCase().includes('hỗ trợ') || userMessage.toLowerCase().includes('giúp')) {
            response = "Tôi sẵn sàng hỗ trợ bạn. Bạn đang gặp vấn đề gì? Hãy mô tả chi tiết để tôi có thể giúp đỡ hiệu quả nhất.";
        } else {
            response = responses[Math.floor(Math.random() * responses.length)];
        }
        
        this.addMessage(mode, response, 'bot');
    }
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', () => {
    window.chatSystem = new ResponsiveChatSystem();
});