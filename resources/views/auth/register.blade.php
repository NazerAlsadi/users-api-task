<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 500px;">
    <div class="card shadow">
        <div class="card-body">

            <h3 class="text-center mb-4">Create Account</h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $e)
                        <div>{{ $e }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register.submit') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation" required>
                </div>

                <button class="btn btn-success w-100">Register</button>
            </form>

            <p class="mt-3 text-center">
                Already have an account?
                <a href="{{ route('login') }}">Login</a>
            </p>

        </div>
    </div>
</div>

</body>
</html>
