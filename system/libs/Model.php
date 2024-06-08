<?php

namespace System\libs;


/**
 * Main Model
 */
class Model
{

    protected $db;
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

        //$this->db = new Database($dsn, DB_USER, DB_PASSWORD);

        if (!isset($this->db)) {
            try {
                $link = new \PDO($dsn, DB_USER, DB_PASSWORD);
                $link->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                $link->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
                $link->exec("SET CHARACTER SET utf8");
                $this->db = $link;
            } catch (\PDOException $e) {
                die("Failed to connect with Database" . $e->getMessage());
            }
        }
    }

    public function query($sql, $data = array())
    {
        $stmt = $this->db->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindParam($key, $value);
        }

        $this->queryResult = $stmt;
        return $this;
    }

    public function save()
    {
        $result = $this->queryResult->execute();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }


    public function delete()
    {
        $result = $this->queryResult->execute();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function execute()
    {
        return $this->queryResult->execute();
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