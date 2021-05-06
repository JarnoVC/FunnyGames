<?php

include_once(__DIR__."/Database.php");


class User{
    
    
    
    
    private $username;
    private $email;
    private $password;
    private $confirmpassword;
    private $image;
    private $bio;
    private $status;

    private $oldEmail; 
    private $newEmail;
    private $newEmailCheck;
     

    

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername($username)
    {
        
        if (empty($username)) {
            throw new Exception("Please fill in a username");
        } 
        $this->username = $username;
        

        return $this;
    }

    /**
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        if (empty($email)) {
            throw new Exception("Please fill in an email adress");
        } 
        $this->email = $email;
        return $this;
        
        
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $option = [
            'cost' => 12,
        ];
        
        if (empty($password)) {
            throw new Exception("Please fill in a password");
        } elseif (strlen($password) < 8 || strlen($password) > 16) {
            throw new Exception("Password must be between 8 and 16 characters");
        }
        $this->password = password_hash($password, PASSWORD_BCRYPT, $option);
        return $this;
        
        
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of confirmpassword
     *
     * @return  self
     */ 
    public function setConfirm_password($confirm_password)
    {
        $option = [
            'cost' => 12,
        ];
        
        if (empty($confirm_password)) {
            throw new Exception("Please confirm your password");
            
        } elseif (strlen($confirm_password) < 8 || strlen($confirm_password) > 16) {
            throw new Exception("Password must be between 8 and 16 characters");
        }

        $this->confirm_password = password_hash($confirm_password, PASSWORD_BCRYPT, $option);
        
        return $this;
        
    }

    /**
     * Get the value of confirm_password
     */ 
    public function getConfirm_password()
    {
        return $this->confirm_password;
    }

    /*functie om te controleren of de mail die de gebruiker wilt nemen niet al bestata in de database*/
    public function validateEmail($email)
    {
        $conn = DB::Connection();
        $statement = $conn->prepare('SELECT * FROM user WHERE  email = :email ');
        $statement->bindvalue(':email', $email);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return true;
            
        } else {
            return false;
        }
    }
    /*functie om te controleren of de username die de gebruiker wilt nemen niet al bestaat in de database*/
    public function validateUsername($username)
    {
        $conn = DB::Connection();
        $statement = $conn->prepare('SELECT * FROM user WHERE  username = :username ');
        $statement->bindvalue(':username', $username);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return true;
            
        } else {
            return false;
        }
    }
    /*functie om de gebruiker te laten registreren*/
    public function register()
    {
        
        
        $conn = DB::Connection();
        $statement = $conn->prepare('INSERT INTO user (email, username, password) values (:email, :username, :password)');
        $email = $this->getEmail();
        $username = $this->getUsername();
        $password = $this->getPassword();
        //$confirm_password = $this->getConfirm_password();


        $statement->bindvalue(":email", $email);
        $statement->bindvalue(":username", $username);
        $statement->bindvalue(":password", $password);

        $statement->execute();
           
    }
    /*functie om de gebruiker in te laten loggen in zijn account*/
    public function login($email, $password)
    {
        $conn = DB::Connection();
        $statement = $conn->prepare('SELECT * FROM user WHERE email = :email');
        
        $statement->bindvalue(':email', $email);
        
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if ($user === false) {
            echo "nout found";
            return false;
            
        } else {
            if (password_verify($password, $user['password'])) {
                echo "succes";
                return true;
                
            } else {
                echo "fail";
                return false;
                
            }
        }

        
    }
    /*functie om de ID van een gebruiker te krijgen -> gebruiken
    om de correcte posts weer te geven voor de gebruiker*/
    public static function getIdByEmail($email){
        $conn = Db::Connection();
        $statement = $conn->prepare("SELECT id FROM user WHERE email = :email");
        $statement->bindValue(':email', $email);
        $statement->execute();
        $result = $statement->fetch();
        return $result['id'];
    }
    /*functie om gebruiker na het in te loggen door te verwijzen naar de hoofdpagina*/
    public function startSession($e) {
        session_start();
        $_SESSION['id'] = $e;
        header('location: index.php');
    }

    

    
}