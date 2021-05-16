<?php
        @include('php/header.php');
        if(!checkActive())
            header('location:login.php?error=nosession'); //session
        @include('php/function.inc.php');
        $utente = generateUserOBJ(session_id());
        //var_dump($utente);
        
?>	

    <div class="wrapper user-area ">
        <br>

        <div class="row">
            <div class='color-lightb user-nav col'>
                <ul>
                    <li><a href="areaUtente.php">Torna indietro</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="wrapper user-info" style="text-align:left;">
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
                    <input type="text" class="form-control" placeholder="Titolo" >
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
                        <textarea class="form-control rounded-25" id="request" rows="5" max-rows="8"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="margin-top:5px;">Invia</button>
            </form>
        </div>
    </div>





</div>