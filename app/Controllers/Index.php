<?php
/**
* Index Controller
*/
class Index extends Controller{

	public function __construct(){
		parent::__construct();
	}

	// public function home(){
	// 	$data  = array();
	// 	$tablePost = "post";
	// 	$tableCat = "category";

	// 	$PostModel = $this->load->model("PostModel");
	// 	$data['allPost'] = $PostModel->getAllPost($tablePost, $tableCat);

	// 	$this->load->blogView("content",$data,$PostModel);
	// }

	public function home(){
		
		$this->load->homeView("home");
	}


	public function postDetails($id){
		$this->load->view("header");

		$data  = array();
		$tablePost = "post";
		$tableCat = "category";
		$PostModel = $this->load->model("PostModel");
		$data['postById'] = $PostModel->getPostById($tablePost, $tableCat, $id);
		$this->load->view("details",$data);

		$CatModel = $this->load->model("CatModel");
		$data['catList'] = $CatModel->catList($tableCat);
		$data['latestPost'] = $PostModel->getLatestPost($tablePost);
		$this->load->view("sidebar",$data);

		$this->load->view("footer");
	}

	public function postByCat($id){
		$this->load->view("header");

		$data  = array();
		$tablePost = "post";
		$tableCat = "category";
		$PostModel = $this->load->model("PostModel");
		$data['postByCat'] = $PostModel->getPostByCat($tablePost, $tableCat, $id);
		$this->load->view("categorypost",$data);

		$CatModel = $this->load->model("CatModel");
		$data['catList'] = $CatModel->catList($tableCat);
		$data['latestPost'] = $PostModel->getLatestPost($tablePost);
		$this->load->view("sidebar",$data);

		$this->load->view("footer");
	}

}
?>