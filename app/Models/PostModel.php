<?php
/**
* Post Model
*/
class PostModel extends Model{

	public function __construct(){
		parent::__construct();
	}

	public function getAllPost($tablePost, $tableCat){
		$sql  = "SELECT $tablePost.*, $tableCat.name FROM $tablePost
				INNER JOIN $tableCat
				ON $tablePost.cat = $tableCat.id
				ORDER BY $tablePost.id DESC LIMIT 3";
		return $this->db->select($sql);
	}
	
	public function getPostById($tablePost, $tableCat, $id){
		$sql  = "SELECT $tablePost.*, $tableCat.name FROM $tablePost
				INNER JOIN $tableCat
				ON $tablePost.cat = $tableCat.id
				WHERE $tablePost.id = $id";
		return $this->db->select($sql);
	}

	public function getPostByCat($tablePost, $tableCat, $id){
		$sql  = "SELECT $tablePost.*, $tableCat.name FROM $tablePost
				INNER JOIN $tableCat
				ON $tablePost.cat = $tableCat.id
				WHERE $tableCat.id = $id";
		return $this->db->select($sql);
	}

	public function getLatestPost($tablePost){
		$sql  = "SELECT * FROM $tablePost ORDER BY id DESC LIMIT 5";
		return $this->db->select($sql);
	}
	

}
?>