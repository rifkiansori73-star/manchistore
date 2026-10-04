<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'ManchiStore - Game Store & Services' }}</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #0f172a;
            color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }
        /* Container khusus tampilan publik/mobile ala Lynk.id */
        .mobile-container {
            max-width: 480px;
            margin: 0 auto;
            min-height: 100vh;
            background: #1e293b;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
            padding: 20px 16px;
            display: flex;
            flex-direction: column;
        }
        .content-wrapper {
            flex: 1;
        }
        .card-link {
            background: #334155;
            border: 1px solid #475569;
            border-radius: 12px;
            color: #ffffff;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
            display: flex;
            align-items: center;
            padding: 14px 16px;
            margin-bottom: 12px;
        }
        .card-link:hover {
            background: #475569;
            color: #38bdf8;
            transform: translateY(-2px);
        }
        .card-icon {
            font-size: 1.5rem;
            width: 40px;
            text-align: center;
            margin-right: 12px;
        }
        .btn-custom-wa {
            background-color: #25d366;
            color: white;
            font-weight: 600;
        }
        .btn-custom-wa:hover {
            background-color: #1ebc57;
            color: white;
        }
    </style>
    @stack('styles')
</head>
<body>
    @hasSection('is_admin')
        <!-- Jika halaman admin, buat melebar penuh tanpa batasan mobile container -->
        <div class="admin-wrapper w-100 min-vh-100 bg-light text-dark">
            @yield('content')
        </div>
    @else
        <!-- Tdefault untuk halaman publik / link bio -->
        <div class="mobile-container">
            <div class="content-wrapper">
                @yield('content')
            </div>
            
            <!-- Footer Copyright Soft Light White -->
            <footer class="text-center mt-4 pt-3 border-top" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                <p class="mb-0" style="color: rgba(248, 250, 252, 0.4); font-size: 0.78rem; letter-spacing: 0.4px; font-weight: 400;">
                    &copy; {{ date('Y') }} <span style="color: rgba(248, 250, 252, 0.6); font-weight: 500;">ManchiStore</span>. All Rights Reserved.
                </p>
            </footer>
        </div>
    @endif

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>