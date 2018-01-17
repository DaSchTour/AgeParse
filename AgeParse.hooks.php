<?php

/**
 * Define functions that do the actual calculations.
/**/
$dir = dirname(__FILE__);
require( $dir . '/AgeParse.body.php' );

class AgeParseHooks {
	public static function wfAgeParse_Setup(&$parser) {
		$parser->setFunctionHook( 'MAG_AGEPARSE', 'AgeParseHooks::wfAgeParse_Render');
		return true;
	}
	 
	/**
	 * Parse out any arguments/attributes of the {{age}} call and calculate the age differece.
	**/
	public static function wfAgeParse_Render( &$parser ) {
		global $wgAgeErrorBox;		// global setting to show errors in a distinct box site-wide by default; can be overridden by errbox="no" in each use
		global $wgAgeDefaultToday;	// global setting to use current date if FROM or TO not specified site-wide by default
		global $wgAgeZeroNegatives;	// global setting to use zero negative date differences
		$argv = array();
	 
		$retval        = '';	// result to show
		$sToday        = '';	// current date not set
		$errbox        = false;	// do not show error box if error occurs
		$zeronegatives = false;	// show 0 when date difference is negative
	 
		// set local values per global controls, some of which can be overridden
		if (isset($wgAgeDefaultToday)) {
			if ($wgAgeDefaultToday) $sToday = date('Y-m-d'); // if global is set, then get current date for FROM/TO defaults if not set in attributes
		} // otherwise $sToday is blank, which is an error
	 
		if (isset($wgAgeErrorBox)) {
			$errbox = ($wgAgeErrorBox);	// if global is set, use global value
		}
	 
		if (isset($wgAgeZeroNegatives)) {
			$zeronegatives = ($wgAgeZeroNegatives); // if global is set, use global value
		}
	 
		// get attributes from {{#age ...}} request using name=value pairs
		foreach (func_get_args() as $arg) if (!is_object($arg)) {
			if (preg_match('/^(.+?)\\s*=\\s*(.+)$/',$arg,$match)) $argv[$match[1]]=$match[2];
		}
		if (!isset($argv[wfMessage('from')->text()]))   $from   = $sToday; 		else $from   = trim($argv[wfMessage('from')->text()]);
		if (!isset($argv[wfMessage('to')->text()]))     $to     = $sToday; 		else $to     = trim($argv[wfMessage('to')->text()]);
		if (!isset($argv[wfMessage('left')->text()]))   $left   = '';      		else $left   = $argv[wfMessage('left')->text()];		// do not trim; use as entered
		if (!isset($argv[wfMessage('right')->text()]))  $right  = '';      		else $right  = $argv[wfMessage('right')->text()];		// do not trim; use as entered
		if (!isset($argv[wfMessage('format')->text()])) $format = wfMessage('ymd')->text();	else $format = strtolower(trim($argv[wfMessage('format')->text()]));
	 
	 	if (isset($argv[wfMessage('zeronegatives')->text()])) 
			$zeronegatives = (strtolower(trim($argv[wfMessage('zeronegatives')->text()])) == wfMessage('yes')->text());	// 'yes' == true; anything else == false;
	 
		if (isset($argv[wfMessage('errbox')->text()]))
			$errbox = (strtolower(trim($argv[wfMessage('errbox')->text()])) == wfMessage('yes')->text()); // 'yes' == true; anything else == false
	 
		// validate input
		if ($format <> wfMessage('ymd')->text() && $format <> wfMessage('ym')->text() && $format <> wfMessage('y')->text()) $format = wfMessage('ymd')->text(); //use default if invalid
	 
		$retval = calculateAge($from,$to,$format,$left,$right,$errbox,$zeronegatives);
		return $retval;
	}
}
