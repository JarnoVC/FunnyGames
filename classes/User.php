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

    
    public function validateEmail()
    {
        $conn = DB::Connection();
        $statement = $conn->prepare('SELECT email FROM user WHERE  email = :email ');
        $email = $this->getEmail();
        $statement->bindvalue(':email', $email);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if ($result) {
            throw new Exception("Email already in use");
            exit();
        }
    }

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

    public function login()
    {
        $conn = DB::Connection();
        $statement = $conn->prepare('SELECT * FROM users WHERE email = :email AND password = :password');
        $email = $this->getEmail();
        $password = $this->getPassword();
        
        $statement->bindvalue(':email', $email);
        $statement->bindValue(':password', $password);
        echo "lul";
        $statement->execute();
        
        $result = $statement->fetch();
        if(!$result){
            echo "nee";
            return false;
        }else{
            echo "hey";
            return true;
        }

        /*$hash = $result['password'];
        if(password_verify($password, $hash)) {
            return true;
        } else {
            return false;
            echo "pech";
        }*/
    }

    public static function getIdByEmail($email){
        $conn = Db::Connection();
        $statement = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $statement->bindValue(':email', $email);
        $statement->execute();
        $result = $statement->fetch();
        return $result['id'];
    }

    public function startSession($e) {
        session_start();
        $_SESSION['id'] = $e;
        header('location: index.php');
    }

    

    
}