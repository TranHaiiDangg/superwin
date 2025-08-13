<footer class="footer" style="margin: 10px auto">
    <div class="footer-container">
        <div class="footer-column">
            <h3>Hỗ trợ khách hàng</h3>
            <ul>
                <li><span class="hotline">Hotline: 028.6269.7382</span></li>
                <li>(08-17h từ T2-T7)</li>
                <li><a href="#">Các câu hỏi thường gặp</a></li>
                <li><a href="#">Gửi yêu cầu hỗ trợ</a></li>
                <li><a href="#">Hướng dẫn đặt hàng</a></li>
                <li><a href="#">Phương thức vận chuyển</a></li>
                <li><a href="#">Chính sách đổi trả</a></li>
            </ul>
        </div>

        <div class="footer-column">
            <h3>Về SuperWin.vn</h3>
            <ul>
                <li><a href="#">Giới thiệu SuperWin.vn</a></li>
                <li><a href="#">Tuyển dụng</a></li>
                <li><a href="#">Chính sách bảo mật</a></li>
                <li><a href="#">Điều khoản sử dụng</a></li>
                <li><a href="#">Liên hệ</a></li>
            </ul>
        </div>

        <div class="footer-column newsletter-section">
            <h3>Cập nhật thông tin khuyến mãi</h3>
            <div id="phone-error" style="color:red; font-size:0.9em; display:none; margin-bottom:4px; margin-left:10px;"></div>
            <form class="newsletter-form" onsubmit="return validatePhoneNumber(event)">
                <input type="tel" id="newsletter-phone" placeholder="Số điện thoại của bạn">
                <button type="submit">Đăng ký</button>
            </form>
            <script>
                function validatePhoneNumber(event) {
                    var phoneInput = document.getElementById('newsletter-phone');
                    var errorDiv = document.getElementById('phone-error');
                    var phone = phoneInput.value.trim();
                    // Chấp nhận số bắt đầu bằng 0 hoặc +84, theo sau là 9-10 số
                    var phoneRegex = /^(0\d{9,10}|\+84\d{9,10})$/;
                    if (!phoneRegex.test(phone)) {
                        errorDiv.textContent = 'Vui lòng nhập số điện thoại hợp lệ';
                        errorDiv.style.display = 'block';
                        event.preventDefault();
                        return false;
                    } else {
                        errorDiv.style.display = 'none';
                        var now = new Date();
                        var day = now.getDay(); // 0: Chủ nhật, 1: Thứ 2, ..., 6: Thứ 7
                        var hour = now.getHours();
                        if (day >= 1 && day <= 6 && hour >= 8 && hour < 17) {
                            alert('Đã nhận thông tin! Nhân viên tư vấn sẽ gọi cho bạn trong vòng ít phút tới.');
                            window.location.href = '/';
                        } else {
                            alert('Cảm ơn bạn! Chúng tôi sẽ liên hệ lại trong giờ làm việc tiếp theo.');
                            window.location.href = '/';
                        }
                    }
                }
            </script>
            <div class="footer-logo-row" style="display: flex; align-items: center; justify-content: space-between; margin-top: 12px; gap: 20px;">
                <div style="font-size: 13px;">
                    <div><strong>Địa chỉ:</strong> Lô C2-2, Đường VL3, Khu Công Nghiệp Vĩnh Lộc 2, Quốc Lộ 1, Xã Long Hiệp, Huyện Bến Lức, Tỉnh Long An, VN</div>
                    <div><strong>Mã số doanh nghiệp:</strong> 1102 046 767</div>
                </div>
                <a href="#">
                    <img src="/image/logoSaleNoti.png" alt="Bộ Công Thương" style="max-width: 130px; height: auto;">
                </a>
            </div>

        </div>
    </div>
</footer>

<style>
    .footer {
    width: 100%;
    max-width: 1280px;
    margin: 20px auto 0;
    background: #4facfe;
    color: white;
    padding: 30px 20px 20px;
}

.footer-container {
    display: grid;
    grid-template-columns: 1fr 1fr 1.2fr;
    gap: 40px;
    max-width: 1200px;
    margin: 0 auto;
}

.footer-column h3 {
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 15px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
</style>
