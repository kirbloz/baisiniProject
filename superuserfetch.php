<?php
@include('php/header.php');
if (!checkActiveSuper())
    header('location:superlogin.php?error=nosession'); //session

//salvo il power level
@include('php/function.inc.php');
$utente = generateSuperuserOBJ(session_id());

/*

SFRUTTO LA VAR SELECT NEL GET PER ESEGUIRE UN'AZIONE DIVERSA
PRIMA CONTROLLO CHE L'URL SIA LECITO

*/
//se idUser o matricola sono != empty allora entro nelle condizioni
if (!(isset($_GET)   &&  (isset($_GET['select']) || (isset($_GET['idUser']) || isset($_GET['matricola']))))) {
    header('location:areaSuperutente.php'); //sto cercando di accedere alla pagina in maniera illecita
}
/*
dopo aver controllato
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
        /*

        NON SONO STATI SPECIFICATI PARAMETRI PER LE TAB SINGOLE. ALLORA CONTROLLO
        IL VALORE DI SELECT PER DECIDERE A QUALE GESTIONE ACCEDERE
        (utenti/dipendenti/componenti/interventi)

    */
        echo '<div class="wrapper user-area">
                <div class="color-lightb user-nav">
                <ul>
                    <li><a href="areaSuperutente.php">Torna indietro</a></li>
                </ul>
            </div>';

        require_once('admin/adminfun.inc.php');
        //se effettivamente ho specificato dei parametri di ricerca aka il select vado
        //a eseguire lo script necessario
        if ($_GET['select'] == 'users') {
            /*
                            TABELLA UTENTI
        */
            if ($utente->getPower() < 1)
                echo "<p class='centered alert alert-danger col-4'> Non hai i privilegi per accedere a quest'area. </p>";
            else {
                fetchUsers();
            }
        } else if ($_GET['select'] == 'techs') {
            /*
                                TABELLA TECNICI
        */
            if ($utente->getPower() < 2)
                echo "<p class='centered alert alert-danger col-4'> Non hai i privilegi per accedere a quest'area. </p>";
            else {
                fetchTechs();
            }
        } else if ($_GET['select'] == 'components') {
            /*
                                TABELLA COMPONENTI
        */
            if ($utente->getPower() < 2) {
                echo "<p class='centered alert alert-danger col-4'> Non hai i privilegi per accedere a quest'area. </p>";
            } else {
                fetchComponents();
            }
        } else if ($_GET['select'] == 'works') {
            /*
                                TABELLA INTERVENTI
        */
            if ($utente->getPower() < 1) {
                echo "<p class='centered alert alert-danger col-4'> Non hai i privilegi per accedere a quest'area. </p>";
            } else {
                echo '</div><div class="wrapper">';
                fetchWorks(); //stampo il menu TROVA - AGGIUNGI
                //se è stato submittato il form di ricerca in fetchWorks, allora invoco fetchWorksShow

                if (isset($_GET['IdUserWork']) && $_GET['submit'] == 'Trova') {
                    fetchWorksShow($_GET['IdUserWork']); //stampo i lavori di un cliente

                } else if (isset($_GET['IdUserWork']) && $_GET['submit'] == 'Aggiungi') {
                    fetchWorksAdd($_GET['IdUserWork']); //stampo il form per l'aggiunta
                }

                //gestione dei messaggi d'errore
                if (isset($_GET['error']))
                    if ($_GET['error'] == 'noerror')
                        echo "<p class='centered alert alert-info col-4'> Intervento programmato correttamente. </p>";
                    else if ($_GET['error'] == 'query')
                        echo "<p class='centered alert alert-danger col-4'> C'&egrave; stato un problema col database. Riprova pi&ugrave; tardi o contattaci. </p>";
                echo "</div>";
            }
        } else if ($_GET['select'] == 'tickets') {
            /*
                                TABELLA TICKETS
            */
            if ($utente->getPower() < 0) {
                echo "<p class='centered alert alert-danger col-4'> Non hai i privilegi per accedere a quest'area. </p>";
            } else {
                echo '</div><div class="wrapper">';
                fetchTickets(); //stampo il menu TROVA - AGGIUNGI

                //gestione dei messaggi d'errore
                if (isset($_GET['error'])) {
                    if ($_GET['error'] == 'noerroredit')
                        echo "<p class='centered alert alert-success col-4'> Ticket modificato correttamente. </p>";
                    else if ($_GET['error'] == 'query')
                        echo "<p class='centered alert alert-danger col-4'> C'&egrave; stato un problema col database. Riprova pi&ugrave; tardi o contattaci. </p>";
                    else if ($_GET['error'] == 'noerrordelete')
                        echo "<p class='centered alert alert-info col-4'> Ticket eliminato correttamente. </p>";
                    echo "</div>";
                    die();
                }

                //se è stato submittato il form di ricerca in fetchTickets, invoco fetchTicketsShow
                if (isset($_GET['idUserTicket']) && $_GET['submit'] == 'Trova') {
                    //echo "show";
                    fetchTicketsShow($_GET['idUserTicket']); //stampo i ticket di un cliente

                    //non mi serve più l'else if perchè è tutto gestito dalla form in fetchTicketsShow che rimanda a ticketarea.inc.php
                }/* else if (isset($_GET['idUserTicket']) && $_GET['submit'] == 'Modifica') {
                    fetchTicketsEdit($_GET['idUserTicket']); //stampo il form per l'aggiunta
                    echo "edit";
                } else if (isset($_GET['idUserTicket']) && $_GET['submit'] == 'Elimina') {
                    fetchTicketsEdit($_GET['idUserTicket']); //stampo il form per l'aggiunta
                    echo "delete";

                }*/
                echo "</div>";
            }
        } else
            echo "<p class='centered alert alert-danger col-4'>Parametri errati</p>";
    }
}
