<?php

class FuzzyTime {
	/**
	* Various time formats - used in calculations
	*/
	private static $_time_formats = array(
	array(20, 'just now'),
	array(60, 'under a minute'),
	array(90, '1 minute'),
	array(3600, 'minutes', 60),
	array(5400, '1 hour'),
	array(86400, 'hours', 3600),
	array(129600, '1 day'),
	array(604800, 'days', 86400),
	array(907200, '1 week'),
	array(2628000, 'weeks', 604800),
	array(3942000, '1 month'),
	array(31536000, 'months', 2628000),
	array(47304000, '1 year'),
	array(3153600000, 'years', 31536000),
	);

	/**
	* Convert date into a 'fuzzy' format
	*   -  15 minutes ago,  3 days ago, etc.
	* Pass a unix timestamp or a string to parse to a date.
	* @param string|number
	* @return string
	*/
	public static function get($date_from)
	{
		$now = time();// current unix timestamp

		// if a number is passed assume it is a unix time stamp
		// if string is passed try and parse it to unix time stamp
		if(is_numeric($date_from)){
			$dateFrom = $date_from;
		}elseif (is_string($date_from)) {
			$dateFrom   = strtotime($date_from);
		}

		$difference = $now - $dateFrom;// difference between now and the passed time.
		$val    = '';// value to return

		if ($dateFrom <= 0) {
			$val = 'a long time ago';
		} else {
			//loop through each format measurement in array
			foreach (self::$_time_formats as $format) {
				// if the difference from now and passed time is less than first option in format measurment
				if ($difference < $format[0]) {
					//if the format array item has no calculation value
					if (count($format) == 2) {
						$val = $format[1] . ($format[0] === 20 ? '' : ' ago');
						break;
					} else {
						// divide difference by format item value to get number of units
						$val = ceil($difference / $format[2]) . ' ' . $format[1] . ' ago';
						break;
					}
				}
			}
		}
		return $val;
	}
}
