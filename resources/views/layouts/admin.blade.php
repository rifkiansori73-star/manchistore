<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ManChi Admin Portal</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --sidebar-width: 260px;
            --topbar-height: 70px;
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --sidebar-bg: #0f172a;
            --sidebar-border: #1e293b;
            --sidebar-text: #94a3b8;
            --sidebar-text-active: #ffffff;
            --body-bg: #f8fafc;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--body-bg);
            color: #334155;
            overflow-x: hidden;
        }

        /* Sidebar Container */
        #sidebar {
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
        }

        /* Sidebar Brand & Logo */
        .sidebar-brand-wrapper {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--sidebar-border);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #ffffff;
            font-weight: 800;
            font-size: 1.15rem;
            text-decoration: none;
            letter-spacing: -0.3px;
        }

        .sidebar-logo-glow {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #00d2ff;
            box-shadow: 0 0 12px rgba(0, 210, 255, 0.4);
        }

        /* Sidebar Navigation Menu */
        .sidebar-heading {
            padding: 1.25rem 1.5rem 0.5rem;
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #64748b;
        }

        .nav-sidebar {
            padding: 0.5rem 0.8rem;
        }

        .nav-sidebar .nav-item {
            margin-bottom: 4px;
        }

        .nav-sidebar .nav-link {
            color: var(--sidebar-text);
            padding: 10px 14px;
            font-size: 0.88rem;
            font-weight: 500;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
        }

        .nav-sidebar .nav-link:hover {
            color: var(--sidebar-text-active);
            background-color: rgba(255, 255, 255, 0.05);
        }

        .nav-sidebar .nav-link.active {
            color: #ffffff;
            background: linear-gradient(90deg, rgba(79, 70, 229, 0.3) 0%, rgba(79, 70, 229, 0.08) 100%);
            border-left: 3px solid #6366f1;
            border-radius: 4px 10px 10px 4px;
            font-weight: 600;
        }

        .menu-icon {
            width: 24px;
            font-size: 1rem;
            margin-right: 10px;
            text-align: center;
            opacity: 0.8;
            transition: transform 0.2s ease;
        }

        .nav-link:hover .menu-icon, .nav-link.active .menu-icon {
            opacity: 1;
            color: #818cf8;
        }

        .arrow-icon {
            font-size: 0.72rem;
            transition: transform 0.25s ease;
            opacity: 0.6;
        }

        .nav-link[aria-expanded="true"] .arrow-icon {
            transform: rotate(180deg);
            opacity: 1;
            color: #818cf8;
        }

        /* Submenu Styling */
        .submenu {
            padding-left: 0;
            margin-top: 2px;
            margin-bottom: 4px;
        }

        .submenu .nav-link {
            padding: 8px 14px 8px 48px !important;
            font-size: 0.84rem;
            color: #94a3b8;
            border-left: none !important;
            border-radius: 8px;
        }

        .submenu .nav-link:hover {
            color: #818cf8 !important;
            background-color: rgba(255, 255, 255, 0.04) !important;
        }

        .submenu .nav-link.active {
            color: #818cf8 !important;
            background-color: rgba(129, 140, 248, 0.1) !important;
            font-weight: 600;
        }

        /* Main Content Wrapper */
        #content-wrapper {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Topbar Header */
        .topbar {
            height: var(--topbar-height);
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .sidebar-toggler-btn {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #475569;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .sidebar-toggler-btn:hover {
            background: #e2e8f0;
            color: #0f172a;
        }

        .user-avatar-badge {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            color: #ffffff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
        }

        /* Footer */
        footer {
            background-color: #ffffff;
            border-top: 1px solid #e2e8f0;
        }

        /* Overlay for Mobile Navigation */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1030;
            display: none;
        }

        /* Responsive Breakpoints & Mobile Optimization */
        @media (max-width: 991.98px) {
            #sidebar {
                margin-left: calc(var(--sidebar-width) * -1);
                box-shadow: none;
            }
            #sidebar.show {
                margin-left: 0;
                box-shadow: 10px 0 25px rgba(0, 0, 0, 0.3);
            }
            #content-wrapper {
                margin-left: 0;
                width: 100%;
            }
            .sidebar-overlay.show {
                display: block;
            }
        }
    </style>
</head>
<body>

<!-- Overlay Gelap untuk Mobile saat Sidebar Terbuka -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="d-flex">
    <!-- Sidebar -->
    <nav id="sidebar">
        <!-- Brand Header dengan Logo Web Publik -->
        <div class="sidebar-brand-wrapper">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <img src="{{ asset('img/logo.jpg') }}" alt="ManChi Store" class="sidebar-logo-glow">
                <div>
                    <div>ManChi <span class="text-indigo fs-xs fw-normal" style="color: #818cf8;">Store</span></div>
                    <div style="font-size: 0.65rem; color: #64748b; font-weight: 500; letter-spacing: 0.5px;">ADMIN PANEL v2.0</div>
                </div>
            </a>
        </div>

        <div class="flex-grow-1 overflow-y-auto">
            <div class="sidebar-heading">Menu Utama</div>
            <ul class="nav flex-column nav-sidebar">
                
                <!-- Menu 1: Order -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/orders*') || request()->is('admin/dashboard*') ? 'active' : '' }}" 
                       data-bs-toggle="collapse" 
                       href="#orderSubmenu" 
                       role="button" 
                       aria-expanded="{{ request()->is('admin/orders*') || request()->is('admin/dashboard*') ? 'true' : 'false' }}">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-receipt menu-icon"></i>
                            <span>Order</span>
                        </div>
                        <i class="fa-solid fa-chevron-down arrow-icon"></i>
                    </a>
                    <div class="collapse {{ request()->is('admin/orders*') || request()->is('admin/dashboard*') ? 'show' : '' }} submenu" id="orderSubmenu">
                        <ul class="nav flex-column">
                            <li>
                                <a href="{{ route('admin.orders.index') }}" 
                                   class="nav-link {{ request()->is('admin/orders*') || request()->is('admin/dashboard*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-minus fs-xs me-2 opacity-50"></i> Manage Orders
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Menu 2: Services (Tarif Joki & Setting Kontak Sosial Media di bawahnya) -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/joki-rates*') || request()->is('admin/settings*') ? 'active' : '' }}" 
                       data-bs-toggle="collapse" 
                       href="#servicesSubmenu" 
                       role="button" 
                       aria-expanded="{{ request()->is('admin/joki-rates*') || request()->is('admin/settings*') ? 'true' : 'false' }}">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-table-cells-large menu-icon"></i>
                            <span>Services & Config</span>
                        </div>
                        <i class="fa-solid fa-chevron-down arrow-icon"></i>
                    </a>
                    <div class="collapse {{ request()->is('admin/joki-rates*') || request()->is('admin/settings*') ? 'show' : '' }} submenu" id="servicesSubmenu">
                        <ul class="nav flex-column">
                            <li>
                                <a href="{{ route('admin.joki.index') }}" 
                                   class="nav-link {{ request()->is('admin/joki-rates*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-minus fs-xs me-2 opacity-50"></i> Setting Tarif Joki
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.settings.index') }}" 
                                   class="nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-minus fs-xs me-2 opacity-50"></i> Setting Kontak & Sosial Media
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <div class="sidebar-heading mt-2">Katalog</div>

                <!-- Menu 3: Katalog Stok Game -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/accounts*') ? 'active' : '' }}" 
                       data-bs-toggle="collapse" 
                       href="#catalogSubmenu" 
                       role="button" 
                       aria-expanded="{{ request()->is('admin/accounts*') ? 'true' : 'false' }}">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-bag-shopping menu-icon"></i>
                            <span>Produk & Akun</span>
                        </div>
                        <i class="fa-solid fa-chevron-down arrow-icon"></i>
                    </a>
                    <div class="collapse {{ request()->is('admin/accounts*') ? 'show' : '' }} submenu" id="catalogSubmenu">
                        <ul class="nav flex-column">
                            <li>
                                <a href="{{ route('admin.accounts.index') }}" 
                                   class="nav-link {{ request()->is('admin/accounts*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-minus fs-xs me-2 opacity-50"></i> Katalog Stok Game
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
        
        <!-- Sidebar Bottom Footer Info -->
        <div class="p-3 border-top border-secondary border-opacity-25 text-center">
            <span class="badge bg-primary bg-opacity-10 text-primary fw-medium px-2 py-1" style="font-size: 0.7rem; background-color: rgba(79, 70, 229, 0.1) !important; color: #818cf8 !important;">
                <i class="fa-solid fa-shield-halved me-1"></i> Admin Secure Access
            </span>
        </div>
    </nav>

    <!-- Content Wrapper -->
    <div id="content-wrapper">
        <!-- Topbar Header -->
        <nav class="navbar topbar px-3 px-lg-4 mb-4">
            <div class="d-flex w-100 justify-content-between align-items-center">
                
                <!-- Left Section: Mobile Toggle & Title -->
                <div class="d-flex align-items-center gap-3">
                    <button class="sidebar-toggler-btn d-lg-none" id="sidebarToggle" title="Toggle Menu">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div class="d-flex flex-column">
                        <span class="fw-bold text-dark fs-5 lh-sm">Dashboard Panel</span>
                        <span class="text-secondary" style="font-size: 0.75rem;">Kelola transaksi dan pengaturan toko Anda</span>
                    </div>
                </div>

                <!-- Right Section: Live Store & User Dropdown -->
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center gap-1.5 rounded-pill px-3 py-1.5 fw-semibold" style="border-color: #4f46e5; color: #4f46e5;">
                        <i class="fa-solid fa-store fs-xs"></i>
                        <span>Live Store</span>
                    </a>

                    <div class="border-end h-50 my-auto" style="height: 24px !important;"></div>

                    <!-- Dropdown Profil Admin -->
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 p-0" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar-badge">
                                {{ strtoupper(substr(Auth::user()->name ?? 'M', 0, 1)) }}
                            </div>
                            <div class="d-none d-lg-block text-start">
                                <div class="fw-bold text-dark lh-1" style="font-size: 0.88rem;">{{ Auth::user()->name ?? 'Admin ManChi' }}</div>
                                <div class="text-secondary mt-1" style="font-size: 0.72rem;">Super Administrator</div>
                            </div>
                            <i class="fa-solid fa-chevron-down text-secondary fs-xs ms-1 d-none d-lg-inline"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3 p-2 rounded-3" aria-labelledby="userDropdown" style="min-width: 200px;">
                            <li class="px-2 py-1 mb-1 border-bottom d-lg-none">
                                <div class="fw-bold text-dark">{{ Auth::user()->name ?? 'Admin ManChi' }}</div>
                                <div class="text-secondary small">Super Administrator</div>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger fw-semibold rounded-2 py-2 w-100 text-start bg-transparent border-0">
                                        <i class="fa-solid fa-right-from-bracket me-2"></i> Logout System
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </nav>

        <!-- Main Content Area -->
        <main class="flex-grow-1 px-3 px-lg-4">
            @yield('content')
        </main>
        
        <!-- Footer -->
        <footer class="py-3 mt-4 text-center text-secondary small">
            <div class="container-fluid d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 px-4">
                <span>&copy; {{ date('Y') }} <strong>ManChi Store</strong>. All rights reserved.</span>
                <span class="fw-medium text-primary" style="color: #4f46e5 !important;">manchistore.com</span>
            </div>
        </footer>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom Script untuk Sidebar Mobile Toggle -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        if (sidebarToggle && sidebar && sidebarOverlay) {
            sidebarToggle.addEventListener('click', function () {
                sidebar.classList.toggle('show');
                sidebarOverlay.classList.toggle('show');
            });

            sidebarOverlay.addEventListener('click', function () {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            });
        }
    });
</script>
</body>
</html>