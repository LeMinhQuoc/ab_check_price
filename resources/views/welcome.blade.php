<!DOCTYPE html>
<html>
<head>
    <title>My Homepage</title>
    <style>
        .menu {
            background-color: #333;
            overflow: hidden;
        }
        .menu a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .menu a:hover {
            background-color: #ddd;
            color: black;
        }
        .session {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="menu">
        <a href="http://localhost/AB_Check_P/public/products">Check giá</a>
        <a href="#">Chat Box AI</a>
        <a href="#">Training</a>
        <a href="#">Blog chuyện AB</a>
    </div>
    <div class="session">
        <form action="/login" method="post">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username"><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"><br>
            <input type="submit" value="Login">
        </form>
        <form action="/register" method="post">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username"><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"><br>
            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>