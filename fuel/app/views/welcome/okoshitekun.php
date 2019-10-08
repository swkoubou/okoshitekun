<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>okoshitekun</title>
    <?php echo Asset::css('okoshite.css'); ?>
</head>
<body>
<div class="Currenttime">
    <script type="text/javascript">
        //時限表示 時間を時限に変換して返す
        function period(num)
        {
            let frame;
            if (num < 930 || num > 1810)
            {
                frame = "放課";
            }
            else if (num < 1100)
            {
                frame = "1限目";
            }
            else if (num < 1240)
            {
                frame = "2限目";
            }
            else if (num < 1450)
            {
                frame = "3限目";
            }
            else if (num < 1630)
            {
                frame = "4限目";
            }
            else if (num < 1810)
            {
                frame = "5限目";
            }
            return frame;
        }
        //起こす人表示　時間を受け取ってその時間に起こす必要がある人を返す
        function sleeplist(num){
            var people;
            if (num < 930)
            {
                people = "<?php echo $rows['one']; ?>";
            }
            else if (num < 1110)
            {
                people = "<?php echo $rows['two']; ?>";
            }
            else if (num < 1320)
            {
                people = "<?php echo $rows['three']; ?>";
            }
            else if (num < 1500)
            {
                people = "<?php echo $rows['four']; ?>";
            }
            else if (num < 1640)
            {
                people = "<?php echo $rows['five']; ?>";
            }else{
                people = "";
            }
            return people;
        }
        //桁揃え　9以下の数字を入れると頭に0をつけて返す
        function digit(num)
        {
            let bar;
            if (num<10)
            {
                bar = '0'+num;
            }
            else
            {
                bar = num;
            }
            return bar;
        }
        //htmlに値を表示させてsetintervalで1000msecごとに表示を更新する
        function time()
        {
            //currenttime 日付インスタンス
            let currenttime = new Date();
            frame.innerHTML=
                period(currenttime.getHours() + '' + digit(currenttime.getMinutes()));
            date.innerHTML=
                currenttime.getMonth() + 1 + '/' + currenttime.getDate() + ' ' + currenttime.getHours() + ':' + digit(currenttime.getMinutes());
            sleep.innerHTML=
                sleeplist(currenttime.getHours() + '' + digit(currenttime.getMinutes()));
        }
        setInterval(time,1000);
    </script>
    <h1 id="frame">時限</h1>
    <p id="date">時刻</p>
</div>
<div class="Sleep">
    <p id='sleep'>hogeさん</p>
    <?php
    ?>
</div>
<div class="Sleep_list">
    <dl class="Timetable">
        <?php
        //起こす人一覧表示
        for ($i=1;$i<6;$i++)
        {
            switch ($i){
                case 1:
                    $k = 'one';
                    break;
                case 2:
                    $k = 'two';
                    break;
                case 3:
                    $k = 'three';
                    break;
                case 4:
                    $k = 'four';
                    break;
                case 5:
                    $k = 'five';
                    break;
                default:
                    $k = 'after';
            }
            echo "<dt>{$i}限目</dt>";
            //rows 現在年月日と一致するdateを持ったレコード
            echo "<dd>$rows[$k]</dd>";
        }
        ?>
    </dl>
</div>
<?php
?>
</body>
</html>