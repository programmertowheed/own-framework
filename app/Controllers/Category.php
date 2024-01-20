<?php
/**
 * Category Controller
 */
class Category extends Controller{
	
	function __construct(){
		parent::__construct();
	}

	public function categoryList(){
		$data  = array();
		$table = "category";
		$CatModel = $this->load->model("CatModel");
		$data['cat'] = $CatModel->catList($table);
		$this->load->view("category",$data);
	}

	public function catById(){
		$data  = array();
		$table = "category";
		$id = 2;
		$CatModel = $this->load->model("CatModel");
		$data['catbyid'] = $CatModel->catById($table,$id);
		$this->load->view("catbyid",$data);
	}


	public function addCategory(){
		$this->load->view("addCategory");
	}

	public function insertCategory(){
		$table = "category";
		if(isset($_REQUEST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
			$name   = $_POST['name'];
			$title  = $_POST['title'];
		
			$data  = array(
				'name' => $name,
				'title' => $title
				);
			$CatModel = $this->load->model("CatModel");
			$result   = $CatModel->insertCat($table,$data);

			$mdata = array();
			if ($result == 1) {
				$mdata['msg'] = "Category Added Successfully....";
			}else{
				$mdata['err'] = "Category Not Added.";
			}
			$this->load->view("addCategory",$mdata);
		}else{
			$this->load->view("addCategory");
		}

	}

	public function catUpdate(){
		$data  = array();
		$id = 8;
		$table = "category";
		$CatModel = $this->load->model("CatModel");
		$data['catById'] = $CatModel->catById($table,$id);
		$this->load->view("catUpdate",$data);
	}


	public function updateCat(){
		$table = "category";
		$id  = $_POST['id'];
		$name   = $_POST['name'];
		$title  = $_POST['title'];
		$cond   ="id=$id";
		$data  = array(
				'name' => $name,
				'title' => $title
				);
		$CatModel = $this->load->model("CatModel");
		$result   = $CatModel->catUpdate($table, $data, $cond);
		$mdata = array();
		if ($result == 1) {
			$mdata['msg'] = "Category Updated Successfully....";
		}else{
			$mdata['err'] = "Category Not Updated.";
		}
		$this->load->view("catUpdate",$mdata);
	}

	public function deleteCatById(){
		$table = "category";
		$cond  = "id=12";
		$CatModel = $this->load->model("CatModel");
		$result   = $CatModel->delCatById($table, $cond);
		
	}

}

?>