<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Panel - ManChi Store</title>
    <!-- Gunakan Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { 
            background-color: #0f172a; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card { 
            border: none; 
            border-radius: 16px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.5); 
            background: #1e293b;
            color: #f8fafc;
        }
        .login-logo-glow {
            width: 80px;
            height: 80px;
            object-fit: cover;
            box-shadow: 0 0 20px rgba(0, 210, 255, 0.4);
            border: 3px solid #00d2ff !important;
        }
        .form-control {
            background-color: #0f172a;
            border-color: #334155;
            color: #f8fafc;
        }
        .form-control:focus {
            background-color: #0f172a;
            border-color: #00d2ff;
            color: #f8fafc;
            box-shadow: 0 0 0 0.25rem rgba(0, 210, 255, 0.25);
        }
        .form-label {
            color: #cbd5e1;
            font-size: 0.85rem;
            font-weight: 600;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card login-card p-4">
                
                <!-- Logo Store & Header -->
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <img src="{{ asset('img/logo.jpg') }}" alt="ManchiStore Logo" class="rounded-circle login-logo-glow">
                    </div>
                    <h4 class="fw-bold text-white mb-1">ManChi Admin</h4>
                    <p class="text-secondary small mb-0">Silakan login untuk mengelola orderan</p>
                </div>

                <!-- Alert Error -->
                @if($errors->any())
                    <div class="alert alert-danger bg-danger bg-opacity-10 border-0 text-danger small py-2 rounded-3 mb-3">
                        <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $errors->first() }}
                    </div>
                @endif

                <!-- Form Login (Menggunakan secure route/url agar aman dari peringatan HTTP) -->
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control py-2" value="{{ old('email') }}" required autofocus placeholder="Masukan Email">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control py-2" required placeholder="Masukan Password">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow-sm rounded-3">
                        <i class="fa-solid fa-right-to-bracket me-1"></i> Login to Panel
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>