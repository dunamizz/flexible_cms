<?php
class DB {
    private static $_instance = null;
    private $_pdo, 
            $_query,
            $_error = false,
            $_result,
            $_count = 0;
             
    private function __construct() {
        try {
            $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
            //echo 'Database connected';
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance() {
        if(!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;

    }
    public function query($sql, $params = array()) {
        $this->_error = false;
        if($this->_query = $this->_pdo->prepare($sql)) {
            if(count($params)) {
                $i = 1;
                foreach($params as $param) {
                    $this->_query->bindValue($i, $param);
                    $i++;
                }
            }
            if($this->_query->execute()) {
                $this->_result = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->error = true;
            }
        }
        return $this;
    }
    public function error() {
        return $this->_error;
    }
}