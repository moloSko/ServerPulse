# ServerPulse

![ServerPulse Logo](Assets/ico/icon_serverpulse.png)

**ServerPulse** — это веб-приложение для мониторинга игровых серверов. Оно позволяет добавлять серверы, отслеживать их статус (онлайн/оффлайн), количество игроков и другую информацию. Также в приложении реализована система рекламных блоков, которые могут добавлять администраторы.

---

## Основные функции

- **Мониторинг серверов**:
  - Добавление серверов (название, IP, порт).
  - Отображение статуса серверов (онлайн/оффлайн).
  - Просмотр количества игроков и другой информации о сервере.

- **Рекламные блоки**:
  - Администраторы могут добавлять рекламные блоки.
  - Рекламные блоки отображаются в правой части страницы.

- **Авторизация и регистрация**:
  - Пользователи могут регистрироваться и входить в систему.
  - Администраторы имеют дополнительные права (добавление рекламы).

---

## Установка

### Требования

- Веб-сервер (например, Apache или Nginx).
- PHP 7.4 или выше.
- MySQL или MariaDB.
- Composer (для установки зависимостей).

### Шаги установки

1. **Клонируйте репозиторий**:

   ```bash
   git clone https://github.com/moloSko/ServerPulse.git
   cd ServerPulse```
2. **Установите зависимости:**:

- Установите библиотеку austinb/gameq для работы с игровыми серверами:
  ```bash
  composer require austinb/gameq:~3.1
  ```
- Затем установите остальные зависимости:
  ```bash
  composer install
  ```

3. **Настройте базу данных:**

  - Создайте базу данных MySQL.

  - Импортируйте структуру таблиц из файла database.sql (если он есть) или создайте таблицы вручную:

  ```sql
  Copy
  CREATE TABLE servers (
      id INT AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(255) NOT NULL,
      ip VARCHAR(15) NOT NULL,
      port INT NOT NULL
  );
  
  CREATE TABLE advertisements (
      id INT AUTO_INCREMENT PRIMARY KEY,
      title VARCHAR(255) NOT NULL,
      content TEXT NOT NULL,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  );
  
  CREATE TABLE users (
      id INT AUTO_INCREMENT PRIMARY KEY,
      username VARCHAR(50) NOT NULL UNIQUE,
      password VARCHAR(255) NOT NULL,
      role ENUM('user', 'admin') DEFAULT 'user',
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  );
  ```


4. **Настройте подключение к базе данных:**

- Отредактируйте файл DataBase/db.php и укажите данные для подключения к вашей базе данных:

  ```php
  <?php
  $host = 'localhost';
  $dbname = 'serverpulse';
  $user = 'root';
  $password = '';
  
  try {
      $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
      die("Ошибка подключения к базе данных: " . $e->getMessage());
  }
  ?>
  ```

5. **Запустите веб-сервер:**

- Если вы используете встроенный сервер PHP:

  ```bash
  php -S localhost:8000
  Откройте браузер и перейдите по адресу http://localhost:8000.
  ```


---

## Использование

### Добавление серверов
1. Перейдите на главную страницу.

2. Заполните форму:
 - Название сервера.
 - IP-адрес.
 - Порт.

3. Нажмите "Добавить сервер".

Просмотр статуса серверов
На главной странице отображается список серверов с их статусом (онлайн/оффлайн) и количеством игроков.

Нажмите на сервер, чтобы увидеть подробную информацию.

Добавление рекламы (для администраторов)
Авторизуйтесь как администратор.

В правой части страницы заполните форму:

Заголовок.

Содержимое.

Нажмите "Добавить рекламу".
