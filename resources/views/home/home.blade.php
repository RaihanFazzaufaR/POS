<html>
    <head>
        <title>Home</title>
    </head>
    <body>
        <h1>Home Page</h1>
        <ul>
            <li><a href="{{route('category')}}">Category</a></li>
            <li><a href="{{route('user',[1,'Raihan'])}}">User</a></li>
            <li><a href="{{route('sales')}}">Sales</a></li>
        </ul>
    </body>
</html>