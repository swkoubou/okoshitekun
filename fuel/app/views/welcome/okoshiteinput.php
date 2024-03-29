<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>okoshitekun</title>
</head>
<body>
    <?php
        echo Form::open('input/dbinput');

        //年のセレクトボックス
        echo '<select name="year">';
        $year = Date::time()->format("%Y");
        for($i = $year;$i < $year + 5;$i++)
        {
            echo "<option value = {$i}>{$i}年</option>";
        }
        echo '</select>';

        //月のセレクトボックス
        echo '<select name="month">';
        $month = Date::time()->format("%M");
        for($i = 1;$i < 13;$i++)
        {
            echo "<option value = {$i}>{$i}月</option>";
        }
        echo '</select>';

        //日のセレクトボックス
        echo '<select name="day">';
        $day = Date::time()->format("%D");
        for($i = 1;$i < 32;$i++)
        {
            echo "<option value = {$i}>{$i}日</option>";
        }
        echo '</select>';

        //checkbox表示
        $i = 1;
        foreach($period as $periods)
        {
            echo "<p>~{$i}限目</p>";
            $i++;
            foreach($kouboumin as $people)
            {
                //id=name+period
                echo Form::checkbox($people.$periods,$people);
                echo Form::label($people,$people.$periods).'  ';
            }
        }

        echo '<br>'.Form::submit();

        echo Form::close();
    ?>
</body>
</html>