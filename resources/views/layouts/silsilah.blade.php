<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Silsilah Keluarga</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@400;500;600;700&family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #81B29A;
            --primary-hover: #6D9A84;
            --secondary: #E07A5F;
            --secondary-hover: #C86B52;
            --background: #FDFBF7;
            --foreground: #3D405B;
            --muted: #F4F1DE;
            --muted-foreground: #8D909B;
            --card: #FFFFFF;
            --border: #EAE6D8;
            --male: #3D5A80;
            --female: #EE6C4D;
            --deceased: #989898;
            --shadow-soft: 0 4px 20px -2px rgba(61, 64, 91, 0.08);
            --shadow-hover: 0 10px 30px -5px rgba(61, 64, 91, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            overflow: hidden;
            font-family: 'Nunito', sans-serif;
            background: var(--background);
            color: var(--foreground);
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Fraunces', serif;
            font-weight: 600;
        }

        /* Modern Navbar */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 0.75rem 1rem;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .navbar-brand-custom {
            font-family: 'Fraunces', serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--foreground);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
        }

        .navbar-brand-custom:hover {
            color: var(--primary);
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            box-shadow: 0 4px 12px rgba(129, 178, 154, 0.3);
        }

        /* Tree Container */
        .tree-container {
            width: 100vw;
            height: calc(100vh - 70px);
            margin-top: 70px;
            overflow: auto;
            background: var(--background);
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(129, 178, 154, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(224, 122, 95, 0.06) 0%, transparent 50%),
                radial-gradient(circle at 50% 80%, rgba(244, 241, 222, 0.5) 0%, transparent 50%);
            padding: 2rem;
            position: relative;
        }

        @media (min-width: 768px) {
            .tree-container {
                padding: 3rem 4rem;
            }
        }

        .tree {
            display: inline-block;
            min-width: 100%;
            padding: 2rem 0;
        }

        .tree ul {
            padding-top: 2rem;
            position: relative;
            display: flex;
            justify-content: center;
            padding-left: 0;
            transition: all 0.3s ease;
        }

        .tree li {
            float: left;
            text-align: center;
            list-style-type: none;
            position: relative;
            padding: 2rem 0.75rem 0 0.75rem;
        }

        @media (max-width: 768px) {
            .tree li {
                padding: 1.5rem 0.5rem 0 0.5rem;
            }
        }

        /* Modern Tree Lines */
        .tree li::before,
        .tree li::after {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            border-top: 2px solid var(--border);
            width: 50%;
            height: 2rem;
            transition: all 0.3s ease;
        }

        .tree li::after {
            right: auto;
            left: 50%;
            border-left: 2px solid var(--border);
        }

        .tree li:hover::before,
        .tree li:hover::after {
            border-color: var(--primary);
        }

        .tree li:only-child::after,
        .tree li:only-child::before {
            display: none;
        }

        .tree li:only-child {
            padding-top: 0;
        }

        .tree li:first-child::before,
        .tree li:last-child::after {
            border: 0 none;
        }

        .tree li:last-child::before {
            border-right: 2px solid var(--border);
            border-radius: 0 12px 0 0;
        }

        .tree li:first-child::after {
            border-radius: 12px 0 0 0;
        }

        .tree ul ul::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            border-left: 2px solid var(--border);
            width: 0;
            height: 2rem;
        }

        /* Node Group */
        .node-group {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            position: relative;
        }

        /* Modern Node Card */
        .node {
            background: var(--card);
            border: 2px solid var(--male);
            border-radius: 20px;
            padding: 1rem;
            min-width: 140px;
            max-width: 180px;
            position: relative;
            z-index: 10;
            white-space: normal;
            box-shadow: var(--shadow-soft);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .node {
                min-width: 110px;
                max-width: 140px;
                padding: 0.75rem;
                border-radius: 16px;
            }
        }

        .node:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow: var(--shadow-hover);
        }

        .node img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 0.5rem;
            border: 3px solid white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        @media (max-width: 768px) {
            .node img {
                width: 45px;
                height: 45px;
            }
        }

        .node:hover img {
            transform: scale(1.1);
            box-shadow: 0 6px 16px rgba(0,0,0,0.15);
        }

        .node.female {
            border-color: var(--female);
        }

        .node.deceased {
            background: linear-gradient(135deg, #f5f5f5, #e8e8e8);
            opacity: 0.85;
        }

        .node.deceased:not(.female) {
            border-color: var(--male);
        }

        .node.female.deceased {
            border-color: var(--female);
        }

        .node.deceased::after {
            content: '';
            position: absolute;
            top: 8px;
            right: 8px;
            width: 10px;
            height: 10px;
            background: var(--deceased);
            border-radius: 50%;
        }

        .node-name {
            font-family: 'Fraunces', serif;
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--foreground);
            line-height: 1.3;
            margin-top: 0.25rem;
        }

        @media (max-width: 768px) {
            .node-name {
                font-size: 0.75rem;
            }
        }

        /* Default Avatar */
        .default-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.5rem;
            font-size: 1.5rem;
            color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            .default-avatar {
                width: 45px;
                height: 45px;
                font-size: 1.2rem;
            }
        }

        .default-avatar.male {
            background: linear-gradient(135deg, var(--male), #4a6fa5);
        }

        .default-avatar.female {
            background: linear-gradient(135deg, var(--female), #f08a6d);
        }

        /* Spouse Connector */
        .connector-spouse {
            width: 30px;
            height: 3px;
            background: linear-gradient(90deg, var(--male), var(--female));
            border-radius: 4px;
            margin: 0 -8px;
            position: relative;
        }

        .connector-spouse::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 12px;
            height: 12px;
            background: white;
            border: 2px solid var(--secondary);
            border-radius: 50%;
        }

        /* Action Buttons */
        .btn-circle {
            width: 32px;
            height: 32px;
            padding: 0;
            border-radius: 50%;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            .btn-circle {
                width: 28px;
                height: 28px;
                font-size: 0.75rem;
            }
        }

        .btn-circle:hover {
            transform: scale(1.15);
        }

        .btn-circle-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            color: white;
        }

        .btn-circle-secondary {
            background: linear-gradient(135deg, var(--secondary), var(--secondary-hover));
            color: white;
        }

        .btn-circle-info {
            background: linear-gradient(135deg, #5DADE2, #3498DB);
            color: white;
        }

        .btn-circle-warning {
            background: linear-gradient(135deg, #F5B041, #E67E22);
            color: white;
        }

        /* Trace Button */
        .btn-trace {
            position: absolute;
            top: 6px;
            left: 6px;
            border: none;
            background: rgba(255, 255, 255, 0.9);
            color: var(--muted-foreground);
            border-radius: 8px;
            width: 24px;
            height: 24px;
            font-size: 0.65rem;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 15;
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .btn-trace:hover {
            background: var(--primary);
            color: white;
            transform: scale(1.1);
        }

        /* Modern Modal Styles */
        .modal-content {
            border: none;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            color: white;
            border: none;
            padding: 1.25rem 1.5rem;
        }

        .modal-header .modal-title {
            font-family: 'Fraunces', serif;
            font-weight: 600;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }

        .modal-header .btn-close:hover {
            opacity: 1;
        }

        .modal-body {
            padding: 1.5rem;
            background: var(--background);
        }

        .modal-footer {
            background: var(--muted);
            border: none;
            padding: 1rem 1.5rem;
        }

        /* Form Controls */
        .form-control, .form-select {
            border: 2px solid var(--border);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-family: 'Nunito', sans-serif;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(129, 178, 154, 0.15);
        }

        .form-label {
            font-weight: 600;
            color: var(--foreground);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        /* Modern Buttons */
        .btn-modern {
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-family: 'Nunito', sans-serif;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.15);
        }

        .btn-modern-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            color: white;
        }

        .btn-modern-secondary {
            background: linear-gradient(135deg, var(--secondary), var(--secondary-hover));
            color: white;
        }

        .btn-modern-outline {
            background: white;
            border: 2px solid var(--border);
            color: var(--foreground);
        }

        .btn-modern-outline:hover {
            background: var(--muted);
        }

        /* Nav Tabs */
        .nav-tabs-modern {
            border: none;
            background: var(--muted);
            border-radius: 12px;
            padding: 4px;
            gap: 4px;
        }

        .nav-tabs-modern .nav-link {
            border: none;
            border-radius: 10px;
            padding: 0.6rem 1.2rem;
            color: var(--muted-foreground);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .nav-tabs-modern .nav-link:hover {
            color: var(--foreground);
            background: rgba(255,255,255,0.5);
        }

        .nav-tabs-modern .nav-link.active {
            background: white;
            color: var(--primary);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--muted);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.5s ease-out forwards;
        }

        .node {
            animation: fadeInUp 0.5s ease-out forwards;
        }

        /* Active Trace Style */
        .node.active-trace {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 4px rgba(129, 178, 154, 0.3), var(--shadow-hover) !important;
        }

        /* Badges */
        .badge-modern {
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .badge-success {
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
        }

        .badge-danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }

        /* Info Table */
        .info-table {
            width: 100%;
        }

        .info-table tr {
            border-bottom: 1px solid var(--border);
        }

        .info-table tr:last-child {
            border-bottom: none;
        }

        .info-table th, .info-table td {
            padding: 0.75rem 0.5rem;
            vertical-align: middle;
        }

        .info-table th {
            color: var(--muted-foreground);
            font-weight: 600;
            font-size: 0.85rem;
            width: 35%;
        }

        /* Profile Image in Modal */
        .profile-image-container {
            position: relative;
            display: inline-block;
        }

        .profile-image {
            width: 180px;
            height: 180px;
            border-radius: 20px;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: var(--shadow-soft);
        }

        @media (max-width: 768px) {
            .profile-image {
                width: 140px;
                height: 140px;
            }
        }

        /* Section Headers */
        .section-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--border);
        }

        .section-header i {
            color: var(--primary);
        }

        .section-header h6 {
            margin: 0;
            font-family: 'Fraunces', serif;
            font-weight: 600;
            color: var(--foreground);
        }
    </style>
</head>

<body>
    <!-- Modern Navbar -->
    <nav class="navbar-custom">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <a class="navbar-brand-custom" href="#">
                <div class="brand-icon">
                    <i class="fa-solid fa-tree"></i>
                </div>
                <span class="d-none d-md-inline">Silsilah Keluarga Besar Mbah Buyut Abdul Jalil - Karmiji</span>
                <span class="d-md-none">Silsilah Keluarga</span>
            </a>
        </div>
    </nav>

    <div class="container-fluid p-0">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    @stack('scripts')
</body>

</html>
