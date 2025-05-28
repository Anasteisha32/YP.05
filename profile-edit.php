<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAL - Редактирование профиля</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .logo{
            color: rgb(18, 78, 18);
        }
        .btn-secondary {
            background-color: var(--secondary-color);
            color: var(--text-color);
            border: 1px solid var(--border-color);
            width: 200px;
            height: 40px;
            border-radius: 20px;
            padding: 3px;
        }
        .btn-secondary:hover {
            background-color: #e0e0e0;
        }
        .form-actions a{
            color: black;
            text-decoration: none;
        }
        h1{
            margin-bottom:20px
        }
        .btn-primary {
            background-color: #74bd78;
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
        .dashboard-active #dashboard-link,
        .projects-active #projects-link {
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
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
                    <li><a href="dashboard.php" id="dashboard-link">Личный кабинет</a></li>
                    <li><a href="projects.php" id="projects-link">Проекты</a></li>
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
                        <a href="profile-edit.php">Редактировать профиль</a>
                        <a href="index.php">Выйти</a>
                    </div>
                </div>
            </div>
        </header>

        <main class="main-content">
            <h1>Редактирование профиля</h1>
            <div class="form-container">
                <form class="profile-form">
                    <div class="form-section">
                        <h2>Личные данные</h2>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="edit-lastname">Фамилия </label>
                                <input type="text" id="edit-lastname" required>
                                <small class="form-hint">Только латинские буквы</small>
                            </div>
                            <div class="form-group">
                                <label for="edit-firstname">Имя</label>
                                <input type="text" id="edit-firstname"  required>
                                <small class="form-hint">Только латинские буквы</small>
                            </div>
                            <div class="form-group">
                                <label for="edit-middlename">Отчество</label>
                                <input type="text" id="edit-middlename" >
                                <small class="form-hint">Необязательно для ввода</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2>Данные для входа</h2>
                        <div class="form-group">
                            <label for="edit-email">Электронная почта*</label>
                            <input type="email" id="edit-email"  required>
                            <small class="form-hint">Формат: xx@xx.xx</small>
                        </div>
                        <div class="form-group">
                            <label for="edit-password">Новый пароль</label>
                            <input type="password" id="edit-password" placeholder="Оставьте пустым, чтобы не менять">
                        </div>
                    </div>

                    <div class="form-section">
                        <h2>Краткая информация</h2>
                        <div class="form-group">
                            <label for="edit-bio">Расскажите о себе</label>
                            <textarea id="edit-bio" rows="4"></textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button class="btn-secondary"><a href="dashboard.php">Отмена</a></button>
                        <button type="submit" class="btn-primary">Сохранить изменения</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
    

  <script>
$(document).ready(function() {
    // Загружаем данные пользователя при загрузке страницы
    Ajax("backend/edit_user_controller.php", null, function(_data) {
        console.log("Received data:", _data); // Вывод данных в консоль для проверки
        let User = JSON.parse(_data);
        $("#edit-lastname").val(User.last_name);
        $("#edit-firstname").val(User.first_name);
        $("#edit-middlename").val(User.middle_name);
        $("#edit-email").val(User.email);
        $("#edit-bio").val(User.biography);

         $(".user-name").text(`${User.last_name} ${User.first_name} ${User.middle_name}`);
        $(".user-email").text(User.email || "Email отсутствует");
    });

    // Обработка отправки формы
    $(".profile-form").submit(function(event) {
        event.preventDefault();

        let GetData = new FormData();
        GetData.append("last_name", $("#edit-lastname").val());
        GetData.append("first_name", $("#edit-firstname").val());
        GetData.append("middle_name", $("#edit-middlename").val());
        GetData.append("email", $("#edit-email").val());
        GetData.append("biography", $("#edit-bio").val());

        AjaxFormData("backend/edit_user_controller.php", GetData, function(_data) {
            console.log("Received data:", _data); // Вывод данных в консоль для проверки
            let User = JSON.parse(_data);
            alert("Данные успешно обновлены!");
            window.location.href = "dashboard.php";
        });
    });
});

// Функция для отправки FormData
function AjaxFormData(url, formData, callback) {
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            callback(response);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

// Функция для отправки AJAX-запросов
function Ajax(url, data, callback) {
    $.ajax({
        url: url,
        type: data ? "POST" : "GET",
        data: data,
        success: function(response) {
            callback(response);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}


</script>




</body>
</html>