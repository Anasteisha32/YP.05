<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>MAL - Редактирование столбца</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .logo{ color: rgb(18, 78, 18); }
        .main-content { padding: 24px; max-width: 1545px; margin: 0 auto; min-height: 100vh; }
        .btn-secondary {
            background-color: var(--secondary-color);
            color: var(--text-color);
            border: 1px solid var(--border-color);
            width: 200px;
            border-radius: 20px;
            padding: 2px;
        }
        .btn-secondary:hover {
            background-color: #e0e0e0;
        }
       .btn-primary {
            background-color: var(--primary-color);
            color: white;
            border: 1px solid var(--border-color);
            width: 237px;
            height: 30px;
            border-radius: 20px;
            padding: 3px;
        }
        .btn-primary:hover {
            background-color: var(--primary-dark);
            color: white;
        }
        .form-actions a{
           color:black;
           text-decoration: none;
        }
        .form-container h1{
            margin-bottom:16px
        }
    </style>
    <script src="jquery-3.6.3.js"></script>
    <script src="ajax.js"></script>
</head>
<body>
    <div class="app-container">
        <header class="app-header">
            <div class="logo">MAL - система управления проектами</div>
            <nav class="main-nav">
                <ul>
                    <li><a href="dashboard.php">Личный кабинет</a></li>
                    <li><a href="projects.php" class="active">Проекты</a></li>
                </ul>
            </nav>
            <div class="user-menu">
                <div class="user-info">
                    <span class="user-name">Иванов Иван Иванович</span>
                    <span class="user-email">ivanov@example.com</span>
                </div>
                <div class="dropdown-menu">
                    <button class="dropdown-btn">▼</button>
                    <div class="dropdown-content">
                        <a href="profile-edit.html">Редактировать профиль</a>
                        <a href="index.html">Выйти</a>
                    </div>
                </div>
            </div>
        </header>
        <main class="main-content">
            <div class="form-container">
                <h1>Редактирование столбца</h1>
                <form class="task-form">
                    <div class="form-section">
                        <div class="form-group">
                            <label for="task-name">Наименование</label>
                            <input type="text" id="task-name" placeholder="Введите название столбца" required>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-secondary"><a href="kanban.php" >Отмена</a></button>
                        <button type="submit" class="btn-primary">Изменить столбец</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
<script>
    Ajax("backend/user_controller.php", null, function(_data) {
        console.log(_data);

        let User = JSON.parse(_data);

        $(".user-name").text(`${User.last_name} ${User.first_name} ${User.middle_name}`);
        $(".user-email").text(User.email || "Email отсутствует");
    });
</script>
</body>
</html>