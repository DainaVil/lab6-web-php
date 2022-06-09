<!DOCTYPE html>
<html>

<head>
    <title>Вилюнайте - Работа 3 </title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0' charset='utf-8'>
</head>

<body>
    <?php
    echo "<p><a href='index.html'>К содержанию</a>";
    ?>
    <br>
    <?php
        $link = mysqli_connect("localhost", "root", "", "mysql") or die ('Я не могу подключиться к базе данных, так как: ' . mysqli_connect_error());
        $query = 'SELECT * FROM games';
        $result = mysqli_query($link, $query);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

    echo "<h2> Список топовых игр</h2>";

    // форма поиска
    echo "<form  method='post' action='work3.php?go'  id='searchform'>";  
        
        $names = mysqli_query($link, 'SELECT name FROM games');
        echo "<select name = 'name'>";
        echo "<option value = '' >Название</option>";
        while($object = mysqli_fetch_object($names)){
            echo "<option value = '$object->name' > $object->name </option>";
        }
        echo "</select>";?>
        <?php       
        
        $genres = mysqli_query($link, 'SELECT DISTINCT genre FROM games');
        echo "<select name = 'genre' >";
        echo "<option value = '' >Жанр</option>";
        while($object = mysqli_fetch_object($genres)){
            echo "<option value = '$object->genre' > $object->genre </option>";
        }
        echo "</select>";
        
        $years = mysqli_query($link, 'SELECT DISTINCT year FROM games');
        echo "<select name = 'year'>";
        echo "<option value = '' >Год выпуска</option>";
        while($object = mysqli_fetch_object($years)){
            echo "<option value = '$object->year' > $object->year </option>";
        }
        echo "</select>";
        
        $platforms = mysqli_query($link, 'SELECT DISTINCT `platform` FROM games');
        echo "<select name = 'platform'>";
        echo "<option value = '' >Платформа</option>";
        $rows = mysqli_fetch_all($platforms);
        $pls = [];
        foreach ($rows as $row) {
            $vals = explode(',', $row[0]);
            for ($i=0; $i<count($vals); $i++) {
                $vals[$i] = trim($vals[$i]);
                $flag=in_array($vals[$i], $pls);
                if (!$flag) {
                    $pls[] = $vals[$i];
                }
            }
        }
        foreach($pls as $object){
            echo "<option value = '$object' > $object </option>";
        }
        echo "</select>";
        
        $publishers = mysqli_query($link, 'SELECT DISTINCT publisher FROM games');
        echo "<select name = 'publisher'>";
        echo "<option value = '' >Издатель</option>";
        while($object = mysqli_fetch_object($publishers)){
            echo "<option value = '$object->publisher' > $object->publisher </option>";
        }
        echo "</select>";?>
        
        <input  type="text" name="search" placeholder="Поиск по имени, жанру итд"> 
        <button type="submit" name="submit">Поиск</button>
    </form> 
    

    <?php 
        if(isset($_POST['submit'])){ 
            if(isset($_GET['go'])){ 
                
                $name=$_POST['name']; 
                $genre=$_POST['genre'];
                $year=$_POST['year'];
                $platform=$_POST['platform'];
                $publisher=$_POST['publisher'];
                $search=$_POST['search']; 

                $str_name='';
                $str_genre = '';
                $str_year = '';
                $str_platform = '';
                $str_publisher = '';

                $query = "SELECT * FROM games";
                $added = false;

                if ($name != '') {
                    $str_name = "(name = '" . $name .  "')";
                    $query = $query . " WHERE " . $str_name;
                    $added = true;
                }
                if ($genre != '') {
                    $str_genre = "(genre = '" . $genre . "')";
                    if ($added) { 
                        $query = $query . " AND " . $str_genre;
                    }
                    else { 
                        $query = $query . " WHERE " . $str_genre;
                        $added = true;
                    }
                    
                }
                if ($year != '') {
                    $str_year = "(year = '" . $year . "')";
                    if ($added) { 
                        $query = $query . " AND " . $str_year; }
                    else {
                        $query = $query . " WHERE " . $str_year;
                        $added = true;
                    }
                }
                if ($platform != '') {
                    $str_platform = "(platform LIKE '%" . $platform .  "%')";
                    if ($added) { 
                        $query = $query . " AND " . $str_platform; }
                    else {
                        $query = $query . " WHERE " . $str_platform;
                        $added = true;
                    }
                }
                if ($publisher != '') {
                    $str_publisher = "(publisher = '" . $publisher . "')";
                    if ($added) { 
                        $query = $query . " AND " . $str_publisher;}
                    else {
                        $query = $query . " WHERE " . $str_publisher;
                        $added = true;
                    }
                }
                if ($search != '') {
                    $str_search = "(name LIKE '%" . $search .  "%') OR (genre LIKE '%" . $search .  "%') OR (publisher LIKE '%" . $search .  "%')";
                    if ($added) {
                        $query = $query . " AND " . $str_search;}
                    else {
                        $query = $query . " WHERE " . $str_search;
                    }
                }


                $link = mysqli_connect("localhost", "root", "", "mysql") or die ('Я не могу подключиться к базе данных, так как: ' . mysqli_connect_error());
                $result=mysqli_query($link, $query); 
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
                    while($value=mysqli_fetch_array($result)) {  
                ?>
                    <tr>
                        <td id="n"><?= $counter ?></td>
                        <td id="name"><?= $value['name'] ?></td>
                        <td id="genre"><?= $value['genre'] ?></td>
                        <td id="year"><?= $value['year'] ?></td>
                        <td id="platform"><?= $value['platform'] ?></td>
                        <td id="publisher"><?= $value['publisher'] ?></td>
                    </tr>
                    <?php $counter++; 
                    } ?>
                </table>
                <?php
                 
            } 
            }
        else {
            $query = 'SELECT * FROM games';
            $result = mysqli_query($link, $query);
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
                ?>
                    <tr>
                        <td id="n"><?= $counter ?></td>
                        <td id="name"><?= $value['name'] ?></td>
                        <td id="genre"><?= $value['genre'] ?></td>
                        <td id="year"><?= $value['year'] ?></td>
                        <td id="platform"><?= $value['platform'] ?></td>
                        <td id="publisher"><?= $value['publisher'] ?></td>
                    </tr>
                <?php
                    $counter++;
                endforeach;
                ?>
            </table>
        <?php } 
        ?>
        
</body>

</html>