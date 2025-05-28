<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAL - Доска задач</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        :root { --column-bg: #f5f5f5; }
        .logo{ color: rgb(18, 78, 18); }
        .btn-primary, .btn-add-column, .btn-task, .btn-task-danger {
            min-width: 130px; height: 35px; border-radius: 20px; font-size: 15px; font-family: inherit;
            display: inline-flex; align-items: center; justify-content: center; padding: 0 24px;
            border: 1px solid var(--border-color, #e0e0e0); box-sizing: border-box;
            transition: background .2s, color .2s; cursor: pointer; text-decoration: none;
        }
        .btn-primary { background-color: var(--primary-color, #74bd78); color: var(--text-color, #333); margin-right: 10px; }
        .btn-primary:hover { background-color: var(--primary-dark, #466d48); color: white; }
        .btn-add-column { background-color: var(--secondary-color, #f5f5f5); color: var(--text-color, #333);}
        .btn-add-column:hover { background-color: var(--border-color, #b7b7b7);}
        .btn-task { background-color: var(--secondary-color, #f5f5f5); color: var(--text-color, #333);}
        .btn-task:hover { background-color: var(--primary-color, #74bd78); color: #fff;}
        .btn-task-danger { background-color: var(--danger-color, #d32f2f); color: #fff; border: 1px solid var(--danger-color, #d32f2f); margin-left: 10px;}
        .btn-task-danger:hover { background-color: #b71c1c; }
        .task-actions { display: flex; gap: 10px; margin-top: 14px; }
        .btn-task-link { text-decoration: none; }
        .main-content { padding: 24px; max-width: 1545px; margin: 0 auto; min-height: 100vh; }
        .kanban-header a { color: black; text-decoration: none; }
        .kanban-board { display: flex; gap: 24px; align-items: flex-start; overflow-x: auto;}
        .kanban-column { min-width: 355px; background-color: var(--column-bg); border-radius: 8px; padding: 12px; display: flex; flex-direction: column; }
        .column-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }
        .column-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--primary-color, #74bd78);
            letter-spacing: 0.01em;
            margin: 0;
        }
        .column-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .icon-btn {
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 3px 3px;
            vertical-align: middle;
            line-height: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .icon-btn svg {
            width: 18px;
            height: 18px;
            display: block;
            fill: #888;
            transition: fill 0.16s;
        }
        .icon-btn:hover svg { fill: #d32f2f; }
        .icon-btn.edit-column svg:hover { fill: var(--primary-color, #74bd78);}
        .tasks-list { display: flex; flex-direction: column; gap: 18px; margin-bottom: 12px;}
        .subtasks-link { color: var(--primary-dark, #466d48); font-weight: 500; cursor: pointer; text-decoration: underline dotted; transition: color 0.2s;}
        .subtasks-link:hover { color: var(--primary-color, #74bd78);}
        .task-card { background-color: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            padding: 16px 16px 10px 16px; display: flex; flex-direction: column; justify-content: space-between;}
        .responsibles-block { margin-top: 14px; margin-bottom: 0; }
        .responsibles-title { font-weight: 600; font-size: 14px; color: var(--primary-dark, #466d48); margin-bottom: 4px; }
        .responsibles-list { font-size: 14px; color: var(--text-color, #333); margin-bottom: 2px;}
        .no-responsibles {font-size: 14px; color: var(--text-light, #888); font-style: italic;}
        .task-header h4 { margin:0 0 4px 0;font-weight:600;font-size:16px; }
        .task-due { font-size: 13px; color: var(--text-light, #888); margin-left: 12px;}
        .task-description { font-size: 14px; color: var(--text-color, #333); margin:0 0 8px 0;}
        .task-assignees { font-size: 14px;}
        .assignee { color: var(--primary-color, #74bd78);}
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
           <div class="kanban-header">
    <h1>Название проекта</h1>
    <div class="kanban-actions">
        <a href="add-task.php?project_id=<?php echo $_GET['project_id']; ?>" class="btn-primary">Добавить задачу</a>
        <a href="column-kanban.php" class="btn-add-column">Добавить столбец</a>
    </div>
</div>

            <div class="kanban-board">
                <!-- Новые -->
                <div class="kanban-column">
                    <div class="column-header">
                        <span class="column-title">Новые</span>
                        <div class="column-actions">
                            <a href="edit-column-kanban.php" class="icon-btn edit-column" title="Редактировать столбец">
                                <svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75l11.06-11.06-3.75-3.75L3 17.25zM21.41 6.34c.38-.38.38-1.02 0-1.41l-2.34-2.34a.9959.9959 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                            </a>
                            <button class="icon-btn" title="Удалить столбец">
                                <svg viewBox="0 0 24 24"><path d="M18.3 5.71a1 1 0 00-1.41 0L12 10.59 7.11 5.7A1 1 0 105.7 7.11L10.59 12l-4.89 4.89a1 1 0 101.41 1.41L12 13.41l4.89 4.89a1 1 0 001.41-1.41L13.41 12l4.89-4.89a1 1 0 000-1.4z"/></svg>
                            </button>
                        </div>
                    </div>
                    <div class="tasks-list">
                        <!-- Задачи будут загружены динамически -->
                    </div>
                </div>
                <!-- В процессе -->
                <div class="kanban-column">
                    <div class="column-header">
                        <span class="column-title">В процессе</span>
                        <div class="column-actions">
                            <a href="edit-column-kanban.php" class="icon-btn edit-column" title="Редактировать столбец">
                                <svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75l11.06-11.06-3.75-3.75L3 17.25zM21.41 6.34c.38-.38.38-1.02 0-1.41l-2.34-2.34a.9959.9959 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                            </a>
                            <button class="icon-btn" title="Удалить столбец">
                                <svg viewBox="0 0 24 24"><path d="M18.3 5.71a1 1 0 00-1.41 0L12 10.59 7.11 5.7A1 1 0 105.7 7.11L10.59 12l-4.89 4.89a1 1 0 101.41 1.41L12 13.41l4.89 4.89a1 1 0 001.41-1.41L13.41 12l4.89-4.89a1 1 0 000-1.4z"/></svg>
                            </button>
                        </div>
                    </div>
                    <div class="tasks-list">
                        <!-- Задачи будут загружены динамически -->
                    </div>
                </div>
                <!-- На проверке -->
                <div class="kanban-column">
                    <div class="column-header">
                        <span class="column-title">На проверке</span>
                        <div class="column-actions">
                            <a href="edit-column-kanban.php" class="icon-btn edit-column" title="Редактировать столбец">
                                <svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75l11.06-11.06-3.75-3.75L3 17.25zM21.41 6.34c.38-.38.38-1.02 0-1.41l-2.34-2.34a.9959.9959 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                            </a>
                            <button class="icon-btn" title="Удалить столбец">
                                <svg viewBox="0 0 24 24"><path d="M18.3 5.71a1 1 0 00-1.41 0L12 10.59 7.11 5.7A1 1 0 105.7 7.11L10.59 12l-4.89 4.89a1 1 0 101.41 1.41L12 13.41l4.89 4.89a1 1 0 001.41-1.41L13.41 12l4.89-4.89a1 1 0 000-1.4z"/></svg>
                            </button>
                        </div>
                    </div>
                    <div class="tasks-list">
                        <!-- Задачи будут загружены динамически -->
                    </div>
                </div>
                <!-- Готово -->
                <div class="kanban-column">
                    <div class="column-header">
                        <span class="column-title">Готово</span>
                        <div class="column-actions">
                            <a href="edit-column-kanban.php" class="icon-btn edit-column" title="Редактировать столбец">
                                <svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75l11.06-11.06-3.75-3.75L3 17.25zM21.41 6.34c.38-.38.38-1.02 0-1.41l-2.34-2.34a.9959.9959 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                            </a>
                            <button class="icon-btn" title="Удалить столбец">
                                <svg viewBox="0 0 24 24"><path d="M18.3 5.71a1 1 0 00-1.41 0L12 10.59 7.11 5.7A1 1 0 105.7 7.11L10.59 12l-4.89 4.89a1 1 0 101.41 1.41L12 13.41l4.89 4.89a1 1 0 001.41-1.41L13.41 12l4.89-4.89a1 1 0 000-1.4z"/></svg>
                            </button>
                        </div>
                    </div>
                    <div class="tasks-list">
                        <!-- Задачи будут загружены динамически -->
                    </div>
                </div>
            </div>
        </main>
    </div>
<script>
// Функция для удаления задачи
function deleteTask(taskId) {
    if (confirm("Вы уверены, что хотите удалить эту задачу?")) {
        // Создаем объект FormData для передачи данных
        let formData = new FormData();
        formData.append('task_id', taskId);

        Ajax("backend/delete_task_with_subtasks_controller.php", formData, function(response) {
            try {
                let result = typeof response === 'string' ? JSON.parse(response) : response;
                if (result.success) {
                    alert("Задача успешно удалена");
                    location.reload(); // Перезагружаем страницу для обновления списка задач
                } else {
                    alert("Ошибка при удалении задачи: " + result.error);
                }
            } catch (e) {
                console.error("Ошибка при разборе ответа:", e);
                console.error("Ответ сервера:", response);
            }
        });
    }
}

// Функция для отправки запроса на сервер
function updateTaskColumn(taskId, columnId) {
    let formData = new FormData();
    formData.append('task_id', taskId);
    formData.append('column_id', columnId);

    Ajax("backend/update_task_column_controller.php", formData, function(response) {
        try {
            let result = typeof response === 'string' ? JSON.parse(response) : response;
            if (result.success) {
                alert("Столбец задачи успешно обновлен");
                location.reload(); // Перезагружаем страницу для обновления списка задач
            } else {
                alert("Ошибка при обновлении столбца задачи: " + result.error);
            }
        } catch (e) {
            console.error("Ошибка при разборе ответа:", e);
            console.error("Ответ сервера:", response);
        }
    });
}

$(document).ready(function() {
    // Получение ID проекта из URL
    const urlParams = new URLSearchParams(window.location.search);
    const projectId = urlParams.get('project_id');

    if (!projectId) {
        console.error("Ошибка: отсутствует project_id в URL");
        alert("Ошибка: отсутствует project_id в URL");
        window.location.href = "projects.php"; // Перенаправляем на страницу проектов
        return;
    }

    // Остальной код остается без изменений
    let currentUserId;
    let project;
    let isCreatorOrAdmin = false;

    // Загрузка данных пользователя
    Ajax("backend/user_controller.php", null, function(_data) {
        try {
            let User = typeof _data === 'string' ? JSON.parse(_data) : _data;
            $(".user-name").text(`${User.last_name} ${User.first_name} ${User.middle_name}`);
            $(".user-email").text(User.email || "Email отсутствует");
            currentUserId = User.user_id;
        } catch (e) {
            console.error("Ошибка при разборе данных пользователя:", e);
            console.error("Ответ сервера:", _data);
        }
    });

    // Создаем объект FormData для передачи данных
    let formData = new FormData();
    formData.append('project_id', projectId);

    // Загрузка данных проекта
    Ajax("backend/get_project_controller.php", formData, function(_data) {
        try {
            project = typeof _data === 'string' ? JSON.parse(_data) : _data;
            if (project.error) {
                console.error("Ошибка при загрузке проекта:", project.error);
                return;
            }
            $(".kanban-header h1").text(project.name);

            // Проверяем права пользователя
            isCreatorOrAdmin = currentUserId === project.creator_id || 
                             (project.members && project.members.some(member => 
                              member.user_id === currentUserId && member.role === 'admin'));

            // Отображение кнопок в зависимости от прав
            if (isCreatorOrAdmin) {
                $(".kanban-actions").show();
                $(".icon-btn").show();
            } else {
                $(".kanban-actions").hide();
                $(".icon-btn").hide();
            }

            // Загрузка задач проекта
            loadProjectTasks(projectId);
        } catch (e) {
            console.error("Ошибка при разборе данных проекта:", e);
            console.error("Ответ сервера:", _data);
        }
    });

    // Функция для загрузки задач проекта
    function loadProjectTasks(projectId) {
        Ajax(`backend/get_tasks_controller.php?project_id=${projectId}`, null, function(_data) {
            try {
                let tasks = typeof _data === 'string' ? JSON.parse(_data) : _data;

                if (tasks.error) {
                    console.error("Ошибка при загрузке задач:", tasks.error);
                    return;
                }

                // Очистка существующих задач
                $('.tasks-list').empty();

                // Добавление задач в соответствующие столбцы
                tasks.forEach(function(task) {
                    let assigneesList = task.assignees ? task.assignees.split(', ').map(assignee => 
                        `<div style="color: green;">${assignee}</div>`).join('') : 
                        '<div style="color: green;">Ответственных нет</div>';
                    
                    let subtasksCount = task.subtasks_count || 0;
                    let subtasksLink = subtasksCount > 0 ? 
                        `<a href="subtasks.php?task_id=${task.task_id}&project_id=${projectId}" class="subtasks-link">
                            <span class="subtasks-count">${subtasksCount} подзадач</span>
                        </a>` : 
                        `<span class="subtasks-count">0 подзадач</span>`;

                    let isTaskCreatorOrAdmin = currentUserId === task.creator_id || isCreatorOrAdmin;
                    let editButton = isTaskCreatorOrAdmin ? 
                        `<a href="edit-task.php?task_id=${task.task_id}&project_id=${projectId}" class="btn-task btn-task-link">
                            Редактировать
                        </a>` : '';
                    
                    let deleteButton = isTaskCreatorOrAdmin ? 
                        `<button class="btn-task btn-task-danger" onclick="deleteTask(${task.task_id})">
                            Удалить
                        </button>` : '';

                    let taskCard = `
                        <div class="task-card" draggable="true" data-task-id="${task.task_id}">
                            <div>
                                <div class="task-header">
                                    <h4>${task.title}</h4>
                                    <span class="task-due">${task.due_date}</span>
                                </div>
                                <p class="task-description">${task.description}</p>
                                <div class="task-assignees">
                                    <div class="responsibles-title"></div>
                                    <div class="assignee"></div>
                                    ${subtasksLink}
                                </div>
                                <div class="responsibles-block">
                                    <div class="responsibles-title">Создатель:</div>
                                    <div class="responsibles-list">${task.creator_last_name} ${task.creator_first_name} ${task.creator_middle_name}</div>
                                    <div class="responsibles-title">     </div>
                                    <div class="responsibles-title">Ответственные:</div>
                                    <div class="responsibles-list">${assigneesList}</div>
                                </div>
                            </div>
                            <div class="task-actions">
                                ${editButton}
                                ${deleteButton}
                            </div>
                        </div>
                    `;

                    let columnIndex = parseInt(task.column_id) - 1;
                    $(`.kanban-column:eq(${columnIndex}) .tasks-list`).append(taskCard);
                });

                // Инициализация drag and drop
                initDragAndDrop();

            } catch (e) {
                console.error("Ошибка при разборе данных задач:", e);
                console.error("Ответ сервера:", _data);
            }
        });
    }

    // Функция для инициализации drag and drop
    function initDragAndDrop() {
        $('.task-card').on('dragstart', function(e) {
            e.originalEvent.dataTransfer.setData('text/plain', $(this).attr('data-task-id'));
        });

        $('.kanban-column').on('dragover', function(e) {
            e.preventDefault();
        });

        $('.kanban-column').on('drop', function(e) {
            e.preventDefault();
            let taskId = e.originalEvent.dataTransfer.getData('text/plain');
            let columnId = $(this).index() + 1;
            updateTaskColumn(taskId, columnId);
        });
    }
});

// Функции для работы с задачами (остаются без изменений)
function deleteTask(taskId) {
    if (confirm("Вы уверены, что хотите удалить эту задачу?")) {
        let formData = new FormData();
        formData.append('task_id', taskId);

        Ajax("backend/delete_task_with_subtasks_controller.php", formData, function(response) {
            try {
                let result = typeof response === 'string' ? JSON.parse(response) : response;
                if (result.success) {
                    alert("Задача успешно удалена");
                    location.reload();
                } else {
                    alert("Ошибка при удалении задачи: " + result.error);
                }
            } catch (e) {
                console.error("Ошибка при разборе ответа:", e);
                console.error("Ответ сервера:", response);
            }
        });
    }
}

function updateTaskColumn(taskId, columnId) {
    let formData = new FormData();
    formData.append('task_id', taskId);
    formData.append('column_id', columnId);

    Ajax("backend/update_task_column_controller.php", formData, function(response) {
        try {
            let result = typeof response === 'string' ? JSON.parse(response) : response;
            if (result.success) {
                alert("Столбец задачи успешно обновлен");
                location.reload();
            } else {
                alert("Ошибка при обновлении столбца задачи: " + result.error);
            }
        } catch (e) {
            console.error("Ошибка при разборе ответа:", e);
            console.error("Ответ сервера:", response);
        }
    });
}
</script>
</body>
</html>
