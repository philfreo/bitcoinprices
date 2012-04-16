<?php

class Bitcoin {

	const DATA_URL = 'https://mtgox.com/code/data/ticker.php';

	public static function fetchPriceData() {
		$cache = Cache::getInstance();
		
		$data = json_decode(fetchUrl(self::DATA_URL));

		$latestPrice = (float) $data->ticker->last;
		
		if ($latestPrice) {
			$cache->set('currentPrice', $latestPrice, 60*5);
			$cache->set('currentPriceTime', time());
		}
		
		return $latestPrice;
	}

	public static function getLatestPrice() {
		$cache = Cache::getInstance();

		$price = $cache->get('currentPrice');
		
		if ($price === false) {
			$price = self::fetchPriceData();
		}
		
		return $price;
	}
	
	public static function getLatestTime() {
		$cache = Cache::getInstance();
	
		$updated = $cache->get('currentPriceTime');
		
		if (!$updated) {
			$updated = time();
		}
		
		return $updated;
	}

}
