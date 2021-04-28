<?php

require_once('../php/function.inc.php');
require_once('../php/session.inc.php');

class User {

    private $id,                //id_user
            $username,          //username      
            $email;             //email

    //attributi da customer
    //wip
    
    public function __construct(){
        $this->id = NULL;
        $this->username = NULL;
        $this->email = NULL;
    }

    public function __destruct(){
    }

    //setters and getters
    public function setId($value) {
        $this->id = $value;
    }

    public function setUsername(string $value) {
        $this->username = $value;
    }

    public function setEmail(string $value) {
        $this->email = $value;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getUsername(): ?string {
        return $this->username;
    }

    public function getEmail(): ?string{
      return $this->email;   
    }


    /* registrazione dell'utente nel Database */

    public function add_user($username, $pwd, $repeat_pwd, $email_address){
        //includo per la connessione
        require_once('../db/databasehandler.inc.php');

        //controllo che il risultato sia PER FORZA false, perchè in caso non sia nè true
        //nè false potrebbe non riconoscere l'errore
        if(emptyInputSignup($username, $pwd, $email_address) !== false){
            header('location:../signup.php?error=emptyinput');
            die();
        }
    
        if(invalidUserN($username) !== false){
            header('location:../signup.php?error=invalidusername');
            die();
        }
    
        if(invalidEmail($email_address) !== false){
            header('location:../signup.php?error=invalidemail');
            die();
        }
    
        if(invalidPwd($pwd) !== false){
            header('location:../signup.php?error=invalidpassword');
            die();
        }
    
        if(pwdMatch($pwd, $repeat_pwd) !== false){
            header('location:../signup.php?error=pwdsnotmatching');
            die();
        }
        
        //uso la conenssione al db, controllo se esiste già epoi procedo con il caricamento dei dati
        if(userExists($connection, $username, $email_address) !== false){
            header('location:../signup.php?error=useralreadyexists');
            die();
        }

        if(createUser($connection, $username, $pwd, $email_address) !== true){
            header('location:../signup.php?error=queryfailed');
            die();
        }

        //ora posso inserire i valori nell'oggetto User
        //no ho deciso di inviare l'utente alla login e non mischiare le cose

        //rimando l'utente alla pagina di signup con il codice corretto
        header('location:../signup.php?error=none&username='. $username);
        die();
    }

    public function login_user($username, $pwd){ 

        //includo per la connessione
        require_once('../db/databasehandler.inc.php');

        //controllo che il risultato sia PER FORZA false, perchè in caso non sia nè true
        //nè false potrebbe non riconoscere l'errore
        if(emptyInputLogin($username, $pwd) !== false){
            header('location:../login.php?error=emptyinput');
            die();
        }

        if(loginUser($connection, $username, $pwd) !== true){
            header('location:../login.php?error=queryfailed');
            die();
        }

        if(($uid_result = createSession($connection, $username)) == false){
            header('location:../login.php?error=sessionfailed');
            die();
        }
        
        return $uid_result;
        //fine script e si ritorna a login.inc.php
    }

    public function logout_user(){
        $this->__destruct();
        stopSession($this->username);
    }
}