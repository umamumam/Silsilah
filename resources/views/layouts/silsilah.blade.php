<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Silsilah Keluarga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }

        .tree-container {
            width: 100vw;
            height: calc(100vh - 70px);
            overflow: auto;
            /* Update Background Disini */
            background: linear-gradient(rgba(249, 249, 249, 0.8), rgba(249, 249, 249, 0.8)),
                        url("{{ asset('h2.png') }}") !important;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            padding: 100px;
            position: relative;
        }

        .tree {
            display: inline-block;
            min-width: 100%;
        }

        .tree ul {
            padding-top: 20px;
            position: relative;
            display: flex;
            justify-content: center;
            padding-left: 0;
        }

        .tree li {
            float: left;
            text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 5px 0 5px;
        }

        /* Warna garis digelapkan sedikit agar kontras dengan background */
        .tree li::before,
        .tree li::after,
        .tree ul ul::before {
            content: '';
            position: absolute;
            border-color: #777; /* Garis lebih gelap */
            border-width: 2px;
        }

        .tree li::before,
        .tree li::after {
            top: 0;
            right: 50%;
            border-top: 2px solid #777;
            width: 50%;
            height: 20px;
        }

        .tree li::after {
            right: auto;
            left: 50%;
            border-left: 2px solid #777;
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
            border-right: 2px solid #777;
            border-radius: 0 5px 0 0;
        }

        .tree li:first-child::after {
            border-radius: 5px 0 0 0;
        }

        .tree ul ul::before {
            top: 0;
            left: 50%;
            border-left: 2px solid #777;
            width: 0;
            height: 20px;
        }

        .node-group {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            position: relative;
        }

        .node {
            border: 2px solid #0d6efd;
            border-radius: 8px;
            padding: 8px;
            background: rgba(255, 255, 255, 0.95); /* Sedikit transparan agar menyatu */
            min-width: 140px;
            max-width: 160px;
            position: relative;
            z-index: 10;
            white-space: normal;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .node img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 5px;
            border: 1px solid #ddd;
        }

        .node.female {
            border-color: #dc3545;
        }

        .node.deceased {
            background: #e9ecef;
            border-color: #6c757d;
        }

        .connector-spouse {
            width: 20px;
            height: 2px;
            background: #777;
            margin: 0 -5px;
        }

        .btn-circle {
            width: 26px;
            height: 26px;
            padding: 0;
            border-radius: 50%;
            font-size: 12px;
            line-height: 26px;
        }

        .btn-trace {
            position: absolute;
            top: 2px;
            left: 2px;
            border: none;
            background: rgba(0, 0, 0, 0.1);
            color: #666;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            transition: 0.2s;
        }

        .btn-trace:hover {
            background: #0d6efd;
            color: white;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fa-solid fa-tree me-2"></i>Silsilah Keluarga Besar Mbah Buyut Abdul Jalil - Karmiji</a>
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
