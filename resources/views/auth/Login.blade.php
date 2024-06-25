<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100vw;
        }

        .login-container {
            width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-container form label {
            font-weight: bold;
        }

        .login-container form button[type="submit"] {
            width: 100%;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <form id="loginForm">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $('#loginForm').submit(function(e) {
                e.preventDefault();

                var username = $('#username').val();
                var password = $('#password').val();

                $.ajax({
                    url: '/api/login',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    contentType: 'application/json',
                    data: JSON.stringify({
                        username: username,
                        password: password
                    }),
                    success: function(response) {
                        if (username == "admin" && password == "admin") {
                            localStorage.setItem('token', response.token);
                            localStorage.setItem('abilities', "admin");
                            window.location.href = '/book';
                        } else {
                            alert('Login failed: invalid credentials');
                        }
                    },
                    error: function(response) {
                        console.log(response, "error");
                        // Handle error response
                        alert('Login failed: ' + response.responseJSON.message);
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Periksa apakah ada token dan abilities di localStorage
            const token = localStorage.getItem('token');
            const abilities = localStorage.getItem('abilities');

            // Jika tidak ada token atau abilities, alihkan ke halaman login
            if (token != 'undefined' && abilities === 'admin') {
                window.location.href = '/book'; // Sesuaikan dengan route login Anda
            }
        });
    </script>
</body>

</html>