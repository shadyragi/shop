<?php
@session_start();
error_reporting(0);
class productdetailscontroller extends controller
{
	public function find($id)
	{

		$product = (new product)->find($id);
		
		$this->addview($id, $product->categ);
		if(!$product)
		{
			die("not found product");
		}
		else
		{
			$otherdata['loggedin'] = isset($_SESSION['user']) ? $_SESSION['user'] : false;
			$this->view->render("productdetails.php", $product, $otherdata);
		}
	}
	private function addview($id, $category)
	{
		$productview = new productview();
		$productview->user_id = $_SESSION['user'];
		$productview->product_id = $id;
		$productview->category   = $category;
		$productview->getMostFrequentCategory();
		$productview->refresh();
		$productview->save();
	}
}

?>