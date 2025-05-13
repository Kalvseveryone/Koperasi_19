<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/images/logoadakita.png') }}">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f1f1f1;
            font-family: 'Arial', sans-serif;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 3rem;
        }

        .card-title {
            font-size: 1.75rem;
            color: #2a7a7e;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form-control {
            border-radius: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #2a7a7e;
            border-color: #2a7a7e;
            border-radius: 25px;
            padding: 10px 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #2a7a7e;
            border-color: #2a7a7e;
            transform: scale(1.05);
        }

        label {
            font-weight: 600;
        }

        .container {
            max-width: 500px;
            margin-top: 20px;
        }

        .mb-3 {
            margin-bottom: 20px;
        }

        .alert {
            border-radius: 15px;
        }

        .logo {
            max-width: 60%;
            height: auto;
            display: block;
            margin: 0 auto 20px;
            /* Center logo and add margin below it */
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card">
            <div class="card-body">
                <!-- Logo above the login form -->
                <div class="sidebar" id="sidebar">
                    <div class="text-center mb-4">
                        <img src="{{ asset('img/images/logoadakita.png') }}" alt="Logo" class="img-fluid" width="140">
                        <h6 class="mt-2 text-dark">Adakita Koperasi</h6>
                    </div>


                    <h5 class="card-title">Login ADMIN</h5>

                    <!-- Display validation errors if any -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form method="POST" action="{{ url('login') }}">
                        @csrf

                        <!-- Email input -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                placeholder="Enter your email" required autofocus>
                        </div>

                        <!-- Password input -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Enter your password" required>
                        </div>

                        <!-- Remember me checkbox -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" id="remember" class="form-check-input">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>

                        <!-- Login button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>