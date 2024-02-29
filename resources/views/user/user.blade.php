<html>
    <head>
        <title>User</title>
    </head>
    <body>
        <h1>User Page</h1>
        <p>Name : {{ $name }}</p>
        <p>ID : {{ $id }}</p>
        <br>
        <br>
        <a href="{{ route('home') }}">Home</a>
    </body>
</html>