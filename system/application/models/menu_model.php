<?php
class Menu_model extends Model{
	function Menu_model(){
		parent::Model();
	}
	
	function getJSONforDate($location, $date){
		$this->db->select('location, date, menu')->from('menus')->where('location', $location)->where('date', $date);
		
		$query = $this->db->get();
		
		$newjson = '';
		
		if($query->num_rows() > 0){
			$menu_array = $query->result_array();
				$json = json_encode($menu_array);
				$newjson .= '{';
				for($i = 0; $i < count($menu_array); $i++) {
					$m = $menu_array[$i];
					$newjson .= '"' . $m['location'] . '":' . $m['menu'] . '';
					if($i + 1 != count($menu_array))
						$newjson .= ',';
				}
				$newjson .= '}';
				
				//echo $newjson;
				return $newjson;
				//$json = str_replace('\\', '', $json);
/*
								$json = str_replace('"location":', '', $json);
												$json = str_replace('"date":', '', $json);
												$json = str_replace('"menu":', '', $json);
*/
				//print_r ($json);
		}
		else{
			$ci =& get_instance();
			$ci->load->model('import_model');
			$menujson = $ci->import_model->queryXML($location, $date);
			$ci->import_model->insertMeal($location, $date, $menujson);
			return $this->getJSONforDate($location, $date);
		
		
		}
		
		
	}
}

?>