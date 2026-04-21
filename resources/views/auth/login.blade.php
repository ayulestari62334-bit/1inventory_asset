<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Inventory Asset</title>

    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <style>
        /* Background gambar kiosbank */
        body.hold-transition.login-page {
            background: url('{{ asset('image/kiosbank.jpeg') }}') no-repeat center center fixed !important;
            background-size: cover !important;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Overlay blur ringan */
        body.hold-transition.login-page::before {
            content: '';
            position: fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            backdrop-filter: blur(6px);
            background: rgba(0,0,0,0.3);
            z-index: 0;
        }

        /* Card modern minimalis - biru tegas */
        .login-card-body {
            background: linear-gradient(145deg, rgba(0,51,102,0.85), rgba(51,102,204,0.85));
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            padding: 2rem;
            color: #fff;
        }

        /* Logo */
        .login-logo {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-align: center;
            color: #fff;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }

        /* Inputs modern tegas */
        .form-control {
            border-radius: 50px;
            padding: 0.75rem 1rem;
            border: 2px solid rgba(255,255,255,0.6);
            background: rgba(255,255,255,0.15);
            color: #fff;
            transition: all 0.3s ease;
        }

        .form-control::placeholder {
            color: rgba(255,255,255,0.7);
        }

        .form-control:focus {
            border-color: #66ccff;
            box-shadow: 0 0 12px rgba(102,204,255,0.7);
            background: rgba(255,255,255,0.2);
            color: #fff;
        }

        /* Icon di input */
        .input-group-text {
            background: rgba(255,255,255,0.15);
            border: 2px solid rgba(255,255,255,0.6);
            border-right: none;
            color: #fff;
            border-radius: 50px 0 0 50px;
        }

        /* Tombol login modern */
        .btn-primary {
            border-radius: 50px;
            background: linear-gradient(90deg, #003366, #3366cc);
            border: none;
            transition: all 0.3s ease;
            color: #fff;
            font-weight: 600;
            padding: 0.65rem 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #3366cc, #003366);
            transform: translateY(-2px);
        }

        /* Checkbox modern */
        .form-check-input {
            width: 18px;
            height: 18px;
        }

        .form-check-label {
            margin-left: 0.5rem;
            color: #fff;
            font-weight: 500;
        }

        .login-box {
            max-width: 400px;
            margin: 6vh auto;
            position: relative;
            z-index: 1;
        }

        /* Link lupa password */
        .login-card-body a {
            color: #cce6ff;
            text-decoration: underline;
        }

        .login-card-body a:hover {
            color: #ffffff;
        }
    </style>
</head>

<body class="hold-transition login-page">

<div class="login-box">

    <div class="login-logo">
        <b>Inventory</b> Asset
    </div>

    <div class="card">
        <div class="card-body login-card-body">

            <p class="login-box-msg">Silakan login untuk masuk</p>

            <!-- Error Message -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <!-- Email -->
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email"
                           name="email"
                           class="form-control"
                           placeholder="Email"
                           value="{{ old('email') }}"
                           required>
                </div>

                <!-- Password -->
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="Password"
                           required>
                </div>

                <!-- Remember & Button -->
                <div class="row">
                    <div class="col-6 d-flex align-items-center">
                        <div class="form-check">
                            <input type="checkbox"
                                   name="remember"
                                   class="form-check-input"
                                   id="remember">
                            <label class="form-check-label" for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>

                    <div class="col-6 text-end">
                        <button type="submit" class="btn btn-primary btn-block px-4">
                            Login
                        </button>
                    </div>
                </div>

            </form>

            <!-- Forgot Password -->
            @if (Route::has('password.request'))
                <p class="mb-1 mt-3 text-center">
                    <a href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                </p>
            @endif

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>