<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Darussalam Laundry</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15), transparent 70%);
            top: -150px; right: -100px;
            border-radius: 50%;
        }
        body::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.1), transparent 70%);
            bottom: -100px; left: -100px;
            border-radius: 50%;
        }
        .login-container {
            position: relative; z-index: 1;
            width: 100%; max-width: 420px;
            padding: 20px;
        }
        .login-card {
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.4);
        }
        .login-header { text-align: center; margin-bottom: 36px; }
        .login-icon {
            width: 72px; height: 72px;
            background: linear-gradient(135deg, #6366f1, #0ea5e9);
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.3);
        }
        .login-icon i { font-size: 32px; color: #fff; }
        .login-header h1 {
            color: #f1f5f9; font-size: 22px; font-weight: 700;
            margin-bottom: 6px;
        }
        .login-header p { color: #94a3b8; font-size: 14px; }
        .form-group { margin-bottom: 20px; }
        .form-group label {
            display: block; color: #cbd5e1; font-size: 13px;
            font-weight: 500; margin-bottom: 8px;
        }
        .input-wrapper {
            position: relative;
        }
        .input-wrapper i {
            position: absolute; left: 16px; top: 50%; transform: translateY(-50%);
            color: #64748b; font-size: 16px; transition: color 0.3s;
        }
        .input-wrapper input {
            width: 100%; padding: 14px 16px 14px 48px;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(100, 116, 139, 0.3);
            border-radius: 12px; color: #f1f5f9;
            font-size: 14px; font-family: 'Inter', sans-serif;
            transition: all 0.3s;
            outline: none;
        }
        .input-wrapper input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }
        .input-wrapper input:focus + i,
        .input-wrapper input:focus ~ i { color: #6366f1; }
        .input-wrapper input::placeholder { color: #475569; }
        .btn-login {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: #fff; border: none; border-radius: 12px;
            font-size: 15px; font-weight: 600; cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s; margin-top: 8px;
            box-shadow: 0 4px 16px rgba(99, 102, 241, 0.3);
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.4);
        }
        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px; padding: 12px 16px;
            color: #fca5a5; font-size: 13px;
            margin-bottom: 20px;
            display: flex; align-items: center; gap: 10px;
        }
        .alert-error i { color: #ef4444; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-icon">
                    <i class="fas fa-tshirt"></i>
                </div>
                <h1>Darussalam Laundry</h1>
                <p>Silakan login untuk melanjutkan</p>
            </div>

            @if ($errors->any())
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login.process') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" placeholder="Masukkan email" value="{{ old('email') }}" required autofocus>
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                        <i class="fas fa-lock"></i>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> &nbsp; Masuk
                </button>
            </form>
        </div>
    </div>
</body>
</html>
