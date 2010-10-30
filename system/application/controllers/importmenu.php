<?php
class Importmenu extends Controller{

	function Importmenu(){
		
		parent::Controller();	
		$this->load->model('import_model');
	
	}
	
	//date needs to be reported as yyyy-mm-dd for the request
	function index($location, $date){
	/*

		$url = "http://housing.umich.edu/files/helper_files/js/menu2xml.php?location=" . urlencode( $this->import_model->nice2UM($location)) . "&date=".$date;
		

		//Curl the proper XML feed and pick out the juicy bits
		$ch = curl_init( $url );
		
		//curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0(Windows; U; Windows NT 5.2; rv:1.9.2) Gecko/20100101 Firefox/3.6" );

		ob_start();
		curl_exec( $ch );
		curl_close( $ch );
		$res = ob_get_contents();
		ob_end_clean();

		
		$xml = new SimpleXMLElement($res);
		
		//print_r($xml);

//print_r($xml->menu[0]->meal[] );
		$meals = array();
		//$meals[$location] = array();
		
		
		foreach($xml->menu[0]->meal as $meal){
			$name = strtolower( $meal->name);
			$meals[$name] = array();
			 foreach($meal->station as $station){
			 	foreach($station->course as $course){
			 		foreach($course->menuitem as $item){
			 			$i = "";
			 			$i .= $item[0];
			 			if($i != strtoupper($i)) {
							$meals[$name][] = $i;
						}
			 		}
			 	}
			 }
		}
		
		$menujson = json_encode($meals);
*/
		$menujson = $this->import_model->queryXML($location, $date);
		$this->import_model->insertMeal($location, $date, $menujson);		


		
	}
	
	//Import a week's worth of data
	function runimport(){
		$locs = $this->import_model->getAllLocations();
		
		foreach($locs as $loc){
			for($i = 0; $i < 7; $i++){
				//print_r($loc);
				$day = date('y');
				$day += $i;
				$url = "http://roadrunner.davidwilemski.com/UMichDining/index.php/importmenu/index/" . $loc['nice_location'] ."/" . date("Y-m-") . $day;
				echo $url;
				echo '<br />';
				/*
$ch = curl_init( $url );
				
				//curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0(Windows; U; Windows NT 5.2; rv:1.9.2) Gecko/20100101 Firefox/3.6" );
		
				ob_start();
				curl_exec( $ch );
				curl_close( $ch );
				$res = ob_get_contents();
				ob_end_clean();
*/

			}
			
		}
	}


}
?>