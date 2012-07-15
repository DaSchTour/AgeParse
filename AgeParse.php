<?php
/** AgeParse MediaWiki Extension
 * Type: parser
 *
 * @author Mark Daly <research@chanur.com>, DaSch <dasch@daschmedia.de>
 * @version 0.2
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
 
/**
 * Identify the extension, version, author, etc
**/
$wgExtensionCredits['parserhook'][] = array(
		'path'          =>      __FILE__,
        'name'          =>      'AgeParse',
        'version'       =>      '0.2',
        'author'        =>      'Mark Daly, [http://www.daschmedia.de DaSch]',
        'url'           =>      'http://www.mediawiki.org/wiki/Extension:AgeParse',
        'descriptionmsg'=>      'ageparse-desc',
);
 
 
/**
 * Set up extension and messages
**/
$dir = dirname(__FILE__);

$wgExtensionMessagesFiles['AgeParse'] = $dir. '/AgeParse.i18n.php';
$wgExtensionMessagesFiles['AgeParseMagic'] = $dir . '/AgeParse.i18n.magic.php';

$wgAutoloadClasses['AgeParseHooks'] = "$dir/AgeParse.hooks.php";
$wgHooks['ParserFirstCallInit'][] = 'AgeParse::wfAgeParse_Setup';