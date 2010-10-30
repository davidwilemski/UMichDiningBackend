<?php
class Menu extends Controller{
	function Menu(){
		parent::Controller();
		
		$this->load->model('menu_model');
	}
	
	function index($location, $date){
		return $this->menu_model->getJSONforDate($location, $date);
		
	}
	
	function getAllMenus($date){
		$this->load->model('import_model');
		$locs = $this->import_model->getAllLocations();
		
		$temp = '';
		foreach($locs as $loc){
			$temp .= $this->index($loc['nice_location'], $date);
			//echo $temp;

		}
		//print_r( $temp);
		//echo 'hi';
		$json = str_replace('}{', ',', $temp);
			
		echo $json;


	}

}

?>