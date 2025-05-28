<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAL - Добавление задачи</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .logo {
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
        .form-actions a {
            color: black;
            text-decoration: none;
        }
        .form-container h1 {
            margin-bottom: 16px;
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
            <div class="breadcrumbs">
                <a href="projects.php">Проекты</a> /
                <a href="kanban.php">Secret Project</a> /
                <span>Добавление задачи</span>
            </div>

            <div class="form-container">
                <h1>Добавление задачи</h1>
                <form class="task-form">
                    <div class="form-section">
                        <div class="form-group">
                            <label for="task-name">Наименование</label>
                            <input type="text" id="task-name" placeholder="Введите название задачи" required>
                        </div>
                        <div class="form-group">
                            <label for="task-desc">Описание</label>
                            <textarea id="task-desc" rows="3" placeholder="Опишите задачу"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="task-due">Срок выполнения</label>
                            <input type="date" id="task-due" required>
                            <input type="time" id="task-due-time" required>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2>Ответственные</h2>
                        <div class="assignees-list">
                            <!-- Ответственные будут добавлены сюда -->
                        </div>
                        <div class="add-assignee">
                            <select id="assignees" multiple>
                                <!-- Участники проекта будут загружены динамически -->
                            </select>
                            <button type="button" class="btn-secondary" id="add-assignee-btn">Добавить ответственного</button>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-secondary"><a href="kanban.php">Отмена</a></button>
                        <button type="submit" class="btn-primary">Создать задачу</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
    <script>
    // Получение ID проекта из URL
    const urlParams = new URLSearchParams(window.location.search);
    const projectId = urlParams.get('project_id');

    if (!projectId) {
        console.error("Ошибка: отсутствует project_id в URL");
        alert("Ошибка: отсутствует project_id в URL");
        window.location.href = "projects.php"; // Перенаправляем на страницу проектов, если project_id отсутствует
    }

    // Загрузка данных пользователя
    Ajax("backend/user_controller.php", null, function(_data) {
        try {
            let User = typeof _data === 'string' ? JSON.parse(_data) : _data;
            $(".user-name").text(`${User.last_name} ${User.first_name} ${User.middle_name}`);
            $(".user-email").text(User.email || "Email отсутствует");
        } catch (e) {
            console.error("Ошибка при разборе данных пользователя:", e);
            console.error("Ответ сервера:", _data);
        }
    });

    // Загрузка участников проекта
    Ajax(`backend/get_project_members_controller.php?project_id=${projectId}`, null, function(_data) {
        try {
            let members = typeof _data === 'string' ? JSON.parse(_data) : _data;

            if (members.error) {
                console.error("Ошибка при загрузке участников проекта:", members.error);
                alert("Ошибка при загрузке участников проекта: " + members.error);
                return;
            }

            let assigneesSelect = $("#assignees");

            members.forEach(function(member) {
                let option = `<option value="${member.user_id}">${member.last_name} ${member.first_name} ${member.middle_name}</option>`;
                assigneesSelect.append(option);
            });
        } catch (e) {
            console.error("Ошибка при разборе данных участников проекта:", e);
            console.error("Ответ сервера:", _data);
        }
    });

    // Обработка добавления ответственного
    $("#add-assignee-btn").on("click", function() {
        let selectedAssignees = $("#assignees").val();
        let assigneesList = $(".assignees-list");

        selectedAssignees.forEach(function(assigneeId) {
            let assigneeName = $("#assignees option[value='" + assigneeId + "']").text();
            let assigneeItem = `<div class="assignee-item" data-user-id="${assigneeId}">
                <span>${assigneeName}</span>
                <button class="btn-icon" title="Удалить ответственного">✕</button>
            </div>`;
            assigneesList.append(assigneeItem);
        });
    });

    // Обработка удаления ответственного
    $(document).on("click", ".btn-icon", function() {
        $(this).parent().remove();
    });

    // Обработка отправки формы
    $(".task-form").on("submit", function(e) {
        e.preventDefault();

        let taskName = $("#task-name").val();
        let taskDesc = $("#task-desc").val();
        let taskDueDate = $("#task-due").val();
        let taskDueTime = $("#task-due-time").val();
        let assignees = [];
        $(".assignee-item").each(function() {
            assignees.push($(this).data("user-id"));
        });

        let formData = new FormData();
        formData.append('task-name', taskName);
        formData.append('task-desc', taskDesc);
        formData.append('task-due', taskDueDate);
        formData.append('task-due-time', taskDueTime);
        formData.append('project_id', projectId);
        formData.append('assignees', JSON.stringify(assignees));

        Ajax("backend/add_task_controller.php", formData, function(response) {
            try {
                let result = typeof response === 'string' ? JSON.parse(response) : response;
                if (result.success) {
                    alert("Задача успешно создана");
                    window.location.href = `kanban.php?project_id=${projectId}`;
                } else {
                    alert("Ошибка при создании задачи: " + result.error);
                }
            } catch (e) {
                console.error("Ошибка при разборе ответа:", e);
                console.error("Ответ сервера:", response);
            }
        });
    });
    
    </script>
</body>
</html>
