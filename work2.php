<!DOCTYPE html>
<html>

<head>
    <title>Вилюнайте - Работа 2 </title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0' charset='utf-8'>
</head>

<body>
    <?php
        echo "<p><a href='index.html'>К содержанию</a>";
    ?>
    
    <h2> Список топовых игр</h2>
    <p><i>примечание: колонка "разработчик" заменена на колонку "платформы"</i></p>
    <?php
    $file_name = "data.txt";
    $data = file($file_name);
    $counter = 1;
    ?>
    <table border="1">
        <tr>
            <th>N</th>
            <th>Игра</th>
            <th>Жанр</th>
            <th>Год выпуска</th>
            <th>Платформы</th>
            <th>Издатель</th>
        </tr>
        <?php
        foreach ($data as $value) :
            $value = explode(";", $value);
        ?>
            <tr>
                <td><?= $counter ?></td>
                <td><?= $value[0] ?></td>
                <td><?= $value[1] ?></td>
                <td><?= $value[2] ?></td>
                <td><?= $value[3] ?></td>
                <td><?= $value[4] ?></td>
            </tr>
        <?php
        $counter++;
        endforeach;
        ?>
    </table>
</body>

</html>