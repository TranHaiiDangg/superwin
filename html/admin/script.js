// Đăng nhập
function login() {
    const user = document.getElementById("username").value;
    const pass = document.getElementById("password").value;
    const error = document.getElementById("loginError");
  
    if (user === "admin" && pass === "123456") {
      localStorage.setItem("logged_in", "true");
      window.location.href = "dashboard.html";
    } else {
      error.textContent = "Sai tài khoản hoặc mật khẩu!";
    }
  }
  
  // Kiểm tra đăng nhập và thiết bị ở dashboard
  if (window.location.pathname.includes("dashboard.html")) {
    const isMobile = window.innerWidth < 992;
    const isLogin = localStorage.getItem("logged_in");
  
    if (!isLogin || isMobile) {
      window.location.href = "404.html";
    }
  }

  
  
