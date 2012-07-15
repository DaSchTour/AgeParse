  == DESCRIPTION ==
 This extension calculates the number of years plus months plus days between two ISO-8601 formatted
 dates called FROM and TO. These values are specified as attributes to the {{#age}} function. All other
 attributes are optional, incuding:
 from   = ISO-8601 (yyyy-mm-dd) starting date
 to     = ISO-8601 (uuuu-mm-dd) ending date
 format = controls how much of answer is displayed; choices: ymd | ym | y
 left   = character or text to add to front of answer
 right  = character or text to add to end of answer
 errbox = "yes" shows errors as class="errorbox"; "no" shows errors as regular text
 zeronegatives = "yes" shows "0 days" if TO occurs before FROM
 
 == INSTALL ==
 1. Copy AGEPARSE.PHP and AGE.I18N.PHP into extensions/Age folder on wiki
 2. Add the following lines into the wiki LocalSettings.php
 	 require_once( "$IP/extensions/AgeParse/AgeParse.php" );
 	 $wgAgeErrorBox      = true;  //true: show box if arguments/calculation cause error
 	 $wgAgeDefaultToday  = true;  //true: FROM or TO default to current date if not provided
 	 $wgAgeZeroNegatives = true;  //true: show '0 days' if calculated value is negative
  3. Change globals to meet your needs
  4. Add {{#age: from=yyyy-mm-dd |to=yyy-mm-dd}} to page(s)
   
 ==LANGUAGE ==
 AgeParse.i18n.php available to implement translations
 
 == SYNTAX ==
 {{#age: from=yyyy-mm-dd | to=yyyy-mm-dd | left=C | right=C | format=ymd | errbox=yes | zeronegatives=yes }}
 == COMPATIBILITY ==
 This extension cannot be 
  
 == INFO ==
 
== AUTHOR ==
Initial Version by: Mark Daly <research@chanur.com>
Further maintaince: DaSch <dasch@daschmedia.de>

== Licence ==
http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later