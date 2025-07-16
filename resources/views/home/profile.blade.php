<!doctype html>
<html lang="id" class="light-style layout-navbar-fixed layout-wide" dir="ltr" data-theme="theme-default" data-assets-path="../../assets/" data-template="front-pages-no-customizer" data-style="light">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ $profile->name }} - {{ Str::limit($profile->description, 50) }}</title>

    <meta name="description" content="{{ $profile->description }}" />
    <meta name="keywords" content="{{ $profile->name }}, {{ $profile->address }}, produk berkualitas, layanan terbaik" />

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $profile->name }}" />
    <meta property="og:description" content="{{ $profile->description }}" />
    <meta property="og:image" content="{{ $profile->cover_path ? asset('storage/' . $profile->cover_path) : asset('assets/img/front-pages/misc/placeholder-cover.jpg') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ $profile->logo_path ? asset('storage/' . $profile->logo_path) : asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- Remix Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" />

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        /* Modern Color Palette & CSS Variables */
        :root {
            /* Primary Colors - Professional Blue */
            --primary-50: #eff6ff;
            --primary-100: #dbeafe;
            --primary-200: #bfdbfe;
            --primary-300: #93c5fd;
            --primary-400: #60a5fa;
            --primary-500: #3b82f6;
            --primary-600: #2563eb;
            --primary-700: #1d4ed8;
            --primary-800: #1e40af;
            --primary-900: #1e3a8a;

            /* Secondary Colors - Warm Orange */
            --secondary-50: #fff7ed;
            --secondary-100: #ffedd5;
            --secondary-200: #fed7aa;
            --secondary-300: #fdba74;
            --secondary-400: #fb923c;
            --secondary-500: #f97316;
            --secondary-600: #ea580c;
            --secondary-700: #c2410c;
            --secondary-800: #9a3412;
            --secondary-900: #7c2d12;

            /* Success Colors - Green */
            --success-50: #ecfdf5;
            --success-100: #d1fae5;
            --success-200: #a7f3d0;
            --success-300: #6ee7b7;
            --success-400: #34d399;
            --success-500: #10b981;
            --success-600: #059669;
            --success-700: #047857;
            --success-800: #065f46;
            --success-900: #064e3b;

            /* Neutral Colors */
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;

            /* Gradients */
            --gradient-primary: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-700) 100%);
            --gradient-secondary: linear-gradient(135deg, var(--secondary-500) 0%, var(--secondary-600) 100%);
            --gradient-success: linear-gradient(135deg, var(--success-500) 0%, var(--success-600) 100%);
            --gradient-hero: linear-gradient(135deg, var(--primary-600) 0%, var(--secondary-600) 50%, var(--primary-700) 100%);

            /* Shadows */
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --shadow-2xl: 0 25px 50px -12px rgb(0 0 0 / 0.25);

            /* Spacing */
            --border-radius-sm: 0.375rem;
            --border-radius: 0.5rem;
            --border-radius-lg: 0.75rem;
            --border-radius-xl: 1rem;
            --border-radius-2xl: 1.5rem;

            /* Transitions */
            --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-normal: 300ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: 500ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Global Styles */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            line-height: 1.6;
            background: var(--gray-50);
            color: var(--gray-800);
            font-feature-settings: 'cv02', 'cv03', 'cv04', 'cv11';
        }

        /* Improved Typography */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 700;
            line-height: 1.2;
            color: var(--gray-900);
        }

        /* Loading States */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-600), var(--secondary-600));
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            transition: opacity var(--transition-slow), visibility var(--transition-slow);
        }

        .loading-overlay.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 4px solid rgba(255, 255, 255, 0.2);
            border-top: 4px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 1rem;
        }

        .loading-text {
            color: white;
            font-size: 1.1rem;
            font-weight: 500;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Enhanced Navigation */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            box-shadow: var(--shadow-md);
            transition: all var(--transition-normal);
            border-bottom: 1px solid var(--gray-200);
        }

        .navbar-custom.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: var(--shadow-lg);
        }

        .navbar-brand {
            font-weight: 800;
            color: var(--gray-900) !important;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-brand img {
            height: 40px;
            border-radius: var(--border-radius);
        }

        .nav-link {
            font-weight: 500;
            color: var(--gray-600) !important;
            transition: color var(--transition-fast);
            position: relative;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary-600) !important;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 3px;
            background: var(--gradient-primary);
            border-radius: var(--border-radius-sm);
        }

        .btn-primary-custom {
            background: var(--gradient-primary);
            border: none;
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: var(--border-radius);
            font-weight: 600;
            transition: all var(--transition-fast);
            box-shadow: var(--shadow-md);
        }

        .btn-primary-custom:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-lg);
            color: white;
        }

        /* Modern Hero Section */
        .hero-cover {
            min-height: 100vh;
            position: relative;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.3) 100%);
        }

        .hero-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                radial-gradient(circle at 25% 25%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            background-size: 100px 100px;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(1deg); }
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
            max-width: 900px;
            padding: 2rem;
        }

        .hero-logo {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 6px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            margin: 0 auto 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: var(--shadow-2xl);
            background: rgba(255, 255, 255, 0.1);
        }

        .hero-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-logo .placeholder-icon {
            font-size: 4rem;
            color: white;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            letter-spacing: -0.02em;
        }

        .hero-description {
            font-size: 1.375rem;
            opacity: 0.95;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            line-height: 1.7;
            font-weight: 400;
        }

        /* Section Styling */
        .section-modern {
            padding: 6rem 0;
            position: relative;
        }

        .section-title-modern {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-title-modern h2 {
            font-size: 3rem;
            font-weight: 800;
            color: var(--gray-900);
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }

        .section-title-modern .subtitle {
            font-size: 1.25rem;
            color: var(--gray-600);
            max-width: 600px;
            margin: 0 auto;
            font-weight: 400;
        }

        /* Enhanced Product Section */
        .products-section {
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--primary-50) 100%);
        }

        .product-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 3rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .product-search {
            flex: 1;
            max-width: 400px;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
            border: 2px solid var(--gray-200);
            border-radius: var(--border-radius-lg);
            font-size: 1rem;
            transition: all var(--transition-fast);
            background: white;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-500);
            box-shadow: 0 0 0 3px var(--primary-100);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            font-size: 1.25rem;
        }

        .product-card-modern {
            background: white;
            border-radius: var(--border-radius-xl);
            overflow: hidden;
            transition: all var(--transition-normal);
            box-shadow: var(--shadow-md);
            height: 100%;
            border: 1px solid var(--gray-100);
        }

        .product-card-modern:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-2xl);
        }

        .product-image-modern {
            position: relative;
            height: 280px;
            overflow: hidden;
            background: var(--gray-100);
        }

        .product-image-modern img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform var(--transition-slow);
        }

        .product-card-modern:hover .product-image-modern img {
            transform: scale(1.05);
        }

        .product-price-modern {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: var(--gradient-primary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius-2xl);
            font-weight: 700;
            font-size: 0.875rem;
            box-shadow: var(--shadow-lg);
        }

        .product-info-modern {
            padding: 1.5rem;
        }

        .product-name-modern {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }

        .product-description-modern {
            color: var(--gray-600);
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .btn-whatsapp-modern {
            background: var(--gradient-success);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius-lg);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all var(--transition-fast);
            box-shadow: var(--shadow-md);
            width: 100%;
            justify-content: center;
        }

        .btn-whatsapp-modern:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* Load More Button */
        .load-more-container {
            text-align: center;
            margin-top: 3rem;
        }

        .btn-load-more {
            background: var(--gradient-primary);
            border: none;
            color: white;
            padding: 1rem 2rem;
            border-radius: var(--border-radius-lg);
            font-weight: 600;
            font-size: 1.1rem;
            transition: all var(--transition-fast);
            box-shadow: var(--shadow-md);
        }

        .btn-load-more:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-load-more:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Gallery Layout */
        .gallery-section {
            background: white;
        }

        .masonry-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            padding: 0;
        }

        .masonry-item {
            break-inside: avoid;
            background: white;
            border-radius: var(--border-radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all var(--transition-normal);
            cursor: pointer;
            border: 1px solid var(--gray-100);
        }

        .masonry-item:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-xl);
        }

        .masonry-item img {
            width: 100%;
            height: auto;
            display: block;
            transition: transform var(--transition-normal);
        }

        .masonry-item:hover img {
            transform: scale(1.02);
        }

        .masonry-caption {
            padding: 1rem;
            background: white;
        }

        .masonry-caption h6 {
            margin: 0 0 0.5rem 0;
            font-weight: 600;
            color: var(--gray-900);
        }

        .masonry-caption p {
            margin: 0;
            color: var(--gray-600);
            font-size: 0.875rem;
        }

        /* Enhanced Map Section */
        .map-section {
            background: var(--gradient-primary);
            color: white;
        }

        .map-container-modern {
            background: white;
            border-radius: var(--border-radius-2xl);
            overflow: hidden;
            box-shadow: var(--shadow-2xl);
        }

        #map {
            height: 500px;
            width: 100%;
        }

        .map-info-modern {
            padding: 2rem;
            text-align: center;
            background: white;
        }

        .contact-item-modern {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1rem;
            color: var(--gray-600);
        }

        .contact-icon-modern {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--gradient-primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        /* Enhanced Footer */
        .footer-modern {
            background: var(--gray-900);
            color: white;
            padding: 4rem 0 2rem;
        }

        .footer-logo-modern {
            margin-bottom: 2rem;
            text-align: center;
        }

        .footer-logo-modern img {
            height: 60px;
            border-radius: var(--border-radius);
        }

        .footer-description-modern {
            color: var(--gray-300);
            margin-bottom: 2rem;
            line-height: 1.7;
            text-align: center;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .social-links-modern {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .social-link-modern {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--gradient-primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all var(--transition-normal);
            font-size: 1.5rem;
        }

        .social-link-modern:hover {
            color: white;
            transform: translateY(-3px) scale(1.1);
            box-shadow: var(--shadow-xl);
        }

        .footer-contact-modern {
            text-align: center;
            margin-bottom: 2rem;
        }

        .footer-contact-modern h5 {
            margin-bottom: 1rem;
            color: white;
        }

        .footer-contact-modern p {
            color: var(--gray-300);
            margin: 0;
        }

        .footer-bottom-modern {
            border-top: 1px solid var(--gray-700);
            padding-top: 2rem;
            text-align: center;
            color: var(--gray-400);
        }

        /* Enhanced Image Viewer */
        .image-viewer-modern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.95);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }

        .image-viewer-modern.active {
            display: flex;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .image-viewer-content-modern {
            position: relative;
            max-width: 90%;
            max-height: 90%;
            animation: zoomIn 0.3s ease;
        }

        @keyframes zoomIn {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .image-viewer-modern img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-2xl);
        }

        .image-nav-modern {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.9);
            border: none;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all var(--transition-fast);
            color: var(--gray-700);
        }

        .image-nav-modern:hover {
            background: white;
            transform: translateY(-50%) scale(1.1);
            box-shadow: var(--shadow-lg);
        }

        .image-nav-modern.prev {
            left: -80px;
        }

        .image-nav-modern.next {
            right: -80px;
        }

        .modal-close-modern {
            position: absolute;
            top: -70px;
            right: 0;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            font-size: 2rem;
            cursor: pointer;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            transition: all var(--transition-fast);
            backdrop-filter: blur(10px);
        }

        .modal-close-modern:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        .viewer-caption-modern {
            position: absolute;
            bottom: -70px;
            left: 0;
            right: 0;
            text-align: center;
            color: white;
            font-size: 1.1rem;
            font-weight: 500;
        }

        /* Floating WhatsApp */
        .floating-whatsapp-modern {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 70px;
            height: 70px;
            background: var(--gradient-success);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            text-decoration: none;
            box-shadow: var(--shadow-xl);
            z-index: 1000;
            transition: all var(--transition-normal);
            animation: pulse 2s infinite;
        }

        .floating-whatsapp-modern:hover {
            color: white;
            transform: scale(1.1);
            box-shadow: var(--shadow-2xl);
        }

        @keyframes pulse {
            0% { box-shadow: var(--shadow-xl); }
            50% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0.2), var(--shadow-xl); }
            100% { box-shadow: var(--shadow-xl); }
        }

        /* Empty States */
        .empty-state-modern {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--gray-500);
        }

        .empty-state-modern i {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            opacity: 0.3;
            color: var(--gray-400);
        }

        .empty-state-modern h4 {
            margin-bottom: 0.5rem;
            color: var(--gray-700);
            font-weight: 600;
        }

        .empty-state-modern p {
            color: var(--gray-500);
            font-size: 1.1rem;
        }

        /* Skeleton Loading */
        .skeleton {
            background: linear-gradient(90deg, var(--gray-200) 25%, var(--gray-100) 50%, var(--gray-200) 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        .skeleton-card {
            background: white;
            border-radius: var(--border-radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            height: 400px;
        }

        .skeleton-image {
            height: 250px;
            background: var(--gray-200);
        }

        .skeleton-content {
            padding: 1.5rem;
        }

        .skeleton-title {
            height: 20px;
            background: var(--gray-200);
            border-radius: var(--border-radius);
            margin-bottom: 0.5rem;
        }

        .skeleton-text {
            height: 16px;
            background: var(--gray-200);
            border-radius: var(--border-radius);
            margin-bottom: 0.5rem;
        }

        .skeleton-text:last-child {
            width: 60%;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .masonry-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-description {
                font-size: 1.1rem;
            }

            .section-title-modern h2 {
                font-size: 2rem;
            }

            .masonry-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1rem;
            }

            .product-image-modern {
                height: 220px;
            }

            .floating-whatsapp-modern {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
                bottom: 1rem;
                right: 1rem;
            }

            .image-nav-modern {
                width: 50px;
                height: 50px;
                font-size: 1.25rem;
            }

            .image-nav-modern.prev {
                left: 10px;
            }

            .image-nav-modern.next {
                right: 10px;
            }

            #map {
                height: 350px;
            }

            .product-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .product-search {
                max-width: none;
            }
        }

        @media (max-width: 576px) {
            .masonry-grid {
                grid-template-columns: 1fr;
            }

            .hero-cover {
                min-height: 80vh;
            }

            .hero-logo {
                width: 120px;
                height: 120px;
            }

            .hero-title {
                font-size: 2rem;
            }

            .section-title-modern h2 {
                font-size: 1.75rem;
            }

            .section-modern {
                padding: 4rem 0;
            }
        }

        /* Scroll Animations */
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .fade-in-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .stagger-animation {
            transition-delay: var(--stagger-delay, 0ms);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--gray-100);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gradient-primary);
            border-radius: var(--border-radius);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-700);
        }

        /* Focus States for Accessibility */
        .btn-primary-custom:focus,
        .btn-whatsapp-modern:focus,
        .search-input:focus {
            outline: 2px solid var(--primary-500);
            outline-offset: 2px;
        }

        /* Print Styles */
        @media print {
            .navbar-custom,
            .floating-whatsapp-modern,
            .image-viewer-modern {
                display: none !important;
            }
        }
    </style>
</head>

<body>
<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
    <div class="loading-text">Memuat halaman...</div>
</div>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#hero">
            @if($profile->logo_path)
                <img src="{{ asset('storage/' . $profile->logo_path) }}" alt="{{ $profile->name }}">
            @endif
            {{ Str::limit($profile->name, 20) }}
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="ri-menu-line"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#hero">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#products">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#gallery">Galeri</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#location">Lokasi</a>
                </li>
            </ul>

            <a href="{{ route('home.index') }}" class="btn btn-primary-custom">
                <i class="ri-arrow-left-line me-1"></i>Kembali ke Peta
            </a>
        </div>
    </div>
</nav>

<!-- Hero Cover Section -->
<section id="hero" class="hero-cover" style="background-image: url('{{ $profile->cover_path ? asset('storage/' . $profile->cover_path) : asset('assets/img/front-pages/backgrounds/hero-bg-light.png') }}')">
    <div class="hero-overlay"></div>
    <div class="hero-pattern"></div>
    <div class="hero-content">
        @if($profile->logo_path)
            <div class="hero-logo">
                <img src="{{ asset('storage/' . $profile->logo_path) }}" alt="{{ $profile->name }}">
            </div>
        @else
            <div class="hero-logo">
                <div class="placeholder-icon">🏪</div>
            </div>
        @endif

        <h1 class="hero-title">{{ $profile->name }}</h1>
        <p class="hero-description">{{ $profile->description }}</p>
    </div>
</section>

<!-- Products Section -->
<section id="products" class="section-modern products-section">
    <div class="container">
        <div class="section-title-modern fade-in-up">
            <h2>Katalog Produk</h2>
            <p class="subtitle">Temukan berbagai produk berkualitas yang kami tawarkan dengan harga terbaik</p>
        </div>

        @if($profile->products && $profile->products->count() > 0)
            <div class="product-controls fade-in-up">
                <div class="product-search">
                    <i class="ri-search-line search-icon"></i>
                    <input type="text" class="search-input" placeholder="Cari produk..." id="productSearch">
                </div>
            </div>

            <!-- Product Grid -->
            <div class="row gy-4" id="productGrid">
                <!-- Products will be loaded here -->
            </div>

            <!-- Skeleton Loading for Products -->
            <div class="row gy-4" id="productSkeleton" style="display: none;">
                @for($i = 0; $i < 6; $i++)
                    <div class="col-lg-4 col-md-6">
                        <div class="skeleton-card skeleton">
                            <div class="skeleton-image"></div>
                            <div class="skeleton-content">
                                <div class="skeleton-title skeleton"></div>
                                <div class="skeleton-text skeleton"></div>
                                <div class="skeleton-text skeleton"></div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            <div class="load-more-container" id="loadMoreContainer" style="display: none;">
                <button class="btn-load-more" id="loadMoreProducts">
                    <i class="ri-add-line me-2"></i>Muat Lebih Banyak
                </button>
            </div>
        @else
            <div class="empty-state-modern">
                <i class="ri-shopping-bag-3-line"></i>
                <h4>Produk Segera Hadir</h4>
                <p>Kami sedang menyiapkan produk-produk terbaik untuk Anda</p>
            </div>
        @endif
    </div>
</section>

<!-- Gallery Section -->
<section id="gallery" class="section-modern gallery-section">
    <div class="container">
        <div class="section-title-modern fade-in-up">
            <h2>Galeri</h2>
            <p class="subtitle">Koleksi foto dan momen terbaik yang ingin kami bagikan dengan Anda</p>
        </div>

        @if($profile->galleries && $profile->galleries->count() > 0)
            <!-- Gallery Grid -->
            <div class="masonry-grid fade-in-up" id="galleryGrid">
                <!-- Gallery items will be loaded here -->
            </div>

            <div class="load-more-container" id="galleryLoadMoreContainer" style="display: none;">
                <button class="btn-load-more" id="loadMoreGallery">
                    <i class="ri-add-line me-2"></i>Muat Lebih Banyak
                </button>
            </div>
        @else
            <div class="empty-state-modern">
                <i class="ri-camera-2-line"></i>
                <h4>Galeri Segera Hadir</h4>
                <p>Momen-momen berharga akan segera kami bagikan</p>
            </div>
        @endif
    </div>
</section>

<!-- Map Section -->
<section id="location" class="section-modern map-section">
    <div class="container">
        <div class="section-title-modern fade-in-up mb-5">
            <h2 class="text-white">Lokasi Kami</h2>
            <p class="subtitle text-white opacity-75">Temukan kami di lokasi yang strategis dan mudah dijangkau</p>
        </div>

        <div class="map-container-modern fade-in-up">
            <div id="map"></div>
            <div class="map-info-modern">
                <h3>{{ $profile->name }}</h3>

                @if($profile->address)
                    <div class="contact-item-modern">
                        <div class="contact-icon-modern">
                            <i class="ri-map-pin-line"></i>
                        </div>
                        <div>
                            {{ $profile->address }}
                            @if($profile->rt && $profile->rw)
                                <br>RT {{ $profile->rt }} / RW {{ $profile->rw }}
                            @endif
                        </div>
                    </div>
                @endif

                @if($profile->phone)
                    <div class="contact-item-modern">
                        <div class="contact-icon-modern">
                            <i class="ri-phone-line"></i>
                        </div>
                        <div>{{ $profile->phone }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer-modern">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="footer-logo-modern">
                    @if($profile->logo_path)
                        <img src="{{ asset('storage/' . $profile->logo_path) }}" alt="{{ $profile->name }}">
                    @else
                        <h3 class="text-white">{{ $profile->name }}</h3>
                    @endif
                </div>

                <div class="footer-description-modern">
                    {{ $profile->description }}
                </div>

                @if($profile->socialMedia && $profile->socialMedia->count() > 0)
                    <div class="social-links-modern">
                        @foreach($profile->socialMedia as $social)
                            <a href="{{ $social->url }}" target="_blank" class="social-link-modern" title="{{ ucfirst($social->platform) }}">
                                <i class="ri-{{ $social->platform }}-line"></i>
                            </a>
                        @endforeach
                    </div>
                @endif

                <div class="footer-contact-modern">
                    <h5>Hubungi Kami</h5>
                    @if($profile->address)
                        <p>{{ $profile->address }}</p>
                    @endif
                    @if($profile->phone)
                        <p>{{ $profile->phone }}</p>
                    @endif
                </div>

                <div class="footer-bottom-modern">
                    <p>&copy; {{ date('Y') }} {{ $profile->name }}. Semua hak dilindungi undang-undang.</p>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Image Viewer Modal -->
<div id="imageViewer" class="image-viewer-modern">
    <div class="image-viewer-content-modern">
        <button class="modal-close-modern" onclick="closeImageViewer()">&times;</button>
        <button class="image-nav-modern prev" onclick="prevImage()">‹</button>
        <button class="image-nav-modern next" onclick="nextImage()">›</button>
        <img id="viewerImage" src="" alt="">
        <div id="viewerCaption" class="viewer-caption-modern"></div>
    </div>
</div>

<!-- Floating WhatsApp -->
@if($profile->phone)
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->phone) }}?text=Halo%20{{ urlencode($profile->name) }},%20saya%20tertarik%20dengan%20produk%20Anda"
       target="_blank" class="floating-whatsapp-modern" title="Chat WhatsApp">
        <i class="ri-whatsapp-line"></i>
    </a>
@endif

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // Global variables
    let map;
    let currentImageIndex = 0;
    let allGalleryImages = [];
    let currentProductPage = 1;
    let currentGalleryPage = 1;
    let isLoadingProducts = false;
    let isLoadingGallery = false;
    let hasMoreProducts = true;
    let hasMoreGallery = true;
    let allProducts = [];
    let allGalleryItems = [];

    // Profile data from Laravel
    const profileData = {
        name: @json($profile->name),
        description: @json($profile->description),
        latitude: @json($profile->latitude),
        longitude: @json($profile->longitude),
        address: @json($profile->address),
        rt: @json($profile->rt),
        rw: @json($profile->rw),
        phone: @json($profile->phone),
        products: @json($profile->products ?? []),
        galleries: @json($profile->galleries ?? [])
    };

    // Initialize everything when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        showLoadingOverlay();

        setTimeout(() => {
            hideLoadingOverlay();
            initializeComponents();
        }, 1500);
    });

    function showLoadingOverlay() {
        document.getElementById('loadingOverlay').classList.remove('hidden');
    }

    function hideLoadingOverlay() {
        document.getElementById('loadingOverlay').classList.add('hidden');
    }

    function initializeComponents() {
        initializeMap();
        loadInitialProducts();
        loadInitialGallery();
        initializeEventListeners();
        initializeSmoothScroll();
        initializeScrollAnimations();
        initializeImageViewer();
        handleImageErrors();
    }

    // Initialize Map
    function initializeMap() {
        const mapElement = document.getElementById('map');
        if (!mapElement) return;

        // Default coordinates (Surabaya if no coordinates provided)
        const defaultLat = -7.2575;
        const defaultLng = 112.7521;

        const lat = profileData.latitude || defaultLat;
        const lng = profileData.longitude || defaultLng;

        map = L.map('map').setView([lat, lng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const customIcon = L.divIcon({
            html: `<div style="
                    background: var(--gradient-primary);
                    color: white;
                    border-radius: 50%;
                    width: 50px;
                    height: 50px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    box-shadow: var(--shadow-lg);
                    border: 4px solid white;
                "><i class="ri-map-pin-fill" style="font-size: 20px;"></i></div>`,
            iconSize: [50, 50],
            className: 'custom-marker'
        });

        const marker = L.marker([lat, lng], { icon: customIcon }).addTo(map);

        if (profileData.name && profileData.address) {
            marker.bindPopup(`
                <div style="text-align: center; min-width: 250px; padding: 1.5rem;">
                    <h5 style="margin: 0 0 12px 0; color: var(--gray-900); font-weight: 700;">${profileData.name}</h5>
                    <p style="margin: 0 0 16px 0; color: var(--gray-600); line-height: 1.5;">${profileData.address}</p>
                    ${profileData.phone ? `
                        <a href="https://wa.me/${profileData.phone.replace(/[^0-9]/g, '')}"
                           target="_blank"
                           style="background: var(--gradient-success); color: white; padding: 10px 20px; border-radius: var(--border-radius-lg); text-decoration: none; font-weight: 600; box-shadow: var(--shadow-md); display: inline-flex; align-items: center; gap: 8px;">
                            <i class="ri-whatsapp-line"></i> Chat WhatsApp
                        </a>
                    ` : ''}
                </div>
            `).openPopup();
        }
    }

    // Product Management
    function loadInitialProducts() {
        if (!profileData.products || profileData.products.length === 0) return;

        allProducts = profileData.products;

        if (allProducts.length > 6) {
            document.getElementById('loadMoreContainer').style.display = 'block';
        }

        document.getElementById('productSkeleton').style.display = 'flex';

        setTimeout(() => {
            document.getElementById('productSkeleton').style.display = 'none';
            loadProducts();
        }, 1000);
    }

    function loadProducts(append = false) {
        if (isLoadingProducts) return;

        isLoadingProducts = true;
        const productsPerPage = 6;
        const startIndex = (currentProductPage - 1) * productsPerPage;
        const endIndex = startIndex + productsPerPage;
        const products = allProducts.slice(startIndex, endIndex);

        if (!append) {
            document.getElementById('productGrid').innerHTML = '';
        }

        products.forEach((product, index) => {
            const productCard = createProductCard(product);
            productCard.style.setProperty('--stagger-delay', `${index * 100}ms`);
            productCard.classList.add('stagger-animation');
            document.getElementById('productGrid').appendChild(productCard);
        });

        hasMoreProducts = endIndex < allProducts.length;
        document.getElementById('loadMoreProducts').style.display = hasMoreProducts ? 'inline-flex' : 'none';

        if (append) {
            currentProductPage++;
        }

        isLoadingProducts = false;
        triggerScrollAnimation();
    }

    function createProductCard(product) {
        const col = document.createElement('div');
        col.className = 'col-lg-4 col-md-6 fade-in-up';

        const imageSrc = product.image_path ?
            `{{ asset('storage/') }}/${product.image_path}` :
            `data:image/svg+xml;base64,${btoa(`
                <svg width="400" height="300" xmlns="http://www.w3.org/2000/svg">
                    <rect width="100%" height="100%" fill="#f3f4f6"/>
                    <text x="50%" y="50%" font-family="Arial, sans-serif" font-size="18"
                          fill="#6b7280" text-anchor="middle" dy=".3em">
                        ${product.name}
                    </text>
                </svg>
            `)}`;

        col.innerHTML = `
            <div class="product-card-modern">
                <div class="product-image-modern">
                    <img src="${imageSrc}" alt="${product.name}" loading="lazy" onerror="handleImageError(this)">
                    ${product.price ? `
                        <div class="product-price-modern">
                            Rp ${Number(product.price).toLocaleString('id-ID')}
                        </div>
                    ` : ''}
                </div>
                <div class="product-info-modern">
                    <div class="product-name-modern">${product.name}</div>
                    ${product.description ? `
                        <div class="product-description-modern">${product.description.length > 80 ? product.description.substring(0, 80) + '...' : product.description}</div>
                    ` : ''}
                    ${profileData.phone ? `
                        <a href="https://wa.me/${profileData.phone.replace(/[^0-9]/g, '')}?text=Halo%20${encodeURIComponent(profileData.name)},%20saya%20tertarik%20dengan%20produk%20${encodeURIComponent(product.name)}"
                           target="_blank" class="btn-whatsapp-modern">
                            <i class="ri-whatsapp-line"></i>
                            Tanya Produk
                        </a>
                    ` : ''}
                </div>
            </div>
        `;

        return col;
    }

    // Gallery Management
    function loadInitialGallery() {
        if (!profileData.galleries || profileData.galleries.length === 0) return;

        allGalleryItems = profileData.galleries;

        if (allGalleryItems.length > 6) {
            document.getElementById('galleryLoadMoreContainer').style.display = 'block';
        }

        loadGallery();
    }

    function loadGallery(append = false) {
        if (isLoadingGallery) return;

        isLoadingGallery = true;
        const itemsPerPage = 6;
        const startIndex = (currentGalleryPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const items = allGalleryItems.slice(startIndex, endIndex);

        if (!append) {
            document.getElementById('galleryGrid').innerHTML = '';
            allGalleryImages = [];
        }

        items.forEach((item, index) => {
            const galleryItem = createGalleryItem(item, allGalleryImages.length);
            galleryItem.style.setProperty('--stagger-delay', `${index * 150}ms`);
            galleryItem.classList.add('stagger-animation');
            document.getElementById('galleryGrid').appendChild(galleryItem);

            const imageSrc = `{{ asset('storage/') }}/${item.image_path}`;
            allGalleryImages.push({ src: imageSrc, caption: item.caption || '' });
        });

        hasMoreGallery = endIndex < allGalleryItems.length;
        document.getElementById('loadMoreGallery').style.display = hasMoreGallery ? 'inline-flex' : 'none';

        if (append) {
            currentGalleryPage++;
        }

        isLoadingGallery = false;
        triggerScrollAnimation();
    }

    function createGalleryItem(item, index) {
        const galleryItem = document.createElement('div');
        galleryItem.className = 'masonry-item fade-in-up';
        galleryItem.setAttribute('onclick', `openImageViewer(${index})`);
        galleryItem.setAttribute('tabindex', '0');
        galleryItem.setAttribute('role', 'button');
        galleryItem.setAttribute('aria-label', `Gambar galeri ${index + 1}`);

        const imageSrc = `{{ asset('storage/') }}/${item.image_path}`;

        galleryItem.innerHTML = `
            <img src="${imageSrc}" alt="${item.caption || 'Gallery'}" loading="lazy" onerror="handleImageError(this)">
            ${item.caption ? `
                <div class="masonry-caption">
                    <h6>${item.caption}</h6>
                </div>
            ` : ''}
        `;

        // Add keyboard navigation
        galleryItem.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                openImageViewer(index);
            }
        });

        return galleryItem;
    }

    // Event Listeners
    function initializeEventListeners() {
        // Load more buttons
        const loadMoreProductsBtn = document.getElementById('loadMoreProducts');
        if (loadMoreProductsBtn) {
            loadMoreProductsBtn.addEventListener('click', () => {
                loadProducts(true);
            });
        }

        const loadMoreGalleryBtn = document.getElementById('loadMoreGallery');
        if (loadMoreGalleryBtn) {
            loadMoreGalleryBtn.addEventListener('click', () => {
                loadGallery(true);
            });
        }

        // Product search
        const searchInput = document.getElementById('productSearch');
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    filterProducts(e.target.value);
                }, 300);
            });
        }

        // Keyboard navigation
        document.addEventListener('keydown', handleKeyboardNavigation);

        // Window events
        window.addEventListener('scroll', handleScroll);
        window.addEventListener('resize', debounce(handleResize, 250));
    }

    // Filter Functions
    function filterProducts(searchTerm = '') {
        const productCards = document.querySelectorAll('#productGrid .product-card-modern');

        productCards.forEach(card => {
            const cardElement = card.closest('.col-lg-4');
            const productName = card.querySelector('.product-name-modern').textContent.toLowerCase();
            const productDescription = card.querySelector('.product-description-modern')?.textContent.toLowerCase() || '';

            const matchesSearch = productName.includes(searchTerm.toLowerCase()) ||
                productDescription.includes(searchTerm.toLowerCase());

            if (matchesSearch) {
                cardElement.style.display = 'block';
                setTimeout(() => {
                    cardElement.classList.add('fade-in-up', 'visible');
                }, 100);
            } else {
                cardElement.style.display = 'none';
                cardElement.classList.remove('visible');
            }
        });
    }

    // Image Viewer Functions
    function initializeImageViewer() {
        // Touch gestures for mobile
        let touchStartX = 0;
        let touchEndX = 0;

        document.getElementById('imageViewer').addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        document.getElementById('imageViewer').addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        }, { passive: true });

        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;

            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    nextImage();
                } else {
                    prevImage();
                }
            }
        }

        // Close on click outside
        document.getElementById('imageViewer').addEventListener('click', (e) => {
            if (e.target === e.currentTarget) {
                closeImageViewer();
            }
        });
    }

    function openImageViewer(index) {
        const modal = document.getElementById('imageViewer');
        const image = document.getElementById('viewerImage');
        const caption = document.getElementById('viewerCaption');

        currentImageIndex = index;

        if (allGalleryImages[index]) {
            image.src = allGalleryImages[index].src;
            image.alt = allGalleryImages[index].caption || '';
            caption.textContent = allGalleryImages[index].caption || '';
        }

        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeImageViewer() {
        document.getElementById('imageViewer').classList.remove('active');
        document.body.style.overflow = '';
    }

    function nextImage() {
        if (currentImageIndex < allGalleryImages.length - 1) {
            openImageViewer(currentImageIndex + 1);
        } else {
            openImageViewer(0);
        }
    }

    function prevImage() {
        if (currentImageIndex > 0) {
            openImageViewer(currentImageIndex - 1);
        } else {
            openImageViewer(allGalleryImages.length - 1);
        }
    }

    // Navigation and Scroll Functions
    function initializeSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const headerOffset = 100;
                    const elementPosition = target.offsetTop;
                    const offsetPosition = elementPosition - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    function initializeScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        const animatedElements = document.querySelectorAll('.fade-in-up');
        animatedElements.forEach(el => {
            observer.observe(el);
        });
    }

    function triggerScrollAnimation() {
        const animatedElements = document.querySelectorAll('.fade-in-up:not(.visible)');
        animatedElements.forEach(el => {
            const rect = el.getBoundingClientRect();
            if (rect.top < window.innerHeight && rect.bottom > 0) {
                el.classList.add('visible');
            }
        });
    }

    // Event Handlers
    function handleKeyboardNavigation(e) {
        const imageViewer = document.getElementById('imageViewer');
        if (imageViewer.classList.contains('active')) {
            if (e.key === 'ArrowRight') {
                nextImage();
            } else if (e.key === 'ArrowLeft') {
                prevImage();
            } else if (e.key === 'Escape') {
                closeImageViewer();
            }
        }
    }

    function handleScroll() {
        // Update navbar background
        const navbar = document.querySelector('.navbar-custom');
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-link');
        const scrollPos = window.scrollY + 150;

        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }

        // Update active navigation
        sections.forEach(section => {
            const top = section.offsetTop;
            const bottom = top + section.offsetHeight;
            const id = section.getAttribute('id');

            if (scrollPos >= top && scrollPos < bottom) {
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === `#${id}`) {
                        link.classList.add('active');
                    }
                });
            }
        });

        // Trigger animations for newly visible elements
        triggerScrollAnimation();
    }

    function handleResize() {
        // Reinitialize masonry layout if needed
        if (map) {
            map.invalidateSize();
        }
    }

    // Utility Functions
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Error Handling
    function handleImageError(img) {
        img.src = `data:image/svg+xml;base64,${btoa(`
            <svg width="400" height="300" xmlns="http://www.w3.org/2000/svg">
                <rect width="100%" height="100%" fill="#f3f4f6"/>
                <text x="50%" y="50%" font-family="Arial, sans-serif" font-size="18"
                      fill="#6b7280" text-anchor="middle" dy=".3em">
                    Gambar tidak tersedia
                </text>
            </svg>
        `)}`;
        img.alt = 'Gambar tidak tersedia';
    }

    // Set up global error handlers
    function handleImageErrors() {
        document.addEventListener('error', function(e) {
            if (e.target.tagName === 'IMG') {
                handleImageError(e.target);
            }
        }, true);
    }

    // Performance optimizations
    function lazyLoadImages() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.removeAttribute('data-src');
                            observer.unobserve(img);
                        }
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    }

    // Initialize lazy loading
    document.addEventListener('DOMContentLoaded', lazyLoadImages);

    // Analytics and tracking (placeholder)
    function trackEvent(category, action, label) {
        // Analytics tracking would go here
        console.log(`Track: ${category} - ${action} - ${label}`);
    }

    // Add tracking to buttons
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('btn-whatsapp-modern')) {
            trackEvent('Contact', 'WhatsApp Click', 'Product Inquiry');
        } else if (e.target.classList.contains('btn-load-more')) {
            trackEvent('Content', 'Load More', e.target.id);
        }
    });

    // Accessibility improvements
    function improveAccessibility() {
        // Add proper ARIA labels
        document.querySelectorAll('.product-card-modern').forEach((card, index) => {
            card.setAttribute('aria-label', `Produk ${index + 1}`);
            card.setAttribute('role', 'article');
        });
    }

    // Initialize accessibility improvements
    document.addEventListener('DOMContentLoaded', improveAccessibility);

    // Page visibility handling for performance
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            // Pause heavy operations when page is hidden
        } else {
            // Resume operations when page is visible
        }
    });

    // Network status handling
    window.addEventListener('online', () => {
        console.log('Connection restored');
        // Retry failed requests
    });

    window.addEventListener('offline', () => {
        console.log('Connection lost');
        // Show offline message
    });

    // Memory cleanup
    window.addEventListener('beforeunload', () => {
        // Clean up event listeners and resources
        if (map) {
            map.remove();
        }
    });

    console.log('✅ Profile page initialized successfully with Laravel data!');
</script>
</body>
</html>
