<?php 
    include_once(__DIR__."/Db.php");
    class Client{
        private $username;
        private $email;
        private $password;
        private $usertype;

        /**
         * Get the value of username
         */ 
        public function getUsername()
        {
                return $this->username;
        }

        /**
         * Set the value of username
         *
         * @return  self
         */ 
        public function setUsername($username)
        {
                if(empty($username)){
                    throw new Exception("Username cannot be empty 😫");
                }
                $this->username = $username;

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
         * Set the value of email
         *
         * @return  self
         */ 
        public function setEmail($email)
        {
                if(empty($email)){
                    throw new Exception("Email cannot be empty 😫");
                }
                $this->email = $email;

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
         * Set the value of password
         *
         * @return  self
         */ 
        public function setPassword($password)
        {
                if(empty($password)){
                    throw new Exception("Password cannot be empty 😫");
                }
                $this->password = password_hash($password, PASSWORD_DEFAULT);

                return $this;
        }

        public function getUsertype()
        {
                return $this->usertype;
        }

        public function setUsertype($usertype)
        {
                $this->usertype = $usertype; //zet de usertype               
        }

        public function save(){
            //conn
            $conn = Db::getConnection();
            //$conn = new PDO('mysql:host=localhost;dbname=bookshop', 'root', '');

            //insert query
            $statement = $conn->prepare("INSERT INTO clients (username, email, password, usertype) VALUES (:username, :email, :password, :usertype)"); 

            $statement->bindParam(":username", $this->username);
            $statement->bindParam(":email", $this->email);
            $statement->bindParam(":password", $this->password);
            $statement->bindParam(":usertype", $this->usertype); //Voeg usertype toe
            return $statement->execute(); 
         
        }

        public static function getByEmail($email){ 
                $conn = Db::getConnection();
                $statement = $conn->prepare("SELECT * FROM clients WHERE email = :email");
                $statement->bindParam(':email', $email);
                $statement->execute();

                $result = $statement->fetch(PDO::FETCH_ASSOC);

                if($result){
                        $client = new Client();
                        $client->username = $result['username'];
                        $client->email = $result['email'];
                        $client->password = $result['password']; //Haalt direct het gehashte wachtwoord op
                        $client->usertype = $result['usertype']; 
                        return $client;
                }else{
                        return null; //heeft geen gebruiker gevonden
                }
        }

        public static function getAll(){
            $conn = Db::getConnection();
            $statement = $conn->query("SELECT * FROM clients");
            return $statement->fetchAll();
        } 
}

/*0 = regular
1 = admin */