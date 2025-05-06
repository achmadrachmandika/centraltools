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
            background: linear-gradient(135deg, #dceefb, #f0f4f8);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .login-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 40px 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            text-align: center;
            border: 1px solid #e3e6ea;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            background: #f8f9fa;
            color: #333;
            border: 1px solid #ced4da;
        }

        .form-control:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            border: none;
            border-radius: 50px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #00f2fe, #4facfe);
        }

        .btn-outline-light {
            border-color: #ced4da;
            color: #333;
        }

        .btn-outline-light:hover {
            background-color: #f1f1f1;
        }

        .alert {
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="login-card col-11 col-sm-8 col-md-5 col-lg-4">
        <img src="{{ asset('img/CT-ICON.png') }}" alt="Logo" width="80" class="mb-3">
        <h4 class="fw-bold">Selamat Datang di Central Tools</h4>
        <p class="text-muted mb-4">Pengelolaan material di Departemen PPA</p>

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        
        @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
            <div class="input-group mb-4">
                <input type="password" id="password" name="password" class="form-control" placeholder="Password"
                    required>
                <button class="btn btn-outline-light" type="button" id="toggle-password">
                    <i class="bi bi-eye-slash"></i>
                </button>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

    <script>
        document.getElementById("toggle-password").addEventListener("click", function () {
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