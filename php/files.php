<?php
session_start();
require_once '../settings/db.php';
require_once '../settings/root.php';
$connection = connect();

if($_SESSION['login'] == NULL){
    header(rootway() . "index.php");
}

        if (isset($_POST['btn'])) { // проверяем, нажали ли "Прикрепить"
            if (isset ($_FILES['file']) && $_FILES['file']['size'] > 0) { // проверяем, добавили ли в инпут файл (и чтобы он весил больше 0)
                $file = $_FILES['file']; // для удобства дробим части $_FILES (это массив) на переменные

                $name = $file['name'];
                $tmp = $file['tmp_name'];
                $size = $file['size'];
                $type = $file['type'];
                list($nm, $gyp) = explode('.', $name);
                if($gyp == 'php' OR $gyp == 'js' OR $gyp == 'html' OR $gyp == 'css'){
                    ?>
    <script>
        alert('Недопустимые файлы.'); 
        window.location.href = '../files.php';
    </script>
    <?php
                }else
                if ($size <= 10485760) { // если файл меньше 10 МБ, работаем
                    $new_name = time() . rand() . $name; // такие дела: если прикрепляешь файл с таким же именем, что уже существует в папке files (в неё кидаются все файлы), один заменяет другой. Во избежание этого вызываем функцию time(), которая генерирует длинное число, затем функцию rand(), которая генерирует случайное число (на случай, если одновременно отправляют одноимённые файлы), и добавлем к этому название файла с расширением (теперь Вы знаете, почему у скачиваемых файлов бывают странные названия в виде цифр и букв)

                    move_uploaded_file($tmp, '../files/' . $new_name); // перекидываем из временного хранилища в папку files

                    // а теперь надо занести это всё в базу данных

                    $query = "SELECT `id` FROM `user` WHERE `login` = '$_SESSION[login]'"; // узнаём id пользователя по логину из сессии (он уникален)
                    $recive = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($recive);

                    $query = "SELECT `show_login` FROM `setting` WHERE `user_id` = '$row[id]'"; // узнаём значение show_login в setting
                    $recive = mysqli_query($connection, $query);
                    $hider = mysqli_fetch_assoc($recive);

                    $query = "INSERT INTO `message` (`text`, `user_id`, `show_login`) VALUES ('Файл', '$row[id]', '$hider[show_login]')"; // создаём сообщение, к которому прикрепим файл
                    $recive = mysqli_query($connection, $query);

                    $time = date('Y-m-d H:i:s', time()); // узнаём текущую дату отправки файла

                    $query = "SELECT `id` FROM `message` WHERE `user_id` = '$row[id]' AND `time` = '$time'"; // по id пользователя и текущей дате узнаём id сообщения, чтобы знать, к чему прикреплять файл
                    $recive = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($recive);

                    $query = "INSERT INTO `file` (`message_id`, `name`, `type`) VALUES ('$row[id]', '$new_name', '$type')"; // добавляем информацию о файле: к какому сообщению относится, сгенерированное название и тип файла
                    $recive = mysqli_query($connection, $query);

                    header(rootway() . "chat.php"); // возвращаемся в чат после удачной отправки файла
                } else {
    ?>
    <script>
        alert('Размер файла не должен превышать 10 МБ.'); // выводим ошибку, если файл > 10 Мб (не факт, что работает. Может выскочить ошибка сервера из-за долгого ожидания)
        window.location.href = '../files.php';
    </script>
    <?php
                }
            } else {
    ?>
    <script>
        alert('Файл не загружен.'); // если на кнопку нажали, а файл не добавили
        window.location.href = '../files.php';
    </script>            
    <?php
            }
        }
    ?>
</body>
</html>