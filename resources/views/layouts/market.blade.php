<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'ManchiStore - Marketplace Akun Game' }}</title>
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
            margin: 0;
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
</head>
<body>
    <!-- Konten Melebar Penuh 100% -->
    <div class="container-fluid px-4 py-3">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="text-center py-4 mt-auto border-top" style="border-color: rgba(255, 255, 255, 0.08) !important;">
        <p class="mb-0" style="color: rgba(248, 250, 252, 0.4); font-size: 0.78rem;">
            &copy; {{ date('Y') }} <span style="color: rgba(248, 250, 252, 0.6); font-weight: 500;">ManchiStore</span>. All Rights Reserved.
        </p>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>