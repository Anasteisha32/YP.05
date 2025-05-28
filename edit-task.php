<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAL - Изменение задачи</title>
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
        .assignee-item {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }
        .btn-icon {
            margin-left: 10px;
            background: none;
            border: none;
            cursor: pointer;
            color: red;
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
                <span>Редактирование задачи</span>
            </div>

            <div class="form-container">
                <h1>Редактирование задачи</h1>
                <form id="task-form">
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
                            <input type="date" id="task-due">
                            <input type="time" id="task-due-time">
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
                        <button type="button" class="btn-secondary" id="cancel-btn">Отмена</button>
                        <button type="submit" class="btn-primary">Изменить задачу</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
    $(document).ready(function() {
        // Получаем ID задачи и проекта из URL
        const urlParams = new URLSearchParams(window.location.search);
        const taskId = urlParams.get('task_id');
        const projectId = urlParams.get('project_id');

        if (!taskId) {
            console.error("Ошибка: отсутствует task_id в URL");
            alert("Ошибка: отсутствует task_id в URL");
            window.location.href = "projects.php";
            return;
        }

        // Загрузка данных пользователя
        Ajax("backend/user_controller.php", null, function(_data) {
            try {
                let User = typeof _data === 'string' ? JSON.parse(_data) : _data;
                $(".user-name").text(`${User.last_name} ${User.first_name} ${User.middle_name}`);
                $(".user-email").text(User.email || "Email отсутствует");
            } catch (e) {
                console.error("Ошибка при разборе данных пользователя:", e);
            }
        });

        // Загрузка данных задачи и участников проекта
        function loadTaskData() {
            $.ajax({
                url: `backend/edit_task_controller.php?task_id=${taskId}`,
                method: 'GET',
                success: function(data) {
                    try {
                        let response = typeof data === 'string' ? JSON.parse(data) : data;
                        
                        if (response.error) {
                            console.error("Ошибка при загрузке данных задачи:", response.error);
                            alert("Ошибка при загрузке данных задачи: " + response.error);
                            return;
                        }

                        let task = response.task;
                        let members = response.members;

                        // Заполнение формы данными задачи
                        $("#task-name").val(task.name || '');
                        $("#task-desc").val(task.description || '');

                        if (task.due_date) {
                            let dueDate = new Date(task.due_date);
                            $("#task-due").val(dueDate.toISOString().split('T')[0]);
                            $("#task-due-time").val(dueDate.toTimeString().split(' ')[0].substring(0, 5));
                        }

                        // Заполнение списка ответственных
                        let assigneesList = $(".assignees-list");
                        assigneesList.empty();
                        
                        if (task.assignee_ids) {
                            let assigneeIds = task.assignee_ids.split(',');
                            assigneeIds.forEach(function(assigneeId) {
                                if (!assigneeId) return;
                                
                                let assignee = members.find(member => member.user_id == assigneeId);
                                if (assignee) {
                                    let assigneeItem = `<div class="assignee-item" data-user-id="${assignee.user_id}">
                                        <span>${assignee.last_name} ${assignee.first_name} ${assignee.middle_name}</span>
                                        <button type="button" class="btn-icon" title="Удалить ответственного">✕</button>
                                    </div>`;
                                    assigneesList.append(assigneeItem);
                                }
                            });
                        }

                        // Заполнение выпадающего списка участников проекта
                        let assigneesSelect = $("#assignees");
                        assigneesSelect.empty();
                        members.forEach(function(member) {
                            assigneesSelect.append(new Option(
                                `${member.last_name} ${member.first_name} ${member.middle_name}`,
                                member.user_id
                            ));
                        });
                    } catch (e) {
                        console.error("Ошибка при разборе данных:", e);
                        console.error("Ответ сервера:", data);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Ошибка при загрузке данных задачи:", error);
                    alert("Ошибка при загрузке данных задачи");
                }
            });
        }

        // Обработка добавления ответственного
        $("#add-assignee-btn").on("click", function() {
            let selectedAssignees = $("#assignees").val();
            let assigneesList = $(".assignees-list");

            if (!selectedAssignees || selectedAssignees.length === 0) {
                alert("Выберите хотя бы одного участника");
                return;
            }

            selectedAssignees.forEach(function(assigneeId) {
                // Проверяем, не добавлен ли уже этот пользователь
                if ($(`.assignee-item[data-user-id="${assigneeId}"]`).length === 0) {
                    let assigneeName = $("#assignees option[value='" + assigneeId + "']").text();
                    let assigneeItem = `<div class="assignee-item" data-user-id="${assigneeId}">
                        <span>${assigneeName}</span>
                        <button type="button" class="btn-icon" title="Удалить ответственного">✕</button>
                    </div>`;
                    assigneesList.append(assigneeItem);
                }
            });
        });

        // Обработка удаления ответственного
        $(document).on("click", ".btn-icon", function() {
            $(this).parent().remove();
        });

        // Обработка кнопки "Отмена"
        $("#cancel-btn").on("click", function() {
            window.location.href = `kanban.php?project_id=${projectId}`;
        });

        // Обработка отправки формы
        $("#task-form").on("submit", function(e) {
            e.preventDefault();

            let taskName = $("#task-name").val();
            let taskDesc = $("#task-desc").val();
            let taskDueDate = $("#task-due").val();
            let taskDueTime = $("#task-due-time").val();
            let assignees = [];
            
            $(".assignee-item").each(function() {
                assignees.push($(this).data("user-id"));
            });

            let formData = {
                'task_id': taskId,
                'task-name': taskName,
                'task-desc': taskDesc,
                'task-due': taskDueDate,
                'task-due-time': taskDueTime,
                'assignees': assignees,
                'project_id': projectId
            };

            $.ajax({
                url: 'backend/edit_task_controller.php',
                method: 'POST',
                data: formData,
                success: function(data) {
                    try {
                        let result = typeof data === 'string' ? JSON.parse(data) : data;
                        
                        if (result.error) {
                            console.error("Ошибка при изменении задачи:", result.error);
                            alert("Ошибка при изменении задачи: " + result.error);
                            return;
                        }

                        if (result.success) {
                            alert("Задача успешно изменена");
                            window.location.href = `kanban.php?project_id=${projectId}`;
                        }
                    } catch (e) {
                        console.error("Ошибка при разборе ответа:", e);
                        console.error("Ответ сервера:", data);
                        alert("Произошла ошибка при обработке ответа сервера");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Ошибка при изменении задачи:", error);
                    alert("Произошла ошибка при изменении задачи");
                }
            });
        });

        // Запускаем загрузку данных задачи
        loadTaskData();
    });
    </script>
</body>
</html>