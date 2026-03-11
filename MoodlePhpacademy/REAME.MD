# PHP Academy — Moodle 5.1.3 для курсовой по PHP

**Автор:** Часовских Никита Эдуардович, группа БПИ 242  
**Дата:** 24 февраля 2026

## Структура проекта
MoodlePhpacademy/
├── moodle-docker/ ← официальный Docker от Moodle HQ
├── moodle/ ← полный исходный код Moodle 5.1.3 (MOODLE_501_STABLE)
├── blocks/phpinfo/ ← мой кастомный плагин (будет добавлен позже)
└── README.md

## Как запустить (PowerShell)

```powershell
# Перейти в папку moodle-docker
cd D:\Project\php\HSE\MoodlePhpacademy\moodle-docker

# Установить переменные окружения (ВАЖНО: используйте прямые слеши /)
$env:MOODLE_DOCKER_WWWROOT = "D:/Project/php/HSE/MoodlePhpacademy/moodle"
$env:MOODLE_DOCKER_DB = "pgsql"
$env:MOODLE_DOCKER_PHP_VERSION = "8.3"
$env:MOODLE_DOCKER_WEB_PORT = "8080"

# Запустить контейнеры
.\bin\moodle-docker-compose up -d

# Дождаться инициализации БД
.\bin\moodle-docker-wait-for-db

# Установка базы (только при первом запуске)
.\bin\moodle-docker-compose exec webserver php admin/cli/install_database.php `
  --agree-license `
  --fullname="PHP Academy" `
  --shortname="phpacademy" `
  --summary="Демо-платформа для курсовой" `
  --adminuser="admin" `
  --adminpass="admin123" `
  --adminemail="admin@phpacademy.local"

Доступ к системе
Адрес: http://localhost:8080
Логин: admin
Пароль: admin123
Что уже сделано
Moodle 5.1.3 в Docker (PostgreSQL + PHP 8.3)
Курс «Основы PHP для начинающих»В
Кастомный блок block_phpinfo
Важные замечания для Windows
Используйте прямые слеши (/) в путях для переменных окружения — это решает проблемы монтирования томов в Docker Desktop.
Добавьте папку D:\Project в File Sharing (Docker Desktop → Settings → Resources → File Sharing).
