<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAL - Подзадачи</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        :root {
            --column-bg: #f5f5f5;
        }
        .logo {
            color: rgb(18, 78, 18);
        }
        .btn-primary, .btn-add-column, .btn-task, .btn-task-danger {
            min-width: 130px;
            height: 35px;
            border-radius: 20px;
            font-size: 15px;
            font-family: inherit;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 24px;
            border: 1px solid var(--border-color, #e0e0e0);
            box-sizing: border-box;
            transition: background .2s, color .2s;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-primary {
            background-color: var(--primary-color, #74bd78);
            color: var(--text-color, #333);
        }
        .btn-primary:hover {
            background-color: var(--primary-dark, #466d48);
            color: white;
        }
        .btn-add-column {
            background-color: var(--secondary-color, #f5f5f5);
            color: var(--text-color, #333);
        }
        .btn-add-column:hover {
            background-color: var(--border-color, #b7b7b7);
        }
        .btn-task {
            background-color: var(--secondary-color, #f5f5f5);
            color: var(--text-color, #333);
        }
        .btn-task:hover {
            background-color: var(--primary-color, #74bd78);
            color: #fff;
        }
        .btn-task-danger {
            background-color: var(--danger-color, #d32f2f);
            color: #fff;
            border: 1px solid var(--danger-color, #d32f2f);
            margin-left: 10px;
        }
        .btn-task-danger:hover {
            background-color: #b71c1c;
        }
        .task-actions {
            display: flex;
            gap: 10px;
            margin-top: 14px;
        }
        .btn-task-link {
            text-decoration: none;
        }
        .main-content {
            padding: 24px;
            max-width: 1545px;
            margin: 0 auto;
            min-height: 100vh;
        }
        .kanban-header a{
            color: black;
            text-decoration: none;
        }
        .kanban-board {
            display: flex;
            gap: 24px;
            align-items: flex-start;
            overflow-x: auto;
        }
        .kanban-column {
            min-width: 355px;
            background-color: var(--column-bg);
            border-radius: 8px;
            padding: 12px;
            display: flex;
            flex-direction: column;
        }
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
            /* Такой же цвет как и в задачах */
            letter-spacing: 0.01em;
        }
        .column-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        /* Кнопки-иконки */
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
        .icon-btn:hover svg {
            fill: #d32f2f;
        }
        .icon-btn.edit-column svg:hover {
            fill: var(--primary-color, #74bd78);
        }
        .tasks-list {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }
        .task-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            padding: 16px 16px 10px 16px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        /* Стили подзадач, идентично задачам */
        .subtask-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 3px;
        }
        .subtask-due {
            font-size: 13px;
            color: var(--text-light, #888);
            margin-left: 12px;
        }
        .subtask-desc {
            font-size: 14px;
            color: var(--text-color, #333);
            margin-bottom: 8px;
        }
        .subtask-assignees {
            font-size: 14px;
            color: var(--primary-color, #74bd78);
            margin-bottom: 6px;
        }
        .subtasks-header-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 18px;
        }
        .subtasks-header {
            font-size: 24px;
            font-weight: bold;
            color: #111;
        }
        .subtasks-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        @media (max-width: 820px) {
            .main-content { max-width: 98vw; padding: 8px;}
            .kanban-board {gap: 10px;}
            .kanban-column {min-width: 255px; padding: 7px;}
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
            <div class="subtasks-header-row">
                <div class="subtasks-header">Подзадачи задачи: Разработать дизайн</div>
                <div class="subtasks-actions">
                    <a href="kanban.php" class="btn-add-column">← Вернуться к задачам</a>
                    <a href="add-subtasks.php" class="btn-task btn-task-link">Добавить подзадачу</a>
                    <a href="column-kanban.php" class="btn-add-column">Добавить столбец</a>
                </div>
            </div>
            <div class="kanban-board">
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
                        <div class="task-card">
                            <div>
                                <div style="display:flex;align-items:center;margin-bottom:2px;">
                                    <span class="subtask-title">Сделать макет главной страницы</span>
                                    <span class="subtask-due">16.06.2025</span>
                                </div>
                                <div class="subtask-desc">
                                    Макет должен быть выполнен в фирменных цветах.
                                </div>
                                <div class="subtask-assignees">
                                    Ответственные: Иванов И.И., Петров П.П.
                                </div>
                            </div>
                            <div class="task-actions">
                                <a href="edit-subtask.php" class="btn-task btn-task-link">Редактировать</a>
                                <button class="btn-task btn-task-danger">Удалить</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kanban-column">
                    <div class="column-header">
                        <span class="column-title">В работе</span>
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
                        <div class="task-card">
                            <div>
                                <div style="display:flex;align-items:center;margin-bottom:2px;">
                                    <span class="subtask-title">Сделать мобильную версию</span>
                                    <span class="subtask-due">17.06.2025</span>
                                </div>
                                <div class="subtask-desc">
                                    Адаптировать макет для разрешения до 375px.
                                </div>
                                <div class="subtask-assignees">
                                    Ответственные: Сидоров С.С.
                                </div>
                            </div>
                            <div class="task-actions">
                                <a href="edit-subtask.php" class="btn-task btn-task-link">Редактировать</a>
                                <button class="btn-task btn-task-danger">Удалить</button>
                            </div>
                        </div>
                    </div>
                </div>
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
                        <div class="task-card">
                            <div>
                                <div style="display:flex;align-items:center;margin-bottom:2px;">
                                    <span class="subtask-title">Протестировать главную страницу</span>
                                    <span class="subtask-due">18.06.2025</span>
                                </div>
                                <div class="subtask-desc">
                                    Провести тесты для проверки вёрстки.
                                </div>
                                <div class="subtask-assignees">
                                    Ответственные: Петров П.П., Иванова А.А.
                                </div>
                            </div>
                            <div class="task-actions">
                                <a href="edit-subtask.php" class="btn-task btn-task-link">Редактировать</a>
                                <button class="btn-task btn-task-danger">Удалить</button>
                            </div>
                        </div>
                    </div>
                </div>
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
                        <div class="task-card">
                            <div>
                                <div style="display:flex;align-items:center;margin-bottom:2px;">
                                    <span class="subtask-title">Проверить доступность</span>
                                    <span class="subtask-due">19.06.2025</span>
                                </div>
                                <div class="subtask-desc">
                                    Протестировать с помощью Lighthouse.
                                </div>
                                <div class="subtask-assignees">
                                    Ответственных нет
                                </div>
                            </div>
                            <div class="task-actions">
                                <a href="edit-subtask.php" class="btn-task btn-task-link">Редактировать</a>
                                <button class="btn-task btn-task-danger">Удалить</button>
                            </div>
                        </div>
                    </div>
                </div>
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