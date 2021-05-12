<?php

@include_once('../php/function.inc.php');
@include_once('php/session.inc.php');
@include_once('session.inc.php');
@include_once('../db/databasehandler.inc.php');
@include_once('db/databasehandler.inc.php');

class Superuser
{

        private $id,                //id_superuser
                $matricola,         //id_technician
                $email;             //username      

        private $firstname,
                $lastname,
                $gender,
                $birth_date,
                $id_supervisor,
                $id_office,
                $power;

        public function __construct()
        {
                $this->id = NULL;
                $this->matricola = NULL;
                $this->email = NULL;
                $this->firstname = NULL;
                $this->lastname = NULL;
                $this->birth_date = NULL;
                $this->gender = NULL;
                $this->id_supervisor = NULL;
                $this->id_office = NULL;
                $this->power = NULL;
        }

        public function __destruct(){
        }

        public function getEmail(){
                return $this->email;   
        }
        
        public function getFirstname(){
                return $this->firstname;
        }

        public function getLastname(){
                return $this->lastname;
        }

        public function getGender(){
        if(isset($this->gender))
                return $this->gender;
        else 
                return "Unknown";
        } 

        public function getBirth(){
                return $this->birth_date;
        } 

        public function getIdSupervisor(){
                return $this->id_supervisor;
        }

        public function getOffice(){
                return $this->id_office;
        }

        public function getPower(){
                return $this->power;
        }
        public function getSupervisorTuple(){
                @include_once('../db/databasehandler.inc.php');
                @include_once('db/databasehandler.inc.php');

                $result = superuserExists($this->id_supervisor);
                if ($result === false) {
                        return "Unknown";
                } else
                        return $result;
        }

        public function login_user($matricola, $pwd)
        {
                //includo per la connessione
                @require_once('../db/databasehandler.inc.php');

                //controllo che il risultato sia PER FORZA false, perchè in caso non sia nè true
                //nè false potrebbe non riconoscere l'errore
                if (emptyInputLogin($matricola, $pwd) !== false) {
                        header('location:../superlogin.php?error=emptyinput');
                        die();
                }
                
                if ($this->loginDB($matricola, $pwd) !== true) {
                        header('location:../superlogin.php?error=queryfailed');
                        die();
                }

                //a questo punto ho effettuato il login e posso popolare l'oggetto user
                $this->setEverything($matricola, false);
                return $this->id;
                //fine script e si ritorna a superlogin.inc.php
        }


        public function getUserTuple($uid, bool $session){
                global $connection;
                @include_once('../php/session.inc.php');
                //se $session è true, allora uid viene interpretato come la PK della sessione
                if ($session) {
                        $sessionArray = getSupersessionTuple(session_id());
                        $result = superuserExists($sessionArray['id_technician']);
                } else
                        $result = superuserExists($uid);

                if ($result === false) {
                        header('location:../superlogin.php?error=nouser');
                        die();
                } else
                        return $result;
        }

        public function setEverything($uid, bool $session)
        {
                $values = $this->getUserTuple($uid, $session);
                
                if (!is_array($values)) {
                        header('location:../superlogin.php?error=queryfailed');
                        die();
                }

                $this->id = $values['id_superuser'];
                $this->matricola = $values['id_technician'];
                $this->email = $values['email'];
                $this->firstname = $values['firstname'];
                $this->lastname = $values['lastname'];
                $this->gender = $values['gender'];
                $this->birth_date = $values['birth_date'];
                $this->id_supervisor = $values['id_supervisor'];
                $this->id_office = $values['id_office'];
                $this->power = $values['power'];
                
        }

        public function changePWD(string $pwd, string $repeat_pwd)
        {
                //includo per la connessione
                require_once('../db/databasehandler.inc.php');

                //controllo non necessario perchè lo faccio già in logout.inc
                /*if(emptyInputLogin($repeat_pwd, $pwd) !== false){
                header('location:userShowcase.php?redirect=changepwd&error=invalidinput');
                }*/

                //controllo che la pwd non sia uguale
                $uid_result = $this->getUserTuple($this->username, false);

                //se la password fornita è diversa da quella nel db ti rimando indietro
                if (password_verify($pwd, $uid_result['password']) === true) {
                        header('location:userShowcase.php?redirect=changepwd&error=samepwd');
                }

                //controllo che la pwd sia valida e matchi
                if (invalidPwd($pwd) !== false) {
                        header('location:userShowcase.php?redirect=changepwd&error=invalidinput');
                        die();
                }

                if (pwdMatch($pwd, $repeat_pwd) !== false) {
                        header('location:userShowcase.php?redirect=changepwd&error=nomatch');
                        die();
                }

                //inserisco la nuova pwd nel db
                //preparo la query
                $query = "UPDATE user SET password = :pwd_hash WHERE id_user = :id_user;";

                //crypto la password e preparo l'array di valori
                $pwd = password_hash($pwd, PASSWORD_DEFAULT);
                $values = array(
                        ':id_user' => $this->id,
                        ':pwd_hash' => $pwd
                );

                global $connection;
                $statement = $connection->prepare($query);
                try {
                        $statement->execute($values);
                } catch (PDOException $e) {
                        //return false;
                        var_dump($statement);
                        echo $e;
                        die();
                }
                //tutto a posto, lo script ritorna in logout.inc.php e andrà in logout.php
        }

        private function loginDB($uid, $pwd)
        {
                //controllo che l'utente cerchi di loggare un account che esiste effettivamente
                //se l'utente esiste ne ho già salvate le credenziali nella variabile
                $uid_result = $this->getUserTuple($uid, false);

                //se la password fornita è diversa da quella nel db ti rimando indietro
                if (password_verify($pwd, $uid_result['password']) === false) {
                        header('location:../superlogin.php?error=wrongpassword');
                        die();
                } else if (password_verify($pwd, $uid_result['password']) === true) {
                        return true;
                }
                echo "no";
                die();
        }

        public function logout_superuser()
        {
                deleteSessionTuple($this->username);
                $this->__destruct();
        }
        //da adattare alla classe
}
