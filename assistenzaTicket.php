<?php
        @include('php/header.php');
        if(!checkActive())
            header('location:login.php?error=nosession'); //session
        @include('php/function.inc.php');
        $utente = generateUserOBJ(session_id());
        //var_dump($utente);
        

        //controllo se ho submittato
    
?>	

    <div class="wrapper user-area ">
        <br>

        <div class="row">
            <div class='color-lightb user-nav col'>
                <ul>
                    <li><a href="areaUtente.php">Torna indietro</a></li>
                    <li><a href="assistenzaTicket.php?show=true">Visualizza i tuoi ticket</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="wrapper user-info" style="text-align:left;">

        <div class="row">
        <?php
            //var_dump($_POST);
            if(isset($_POST['submit'])){
                //controllo la compilazione del form
                if(empty($_POST['description']) || empty($_POST['title_request'])){
                    echo "<p class='centered error'>Compila tutti i campi.</p>";
                }else{
                    //procedo con il salvataggio e invio mail del ticket
                    if($utente->saveTicket($_POST))
                        echo "<p class='centered alert alert-info'>Ticket inviato con successo.</p>";
                        //echo "<p class='centered alert alert-info'>Non è stato possibile completare la richiesta. Riprova più tardi.</p>";
                
                }
            }else if (isset($_GET) && isset($_GET['show'])){
                //se non c'è stato un submit, controllo se è stato premuto il tasto di visione dei ticket
                $utente->showTicket();
            }
        ?>
        </div>
        <br>
        <div class="row">   
            <div class="container" >
                <div class="col">Compila i campi sottostanti per inviare un ticket d'assistenza via email alla nostra assistenza.</div>
            </div>
        </div>
        <br>
        <div class="row">
            <form action="" method="post">

                <div class="row g-3">
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="title_request" placeholder="Titolo" >
                    </div>
                    <div class="col-sm" style="text-align:left; padding-top:5px;">
                        <?php
                        date_default_timezone_set('Europe/Rome');
                        $orario = date('m/d/Y H:i:s');
                        echo $orario;
                        ?>
                        
                    </div>
                </div>

                <div class="row g-3">
                    <div class="form-group">
                        <label for="request">Inserisci qui la tua richiesta:</label>
                            <textarea name="description" class="form-control rounded-25" id="request" rows="5" max-rows="8"></textarea>
                    </div>
                </div>

            <input type="submit" class="btn btn-primary" name="submit" value="Invia" style="margin-top:5px;">
            </form>
        </div>
    </div>

<?php
        
?>



</div>