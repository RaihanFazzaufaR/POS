<!DOCTYPE html>
<html lang="en">
<head>
    <title>CRUD Laravel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        html{
            height: 100%;
        }
        body{
            height: 100%;
            margin: 0;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .bg-gradient {
            background: linear-gradient(0deg, #ffdcb0 10%, #ffffff 100%);
        }
        table {
            width: 100%;
        }
        td {
            padding: 10px;
        }
        thead {
            background-color: #ffe37c;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 15px;
        }
    </style>
</head>
<body class="bg-gradient">
    <div class="container">
        @yield('content')
    </div>
</body>
</html>