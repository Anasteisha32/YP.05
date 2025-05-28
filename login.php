<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAL - Авторизация</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .logo {
            font-size: 34px;
            font-weight: bold;
            color: rgb(78, 102, 34);
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: var(--secondary-color);
            color: var(--text-color);
            border: 1px solid var(--border-color);
            width: 337px;
            height: 40px;
            border-radius: 20px;
            padding: 3px;
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: var(--primary-dark);
            color: white;
        }
        .error-message {
            color: red;
            margin-top: 10px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="logo">MAL - система управления проектами</div>
        <div class="auth-form">
            <h2>Вход в систему</h2>
            <form action="model/log.php" method="POST">
                <div class="form-group">
                    <label for="email">Электронная почта</label>
                    <input type="email" id="email" name="email" placeholder="Введите email" required>
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" placeholder="Введите пароль" required>
                </div>
                <button type="submit" class="btn-primary">Войти</button>
                <div id="errorMessage" class="error-message">Неверный email или пароль</div>
            </form>
            <div class="auth-footer">
                <p>Нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>
            </div>
        </div>
    </div>

    <script>
        // Show error message if error parameter is present in URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('error')) {
            document.getElementById('errorMessage').style.display = 'block';
        }
    </script>
</body>
</html>
