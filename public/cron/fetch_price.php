<?php
// should be run once per minute

require dirname(dirname(__FILE__)).'/base.php';

echo Bitcoin::fetchPriceData();