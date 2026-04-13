<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MyShop Auth</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #f8f9fa, #ffffff);
        }

        .auth-card {
            backdrop-filter: blur(10px);
            background: rgba(255,255,255,0.9);
            border-radius: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        @yield('content')
    </div>

</body>
</html>