<?php
/**
 * Internationalisation file for extension Age.
 *
 * @addtogroup Extensions
*/
$messages = array();
 
/** English (default)
 * @author Mark Daly
*/
$messages['en'] = array (
	 'from'			 => 'from'
	,'to'			 => 'to'
	,'left'			 => 'left'
	,'right'		 => 'right'
	,'format'		 => 'format'
	,'errbox'		 => 'errbox'
	,'zeronegatives' => 'zeronegatives'
	,'yes'			 => 'yes'
	,'no'			 => 'no'
	,'ymd'			 => 'ymd'
	,'ym'			 => 'ym'
	,'y'			 => 'y'
	,'required-from' => 'FROM attribute is required (e.g. from="2009-01-12")'
	,'required-to'   => 'TO attribute is  required (e.g. from="2009-01-12")'
	,'invalid-from'  => 'FROM date is not valid: $1-$2-$3 (YYYY-MM-DD)'
	,'invalid-to'    => 'TO date is not valid: $1-$2-$3 (YYYY-MM-DD)'
	,'from-first'    => 'FROM ($1-$2-$3) date must occur before TO ($4-$5-$6) date'
	,'same-day'      => 'FROM ($1) and TO ($2) date are the same'
	,'syntax'        => '&lt;age from="yyyy-mm-dd" to="yyyy-mm-dd" [left="c"] [right="c"]&gt;&lt;/age&gt;'
	,'catchall'      => 'Something is wrong with the AGE tag; check your syntax, match quotes, FROM & TO attributes are required, date format should be ISO-8601 (e.g. YYYY-MM-DD), and FROM must be less than TO.'
	,'yy-single'     => 'year'
	,'yy-plural'     => 'years'
	,'mm-single'     => 'month'
	,'mm-plural'     => 'months'
	,'dd-single'     => 'day'
	,'dd-plural'     => 'days'
	,'answer-sep'    => ', '
	,'ageparse-desc' => 'Calculate difference days, months, and years between two dates'
);
 
/** Message documentation (explain purpose of each message)
 * @author Mark Daly
*/
$messages['qqq'] = array (
	 'from'			 => 'attribute to specify starting date'
	,'to'			 => 'attribute to specify ending date'
	,'left'			 => 'attribute to specify text added to front of answer'
	,'right'		 => 'attribute to specify text added after answer'
	,'format'		 => 'attribute to specify what parts of the answer you want to show'
	,'errbox'		 => 'attribute to specify (yes/no) if error should show in a distinctive box'
	,'zeronegatives' => 'attribute to specify (yes/no) if negative days for answer should just show as "0 days"'
	,'yes'			 => 'answer used by errbox and zeronegatives'
	,'no'			 => 'answer used by errbox and zeronegatives'
	,'ymd'			 => 'format to show days, months, and years when that part is greater than zero'
	,'ym'			 => 'format to show months and years when that part is greater than zero'
	,'y'			 => 'format to only show years'
	,'required-from' => 'error message: FROM value is required'
	,'required-to'   => 'error message: TO value is required'
	,'invalid-from'  => 'error message: FROM value is not a valid date'
	,'invalid-to'    => 'error message: TO value is not a valid date'
	,'from-first'    => 'error message: FROM date must be less than or equal to TO date'
	,'same-day'      => 'error message: days are the same, why bother?'
	,'syntax'        => 'error message: show how the tag can be written'
	,'catchall'      => 'error message: show this when we know an error occurred but not what happened'
	,'yy-single'     => 'word for 1 year'
	,'yy-plural'     => 'word for many years'
	,'mm-single'     => 'word for 1 day'
	,'mm-plural'     => 'word for many months'
	,'dd-single'     => 'word for 1 day'
	,'dd-plural'     => 'word for many days'
	,'answer-sep'    => 'separate year, month, and day values in answer'
	,'ageparse-desc' => 'Description for Special:Version'
);
 
/** Spanish (default)
 * @author Google Translator (this is just for testing)
*/
$messages['es'] = array (
	 'from'			 => 'desde'
	,'to'			 => 'para'
	,'left'			 => 'izquierda'
	,'right'		 => 'acertado'
	,'format'		 => 'formato'
	,'errbox'		 => 'caja'
	,'zeronegatives' => 'negativos'
	,'yes'			 => 'si'
	,'no'			 => 'no'
	,'ymd'			 => 'ymd'
	,'ym'			 => 'ym'
	,'y'			 => 'y'
	,'required-from' => 'FROM atributo es necesario (e.g. from="2009-01-12")'
	,'required-to'   => 'TO atributo es necesario (e.g. from="2009-01-12")'
	,'invalid-from'  => 'FROM fecha no es v�lida: $1-$2-$3 (YYYY-MM-DD)'
	,'invalid-to'    => 'TO fecha no es v�lida: $1-$2-$3 (YYYY-MM-DD)'
	,'from-first'    => 'FROM ($1-$2-$3) fecha debe ocurrir antes de TO ($4-$5-$6) fecha'
	,'same-day'      => 'FROM ($1) y TO ($2) fecha son los mismos'
	,'syntax'        => '&lt;age from="yyyy-mm-dd" to="yyyy-mm-dd" [left="c"] [right="c"]&gt;&lt;/age&gt;'
	,'catchall'      => 'Algo est� mal con la edad etiqueta; comprobar su sintaxis, coinciden con las comillas, que van y vuelven a los atributos son necesarios, la fecha debe tener el formato ISO-8601 (por ejemplo, AAAA-MM-DD), y de debe ser inferior a A.'
	,'yy-single'     => 'a�os'
	,'yy-plural'     => 'a�os'
	,'mm-single'     => 'mes'
	,'mm-plural'     => 'mes'
	,'dd-single'     => 'd�a'
	,'dd-plural'     => 'd�a'
	,'answer-sep'    => ', '
);

/** German
 * @author DaSch
*/
$messages['de'] = array (
	 'from'			 => 'von'
	,'to'			 => 'bis'
	,'left'			 => 'links'
	,'right'		 => 'rechts'
	,'format'		 => 'format'
	,'errbox'		 => 'errbox'
	,'zeronegatives' => 'zeronegatives'
	,'yes'			 => 'ja'
	,'no'			 => 'nein'
	,'ymd'			 => 'ymd'
	,'ym'			 => 'ym'
	,'y'			 => 'y'
	,'required-from' => 'FROM attribute is required (e.g. from="2009-01-12")'
	,'required-to'   => 'TO attribute is  required (e.g. from="2009-01-12")'
	,'invalid-from'  => 'FROM date is not valid: $1-$2-$3 (YYYY-MM-DD)'
	,'invalid-to'    => 'TO date is not valid: $1-$2-$3 (YYYY-MM-DD)'
	,'from-first'    => 'FROM ($1-$2-$3) date must occur before TO ($4-$5-$6) date'
	,'same-day'      => 'FROM ($1) and TO ($2) date are the same'
	,'syntax'        => '&lt;age from="yyyy-mm-dd" to="yyyy-mm-dd" [left="c"] [right="c"]&gt;&lt;/age&gt;'
	,'catchall'      => 'Something is wrong with the AGE tag; check your syntax, match quotes, FROM & TO attributes are required, date format should be ISO-8601 (e.g. YYYY-MM-DD), and FROM must be less than TO.'
	,'yy-single'     => 'Jahr'
	,'yy-plural'     => 'Jahre'
	,'mm-single'     => 'Monat'
	,'mm-plural'     => 'Monate'
	,'dd-single'     => 'Tag'
	,'dd-plural'     => 'Tage'
	,'answer-sep'    => ', '
	,'ageparse-desc' => 'Berechnet die Differenz zwischen zwei Datumsangaben'
);