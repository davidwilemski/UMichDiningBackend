<?php
class import_model extends Model {

	function import_model(){
		parent::Model();
	}

	function nice2UM($location){
		$this->db->select('*')->where('nice_location', $location)->from('locations');
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			return $row->UM_location;
		}
		
		
	}
	
	function insertMeal($location, $date, $menujson){
		$this->db->insert('menus', array('location'=>$location, 'date'=>$date, 'menu'=>$menujson));
	}
	
	function getAllLocations(){
		$this->db->select('nice_location')->from('locations');
		
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function queryXML($location, $date){
		
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
		if($menujson == "[]")
			return "{}";
		return $menujson;
	
	}

}
?>