<?php
session_start(); // Начинаем сессию
session_destroy(); // Уничтожаем сессию
header('Location: index.php'); // Перенаправляем на главную страницу
exit();
?>