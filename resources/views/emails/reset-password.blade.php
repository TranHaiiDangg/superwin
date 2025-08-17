<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu - SuperWin</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header img {
            height: 60px;
            margin-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        .message {
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 30px;
            color: #555;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            text-align: center;
            transition: all 0.3s ease;
        }
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            color: #856404;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
        .footer a {
            color: #667eea;
            text-decoration: none;
        }
        .expiry {
            background-color: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            color: #1565c0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('image/logo.png') }}" alt="SuperWin Logo">
            <h1>Đặt lại mật khẩu</h1>
        </div>

        <div class="content">
            <div class="greeting">
                Xin chào {{ $user->name ?? 'Quý khách' }}!
            </div>

            <div class="message">
                Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản SuperWin của bạn.
                Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email này.
            </div>

            <div style="text-align: center;">
                <a href="{{ $url }}" class="button">
                    Đặt lại mật khẩu
                </a>
            </div>

            <div class="expiry">
                <strong>⚠️ Lưu ý:</strong> Link này sẽ hết hạn sau 60 phút vì lý do bảo mật.
            </div>

            <div class="warning">
                <strong>🔒 Bảo mật:</strong>
                Không chia sẻ link này với bất kỳ ai. Link chỉ dành riêng cho bạn và sẽ không hoạt động nếu được sử dụng bởi người khác.
            </div>

            <div class="message">
                Nếu nút trên không hoạt động, bạn có thể copy và paste link sau vào trình duyệt:
                <br><br>
                <a href="{{ $url }}" style="color: #667eea; word-break: break-all;">{{ $url }}</a>
            </div>
        </div>

        <div class="footer">
            <p>
                Email này được gửi từ hệ thống SuperWin.<br>
                Nếu bạn có thắc mắc, vui lòng liên hệ:
                <a href="mailto:support@superwin.com">support@superwin.com</a>
            </p>
            <p>
                © {{ date('Y') }} SuperWin. Tất cả quyền được bảo lưu.
            </p>
        </div>
    </div>
</body>
</html>
