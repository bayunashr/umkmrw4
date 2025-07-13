<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Digital UMKM - Surabaya</title>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            overflow: hidden;
        }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 75px;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 25px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.06);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .logo {
            font-size: 26px;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo i {
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Header Search */
        .header-search {
            flex: 1;
            max-width: 500px;
            margin: 0 30px;
            position: relative;
        }

        .search-container {
            position: relative;
            width: 100%;
        }

        .search-box {
            position: relative;
            background: rgba(248, 250, 252, 0.9);
            border-radius: 25px;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .search-box:focus-within {
            border-color: #667eea;
            background: white;
            box-shadow: 0 10px 40px rgba(102, 126, 234, 0.15);
        }

        .search-input {
            width: 100%;
            padding: 15px 25px 15px 55px;
            border: none;
            outline: none;
            font-size: 16px;
            background: transparent;
            color: #1e293b;
        }

        .search-input::placeholder {
            color: #64748b;
        }

        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-size: 18px;
        }

        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            max-height: 400px;
            overflow-y: auto;
            margin-top: 10px;
            display: none;
            z-index: 1001;
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        .search-item {
            padding: 18px 25px;
            border-bottom: 1px solid #f1f5f9;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-item:hover {
            background: #f8fafc;
            transform: translateX(5px);
        }

        .search-item:last-child {
            border-bottom: none;
        }

        .search-item-title {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 4px;
            font-size: 15px;
        }

        .search-item-address {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 4px;
        }

        .search-item-desc {
            font-size: 12px;
            color: #94a3b8;
        }

        /* Info Panel - Top Right */
        .info-panel {
            position: fixed;
            top: 95px;
            right: 25px;
            width: 320px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            z-index: 999;
            transform: translateX(350px);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .info-panel.active {
            transform: translateX(0);
        }

        .info-toggle {
            position: fixed;
            top: 100px;
            right: 25px;
            z-index: 1001;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            width: 55px;
            height: 55px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .info-toggle:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 40px rgba(102, 126, 234, 0.4);
        }

        .info-panel.active + .info-toggle {
            right: 370px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 15px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.25);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            pointer-events: none;
        }

        .stat-number {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 5px;
            position: relative;
            z-index: 1;
        }

        .stat-label {
            font-size: 11px;
            opacity: 0.95;
            font-weight: 500;
            position: relative;
            z-index: 1;
        }

        /* Categories */
        .categories-section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: #667eea;
        }

        .category-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .category-item {
            background: white;
            padding: 12px 15px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 2px solid transparent;
        }

        .category-item:hover {
            border-color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
        }

        .category-item.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .category-count {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 600;
        }

        .category-item:hover .category-count,
        .category-item.active .category-count {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        /* Map */
        #map {
            height: calc(100vh - 75px);
            margin-top: 75px;
            width: 100%;
        }

        /* Custom cluster styles */
        .marker-cluster-small {
            background-color: rgba(102, 126, 234, 0.8) !important;
            border: 3px solid rgba(102, 126, 234, 1) !important;
        }

        .marker-cluster-medium {
            background-color: rgba(102, 126, 234, 0.8) !important;
            border: 3px solid rgba(102, 126, 234, 1) !important;
        }

        .marker-cluster-large {
            background-color: rgba(102, 126, 234, 0.8) !important;
            border: 3px solid rgba(102, 126, 234, 1) !important;
        }

        .marker-cluster div {
            background-color: rgba(102, 126, 234, 1) !important;
            color: white !important;
            font-weight: 600 !important;
        }

        /* Floating Action Buttons - Right Bottom */
        .fab-container {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .fab {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.3);
        }

        .fab:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 40px rgba(102, 126, 234, 0.4);
        }

        /* Custom marker with label */
        .custom-marker-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            pointer-events: none;
        }

        .marker-icon {
            background: linear-gradient(135deg, #667eea, #764ba2);
            width: 35px;
            height: 35px;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .marker-label {
            background: rgba(255, 255, 255, 0.95);
            color: #1e293b;
            padding: 4px 8px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            white-space: nowrap;
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Custom Popup Styles */
        .leaflet-popup-content {
            margin: 0;
            padding: 0;
            width: 320px !important;
        }

        .popup-container {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        .popup-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 25px;
            position: relative;
        }

        .popup-logo {
            width: 65px;
            height: 65px;
            border-radius: 16px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: 20px;
            right: 25px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .popup-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
            padding-right: 85px;
            line-height: 1.3;
        }

        .popup-address {
            font-size: 14px;
            opacity: 0.95;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
        }

        .popup-body {
            padding: 25px;
            background: white;
        }

        .popup-description {
            color: #64748b;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .popup-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .popup-info-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #667eea;
            font-size: 14px;
            font-weight: 500;
        }

        .popup-products {
            margin-bottom: 20px;
        }

        .popup-products-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #1e293b;
        }

        .popup-product-item {
            font-size: 13px;
            color: #64748b;
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
            font-weight: 500;
        }

        .popup-product-item:last-child {
            border-bottom: none;
        }

        .popup-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .popup-button {
            padding: 15px 20px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .popup-button.primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .popup-button.primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
            color: white;
            text-decoration: none;
        }

        .popup-button.secondary {
            background: #f8fafc;
            color: #64748b;
            border: 2px solid #e2e8f0;
        }

        .popup-button.secondary:hover {
            background: white;
            color: #667eea;
            border-color: #667eea;
            text-decoration: none;
            transform: translateY(-2px);
        }

        /* Loading */
        .loading-container {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            backdrop-filter: blur(10px);
        }

        .loading-content {
            text-align: center;
        }

        .loading-spinner {
            width: 70px;
            height: 70px;
            border: 4px solid #f1f5f9;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        .loading-text {
            color: #64748b;
            font-weight: 500;
            font-size: 16px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header {
                padding: 0 15px;
            }

            .logo {
                font-size: 20px;
            }

            .header-search {
                max-width: 300px;
                margin: 0 15px;
            }

            .info-panel {
                top: 90px;
                right: 15px;
                left: 15px;
                width: auto;
                transform: translateY(-400px);
            }

            .info-panel.active {
                transform: translateY(0);
            }

            .info-toggle {
                top: 90px;
                right: 15px;
            }

            .info-panel.active + .info-toggle {
                right: 15px;
                top: 90px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .stat-card {
                padding: 15px 10px;
            }

            .stat-number {
                font-size: 20px;
            }

            .stat-label {
                font-size: 10px;
            }

            .fab-container {
                bottom: 20px;
                right: 20px;
            }

            .fab {
                width: 55px;
                height: 55px;
                font-size: 18px;
            }

            .popup-container {
                width: 280px !important;
            }

            .popup-header {
                padding: 20px;
            }

            .popup-body {
                padding: 20px;
            }

            .popup-info {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .marker-label {
                font-size: 10px;
                max-width: 100px;
                padding: 3px 6px;
            }

            .marker-icon {
                width: 30px;
                height: 30px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
<!-- Loading Screen -->
<div class="loading-container" id="loadingScreen">
    <div class="loading-content">
        <div class="loading-spinner"></div>
        <div class="loading-text">Memuat Peta UMKM...</div>
    </div>
</div>

<!-- Header -->
<div class="header">
    <div class="logo">
        <i class="fas fa-map-marked-alt"></i>
        UMKM Banjarsugihan
    </div>

    <!-- Search -->
    <div class="header-search">
        <div class="search-container">
            <div class="search-box">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Cari UMKM berdasarkan nama, alamat, atau deskripsi..." id="searchInput">
                <div class="search-results" id="searchResults"></div>
            </div>
        </div>
    </div>
</div>

<!-- Info Panel - Top Right -->
<div class="info-panel" id="infoPanel">
    <!-- Stats Section -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $stats['total_umkm'] }}</div>
            <div class="stat-label">Total UMKM</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['total_products'] }}</div>
            <div class="stat-label">Total Produk</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['new_umkm_today'] }}</div>
            <div class="stat-label">Baru Hari Ini</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['areas_covered'] }}</div>
            <div class="stat-label">Area Terlayani</div>
        </div>
    </div>

    <!-- Categories -->
    <div class="categories-section">
        <div class="section-title">
            <i class="fas fa-tags"></i>
            Kategori
        </div>
        <div class="category-list">
            <div class="category-item active" onclick="filterByCategory(null, this)">
                <span>Semua Kategori</span>
                <span class="category-count">{{ $stats['total_umkm'] }}</span>
            </div>
            @foreach($categories as $category)
                <div class="category-item" onclick="filterByCategory('{{ $category['keyword'] }}', this)">
                    <span>{{ $category['name'] }}</span>
                    <span class="category-count">{{ $category['count'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Info Panel Toggle -->
<button class="info-toggle" onclick="toggleInfoPanel()">
    <i class="fas fa-info"></i>
</button>

<!-- Map Container -->
<div id="map"></div>

<!-- Floating Action Buttons - Right Bottom -->
<div class="fab-container">
    <button class="fab" onclick="locateUser()" title="Lokasi Saya">
        <i class="fas fa-crosshairs"></i>
    </button>
    <button class="fab" onclick="resetZoom()" title="Reset Zoom">
        <i class="fas fa-home"></i>
    </button>
    <button class="fab" onclick="showAllUmkm()" title="Tampilkan Semua">
        <i class="fas fa-eye"></i>
    </button>
    <button class="fab" onclick="toggleHeatmap()" title="Heatmap">
        <i class="fas fa-fire"></i>
    </button>
</div>

<!-- Scripts -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
<script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Global variables
    let map;
    let markers = {};
    let markerCluster;
    let heatmapLayer;
    let isHeatmapVisible = false;
    let currentCategory = null;

    // Initialize map
    function initMap() {
        try {
            // Hide loading screen first
            const loadingScreen = document.getElementById('loadingScreen');
            if (loadingScreen) {
                loadingScreen.style.display = 'none';
            }

            // Check if map container exists
            const mapContainer = document.getElementById('map');
            if (!mapContainer) {
                console.error('Map container not found');
                return;
            }

            // Initialize map
            map = L.map('map', {
                center: [-7.2575, 112.6804],
                zoom: 13,
                zoomControl: true
            });

            // Add tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19,
                subdomains: ['a', 'b', 'c']
            }).addTo(map);

            // Initialize marker cluster with custom colors
            markerCluster = L.markerClusterGroup({
                chunkedLoading: true,
                maxClusterRadius: 60,
                spiderfyOnMaxZoom: false,
                showCoverageOnHover: false,
                zoomToBoundsOnClick: true,
                iconCreateFunction: function(cluster) {
                    const count = cluster.getChildCount();
                    let size = 'small';
                    if (count >= 10) size = 'medium';
                    if (count >= 100) size = 'large';

                    return new L.DivIcon({
                        html: '<div><span>' + count + '</span></div>',
                        className: 'marker-cluster marker-cluster-' + size,
                        iconSize: new L.Point(40, 40)
                    });
                }
            });

            // Load UMKM data
            loadUmkmData();

            // Force map resize after initialization
            setTimeout(() => {
                map.invalidateSize();
            }, 250);

            console.log('Map initialized successfully');

        } catch (error) {
            console.error('Error initializing map:', error);
            // Remove loading screen even if map fails
            const loadingScreen = document.getElementById('loadingScreen');
            if (loadingScreen) {
                loadingScreen.style.display = 'none';
            }
        }
    }

    // UMKM data from Laravel
    const umkms = @json($umkms);

    function loadUmkmData() {
        markerCluster.clearLayers();
        markers = {};

        const heatmapData = [];

        umkms.forEach(umkm => {
            if (umkm.latitude && umkm.longitude) {
                // Create custom marker with label
                const marker = createCustomMarkerWithLabel(umkm);
                markers[umkm.id] = marker;
                markerCluster.addLayer(marker);

                // Add to heatmap data
                heatmapData.push([umkm.latitude, umkm.longitude, 1]);
            }
        });

        map.addLayer(markerCluster);

        // Create heatmap layer
        heatmapLayer = L.heatLayer(heatmapData, {
            radius: 25,
            blur: 15,
            maxZoom: 17,
            gradient: {0.2: 'blue', 0.4: 'cyan', 0.6: 'lime', 0.8: 'yellow', 1.0: 'red'}
        });
    }

    function createCustomMarkerWithLabel(umkm) {
        // Create marker with name label
        const markerHtml = `
                <div class="custom-marker-container">
                    <div class="marker-icon">
                        <i class="fas fa-store"></i>
                    </div>
                    <div class="marker-label">${umkm.name.length > 15 ? umkm.name.substring(0, 15) + '...' : umkm.name}</div>
                </div>
            `;

        const icon = L.divIcon({
            html: markerHtml,
            iconSize: [120, 60],
            iconAnchor: [60, 60],
            className: 'custom-marker-with-label',
            popupAnchor: [0, -60]
        });

        const marker = L.marker([umkm.latitude, umkm.longitude], { icon });

        // Create popup content
        const popupContent = createPopupContent(umkm);
        marker.bindPopup(popupContent, {
            maxWidth: 320,
            className: 'custom-popup',
            offset: [0, -10]
        });

        return marker;
    }

    function createPopupContent(umkm) {
        const logoUrl = umkm.logo_path ? `/storage/${umkm.logo_path}` : '/images/default-logo.png';
        const products = umkm.products || [];

        let productsHtml = '';
        if (products.length > 0) {
            productsHtml = `
                    <div class="popup-products">
                        <div class="popup-products-title">Produk Terbaru:</div>
                        ${products.map(product => `
                            <div class="popup-product-item">
                                ${product.name} ${product.price ? `- Rp ${parseInt(product.price).toLocaleString('id-ID')}` : ''}
                            </div>
                        `).join('')}
                    </div>
                `;
        }

        return `
                <div class="popup-container">
                    <div class="popup-header">
                        <div class="popup-logo">
                            <img src="${logoUrl}" alt="${umkm.name}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 16px;" onerror="this.src='/images/default-logo.png'">
                        </div>
                        <div class="popup-title">${umkm.name}</div>
                        <div class="popup-address">
                            <i class="fas fa-map-marker-alt"></i>
                            ${umkm.address || 'Alamat tidak tersedia'}
                        </div>
                    </div>
                    <div class="popup-body">
                        <div class="popup-description">
                            ${umkm.description ? umkm.description.substring(0, 140) + '...' : 'Tidak ada deskripsi'}
                        </div>
                        <div class="popup-info">
                            <div class="popup-info-item">
                                <i class="fas fa-phone"></i>
                                ${umkm.phone || 'No. telp tidak tersedia'}
                            </div>
                            <div class="popup-info-item">
                                <i class="fas fa-calendar"></i>
                                ${new Date(umkm.created_at).toLocaleDateString('id-ID')}
                            </div>
                        </div>
                        ${productsHtml}
                        <div class="popup-actions">
                            <a href="/umkm/${umkm.slug}" class="popup-button primary">
                                <i class="fas fa-eye"></i>
                                Lihat Profil
                            </a>
                            <a href="tel:${umkm.phone}" class="popup-button secondary">
                                <i class="fas fa-phone"></i>
                                Hubungi
                            </a>
                        </div>
                    </div>
                </div>
            `;
    }

    // Search functionality
    function setupSearch() {
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        let searchTimeout;

        if (!searchInput || !searchResults) return;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            if (query.length < 2) {
                searchResults.style.display = 'none';
                return;
            }

            searchTimeout = setTimeout(() => {
                performSearch(query);
            }, 300);
        });

        // Hide results when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.search-container')) {
                searchResults.style.display = 'none';
            }
        });
    }

    function performSearch(query) {
        const filteredUmkms = umkms.filter(umkm =>
            umkm.name.toLowerCase().includes(query.toLowerCase()) ||
            (umkm.description && umkm.description.toLowerCase().includes(query.toLowerCase())) ||
            (umkm.address && umkm.address.toLowerCase().includes(query.toLowerCase()))
        );

        displaySearchResults(filteredUmkms);
    }

    function displaySearchResults(results) {
        const searchResults = document.getElementById('searchResults');
        searchResults.innerHTML = '';

        if (results.length === 0) {
            searchResults.innerHTML = '<div class="search-item">Tidak ada UMKM ditemukan</div>';
            searchResults.style.display = 'block';
            return;
        }

        results.forEach(umkm => {
            const item = document.createElement('div');
            item.className = 'search-item';
            item.innerHTML = `
                    <div class="search-item-title">${umkm.name}</div>
                    <div class="search-item-address">${umkm.address || 'Alamat tidak tersedia'}</div>
                    <div class="search-item-desc">${umkm.description ? umkm.description.substring(0, 80) + '...' : ''}</div>
                `;

            item.addEventListener('click', () => {
                if (markers[umkm.id]) {
                    map.setView([umkm.latitude, umkm.longitude], 16);
                    markers[umkm.id].openPopup();
                }

                searchResults.style.display = 'none';
                document.getElementById('searchInput').value = umkm.name;
            });

            searchResults.appendChild(item);
        });

        searchResults.style.display = 'block';
    }

    // Info panel toggle
    function toggleInfoPanel() {
        const infoPanel = document.getElementById('infoPanel');
        infoPanel.classList.toggle('active');

        const icon = document.querySelector('.info-toggle i');
        icon.className = infoPanel.classList.contains('active') ? 'fas fa-times' : 'fas fa-info';
    }

    // Category filtering
    function filterByCategory(category, element) {
        currentCategory = category;

        // Update active category
        document.querySelectorAll('.category-item').forEach(item => {
            item.classList.remove('active');
        });
        element.classList.add('active');

        // Filter markers
        markerCluster.clearLayers();

        const filteredUmkms = category === null ? umkms : umkms.filter(umkm =>
            umkm.description && umkm.description.toLowerCase().includes(category.toLowerCase())
        );

        filteredUmkms.forEach(umkm => {
            if (umkm.latitude && umkm.longitude && markers[umkm.id]) {
                markerCluster.addLayer(markers[umkm.id]);
            }
        });

        // Fit bounds if filtered
        if (category !== null && markerCluster.getLayers().length > 0) {
            map.fitBounds(markerCluster.getBounds(), { padding: [20, 20] });
        }
    }

    // FAB functions
    function showAllUmkm() {
        if (map.hasLayer(heatmapLayer)) {
            map.removeLayer(heatmapLayer);
            isHeatmapVisible = false;
        }

        // Show all markers
        markerCluster.clearLayers();
        umkms.forEach(umkm => {
            if (umkm.latitude && umkm.longitude && markers[umkm.id]) {
                markerCluster.addLayer(markers[umkm.id]);
            }
        });

        // Reset category filter
        currentCategory = null;
        document.querySelectorAll('.category-item').forEach(item => {
            item.classList.remove('active');
        });
        document.querySelector('.category-item').classList.add('active');

        // Fit bounds to show all markers
        if (markerCluster.getLayers().length > 0) {
            map.fitBounds(markerCluster.getBounds(), { padding: [20, 20] });
        }
    }

    function locateUser() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                position => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    map.setView([lat, lng], 16);

                    // Add user location marker
                    const userMarker = L.marker([lat, lng], {
                        icon: L.divIcon({
                            html: '<div style="background: #ef4444; width: 25px; height: 25px; border-radius: 50%; border: 3px solid white; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4); animation: pulse 2s infinite;"></div>',
                            iconSize: [25, 25],
                            className: 'user-location-marker'
                        })
                    }).addTo(map);

                    userMarker.bindPopup('📍 Lokasi Anda').openPopup();

                    // Remove marker after 10 seconds
                    setTimeout(() => {
                        map.removeLayer(userMarker);
                    }, 10000);
                },
                error => {
                    alert('Tidak dapat mengakses lokasi Anda. Pastikan GPS aktif dan izinkan akses lokasi.');
                }
            );
        } else {
            alert('Geolocation tidak didukung browser Anda');
        }
    }

    function resetZoom() {
        map.setView([-7.2575, 112.6804], 13);
        showAllUmkm();
    }

    function toggleHeatmap() {
        if (isHeatmapVisible) {
            map.removeLayer(heatmapLayer);
            map.addLayer(markerCluster);
            isHeatmapVisible = false;
        } else {
            map.removeLayer(markerCluster);
            map.addLayer(heatmapLayer);
            isHeatmapVisible = true;
        }
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Hide loading immediately when DOM is ready
        document.getElementById('loadingScreen').style.display = 'none';

        // Setup search
        setupSearch();

        // Delay map initialization to ensure DOM is fully ready
        setTimeout(() => {
            initMap();
        }, 100);
    });

    // Mobile responsive
    window.addEventListener('resize', function() {
        if (map) {
            setTimeout(() => {
                map.invalidateSize();
            }, 100);
        }
    });

    // Fallback: Initialize map if not loaded after 2 seconds
    setTimeout(() => {
        if (!map) {
            initMap();
        }
    }, 2000);

    // Add pulse animation for user location
    const style = document.createElement('style');
    style.textContent = `
            @keyframes pulse {
                0% { transform: scale(1); opacity: 1; }
                50% { transform: scale(1.2); opacity: 0.7; }
                100% { transform: scale(1); opacity: 1; }
            }
        `;
    document.head.appendChild(style);
</script>
</body>
</html>
