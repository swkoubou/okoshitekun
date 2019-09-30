<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>okoshitekun</title>
</head>
<body>
    <?php
    echo "<p>DBcreate: {$dbstate}</p>";
    echo "<p>Tablecreate: {$tablestate}</p>";
    echo Config::get('db.active');
    ?>
</body>
</html>