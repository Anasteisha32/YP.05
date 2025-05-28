<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAL - Создание проекта</title>
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
            border-radius: 20px;
            padding: 2px;
        }
        .btn-secondary:hover {
            background-color: #e0e0e0;
        }
       .btn-primary {
            background-color: var(--primary-color);
            color: var(--text-color);
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
        .btn-second{
            background-color: var(--secondary-color);
            color: var(--text-color);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            height: 30px;
            padding: 3px;
            color: black;
            width: 100px;
            font-size: 16px
        }
        .btn-second:hover {
            background-color: #e0e0e0;
        }
        .btn-primar {
            background-color: var(--secondary-color);
            color: var(--text-color);
            border: 1px solid var(--border-color);
            width: 200px;
            height: 30px;
            padding: 3px;
        }
        .btn-primar:hover {
            background-color: var(--primary-dark);
            color: white;
        }
        .form-container h1{
            margin-bottom:16px
        }
        .radio-group {
            display: flex;
            gap: 8px;
        }
        .gr{
            display: block;
        }
        .form-actions a{
           color:black;
           text-decoration: none;
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
                        <a href="profile-edit.php">Редактировать профиль</a>
                        <a href="index.php">Выйти</a>
                    </div>
                </div>
            </div>
        </header>

        <main class="main-content">
            <div class="form-container">
                <h1>Создание проекта</h1>
                <form class="project-form">
                    <div class="form-section">
                        <h2>Данные проекта</h2>
                        <div class="form-group">
                            <label for="project-name">Наименование</label>
                            <input type="text" id="project-name" placeholder="Введите название проекта" required>
                        </div>
                        <div class="form-group">
                            <label for="project-desc">Описание</label>
                            <textarea id="project-desc" rows="3" placeholder="Опишите проект"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Публичность</label>
                            <div class="radio-group">
                                <label class="gr">
                                    <p>Открытый (виден всем пользователям)</p>
                                    <span>Закрытый (только для участников)</span>
                                </label>
                                <label class="fr">
                                    <input type="radio" name="project-type" value="public" checked>
                                    <input type="radio" name="project-type" value="private">
                                    
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2>Участники проекта</h2>
                        <div class="members-list">
                            <div class="member-item">
                                <span>Иванов Иван Иванович (Вы) - Создатель</span>
                            </div>
                        </div>
                        <div class="add-member">
                            <select id="new-member">
                                <option value="">Выберите сотрудника</option>
                                <!-- Пользователи будут загружены динамически -->
                            </select>
                            <select id="new-member-role">
                                <option value="admin">Администратор</option>
                                <option value="member" selected>Участник</option>
                            </select>
                            <button type="button" class="btn-secondary" id="add-member-btn">Добавить участника</button>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-secondary"><a href="projects.php">Отмена</a></button>
                        <button type="submit" class="btn-primary">Создать проект</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
   <script>
    let userId = null;
    let userFullName = '';

    // Загрузка данных пользователя
    Ajax("backend/user_controller.php", null, function(_data) {
        try {
            let User = typeof _data === 'string' ? JSON.parse(_data) : _data;
            userId = User.user_id;
            userFullName = `${User.last_name} ${User.first_name} ${User.middle_name}`;
            $(".user-name").text(userFullName);
            $(".user-email").text(User.email || "Email отсутствует");

            // Обновляем отображение создателя проекта
            $('.member-item span').first().text(`${userFullName} (Вы) - Создатель`);
        } catch (e) {
            console.error("Ошибка при разборе данных пользователя:", e);
            console.error("Ответ сервера:", _data);
        }
    });

    // Загрузка списка пользователей
    Ajax("backend/get_users_controller.php", null, function(_data) {
        try {
            let users = typeof _data === 'string' ? JSON.parse(_data) : _data;

            if (users.error) {
                console.error("Ошибка при загрузке пользователей:", users.error);
                return;
            }

            let newMemberSelect = $("#new-member");

            users.forEach(function(user) {
                if (user.user_id != userId) {
                    let option = `<option value="${user.user_id}">${user.last_name} ${user.first_name} ${user.middle_name}</option>`;
                    newMemberSelect.append(option);
                }
            });
        } catch (e) {
            console.error("Ошибка при разборе данных пользователей:", e);
            console.error("Ответ сервера:", _data);
        }
    });

    // Обработчик события для добавления участника
    $(document).ready(function() {
        $('#add-member-btn').on('click', function() {
            let userId = $('#new-member').val();
            let userName = $('#new-member option:selected').text();
            let role = $('#new-member-role').val();

            if (userId) {
                let memberItem = `
                    <div class="member-item">
                        <span data-user-id="${userId}">${userName} - ${role === 'admin' ? 'Администратор' : 'Участник'}</span>
                        <button class="btn-icon" onclick="$(this).parent().remove()">✕</button>
                    </div>
                `;
                $('.members-list').append(memberItem);
            }
        });

        // Обработчик события для формы создания проекта
        $('.project-form').on('submit', function(e) {
            e.preventDefault();

            let projectName = $('#project-name').val();
            let projectDesc = $('#project-desc').val();
            let projectType = $('input[name="project-type"]:checked').val();

            let members = [];
            $('.member-item').each(function() {
                let memberId = $(this).find('span').data('user-id');
                let role = $(this).find('span').text().includes('Администратор') ? 'admin' : 'member';
                if (memberId) {
                    members.push({ user_id: parseInt(memberId), role: role });
                }
            });

            let formData = new FormData();
            formData.append('project-name', projectName);
            formData.append('project-desc', projectDesc);
            formData.append('project-type', projectType);
            formData.append('members', JSON.stringify(members));

            Ajax("backend/add_project_controller.php", formData, function(response) {
                try {
                    let result = typeof response === 'string' ? JSON.parse(response) : response;
                    if (result.success) {
                        alert("Проект успешно создан");
                        window.location.href = 'projects.php'; // Перенаправляем на страницу проектов
                    } else {
                        alert("Ошибка при создании проекта: " + result.error);
                    }
                } catch (e) {
                    console.error("Ошибка при разборе ответа:", e);
                    console.error("Ответ сервера:", response);
                }
            });
        });
    });
</script>

</body>
</html>
