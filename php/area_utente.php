<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AREA UTENTE</title>
</head>
<body>
    

    <div class="container color-lightb">

        <br>
        <h1 class="centered"><a href="../index.html">EASY LAN PORTAL</a></h1>
        <br><br>

        <?php
        if(!isset($_POST['username']) || !isset($_POST['pwd'])){
            die("Form non compilato");
            }
        echo "USERNAME: " . htmlentities($_POST['username'], ENT_HTML5, 'ISO-8859-1');
        ?>

        <br><br>
        
        
    </div>
    
</body>
</html>