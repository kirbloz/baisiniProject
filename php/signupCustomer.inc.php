<?php
@include_once('session.inc.php');
@include_once('php/session.inc.php');

if(!checkActive())
    header('location:logout.inc.php'); //session
@include('function.inc.php');
$utente = generateUserOBJ(session_id());

if(!isset($_POST['submit'])){
    //se l'utente è arrivato su questa pagina senza submittare il form
    //lo rispedisce indietro
    header('location:../signupCustomer.php?error=nosubmit');
    die();
}else{
    //includo la classe User
    require('../classes/Superuser.php');
    

    //salvo i dati POST nelle variabili
    $customer_values = array(
        'firstname' => $_POST['firstname'],
        'lastname' => $_POST['lastname'],
        'gender' => $_POST['gender'],
        'address' => $_POST['address'],
        'city' => $_POST['city'],
        'postal_code' => $_POST['postal_code'],
        'birth_date' => $_POST['birth_date']
    );

    //
    //      aggiungere controllo che mi permette di aggiornare le informazioni
    //      è più fast se cancello la tupla e la reinserisco altrimenti devo ricontrollare tutti i campi
    //

    //var_dump($customer_values);
    //die();
    //passo i valori alla funzione della classe user
    $utente->add_Customer($customer_values);
    //unset($_POST);
    die();
}