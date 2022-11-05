<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COBA</title>
</head>
<body>
<?php if(logged_in()):?>
        <a href="/logout"> logout</a>
    <?php else:?>
        <a href="/login"> login</a>
    <?php endif;?>
    <br>

    <?=user()->email?>

    <?php echo (logged_in());?>
    <br><br><br><br><br><br>
    <?php print_r($dt2);?>
    <br>
    <?php print_r($t);
        echo '<br>';
        foreach ($t as $key) {
            echo $key["url"].'<br>';
            # code...
        }
    ?>
    <br>
    <?php dd($dt);?>
    

    

</body>
</html>