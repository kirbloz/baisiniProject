<?php 
/*
preparo questa pagina a sostituire userShowcase o superUserShowcase 
o almeno in parte perchè così faccio include e basta

forse
*/
    @include_once('../php/header.php');
    if(!checkActiveSuper())
        header('location:../superlogin.php?error=nosession'); //session
    @include_once('../php/function.inc.php');
    $utente = generateSuperuserOBJ(session_id());
?>

    <div class="wrapper user-area">

        <div class='color-lightb user-nav'>
            <ul>
                <li><?php
                if(isset($_GET['matricola']))
                    echo "<a href='fetchTechs.inc.php'>Torna indietro</a>";
                else if(isset($_GET['idUser']))
                    echo "<a href='fetchTechs.inc.php'>Torna indietro</a>";
                else 
                    echo "<a href='../areaSuperutente.inc.php'>Qui non c'&egrave; niente.</a>";
                ?></li>
            </ul>
        </div>

<?php
    echo "<br><br>";
    echo "superuser loggato: " . $utente->getLastname();
    echo "<br><br>";

    var_dump($_GET);
    echo "<br><br>";

    if(isset($_GET['matricola'])){
        $query = "SELECT id_superuser, superuser.id_technician, password, email, firstname, lastname, gender, birth_date, id_supervisor, labor_hourly, id_office, power FROM superuser INNER JOIN technician USING(id_technician) WHERE superuser.id_technician = :matricola;";
        $values[':matricola'] = $_GET['matricola'];

        global $connection;
        $statement = $connection->prepare($query);
        
        try{
            $statement->execute($values);
            
        }catch(PDOException $e){
            //header('location:../superlogin.php?error=queryfailed');
            echo $e;
            //die();
        }


        if($statement->rowCount() > 0)
            $statement=$statement->fetch(PDO::FETCH_ASSOC);
        else
            echo "error";
        var_dump($statement);

        /*
            aggiungere query per visualizzare i lavori del tecnico
            i suoi sottoposti
            il suo superiore
            la sua paga
            varie ed eventuali
        */
    }
    else if(isset($_GET['idUser'])){
        //preparo la query per la ricerca e l'array per i valori
        $query = "SELECT * FROM user LEFT JOIN customer USING(id_user) WHERE id_user = :iduser;";
        $values[':iduser'] = $_GET['idUser'];
        var_dump($values);

        global $connection;
        $statement = $connection->prepare($query);
        //se query multiple prepara prima e poi fai nel for con i rispetti values
        try{
            $statement->execute($values);
        }catch(PDOException $e){
            //header('location:../signup.php?error=queryfailed');
            //die();
            echo $e;
        }


        if($statement->rowCount() > 0)
            $statement=$statement->fetch(PDO::FETCH_ASSOC);  
        else
            echo "error";
        var_dump($statement);
        /*
            aggiungere query per visualizzare i lavori relativi alla persona
            i suoi ticket
            i suoi preventivi
            varie ed eventuali
        */
    }
    

    

    