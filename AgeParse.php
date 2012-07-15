<?php
/** AgeParse MediaWiki Extension
 * Type: parser
 *
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
 
DEFINE('AGEPARSE_VERSION','0.2 2009-03-13');
 
/**
 * Identify the extension, version, author, etc
**/
$wgExtensionCredits['parserhook'][] = array(
		'path'          =>      __FILE__,
        'name'          =>      'AgeParse',
        'version'       =>      AGEPARSE_VERSION,
        'author'        =>      'Mark Daly, [http://www.daschmedia.de DaSch]',
        'url'           =>      'http://www.mediawiki.org/wiki/Extension:AgeParse',
        'description'   =>      'Calculate difference days, months, and years between two dates',
        'descriptionmsg'=>      'ageparse-desc',
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