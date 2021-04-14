<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AREA UTENTE</title>
</head>
<body>
    <?php
        if(!isset($_POST['name']) || !isset($_POST['lastname']) || !isset($_POST['pwd']) || !isset($_POST['mail_address']) || !isset($_POST['gender'])){
            die("Form non compilato");
            }
    ?>
    
</body>
</html>