<?php
session_start();
$errors = $_SESSION['errors'] ?? [];
$formData = $_SESSION['form_data'] ?? [];
unset($_SESSION['errors'], $_SESSION['form_data']);
?>

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
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: var(--primary-dark);
            color: white;
        }
        .error {
            color: red;
            margin: 10px 0;
        }
        .auth-container {
            margin: 0 auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="logo">MAL - система управления проектами</div>
        <div class="auth-form">
            <h2>Регистрация</h2>
            
            <?php if (!empty($errors)): ?>
                <div class="error">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="model/reg.php">
                <div class="form-group">
                    <label for="email">Электронная почта</label>
                    <input type="email" id="email" name="email" required
                           value="<?= htmlspecialchars($formData['email'] ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label for="last_name">Фамилия</label>
                    <input type="text" id="last_name" name="last_name" required
                           value="<?= htmlspecialchars($formData['last_name'] ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label for="first_name">Имя</label>
                    <input type="text" id="first_name" name="first_name" required
                           value="<?= htmlspecialchars($formData['first_name'] ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label for="middle_name">Отчество</label>
                    <input type="text" id="middle_name" name="middle_name"
                           value="<?= htmlspecialchars($formData['middle_name'] ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label for="biography">Биография</label>
                    <textarea id="biography" name="biography" rows="4"><?= 
                        htmlspecialchars($formData['biography'] ?? '') 
                    ?></textarea>
                </div>
                
                <button type="submit" class="btn-primary">Зарегистрироваться</button>
                
                <div class="auth-footer">
                    <p>Уже есть аккаунт? <a href="login.php">Войти</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>