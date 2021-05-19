    <?php
    @include('php/header.php');
    if (!checkActiveSuper())
        header('location:superlogin.php?error=nosession'); //session

    //salvo il power level
    @include('php/function.inc.php');
    $utente = generateSuperuserOBJ(session_id());


    //in base alla var specificata in get vado a eseguire script diversi
    //prima controllo se è necessario il redirect
    //se idUser o matricola sono != empty allora entro nelle condizioni
    if (!(isset($_GET)   &&  (isset($_GET['select']) || (isset($_GET['idUser']) || isset($_GET['matricola']))))) {
        header('location:areaSuperutente.php'); //sto cercando di accedere alla pagina in maniera illecita
    }
    /*
        dopo aver controllato che posso essere in questa pagina, 
        !(c'è get AND c'è select OR (idUser OR matricola))
        decido se visualizzare tabelle multiple(tutti gli utenti/superutenti) 
        o tabelle singole(1 utente/superutente)
    */ else {
        //se ho idUser o matricola allora devo stampare le tabelle singole
        if (isset($_GET['idUser']) || isset($_GET['matricola'])) {

            //stampo il tasto per tornare indietro
    ?>
            <div class="wrapper user-area">
                <div class='color-lightb user-nav'>
                    <ul>
                        <li><?php
                            if (isset($_GET['matricola']))
                                echo "<a href='superuserfetch.php?select=techs'>Torna indietro</a>";
                            else if (isset($_GET['idUser']))
                                echo "<a href='superuserfetch.php?select=users'>Torna indietro</a>";
                            ?></li>
                    </ul>
                </div>
        <?php

            //includo la pagina showdetails che si occupa di gestire le tabelle singole
            $_GET['superuser'] = true;
            if (isset($_GET['matricola']) && $utente->getPower() > 1)
                @require('common/showDetails.inc.php');
            else if (isset($_GET['idUser']) && $utente->getPower() > 0)
                @require('common/showDetails.inc.php');
            else
                echo "<br><br><p class='centered error' style='margin: 10px 0px;'> Non hai i privilegi per accedere a quest'area. </p>";
        } else {
            //se non ho l'id di un signolo user o tecnico mi preparo a visualizzare le tabelle multiple
            //quindi se faccio tabelle multiple
            echo '<div class="wrapper user-area">
                        <div class="color-lightb user-nav">
                        <ul>
                            <li><a href="areaSuperutente.php">Torna indietro</a></li>
                        </ul>
                    </div>
                    <br><br>';

            require_once('admin/adminfun.inc.php');
            //se effettivamente ho specificato dei parametri di ricerca aka il select vado
            //a eseguire lo script necessario
            if ($_GET['select'] == 'users') {

                /*
                                    TABELLA UTENTI
                */
                if ($utente->getPower() < 1)
                    echo "<p class='centered error' style='margin: 10px 0px;'> Non hai i privilegi per accedere a quest'area. </p>";
                else {
                    fetchUsers();
                    //ho stampato la tabella "fect users";
                }
            } else if ($_GET['select'] == 'techs') {

                /*
                                        TABELLA TECNICI
                */
                if ($utente->getPower() < 2)
                    echo "<p class='centered error'> Non hai i privilegi per accedere a quest'area. </p>";
                else {

                    fetchTechs();
                    //echo "fect techs";
                }
            } else if ($_GET['select'] == 'components') {
                if ($utente->getPower() < 2) {
                    echo "<p class='centered error'> Non hai i privilegi per accedere a quest'area. </p>";
                } else {

                    fetchComponents();
                }
            } else
                echo "<p class='centered error'>Parametri errati</p>";
        }
    }
        ?>