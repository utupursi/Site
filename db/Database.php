<?php

class Database
{
    private $servername;
    private $username;
    private $password;
    private $database;
    public $errors=array();
    public $errors1=array();
    public $passwordErr=array();
    private $connection;

    public function __construct()
    {
        $config = require __DIR__ . '/../config.php';
        $this->servername = $config['host'];
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->database = $config['database'];
        $this->connection = new PDO("mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password);
        // set the PDO error mode to exception
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }

    public function loginUser($name,$email, $password)
    {
        $stmt = $this->getConnection()
            ->prepare("SELECT * FROM users ");
        $stmt->execute();
        $users = $stmt->fetchall();
        $t=0;
        foreach($users as $user){
            if ($user['full_name']==$name&&$user['email']!=$email){
                $this->errors[]="Email incorect";
            }
            if ($user['full_name']!=$name&&$user['email']==$email){
                $this->errors[]="Name incorrect";
            }
            if($user['full_name']==$name&&$user['email']==$email){
               if(password_verify($password,$user['password'])){
            $t++;
               }
               else{
                $this->errors[]="Incorrect password";
               }
               break;
            }
    }
      
        if ($t==1){
            $_SESSION['currentUser'] = $user;
            return true;
        }
   else {
   return false;
   }
    }
    public function signupUser($name,$email,$password){
        $stmt = $this->getConnection()
        ->prepare("SELECT * FROM users");
        $stmt->execute();
        $users = $stmt->fetchall();
        $i=0; 
        if (strlen($password) <= '8') {
            $this->passwordErr[] = "Your Password Must Contain At Least 8 Characters!";
        $i++;
        }
        elseif(!preg_match("#[0-9]+#",$password)) {
            $this->passwordErr[] = "Your Password Must Contain At Least 1 Number!";
            $i++;
        }
        elseif(!preg_match("#[A-Z]+#",$password)) {
            $this->passwordErr[] = "Your Password Must Contain At Least 1 Capital Letter!";
           $i++;
        }
        elseif(!preg_match("#[a-z]+#",$password)) {
            $this->passwordErr[] = "Your Password Must Contain At Least 1 Lowercase Letter!";
           $i++;
        }
        foreach($users as $user){
            if($user['full_name']==$name){
                $this->errors1[]='Name exist';
                $i++;
            }
            if($user['email']==$email){
                $this->errors1[]='Email exist';
                $i++;
            }
          
        }
        if($i>1){
            return false;
        }
        if($i<1){
            $password1=password_hash($password,PASSWORD_DEFAULT);
            $stmt = $this->getConnection()
            ->prepare("INSERT INTO users (full_name, email, password, reg_date)
            VALUES ('{$name}', '{$email}', '{$password1}', " . time() . ")");
           $stmt->execute();
           return true;
        }

    }
}
