<?php
    class Db{
        private static $conn = null; 
        //make sure to reuse a connection if it's already open. This is called a singleton pattern

        public static function getConnection(){
            if(self::$conn === null){
                //echo "👾";
                return self::$conn = new PDO('mysql:host=localhost;dbname=bookshop', 'root', '');
            }else{
                echo "😎";
                return self::$conn;
            }

            //$this refers to the current instance of an object, self instead refers to the current class itself
        }
    }