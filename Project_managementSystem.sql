-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 15 2025 г., 11:40
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `Project_managementSystem`
--

-- --------------------------------------------------------

--
-- Структура таблицы `kanban_columns`
--

CREATE TABLE `kanban_columns` (
  `column_id` int NOT NULL COMMENT 'Уникальный идентификатор колонки',
  `project_id` int NOT NULL COMMENT 'ID проекта, к которому относится колонка',
  `name` varchar(100) NOT NULL COMMENT 'Название колонки',
  `position` int NOT NULL COMMENT 'Позиция колонки на доске',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата и время создания колонки',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Дата и время последнего обновления колонки'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `kanban_columns`
--

INSERT INTO `kanban_columns` (`column_id`, `project_id`, `name`, `position`, `created_at`, `updated_at`) VALUES
(1, 1, 'новые', 1, '2025-05-15 08:03:53', '2025-05-15 08:03:53'),
(2, 1, 'в процессе', 2, '2025-05-15 08:03:53', '2025-05-15 08:03:53'),
(3, 1, 'можно проверять', 3, '2025-05-15 08:03:53', '2025-05-15 08:03:53'),
(4, 1, 'готово', 4, '2025-05-15 08:03:53', '2025-05-15 08:03:53'),
(5, 2, 'новые', 1, '2025-05-15 08:03:53', '2025-05-15 08:03:53'),
(6, 2, 'в процессе', 2, '2025-05-15 08:03:53', '2025-05-15 08:03:53'),
(7, 2, 'можно проверять', 3, '2025-05-15 08:03:53', '2025-05-15 08:03:53'),
(8, 2, 'готово', 4, '2025-05-15 08:03:53', '2025-05-15 08:03:53'),
(9, 3, 'новые', 1, '2025-05-15 08:03:53', '2025-05-15 08:03:53'),
(10, 3, 'в процессе', 2, '2025-05-15 08:03:53', '2025-05-15 08:03:53'),
(11, 3, 'можно проверять', 3, '2025-05-15 08:03:53', '2025-05-15 08:03:53'),
(12, 3, 'готово', 4, '2025-05-15 08:03:53', '2025-05-15 08:03:53');

-- --------------------------------------------------------

--
-- Структура таблицы `projects`
--

CREATE TABLE `projects` (
  `project_id` int NOT NULL COMMENT 'Уникальный идентификатор проекта',
  `name` varchar(255) NOT NULL COMMENT 'Название проекта',
  `description` text COMMENT 'Описание проекта',
  `is_public` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Флаг публичности проекта (открытый/закрытый)',
  `created_by` int NOT NULL COMMENT 'ID пользователя, создавшего проект',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата и время создания проекта',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Дата и время последнего обновления проекта'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `projects`
--

INSERT INTO `projects` (`project_id`, `name`, `description`, `is_public`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Разработка сайта \"Сказки\" ', 'Создание сайта для чтения сказок', 1, 1, '2025-05-15 07:53:21', '2025-05-15 07:53:21'),
(2, 'Мобильное приложение аптека', 'Разработка приложения для Android', 0, 2, '2025-05-15 07:53:21', '2025-05-15 07:53:21'),
(3, 'Портал дистанционного обучения', 'Портал для работников техникума', 1, 3, '2025-05-15 07:53:21', '2025-05-15 07:53:21');

-- --------------------------------------------------------

--
-- Структура таблицы `project_members`
--

CREATE TABLE `project_members` (
  `project_member_id` int NOT NULL COMMENT 'Уникальный идентификатор связи участника с проектом',
  `project_id` int NOT NULL COMMENT 'ID проекта',
  `user_id` int NOT NULL COMMENT 'ID пользователя-участника',
  `role` enum('creator','admin','member') NOT NULL COMMENT 'Роль пользователя в проекте (создатель, администратор, участник)',
  `joined_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата и время присоединения к проекту'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `project_members`
--

INSERT INTO `project_members` (`project_member_id`, `project_id`, `user_id`, `role`, `joined_at`) VALUES
(1, 1, 1, 'creator', '2025-05-15 07:55:32'),
(2, 1, 2, 'admin', '2025-05-15 07:55:32'),
(3, 1, 3, 'member', '2025-05-15 07:55:32'),
(4, 2, 2, 'creator', '2025-05-15 07:55:32'),
(5, 2, 1, 'member', '2025-05-15 07:55:32'),
(6, 2, 3, 'member', '2025-05-15 07:55:32'),
(7, 3, 3, 'creator', '2025-05-15 07:55:32'),
(8, 3, 1, 'admin', '2025-05-15 07:55:32'),
(9, 3, 2, 'member', '2025-05-15 07:55:32');

-- --------------------------------------------------------

--
-- Структура таблицы `subtasks`
--

CREATE TABLE `subtasks` (
  `subtask_id` int NOT NULL COMMENT 'Уникальный идентификатор подзадачи',
  `task_id` int NOT NULL COMMENT 'ID родительской задачи',
  `name` varchar(255) NOT NULL COMMENT 'Название подзадачи',
  `description` text COMMENT 'Подробное описание подзадачи',
  `due_date` datetime DEFAULT NULL COMMENT 'Срок выполнения подзадачи',
  `column_id` int NOT NULL COMMENT 'ID колонки, в которой находится подзадача',
  `assigned_to` int DEFAULT NULL COMMENT 'ID пользователя, ответственного за подзадачу',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата и время создания подзадачи',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Дата и время последнего обновления подзадачи'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `subtasks`
--

INSERT INTO `subtasks` (`subtask_id`, `task_id`, `name`, `description`, `due_date`, `column_id`, `assigned_to`, `created_at`, `updated_at`) VALUES
(1, 1, 'Подбор иллюстраций', 'Выбор сказочных иллюстраций для главной страницы', '2025-05-05 00:00:00', 1, 2, '2025-05-15 08:19:37', '2025-05-15 08:19:37'),
(2, 1, 'Анимация элементов', 'Разработка анимации для интерактивных элементов', '2025-05-07 00:00:00', 1, 1, '2025-05-15 08:19:37', '2025-05-15 08:19:37'),
(3, 1, 'Адаптация под мобильные', 'Оптимизация дизайна для мобильных устройств', '2025-05-08 00:00:00', 1, 3, '2025-05-15 08:19:37', '2025-05-15 08:19:37'),
(4, 2, 'Верстка навигации', 'Реализация меню и навигационной панели', '2025-05-08 00:00:00', 2, 2, '2025-05-15 08:19:37', '2025-05-15 08:19:37'),
(5, 2, 'Каталог сказок', 'Верстка страницы со списком сказок', '2025-05-09 00:00:00', 2, 3, '2025-05-15 08:19:37', '2025-05-15 08:19:37'),
(6, 2, 'Страница чтения', 'Верстка страницы для чтения сказок', '2025-05-10 00:00:00', 2, 1, '2025-05-15 08:19:37', '2025-05-15 08:19:37'),
(7, 3, 'Тест формы регистрации', 'Проверка работы формы регистрации пользователей', '2025-05-10 00:00:00', 3, 3, '2025-05-15 08:19:37', '2025-05-15 08:19:37'),
(8, 3, 'Тест формы обратной связи', 'Проверка отправки сообщений через форму', '2025-05-11 00:00:00', 3, 1, '2025-05-15 08:19:37', '2025-05-15 08:19:37'),
(9, 3, 'Тест формы поиска', 'Проверка функционала поиска сказок', '2025-05-11 00:00:00', 3, 2, '2025-05-15 08:19:37', '2025-05-15 08:19:37'),
(10, 4, 'Экран поиска лекарств', 'Разработка прототипа экрана поиска', '2025-05-11 00:00:00', 2, 2, '2025-05-15 08:19:37', '2025-05-15 08:19:37'),
(11, 4, 'Карточка препарата', 'Создание прототипа карточки лекарства', '2025-05-12 00:00:00', 2, 1, '2025-05-15 08:19:37', '2025-05-15 08:19:37'),
(12, 4, 'Корзина заказов', 'Прототип экрана корзины для заказа', '2025-05-12 00:00:00', 2, 3, '2025-05-15 08:19:37', '2025-05-15 08:19:37'),
(13, 5, 'API поиска лекарств', 'Разработка API для поиска препаратов', '2025-05-10 00:00:00', 1, 1, '2025-05-15 08:19:37', '2025-05-15 08:19:37'),
(14, 5, 'API аптек', 'Интеграция с базами данных аптек', '2025-05-11 00:00:00', 1, 3, '2025-05-15 08:19:37', '2025-05-15 08:19:37'),
(15, 5, 'API заказов', 'Реализация API для оформления заказов', '2025-05-12 00:00:00', 1, 2, '2025-05-15 08:19:37', '2025-05-15 08:19:37'),
(16, 6, 'Тест API поиска', 'Проверка работы поиска лекарств', '2025-05-12 00:00:00', 3, 3, '2025-05-15 08:19:37', '2025-05-15 08:19:37'),
(17, 6, 'Тест API заказов', 'Тестирование процесса оформления заказа', '2025-05-13 00:00:00', 3, 1, '2025-05-15 08:19:37', '2025-05-15 08:19:37'),
(18, 6, 'Тест производительности', 'Нагрузочное тестирование API', '2025-05-13 00:00:00', 3, 2, '2025-05-15 08:19:37', '2025-05-15 08:19:37'),
(19, 7, 'Опрос преподавателей', 'Сбор требований от преподавателей', '2025-05-10 00:00:00', 3, 3, '2025-05-15 08:19:37', '2025-05-15 08:19:37'),
(20, 7, 'Анализ конкурентов', 'Исследование аналогичных платформ', '2025-05-11 00:00:00', 3, 1, '2025-05-15 08:19:37', '2025-05-15 08:19:37'),
(21, 7, 'Составление ТЗ', 'Формирование технического задания', '2025-05-12 00:00:00', 3, 2, '2025-05-15 08:19:37', '2025-05-15 08:19:37'),
(22, 8, 'Схема базы данных', 'Проектирование структуры БД', '2025-05-12 00:00:00', 1, 1, '2025-05-15 08:19:37', '2025-05-15 08:19:37'),
(23, 8, 'Схема API', 'Разработка архитектуры API', '2025-05-13 00:00:00', 1, 2, '2025-05-15 08:19:37', '2025-05-15 08:19:37'),
(24, 8, 'Схема модулей', 'Планирование модулей системы', '2025-05-13 00:00:00', 1, 3, '2025-05-15 08:19:37', '2025-05-15 08:19:37'),
(25, 9, 'Модуль авторизации', 'Реализация системы входа', '2025-05-13 00:00:00', 2, 2, '2025-05-15 08:19:37', '2025-05-15 08:19:37'),
(26, 9, 'Модуль курсов', 'Разработка функционала курсов', '2025-05-14 00:00:00', 2, 3, '2025-05-15 08:19:37', '2025-05-15 08:19:37'),
(27, 9, 'Модуль тестирования', 'Создание системы тестов', '2025-05-14 00:00:00', 2, 1, '2025-05-15 08:19:37', '2025-05-15 08:19:37');

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int NOT NULL COMMENT 'Уникальный идентификатор задачи',
  `project_id` int NOT NULL COMMENT 'ID проекта, к которому относится задача',
  `column_id` int NOT NULL COMMENT 'ID колонки, в которой находится задача',
  `name` varchar(255) NOT NULL COMMENT 'Название задачи',
  `description` text COMMENT 'Описание задачи',
  `due_date` datetime DEFAULT NULL COMMENT 'Срок выполнения задачи',
  `created_by` int NOT NULL COMMENT 'ID пользователя, создавшего задачу',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата и время создания задачи',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Дата и время последнего обновления задачи'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`task_id`, `project_id`, `column_id`, `name`, `description`, `due_date`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Дизайн главной страницы', 'Создать макет главной страницы', '2025-05-10 00:00:00', 1, '2025-05-15 08:09:37', '2025-05-15 08:09:37'),
(2, 1, 2, 'Верстка шаблонов', 'Адаптивная верстка страниц', '2025-05-10 00:00:00', 2, '2025-05-15 08:09:37', '2025-05-15 08:09:37'),
(3, 1, 3, 'Тестирование форм', 'Проверка работы форм обратной связи', '2025-05-11 00:00:00', 3, '2025-05-15 08:09:37', '2025-05-15 08:09:37'),
(4, 2, 1, 'Прототип приложения', 'Создать прототип экранов', '2025-05-12 00:00:00', 2, '2025-05-15 08:09:37', '2025-05-15 08:09:37'),
(5, 2, 2, 'API бэкенда', 'Разработка серверной части', '2025-05-12 00:00:00', 1, '2025-05-15 08:09:37', '2025-05-15 08:09:37'),
(6, 2, 3, 'Тестирование API', 'Проверка всех устройств', '2025-05-12 00:00:00', 3, '2025-05-15 08:09:37', '2025-05-15 08:09:37'),
(7, 3, 1, 'Сбор требований', 'Интервью с отделами', '2025-05-12 00:00:00', 3, '2025-05-15 08:09:37', '2025-05-15 08:09:37'),
(8, 3, 2, 'Архитектура портала', 'Проектирование структуры', '2025-05-13 00:00:00', 1, '2025-05-15 08:09:37', '2025-05-15 08:09:37'),
(9, 3, 3, 'Разработка модулей', 'Создание основных модулей', '2025-05-13 00:00:00', 2, '2025-05-15 08:09:37', '2025-05-15 08:09:37');

-- --------------------------------------------------------

--
-- Структура таблицы `task_assignees`
--

CREATE TABLE `task_assignees` (
  `task_assignee_id` int NOT NULL COMMENT 'Уникальный идентификатор назначения',
  `task_id` int NOT NULL COMMENT 'ID задачи',
  `user_id` int NOT NULL COMMENT 'ID пользователя, ответственного за задачу',
  `assigned_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата и время назначения'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `task_assignees`
--

INSERT INTO `task_assignees` (`task_assignee_id`, `task_id`, `user_id`, `assigned_at`) VALUES
(1, 1, 1, '2025-05-15 08:10:31'),
(2, 1, 2, '2025-05-15 08:10:31'),
(3, 2, 2, '2025-05-15 08:10:31'),
(4, 2, 3, '2025-05-15 08:10:31'),
(5, 3, 3, '2025-05-15 08:10:31'),
(6, 4, 2, '2025-05-15 08:10:31'),
(7, 4, 1, '2025-05-15 08:10:31'),
(8, 5, 1, '2025-05-15 08:10:31'),
(9, 5, 3, '2025-05-15 08:10:31'),
(10, 6, 3, '2025-05-15 08:10:31'),
(11, 7, 3, '2025-05-15 08:10:31'),
(12, 7, 1, '2025-05-15 08:10:31'),
(13, 8, 1, '2025-05-15 08:10:31'),
(14, 8, 2, '2025-05-15 08:10:31'),
(15, 9, 2, '2025-05-15 08:10:31'),
(16, 9, 3, '2025-05-15 08:10:31');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL COMMENT 'Уникальный идентификатор пользователя',
  `email` varchar(255) NOT NULL COMMENT 'Электронная почта',
  `password` varchar(255) NOT NULL COMMENT 'Пароль пользователя',
  `first_name` varchar(100) NOT NULL COMMENT 'Имя пользователя',
  `last_name` varchar(100) NOT NULL COMMENT 'Фамилия пользователя',
  `middle_name` varchar(100) DEFAULT NULL COMMENT 'Отчество пользователя',
  `biography` text COMMENT 'Биография',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата и время создания записи',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Дата и время последнего обновления записи'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `first_name`, `last_name`, `middle_name`, `biography`, `created_at`, `updated_at`) VALUES
(1, 'ivan345ZA@gmail.com', '$01af5bb4da8e28c33a37e6ce713a70f3', 'Иван', 'Жуков', 'Александрович', 'Руководитель проектов', '2025-05-15 07:47:36', '2025-05-15 07:47:36'),
(2, 'petr678PP@gmail.com', '$711f17a2c3fc51021026d89c773121af', 'Петр', 'Петров', 'Петрович', 'Разработчик', '2025-05-15 07:47:36', '2025-05-15 07:47:36'),
(3, 'anna123OS@gmail.com', '$343e0f58a8679f1219af5014e029553c', 'Ангелина', 'Орлова', 'Сергеевна', 'Тестировщик', '2025-05-15 07:47:36', '2025-05-15 07:47:36');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `kanban_columns`
--
ALTER TABLE `kanban_columns`
  ADD PRIMARY KEY (`column_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Индексы таблицы `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Индексы таблицы `project_members`
--
ALTER TABLE `project_members`
  ADD PRIMARY KEY (`project_member_id`),
  ADD UNIQUE KEY `project_id` (`project_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `subtasks`
--
ALTER TABLE `subtasks`
  ADD PRIMARY KEY (`subtask_id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `column_id` (`column_id`),
  ADD KEY `assigned_to` (`assigned_to`);

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `column_id` (`column_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Индексы таблицы `task_assignees`
--
ALTER TABLE `task_assignees`
  ADD PRIMARY KEY (`task_assignee_id`),
  ADD UNIQUE KEY `task_id` (`task_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `kanban_columns`
--
ALTER TABLE `kanban_columns`
  MODIFY `column_id` int NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор колонки', AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор проекта', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `project_members`
--
ALTER TABLE `project_members`
  MODIFY `project_member_id` int NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор связи участника с проектом', AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `subtasks`
--
ALTER TABLE `subtasks`
  MODIFY `subtask_id` int NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор подзадачи', AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор задачи', AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `task_assignees`
--
ALTER TABLE `task_assignees`
  MODIFY `task_assignee_id` int NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор назначения', AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор пользователя', AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `kanban_columns`
--
ALTER TABLE `kanban_columns`
  ADD CONSTRAINT `kanban_columns_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `project_members`
--
ALTER TABLE `project_members`
  ADD CONSTRAINT `project_members_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_members_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `subtasks`
--
ALTER TABLE `subtasks`
  ADD CONSTRAINT `subtasks_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`task_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subtasks_ibfk_2` FOREIGN KEY (`column_id`) REFERENCES `kanban_columns` (`column_id`),
  ADD CONSTRAINT `subtasks_ibfk_3` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`column_id`) REFERENCES `kanban_columns` (`column_id`),
  ADD CONSTRAINT `tasks_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `task_assignees`
--
ALTER TABLE `task_assignees`
  ADD CONSTRAINT `task_assignees_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`task_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_assignees_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
