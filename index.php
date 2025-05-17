<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAL - Управление проектами</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        h2 {
            font-size: 54px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .auth-form{
            max-width: 600px;
        }
        p{
            font-size: 30px;
            text-align: center;
        }
        .btn-primary {
            background-color: var(--primary-color);
            color: var(--text-color);
            border: 1px solid var(--border-color);
            width: 237px;
            height: 40px;
            border-radius: 20px;
            padding: 3px;
        }
        .btn-primary:hover {
            background-color: var(--primary-dark);
            color: white;
        }
        .auth-footer{
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 40px;
        }
        #butt1{
            background-color: var(--primary-color);
            color: rgb(255, 255, 255);
        }
        #butt1:hover{
            background-color: var(--primary-dark);
            color: white;
        }
        .auth-footer a{
            color: #000;
        }
        .auth-footer a:hover{
            color: white;
        }
        a{
            color: #000;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-form">
            <h2>MAL</h2>
            <p>Бесплатный и открытый инструмент управления проектами</p>
            <div class="auth-footer">
             <button type="submit" id="butt1" class="btn-primary"><a href="login.php">Войти</a></button>
              <button type="submit" class="btn-primary"><a href="register.php">Зарегистрироваться</a></button>
        </div>
        </div>
    </div>
</body>
</html>