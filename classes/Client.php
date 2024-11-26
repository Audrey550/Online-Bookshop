<?php 
    include_once(__DIR__."/Db.php");
    class Client{
        private $id;
        private $username;
        private $email;
        private $password;
        private $usertype;
        private $credits;
        
        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

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

            /**
         * Get the value of credits
         */ 
        public function getCredits()
        {
                return $this->credits;
        }

        /**
         * Set the value of credits
         *
         * @return  self
         */ 
        public function setCredits($credits)
        {
                $this->credits = $credits;

                return $this;
        }

        public function save(){
            //conn
            $conn = new PDO('mysql:host=localhost;dbname=bookshop', 'root', '');
            $conn = Db::getConnection();
            //Als de gebruiker geen admin is, stel dan de credits in op 1000
                if($this->usertype == 0){
                        $this->credits = 1000;
                }else{
                        $this->credits = 0;
                }

            //insert query
            $statement = $conn->prepare("INSERT INTO clients (username, email, password, usertype, credits) VALUES (:username, :email, :password, :usertype, :credits)"); 

            $statement->bindParam(":username", $this->username);
            $statement->bindParam(":email", $this->email);
            $statement->bindParam(":password", $this->password);
            $statement->bindParam(":usertype", $this->usertype); //Voeg usertype toe
            $statement->bindParam(":credits", $this->credits); //Voeg credits toe
            return $statement->execute(); 
         
        }

        public static function getByEmail($email){ 
                $conn = Db::getConnection();
                $statement = $conn->prepare("SELECT * FROM clients WHERE email = :email");
                $statement->bindParam(':email', $email);
                $statement->execute();

                $result = $statement->fetch(PDO::FETCH_ASSOC);
                //var_dump($result);

                if($result){
                        $client = new Client();
                        $client->setId($result['id']);
                        $client->username = $result['username'];
                        $client->email = $result['email'];
                        $client->password = $result['password']; //Haalt direct het gehashte wachtwoord op
                        $client->usertype = $result['usertype']; 
                        $client->credits = $result['credits'];

                        return $client;
                }else{
                        return null; //heeft geen gebruiker gevonden
                }
        }

        public function updateCredits($newCredits){
                $conn = Db::getConnection();
                $statement = $conn->prepare("UPDATE clients SET credits = :credits WHERE id = :id");
                $statement->bindParam(":credits", $newCredits);
                $statement->bindParam(":id", $this->id);
                return $statement->execute();
        }

        public function updatePassword($newPassword){
                $conn = Db::getConnection();
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT); //Herhash het nieuwe wachtwoord
                $statement = $conn->prepare("UPDATE clients SET password = :password WHERE id = :id");
                $statement->bindParam(":password", $hashedPassword);
                $statement->bindParam(":id", $this->id);
                return $statement->execute();        
        }

        public static function getAll(){
            $conn = Db::getConnection();
            $statement = $conn->query("SELECT * FROM clients");
            return $statement->fetchAll();
        } 
}
/*0 = regular
1 = admin */