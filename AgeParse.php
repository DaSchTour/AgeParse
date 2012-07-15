<?php
/** AgeParse MediaWiki Extension
 * Type: parser
 *
 * This extension calculates the number of years plus months plus days between two ISO-8601 formatted
 * dates called FROM and TO. These values are specified as attributes to the {{#age}} function. All other
 * attributes are optional, incuding:
 *  from   = ISO-8601 (yyyy-mm-dd) starting date
 *  to     = ISO-8601 (uuuu-mm-dd) ending date
 *  format = controls how much of answer is displayed; choices: ymd | ym | y
 *  left   = character or text to add to front of answer
 *  right  = character or text to add to end of answer
 *  errbox = "yes" shows errors as class="errorbox"; "no" shows errors as regular text
 *  zeronegatives = "yes" shows "0 days" if TO occurs before FROM
 * 
 * == INSTALL ==
 *  1. Copy AGEPARSE.PHP and AGE.I18N.PHP into extensions/Age folder on wiki
 *  2. Add the following lines into the wiki LocalSettings.php
 *		 require_once( "$IP/extensions/AgeParse/AgeParse.php" );
 * 		 $wgAgeErrorBox      = true;  //true: show box if arguments/calculation cause error
 * 		 $wgAgeDefaultToday  = true;  //true: FROM or TO default to current date if not provided
 *		 $wgAgeZeroNegatives = true;  //true: show '0 days' if calculated value is negative
 *  3. Change globals to meet your needs
 *  4. Add {{#age: from=yyyy-mm-dd |to=yyy-mm-dd}} to page(s)
 *  
 * ==LANGUAGE ==
 * AgeParse.i18n.php available to implement translations
 * 
 * == SYNTAX ==
 * {{#age: from=yyyy-mm-dd | to=yyyy-mm-dd | left=C | right=C | format=ymd | errbox=yes | zeronegatives=yes }}
 *
 * == COMPATIBILITY ==
 * This extension cannot be 
 *  
 * == INFO ==
 * @author Mark Daly <research@chanur.com>
 * @version 0.1
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
**/
 
/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
**/
if(!defined('MEDIAWIKI')){
	echo("This is an extension to the MediaWiki package and cannot be run standalone.\n" );
	die(-1);
}
 
DEFINE('AGEPARSE_VERSION','0.1 2009-03-13');
 
/**
 * Identify the extension, version, author, etc
**/
$wgExtensionCredits['parserhook'][] = array(
		'path'          =>      __FILE__,
        'name'          =>      'AgeParse',
        'version'       =>      AGEPARSE_VERSION,
        'author'        =>      'Mark Daly',
        'url'           =>      'http://www.mediawiki.org/wiki/Extension:AgeParse',
        'description'   =>      'Calculate difference days, months, and years between two dates'
);
 
 
/**
 * Set up extension and messages
**/
$wgExtensionFunctions[] = 'wfAgeParse_Setup';
 
$wgHooks['LanguageGetMagic'][] = 'wfAgeParse_Magic';
 
$wgExtensionMessagesFiles['age'] = dirname(__FILE__) . '/AgeParse.i18n.php';
 
function wfAgeParse_Magic( &$magicWords, $langCode = "en" ) {
	$magicWords['age'] = array( 0, 'age' );
	return true;
}
 
function wfAgeParse_Setup() {
	wfLoadExtensionMessages( 'age' );
	global $wgParser;
	$wgParser->setFunctionHook( 'age', 'wfAgeParse_Render' );
}
 
 
/**
 * Define functions that do the actual calculations.
/**/
require( dirname(__FILE__) . '/AgeParse.body.php' );
 
/**
 * Parse out any arguments/attributes of the {{age}} call and calculate the age differece.
**/
function wfAgeParse_Render( &$parser ) {
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
	if (!isset($argv[wfMsg('from')]))   $from   = $sToday; 		else $from   = trim($argv[wfMsg('from')]);
	if (!isset($argv[wfMsg('to')]))     $to     = $sToday; 		else $to     = trim($argv[wfMsg('to')]);
	if (!isset($argv[wfMsg('left')]))   $left   = '';      		else $left   = $argv[wfMsg('left')];		// do not trim; use as entered
	if (!isset($argv[wfMsg('right')]))  $right  = '';      		else $right  = $argv[wfMsg('right')];		// do not trim; use as entered
	if (!isset($argv[wfMsg('format')])) $format = wfMsg('ymd');	else $format = strtolower(trim($argv[wfMsg('format')]));
 
 	if (isset($argv[wfMsg('zeronegatives')])) 
		$zeronegatives = (strtolower(trim($argv[wfMsg('zeronegatives')])) == wfMsg('yes'));	// 'yes' == true; anything else == false;
 
	if (isset($argv[wfMsg('errbox')]))
		$errbox = (strtolower(trim($argv[wfMsg('errbox')])) == wfMsg('yes')); // 'yes' == true; anything else == false
 
	// validate input
	if ($format <> wfMsg('ymd') && $format <> wfMsg('ym') && $format <> wfMsg('y')) $format = wfMsg('ymd'); //use default if invalid
 
	$retval = calculateAge($from,$to,$format,$left,$right,$errbox,$zeronegatives);
	return $retval;
}