const registerButton = document.getElementById("register");
const loginButton = document.getElementById("login");
const container = document.getElementById("container");

registerButton.addEventListener("click", () => {
    container.classList.add("right-panel-active");
});

loginButton.addEventListener("click", () => {
    container.classList.remove("right-panel-active");
});

document.addEventListener("DOMContentLoaded", () => {
    const registerForm = document.querySelector(".register-container form");
    const loginForm = document.querySelector(".login-container form");

    registerForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const name = registerForm.querySelector("input[type='text']").value;
        const email = registerForm.querySelector("input[type='email']").value;
        const password = registerForm.querySelector("input[type='password']").value;

        if (!name || !email || !password) {
            alert("Vui lòng nhập đầy đủ thông tin!");
            return;
        }

        let users = JSON.parse(localStorage.getItem("users")) || [];
        if (users.some(user => user.email === email)) {
            alert("Email đã được sử dụng!");
            return;
        }

        users.push({ name, email, password });
        localStorage.setItem("users", JSON.stringify(users));
        alert("Đăng ký thành công! Vui lòng đăng nhập.");
    });

    loginForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const email = loginForm.querySelector("input[type='email']").value;
        const password = loginForm.querySelector("input[type='password']").value;

        console.log("Email:", email, "Password:", password);
        const users = JSON.parse(localStorage.getItem("users")) || [];
        console.log("Users in localStorage:", users);
        const savedUser = users.find(user => user.email === email && user.password === password);
        console.log("savedUser:", savedUser);

        if (!savedUser) {
            alert("Sai email hoặc mật khẩu!");
            return;
        }

        localStorage.setItem("currentUser", JSON.stringify({ name: savedUser.name, email: savedUser.email }));
        alert(`Xin chào, ${savedUser.name}! Đăng nhập thành công.`);

        // Trì hoãn chuyển hướng
        setTimeout(() => {
            window.location.replace("home1.php");
            console.log("Redirecting to home1.php");
        }, 100);
    });
});