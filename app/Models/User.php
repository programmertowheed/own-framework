<?php

namespace App\Models;

use System\libs\Model;


class User extends Model
{

    public $table = "users";

    public function __construct()
    {
        parent::__construct();
    }

    public function userList()
    {
        $tbl = $this->table;
        $sql = "SELECT * FROM $tbl";
        return $this->db->select($sql);
    }

}