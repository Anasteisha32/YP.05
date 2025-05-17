<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAL - Регистрация</title>
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
    }
.btn-primary:hover {
    background-color: var(--primary-dark);
    color: white;
    }
</style>
</head>
<body>
    <div class="auth-container">
        <div class="logo">MAL - система управления проектами</div>
        <div class="auth-form">
            <h2>Регистрация</h2>
            <form>
                <div class="form-group">
                    <label for="reg-email">Электронная почта</label>
                    <input type="email" id="reg-email" placeholder="Введите email" required>
                    <small class="form-hint">Формат: xx@xx.xx</small>
                </div>
                <div class="form-group">
                    <label for="reg-password">Пароль</label>
                    <input type="password" id="reg-password" placeholder="Введите пароль" required>
                </div>
                <div class="form-group">
                    <label for="reg-lastname">Фамилия</label>
                    <input type="text" id="reg-lastname" placeholder="Введите фамилию" required>
                    <small class="form-hint">Только латинские буквы</small>
                </div>
                <div class="form-group">
                    <label for="reg-firstname">Имя</label>
                    <input type="text" id="reg-firstname" placeholder="Введите имя" required>
                    <small class="form-hint">Только латинские буквы</small>
                </div>
                <div class="form-group">
                    <label for="reg-middlename">Отчество</label>
                    <input type="text" id="reg-middlename" placeholder="Введите отчество (необязательно)">
                </div>
               <div class="form-group">
                            <label for="edit-bio">Биография</label>
                            <textarea id="edit-bio" rows="4" placeholder="Расскажите о себе"> </textarea>
                        </div>
                <button type="submit" class="btn-primary">Зарегистрироваться</button>
                <div class="auth-footer">
                <p>Уже есть аккаунт? <a href="login.php">Войти</a></p>
            
            </form>
            
        </div>
    </div>
</body>
</html>