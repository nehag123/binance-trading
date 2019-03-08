<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ema_cross_list_cron extends CI_Controller {

  	public function __construct() {
		parent::__construct();
		
		$this->load->helper(array('url'));
		$this->load->library('s3');
		$this->load->database();
		
		
		require_once APPPATH . "third_party/php-binance-api.php";
		
	
		$this->load->model('bot_cron_model');
	}
	
	
public function index() {
		$lowPriceThreshold = 0.00000250;
		$api = createBinanceApiObject('ubc');
		$prices = $api->prices();
		
		$daysCutoff = 4;
		$coin_pairs = $this->bot_cron_model->getCoinPairs($daysCutoff);
		if($coin_pairs){
			$coinSortArray = Array();

			foreach($coin_pairs as $coins) {
				$cross_coinPair = $coins->coin_pair;

				$pairPrice = $prices[$cross_coinPair];

				$thisCoinEmaCrossInstanceArray = Array();
				$thisCoinSortValue = 0;

				if ($pairPrice > $lowPriceThreshold)
				{
					
					$sql2 = "SELECT * 
					FROM ema_cross WHERE coin_pair='".$cross_coinPair."' 
					AND last_modified_date >= DATE(NOW()) - INTERVAL $daysCutoff DAY ORDER BY last_modified_date DESC";

					$result2 = $this->db->query($sql2);
					$result2 = $result2->result_array();
					if($result2){

						foreach($result2 as $emaRec) {
								$date = $emaRec['last_modified_date'];
								$emaCrossUp = $emaRec['crossed_up'];
								$periodEma = $emaRec['candle_period'];
								$fastEma = $emaRec['fast_ema'];
								$slowEma = $emaRec['slow_ema'];


								if($emaCrossUp == 1){ 
									$thisCrossSortValue = $this->getCrossSortValue($periodEma,$slowEma,$fastEma,$date);

									$thisCoinSortValue = $thisCoinSortValue + $thisCrossSortValue;

									$time = strtotime($date);
									$timeLapseMinutes = round((time()-$time) / 60);

									$thisInstanceRecord = Array('coin'=>$cross_coinPair,'period'=>$periodEma,'slow'=>$slowEma,'fast'=>$fastEma,'date'=>$date,'age_in_minutes'=>$timeLapseMinutes,'isUp'=>$emaCrossUp);
									$thisCoinEmaCrossInstanceArray[] = $thisInstanceRecord;
								}else{
									break;
								} 						
						}
						if ($thisCoinSortValue > 0){
							$thisCoinActivityRecord = array('coin_pair'=> $cross_coinPair,'id'=> $cross_coinPair,'sort_value'=>$thisCoinSortValue,'ema_instances'=>$thisCoinEmaCrossInstanceArray);
							$coinSortArray[] = $thisCoinActivityRecord;
						} 
					}
				}
			}
			usort($coinSortArray, 'sortByOrder');
			foreach($coinSortArray as $coinRec) {
				echo $coinRec['coin_pair'].' - '. $coinRec['sort_value'];
				echo '<br>';
			}
           
            $coinArrayJson1 = json_encode($coinSortArray);
			$jsonFileName1 = 'ema_bot_recent_results.json';
			$this->s3->write($jsonFileName1,$coinArrayJson1);
             
             $coinArrayJson= array('symbols'=>$coinSortArray);
			$coinArrayJson_v2 = json_encode($coinArrayJson);
			$jsonFileName = 'ema_bot_recent_results_v2.json';
			$this->s3->write($jsonFileName,$coinArrayJson_v2);
		}
	}	
	
	
public function getCrossSortValue($cross_emaPeriod,$cross_emaSlow,$cross_emaFast,$date)
	{
		$time = strtotime($date);
		$timeLapseMinutes = (time()-$time) / 60;

		$emaSortVal = 0;
		$periodSortVal = 0;
		$ageSortVal = 0;

		$crossNumbersStr = $cross_emaFast.'/'.$cross_emaSlow;
		switch($crossNumbersStr){
			case '4/9':
			$emaSortVal = 2;
			break;
			case '4/18':
			$emaSortVal = 3;
			break;
			case '9/18':
			$emaSortVal = 4;
			break;
		}
		
		if ($timeLapseMinutes < (1 * 60)){
		$ageSortVal = 1;//1;
	    }elseif ($timeLapseMinutes < (3 * 60)){
		$ageSortVal = 3;//1;
	   }elseif ($timeLapseMinutes < (6 * 60)){
		$ageSortVal = 10;//1;
	   }elseif ($timeLapseMinutes < (24 * 60)){
		$ageSortVal = 6;//3;
	   }elseif ($timeLapseMinutes < (48 * 60)){
		$ageSortVal = 3;//6;
	    }elseif ($timeLapseMinutes >= (48 * 60)){
		$ageSortVal = 1;//10;
	}

		//~ if ($timeLapseMinutes < (4 * 60)){
			//~ $ageSortVal = 10;
		//~ }elseif ($timeLapseMinutes < (24 * 60)){
			//~ $ageSortVal = 6;
		//~ }elseif ($timeLapseMinutes < (48 * 60)){
			//~ $ageSortVal = 3;
		//~ }elseif ($timeLapseMinutes >= (48 * 60)){
			//~ $ageSortVal = 1;
		//~ }

		switch($cross_emaPeriod){
			case '1d':
			$periodSortVal = 20;
			break;
			case '4h':
			$periodSortVal = 3;
			break;
			case '1h':
			$periodSortVal = 2;
			break;
		}
		$sortVal = $emaSortVal + $ageSortVal + $periodSortVal;
		return $sortVal;
	}
	
Public function sortByOrder($a, $b) {
	return $b['sort_value'] - $a['sort_value'];
}
function sortByTime($a, $b) {
	return $a['age_in_minutes'] - $b['age_in_minutes'];
}

function getCrossedUpString($crossed_up){
	if($crossed_up == '1'){
		$emaCrossUp = 'YES';
	}else{	
		$emaCrossUp = 'NO';
	}			
	return $emaCrossUp;

}		
	
}	
