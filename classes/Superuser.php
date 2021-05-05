<?php
@include_once('../php/function.inc.php');
@include_once('php/session.inc.php');
@include_once('session.inc.php');
@include_once('../db/databasehandler.inc.php');
@include_once('db/databasehandler.inc.php');
@include_once('../classes/User.php');
@include_once('classes/Superuser.php');
class Superuser extends User{

    private $matricola,
            $officeId;

    public function __construct(){
        $this->id = NULL;
        $this->matricola = NULL;
        $this->firstname = NULL;
        $this->lastname = NULL;
        $this->gender = NULL;
        $this->birth_date = NULL;
        $this->email = NULL;
    }

    public function __destruct(){
    }

    //setters and getters
    public function setId($value) {
        $this->id = $value;
    }

    public function setUsername(string $value) {
        $this->matricola = $value;
    }

    public function setEmail(string $value) {
        $this->email = $value;
    }

    public function getId(){
            return $this->id;
    }

    public function getUsername(){
        return $this->matricola;
    }

    public function getEmail(){
      return $this->email;   
    }

    public function getFirstname(){
        if(isset($this->firstname))
            return $this->firstname;
        else 
            return "Unknown";
    }

    public function getLastname(){
        if(isset($this->lastname))
            return $this->lastname;
        else 
            return "Unknown";
    }

    public function getGender(){
        if(isset($this->gender))
            return $this->gender;
        else 
            return "Unknown";
    }

    public function getBirth(){
        if(isset($this->birth_date))
            return $this->birth_date;
        else 
            return "Unknown";
    }

    public function login_superuser($matricola, $pwd){ 

        //includo per la connessione
        require_once('../db/databasehandler.inc.php');

        //controllo che il risultato sia PER FORZA false, perchè in caso non sia nè true
        //nè false potrebbe non riconoscere l'errore
        if(emptyInputLogin($matricola, $pwd) !== false){
            header('location:../superlogin.php?error=emptyinput');
            die();
        }
        
        if($this->loginDB($matricola, $pwd) !== true){
            header('location:../superlogin.php?error=queryfailed');
            die();
        }


        //a questo punto ho effettuato il login e posso popolare l'oggetto superuser
        $this->setEverything($matricola, false);
        echo "siii";
        die();
        return $this->id;
        //fine script e si ritorna a login.inc.php
    }

    //loginDB è ereditata, userExist e altre con le query vengono overridate
    //no non è vero
    private function loginDB($uid, $pwd){
        
        //controllo che l'utente cerchi di loggare un account che esiste effettivamente
        //se l'utente esiste ne ho già salvate le credenziali nella variabile
        $uid_result = $this->getUserTuple($uid, false);
    
        //se la password fornita è diversa da quella nel db ti rimando indietro
        if(password_verify($pwd, $uid_result['password']) === false){
            header('location:../superlogin.php?error=wrongpassword');
            die();
        }else if(password_verify($pwd, $uid_result['password']) === true){
            return true;
        }
        echo "no";
        die();
    }

    public function getUserTuple($uid, bool $session){

        global $connection;
        //se $session è true, allora uid viene interpretato come la PK della sessione
        if($session){
            $session = getSessionTuple(session_id(), "superuser");
            $result = userExists($session['username'], $session['username'], "superuser");
        }else
            $result = userExists($uid, $uid, "superuser");

        if($result === false){
            header('location:../superlogin.php?error=nouser');
            die();
        }else
            return $result;
    }

    private function getTechTuple($uid, bool $session){
        global $connection;
        //se $session è true, allora uid viene interpretato come la PK della sessione
        if($session){
            $session = getSessionTuple(session_id(), "superuser");
            $result = userExists($session['username'], $session['username'], "superuser");
        }else
            $result = userExists($uid, $uid, "superuser");

        if($result === false){
            header('location:../superlogin.php?error=nouser');
            die();
        }else
            return $result;
    }

    public function setEverything($uid, bool $session){

        $values = $this->getTechTuple($uid, $session);
        if(!is_array($values)){
            header('location:../superlogin.php?error=queryfailed');
            die();
        }
        var_dump($values);
        $this->id = $values['id_superuser'];
        $this->firstname = $values['firstname'];
        $this->lastname = $values['lastname'];
    }
//logout ereditario
}