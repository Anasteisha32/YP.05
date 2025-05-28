<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAL - Проекты</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .logo{
            color: rgb(18, 78, 18);
        }
        .btn-secondary {
            background-color: var(--secondary-color);
            color: var(--text-color);
            border: 1px solid var(--border-color);
            width: 140px;
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
            height: 40px;
            border-radius: 20px;
            padding: 3px;
        }
        .btn-primary:hover {
            background-color: var(--primary-dark);
            color: white;
        }
        .projects-header a{
           color: white;
            text-decoration: none;
        }
        .task-assignees {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-top: 10px
        }
        .btn-second {
            background-color:  #e0e0e0;
            color: var(--text-color);
            border: 1px solid var(--border-color);
            width: 140px;
            border-radius: 20px;
            padding: 2px;
            height: 30px;
        }
        .btn-second:hover {
            background-color:var(--primary-color);
        }
        #sec{
            background-color:var(--danger-color);
            color: white;
        }
        #sec:hover{
           background-color: #b71c1c;
        }
        .project-footer a {
           color:black;
            text-decoration: none;
        }
        .project-footer a:hover {
           color:white;
        }
       .project-card {
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            padding: 16px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
            align-items: start;
        }

        /* Добавляем стиль для активной страницы */
        .projects-active #projects-link,
        .dashboard-active #dashboard-link {
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
        }
    </style>
    <script src="jquery-3.6.3.js"></script>
    <script src="ajax.js"></script>
</head>
<body class="projects-active">
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
            <div class="projects-header">
                <h1>Проекты</h1>
                <button class="btn-primary" id="create-project-btn"><a href="add-project.php">Создать проект</a></button>
            </div>

            <div class="projects-grid" id="projects-grid">
                <!-- Проекты будут загружены динамически -->
            </div>
        </main>
    </div>
<script>
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

    // Загрузка проектов пользователя
    Ajax("backend/projects_controller.php", null, function(_data) {
        try {
            let projects = typeof _data === 'string' ? JSON.parse(_data) : _data;

            if (projects.error) {
                console.error("Ошибка при загрузке проектов:", projects.error);
                return;
            }

            let projectsGrid = $("#projects-grid");

            projects.forEach(function(project) {
                let creatorName = `${project.creator_last_name} ${project.creator_first_name} ${project.creator_middle_name}`;
                let isCreator = project.user_role === 'creator';

                let editButton = isCreator ? `<button class="btn-secondary" onclick="window.location.href='edit-project.php?project_id=${project.project_id}'">Редактировать</button>` : '';
                let deleteButton = isCreator ? `<button class="btn-secondary" id="sec" onclick="deleteProject(${project.project_id})">Удалить</button>` : '';

                let projectCard = `
                    <div class="project-card">
                        <div class="project-header">
                            <h3>${project.name}</h3>
                            <span class="project-status ${project.is_public ? 'public' : 'private'}">${project.is_public ? 'Открытый' : 'Закрытый'}</span>
                        </div>
                        <p class="project-description">${project.description}</p>
                        <div class="project-footer">
                            <span class="project-creator">Создатель: ${creatorName}</span>
                            <button class="btn-second"><a href="kanban.php?project_id=${project.project_id}" class="active">Открыть</a></button>
                        </div>
                        <div class="task-assignees">
                            ${deleteButton}
                            ${editButton}
                        </div>
                    </div>
                `;
                projectsGrid.append(projectCard);
            });
        } catch (e) {
            console.error("Ошибка при разборе данных проектов:", e);
            console.error("Ответ сервера:", _data);
        }
    });

    // Функция для удаления проекта
    function deleteProject(projectId) {
        if (confirm("Вы уверены, что хотите удалить этот проект?")) {
            // Создаем объект FormData для передачи данных
            let formData = new FormData();
            formData.append('project_id', projectId);

            Ajax("backend/delete_project_controller.php", formData, function(response) {
                try {
                    let result = typeof response === 'string' ? JSON.parse(response) : response;
                    if (result.success) {
                        alert("Проект успешно удален");
                        location.reload(); // Перезагружаем страницу для обновления списка проектов
                    } else {
                        alert("Ошибка при удалении проекта: " + result.error);
                    }
                } catch (e) {
                    console.error("Ошибка при разборе ответа:", e);
                    console.error("Ответ сервера:", response);
                }
            });
        }
    }
</script>

</body>
</html>
