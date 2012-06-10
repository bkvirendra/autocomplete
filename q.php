<?php

/*******************************************************
########################################################
		Title: Autocomplete suggestions using Google
		
		Author: Virendra Rajput
		Twitter: @bkvirendra
		email: thevirendrarajput@facebook.com
		demo: http://teckzone.in/fbinstant/q.php?q= {Query goes here}

		Date: 10th June, 2012
		Available under Creative Commons License

#######################################################
*******************************************************/

if (isset($_REQUEST["q"])) { 

	$query = $_REQUEST["q"];

	$q = "'http://google.com/complete/search?output=toolbar&q=$query'"; // Building the query
	
	// yql request
	$query = "select * from xml where url=$q";
	$url = "http://query.yahooapis.com/v1/public/yql?q=";
	$url .= rawurlencode($query);
	$url .= "&format=json&env=store://datatables.org/alltableswithkeys";

	function get_data($url) { // function for Curl Request
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	$data = get_data($url); // getting the suggestions

	$info = json_decode($data, true); // decoding the json data
	
	header('Content-type: application/json'); // sending json headers
	//echo "<pre>"; print_r($info); echo "</pre>"; // Used for debugging 

	/********************************************
		#################################
		   formatting the suggestions
		#################################
	********************************************/
	echo "[";
	echo '"';
	echo $_GET["q"];
	echo '"';
	echo ",";
	echo "[";
	$c = 0;

	foreach( $info['query']['results']['toplevel']['CompleteSuggestion'] as $i ) {
		$return = $i['suggestion']['data'];
		echo '"';
	    echo $return;
		echo '"';
		$c++;
	if ($c <= 9) {
	   echo ",";
   } else {

   }
}
	echo "]";
	echo "]";
} else {
	echo "not found"; // Not found
}
?>