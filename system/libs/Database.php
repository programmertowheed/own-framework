<?php

namespace System\libs;

/**
 * Class Database
 */
class Database extends \PDO
{

//    public $fatchStyle = \PDO::FETCH_ASSOC;

    public function __construct($dsn, $user, $pass)
    {
        parent::__construct($dsn, $user, $pass, [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ]);
    }

    public function select($sql, $data = array())
    {
        $stmt = $this->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindParam($key, $value);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find($sql, $data = array())
    {
        $stmt = $this->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindParam($key, $value);
        }

        $stmt->execute();
        return $stmt->fetch();
    }

    public function insert($table, $data)
    {
        $keys = implode(",", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO $table($keys) VALUES($values)";
        $stmt = $this->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindParam(":$key", $value);
        }
        return $stmt->execute();
    }

    public function update($table, $data, $cond)
    {
        $updatekeys = NULL;
        foreach ($data as $key => $value) {
            $updatekeys .= "$key=:$key,";
        }
        $updatekeys = rtrim($updatekeys, ",");

        $sql = "UPDATE $table SET $updatekeys WHERE $cond";
        $stmt = $this->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindParam(":$key", $value);
        }
        return $stmt->execute();
    }

    public function delete($table, $cond, $limit = 1)
    {
        $sql = "DELETE FROM $table WHERE $cond LIMIT $limit";
        return $this->exec($sql);
    }

    public function rawQuery($sql, $data = array())
    {
        $stmt = $this->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindParam($key, $value);
        }

        return $stmt;
    }

}

?>