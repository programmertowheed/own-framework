<?php

namespace System\libs;


/**
 * Main Model
 */
class Model
{

    protected $db = array();
    protected $queryResult;

    public function __construct()
    {
        $dbconfig = [
            "host" => DB_HOST,
            "port" => DB_PORT,
            "dbname" => DB_NAME,
            "charset" => DB_CHARSET,
        ];

        $dsn = "mysql:" . http_build_query($dbconfig, "", ";");
        
        $this->db = new Database($dsn, DB_USER, DB_PASSWORD);
    }

    public function query($sql, $data = array())
    {
        $this->queryResult = $this->db->rawQuery($sql, $data);
        return $this;
    }

    public function get()
    {
        $this->queryResult->execute();
        return (object)$this->queryResult->fetch();
    }

    public function all()
    {
        $this->queryResult->execute();
        return $this->queryResult->fetchAll();
    }


}


?>