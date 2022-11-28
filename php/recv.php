<?php

session_start();

// Проверка в аккаунте ли мы
if($_SESSION['login'] == NULL)
{
    exit();
}


//подключаемся к базе
require_once '../settings/db.php'; 
$connection = connect();
require_once 'time.php'; 


//получаем сообщение из базы
$query = "SELECT * FROM `message` ORDER BY `id` DESC LIMIT 100";
$recv = mysqli_query($connection, $query);
while (($rec = mysqli_fetch_assoc($recv))) {
    $query = "SELECT * FROM `user` WHERE `id` = '$rec[user_id]'";
    $us_re_v = mysqli_query($connection, $query);
    $us_re = mysqli_fetch_assoc($us_re_v);

    

    ?>
<div class="container-chat <?php
if($_SESSION['login'] == $us_re['login']){
echo 'darker';
}
?>">
		<figure>
			<img class="avatar" src="src/logo.png" alt="Avatar" style="width:100%;">
			<figcaption class="header-left"><?php
            if($rec['show_login']){
                echo $us_re['login'];
            }else{
                echo '<a style="color: rgb(' . $us_re['color_r'] . ',' . $us_re['color_g'] . ',' . $us_re['color_b'] . ');">Аноним</a>';
            }
            ?></figcaption>
		</figure>
		<br>
		<p><?php echo $rec['text']; ?></p>
        <?php
            $query = "SELECT * FROM `file` WHERE `message_id` = $rec[id]";
            $file_s = mysqli_query($connection, $query);
            if(($file_se = mysqli_fetch_assoc($file_s))){
                list($type, $format) = explode('/', $file_se['type']);
                if($type == 'image'){
                    ?>
                        <img src="files/<?php echo $file_se['name']; ?>" width="500px" alt=""><br>
                        Приложена картинка 🎨👉 <a href="files/<?php echo $file_se['name']; ?>">Открыть</a>
                    <?php
                }else
                if($type == 'video'){
                    ?>
                    Приложена видеозапись 🎞👉 <a href="files/<?php echo $file_se['name']; ?>">Смотреть</a>
                       
                    <?php
                }else{
                    ?>
                    Приложен Файл 🧧👉 <a href="files/<?php echo $file_se['name']; ?>">Скачать</a>
                    <?php
                }
               
            }

        ?>
		<span class="time"><?php echo show_time($rec['time']); ?></span>
	</div>
    <?php
}



?>