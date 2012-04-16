<?php

require './base.php';

html_header();

$price = Bitcoin::getLatestPrice();
$updated = Bitcoin::getLatestTime();

?>

<div class="textcenter">
	<br /><br />
	<p>1 BTC from Mt. Gox equals&hellip;</p>
	<div id="currentPrice">
		<span class="unit">$</span><span ><?php echo $price; ?></span>
		<span class="unit">USD</span>
	</div>
	<p><em>Last updated <?php echo FuzzyTime::get($updated); ?></em></p>
</div>

<?php

html_footer();
