<?php

class DB
{
    protected $link;
    protected static $instance = null;

    protected function __construct()
    {
        // Соединение и выбор базы данных
        $link = mysqli_connect('localhost', 'root', '', 'Wnet');
        // Отслеживаем ошибки при соединении
        if(!$link){
            echo 'Ошибка:' . mysqli_connect_errno() . ':' . mysqli_connect_error();
        }else{
            $this -> link = $link;
        }
    }

    protected function __clone(){}

    public static function getInstance()
    {
        if(!self::$instance instanceof self){
            self::$instance = new self;
            return self::$instance;
        }
    }

    public function __destruct()
    {
        unset($this -> link);
    }

    public function getArray($id, $work, $connecting, $disconnected)
    {
        $query = "SELECT name_customer, company, number, date_sign, title_service,status
						FROM obj_customers 
						INNER JOIN obj_contracts ON obj_customers.id_customer = obj_contracts.id_customer
						INNER JOIN obj_services ON obj_contracts.id_contract = obj_services.id_contract
						WHERE (obj_customers.id_customer = '$id' OR obj_customers.name_customer = '$id')
						AND (obj_services.status = '$work' 
						OR obj_services.status = '$connecting'
						OR obj_services.status = '$disconnected')";

        $res = mysqli_query($this -> link, $query);

        if(!$res){
            echo mysqli_error($this -> link);
        }

        while($row = mysqli_fetch_assoc($res)){
            $arr[] = $row;
        }
            return $arr;

    }

}

