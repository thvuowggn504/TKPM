const registerButton = document.getElementById("register");
const loginButton = document.getElementById("login");
const container = document.getElementById("container");

registerButton.addEventListener("click", () => {
    container.classList.add("right-panel-active");
});

loginButton.addEventListener("click", () => {
    container.classList.remove("right-panel-active")
})

//Xử lý login và register
document.addEventListener("DOMContentLoaded", () => {
    const registerForm = document.querySelector(".register-container form");
    const loginForm = document.querySelector(".login-container form");

    // Xử lý đăng ký
    registerForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const name = registerForm.querySelector("input[type='text']").value;
        const email = registerForm.querySelector("input[type='email']").value;
        const password = registerForm.querySelector("input[type='password']").value;

        if (!name || !email || !password) {
            alert("Vui lòng nhập đầy đủ thông tin!");
            return;
        }

        // Lưu vào LocalStorage
        localStorage.setItem("user", JSON.stringify({ name, email, password }));
        alert("Đăng ký thành công! Vui lòng đăng nhập.");
    });

    // Xử lý đăng nhập
    loginForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const email = loginForm.querySelector("input[type='email']").value;
        const password = loginForm.querySelector("input[type='password']").value;

        const savedUser = JSON.parse(localStorage.getItem("user"));

        if (!savedUser || savedUser.email !== email || savedUser.password !== password) {
            alert("Sai email hoặc mật khẩu!");
            return;
        }

        alert(`Xin chào, ${savedUser.name}! Đăng nhập thành công.`);

        // Chuyển hướng đến index.html
        window.location.href = "home.html";
    });
});
