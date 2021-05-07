<?php

@include_once('../php/function.inc.php');
@include_once('php/session.inc.php');
@include_once('session.inc.php');
@include_once('../db/databasehandler.inc.php');
@include_once('db/databasehandler.inc.php');

class User {

    private $id,                //id_user
            $username,          //username      
            $email;             //email

    private $firstname,
            $lastname,
            $gender,
            $birth_date,
            $address,
            $city,
            $postal_code;

    //attributi da customer
    //wip
    
    public function __construct(){
        $this->id = NULL;
        $this->username = NULL;
        $this->email = NULL;
        $this->firstname = NULL;
        $this->lastname = NULL;
        $this->gender = NULL;
        $this->address = NULL;
        $this->postal_code = NULL;
        $this->birth_date = NULL;
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

    public function getId(){
        return $this->id;
    }

    public function getUsername(){
        return $this->username;
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

    public function getAddress(){
        if(isset($this->address))
            return $this->address;
        else 
            return "Unknown";
    }

    public function getCity(){
        if(isset($this->city))
            return $this->city;
        else 
            return "Unknown";
    } 

    public function getPostalCode(){
        if(isset($this->postal_code))
            return $this->postal_code;
        else 
            return "Unknown";
    }

    public function getBirth(){
        if(isset($this->birth_date))
            return $this->birth_date;
        else 
            return "Unknown";
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
        if(userExists($username, $email_address) !== false){
            header('location:../signup.php?error=useralreadyexists');
            die();
        }

        if($this->createDB($username, $pwd, $email_address) !== true){
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

        if($this->loginDB($username, $pwd) !== true){
            header('location:../login.php?error=queryfailed');
            die();
        }

        //a questo punto ho effettuato il login e posso popolare l'oggetto user
        $this->setEverything($username, false);
        return $this->id;
        //fine script e si ritorna a login.inc.php
    }


    public function getUserTuple($uid, bool $session){
        global $connection;
        //se $session è true, allora uid viene interpretato come la PK della sessione
        if($session){
            $session = getSessionTuple(session_id());
            $result = userExists($session['username'], $session['username']);
        }else
            $result = userExists($uid, $uid);

        if($result === false){
            header('location:../login.php?error=nouser');
            die();
        }else
            return $result;
    }

    public function setEverything($uid, bool $session){
        $values = $this->getUserTuple($uid, $session);
        if(!is_array($values)){
            header('location:../login.php?error=queryfailed');
            die();
        }
        $this->id = $values['id_user'];
        $this->username = $values['username'];
        $this->email = $values['email'];
    }

    public function setCustomer(){
        global $connection;
        //preparo la query
        $query = "SELECT * FROM customer WHERE id_user = :id_user";
        if(!isset($this->id))
            header('location:logout.inc.php');
        $values = array(':id_user'=> $this->id);

        global $connection;
        $statement = $connection->prepare($query);
        try{
            $statement->execute($values);
        }catch(PDOException $e){
            //errore
            return false;
        }

        //controllo se effettivamente ho una query e proseguo
        if($statement->rowCount() > 0){
            $statement = $statement->fetch(PDO::FETCH_ASSOC); 
        }else{
            //no tupla
            return false;
        }

        var_dump($statement);
        die();
    }

    private function loginDB($uid, $pwd){
        
        //controllo che l'utente cerchi di loggare un account che esiste effettivamente
        //se l'utente esiste ne ho già salvate le credenziali nella variabile
        $uid_result = $this->getUserTuple($uid, false);
    
        //se la password fornita è diversa da quella nel db ti rimando indietro
        if(password_verify($pwd, $uid_result['password']) === false){
            header('location:../login.php?error=wrongpassword');
            die();
        }else if(password_verify($pwd, $uid_result['password']) === true){
            return true;
        }
        echo "no";
        die();
    }

    private function createDB($username, $pwd, $email_address){

        //preparo la query
        $query = "INSERT INTO user( username, password, email) VALUES(:username, :password, :email_address)";
        
        //crypto la password e preparo l'array di valori
        $pwd = password_hash($pwd, PASSWORD_DEFAULT);
        $values = array(
            ':username'=> $_POST['username'],
            ':password' => $pwd,
            ':email_address' => $_POST['email_address']
        );
        global $connection;
        $statement = $connection->prepare($query);
        try{
            $statement->execute($values);
        }catch(PDOException $e){
            //return false;
            var_dump($statement);
            echo $e;
            
            die();
        }
        
        return true;
    }

    public function logout_user(){
        deleteSessionTuple($this->username);
        $this->__destruct();
    }
}