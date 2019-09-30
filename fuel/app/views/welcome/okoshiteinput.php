<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>okoshitekun</title>
</head>
<body>
    <?php
        Form::open();
        echo '<select name="year">';
        $year = Date::time()->format("%Y");
        for($i = $year;$i < $year + 5;$i++)
        {
            echo "<option value = {$i}>{$i}年</option>";
        }

        echo '</select>';
        echo '<select name="month">';
        $month = Date::time()->format("%M");

        for($i = 1;$i < 13;$i++)
        {
            echo "<option value = {$i}>{$i}月</option>";
        }

        echo '</select>';
        echo '<select name="day">';

        $day = Date::time()->format("%D");
        for($i = 1;$i < 32;$i++)
        {
            echo "<option value = {$i}>{$i}日</option>";
        }

        echo '</select>';
        Form::close();
    ?>
</body>
</html>