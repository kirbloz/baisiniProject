<?php
    if(!isset($_POST['username']) || !isset($_POST['pwd']))
    {
?>
<!DOCTYPE html>
<html lang="en">
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyLAN</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="wrapper login-box color-lightb">
        <br>
        <h1 class="centered"><a href="index.php">EASY LAN PORTAL</a></h1>
        <br>
        <form class="centered login-form" action="area_utente.php" method="post">
            <input type="text" name="username" placeholder="Nome utente" required>
            <br><br>
            <input type="email" name="email_address" placeholder="Indirizzo mail" required>
            <br><br>
            <input type="password" name="pwd" placeholder="Password" required>
            <br><br>
            <input type="text" name="id_customer" placeholder="ID Cliente" required>
            <br><br>
            <input class="button" id="reset" type="reset" value="RIPULISCI"/>
			<input class="button" id="confirm" type="submit" value="CONFERMA"/>
        </form>
        <br><br>
        <div class="centered redirect-login"> 
            <a href="loginpage.php">Gi&agrave; registrato? Clicca qui.</a>
        </div>
    </div>
</body>
</html>

<?php
    }else{
?>

<!DOCTYPE html>
<html lang="en">
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyLAN</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="wrapper login-box color-lightb">
        <br>
        <h1 class="centered"><a href="index.php">EASY LAN PORTAL</a></h1>
        <br>
        <div class="centered">
            
            <?php
                $username = $_POST['id_customer'];
                $pwd = $_POST['pwd'];

                if(strlen($id_customer) != 0 && strlen($pwd) != 0 && strlen($pwd) < 21){
                    $pwd = crypt($pwd, 0);
                    $connection = new mysqli("localhost", "root", "root", "easylandb");

                    $query = "SELECT * FROM user WHERE id_customer = '$id_customer'";
                    $result = $connection->query($query);

                    if($result->num_rows != 0)
                        echo "L'utente di cliente ID$id_customer &egrave; gi&agrave; registrato.";
                    else{
                        $query = "INSERT INTO user(id_customer, username, pwd, email) VALUES($id_customer, '$username', '$pwd', '$email_address')";
                        $connection->query($query);
                        echo "L'utente $username &egrave; stato registrato con successo.";
                    }
                }else
                    echo "Dati non validi.";
            ?>

        </div>
    </div>
</body>
</html>

<?php
    }
?>