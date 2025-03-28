<!DOCTYPE html>
<html lang="id">

<head>
    <title>Central Tools - Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Central Tools PPA">
    <link rel="icon" type="image/x-icon" href="{{ asset('img/CT-ICON.png') }}">

    <!-- Bootstrap & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #007bff, #6610f2);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .modern-input {
            border-radius: 12px;
            padding: 12px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .modern-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .btn-primary {
            background: linear-gradient(135deg, #00c6ff, #0072ff);
            border: none;
            border-radius: 50px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0072ff, #00c6ff);
        }
    </style>
</head>

<body>
    <div class="login-card col-md-4">
        <img src="{{ asset('img/CT-ICON.png') }}" alt="Logo" width="80" class="mb-3">
        <h4 class="text-white fw-bold">Selamat Datang</h4>
        <p class="text-white-50">Silahkan login untuk melanjutkan</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email" name="email" class="form-control modern-input mb-3" placeholder="Email" required>
            <div class="input-group mb-3">
                <input type="password" id="password" name="password" class="form-control modern-input"
                    placeholder="Password" required>
                <button class="btn btn-outline-light" type="button" id="toggle-password">
                    <i class="bi bi-eye-slash"></i>
                </button>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

    <script>
        document.getElementById("toggle-password").addEventListener("click", function() {
            let passwordField = document.getElementById("password");
            let icon = this.querySelector("i");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.replace("bi-eye-slash", "bi-eye");
            } else {
                passwordField.type = "password";
                icon.classList.replace("bi-eye", "bi-eye-slash");
            }
        });
    </script>
</body>

</html>