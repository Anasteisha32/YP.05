<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAL - Личный кабинет</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .logo{
            color: rgb(18, 78, 18);
        }
        .btn-secondary {
            background-color: var(--secondary-color);
            color: var(--text-color);
            border: 1px solid var(--border-color);
            width: 300px;
            height: 40px;
            border-radius: 20px;
            padding: 3px;
        }
        .btn-secondary:hover {
            background-color: #e0e0e0;
        }
        .btn-danger {
            background-color: var(--danger-color);
            color: var(--white);
            width: 300px;
            height: 40px;
            border-radius: 20px;
            padding: 3px;
            border: 1px solid var(--border-color);
        }
        .btn-danger:hover {
            background-color: #b71c1c;
        }
        .profile-actions {
            justify-content: center;
        }
        .profile-actions a{
            color: black;
            text-decoration: none;
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
<body class="dashboard-active">
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
            <div class="profile-section">
                <h1>Личный кабинет</h1>
                <div class="profile-card">
                    <div class="profile-header">
                        <h2></h2>
                    </div>
                    <div class="profile-bio">
                        <h3>О себе</h3>
                        <p></p>
                    </div>
                    <div class="profile-actions">
                        <button class="btn-secondary"><a href="profile-edit.php">Редактировать профиль</a></button>
                        <button class="btn-danger" id="delete-account-btn">Удалить аккаунт</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
   <script>
$(document).ready(function() {
    // Загружаем данные пользователя при загрузке страницы
    Ajax("backend/user_controller.php", null, function(_data) {
        console.log("Received data:", _data);
        try {
            // Убедитесь, что данные корректно разбираются
            let User = typeof _data === 'string' ? JSON.parse(_data) : _data;
            $(".profile-header h2").text(`${User.last_name} ${User.first_name} ${User.middle_name}`);
            $(".profile-bio p").text(User.biography || "Биография отсутствует");

            $(".user-name").text(`${User.last_name} ${User.first_name} ${User.middle_name}`);
            $(".user-email").text(User.email || "Email отсутствует");
        } catch (e) {
            console.error("Error parsing JSON:", e);
        }
    });

    // Обработка нажатия на кнопку удаления аккаунта
    $("#delete-account-btn").click(function() {
        if (confirm("Вы уверены, что хотите удалить аккаунт? Это действие нельзя будет отменить.")) {
            let GetData = new FormData();
            GetData.append("action", "delete_account");

            AjaxFormData("backend/user_controller.php", GetData, function(_data) {
                try {
                    let response = typeof _data === 'string' ? JSON.parse(_data) : _data;
                    if (response.success) {
                        window.location.href = "register.php";
                    } else if (response.error) {
                        alert("Ошибка при удалении аккаунта: " + response.error);
                    }
                } catch (e) {
                    console.error("Error parsing JSON:", e);
                }
            });
        }
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
