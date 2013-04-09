<?php
/**
 * Calculate the actual age based on information provided by the {{age}} request.
 * Each attribute is already parsed so this function is only responsible for the 
 * actual calculation.
**/
function calculateAge($from,$to,$format,$left,$right,$errbox,$zeronegatives) {
	$retval = "";
	$bError = true;	// error occurred in attributes; false = no error; true = error
 
	// process the attributes
	if (strlen($from) == 0) {
		$retval = wfMsg('required-from');			// FROM is required, even if from $sToday
	} elseif (strlen($to) == 0) {
		$retval = wfMsg('required-to');				// TO is required, event if from $sToday
	} elseif ($from == $to) {
		$retval = '0 ' . wfMsg('dd-plural');		// no need to calculate anything, they are the same date
	} elseif ($zeronegatives && $to < $from) {
		$retval = '0 ' . wfMsg('dd-plural');		// TO comes before FROM, so we use '0 days'
	} else {
		$aDate = array();
		$aDate = explode('-',$from);				// separate pages in format [<era>-]<yyyy>-<mm>-<dd>
		$first = array();
		$first['year']  = $aDate[0] *1;				// '*1' makes sure it is a number (makes some versions of PHP happy)
		$first['month'] = $aDate[1] *1;
		$first['day']   = $aDate[2] *1;
 
		$aDate = explode('-',$to);					// separate pages in format [<era>-]<yyyy>-<mm>-<dd>
		$last  = array();
		$last['year']   = $aDate[0] *1;				// '*1' makes sure it is a number (makes some versions of PHP happy)
		$last['month']  = $aDate[1] *1;
		$last['day']    = $aDate[2] *1;
 
		// ok, ready to calculate answer
		$diff = date_difference($first,$last);
		if (is_array($diff)) { 			// got something, build answer
			$bError = false;			// turn off error indicator
			if ($diff['years'] > 0) {	// year included in any format
				$retval .= $diff['years'] . ' ' . ($diff['years'] == 1 ? wfMsg('yy-single') : wfMsg('yy-plural'));
			}
 
			if ($diff['months'] > 0 && ($format == wfMsg('ymd') || $format == wfMsg('ym'))) {
				if (strlen($retval) > 0) $retval .= wfMsg('answer-sep');
				$retval .= $diff['months'] . ' ' . ($diff['months'] == 1 ? wfMsg('mm-single') : wfMsg('mm-plural'));
			}
 
			if ($diff['days'] > 0 && ($format == wfMsg('ymd'))) {
				if (strlen($retval) > 0) $retval .= wfMsg('answer-sep');
				$retval .= $diff['days'] . ' ' . ($diff['days'] == 1 ? wfMsg('dd-single') : wfMsg('dd-plural'));
			}
		} else {
			$retval = $diff; // some error message from date_difference()
		}
	}
 
	// prepare answer
	if (strlen($retval) == 0) 
		$retval = wfMsg('catchall');
 
	if (strlen($left) > 0 || strlen($right) > 0) 
		$retval = $left . $retval . $right;
 
	if ($bError && $errbox) 
		$retval = '<div class="'.wfMsg('errorbox').'">'.$retval.'</div>';	// 'errorbox' is found in style sheet (CSS) so it is fixed (not translated)
 
	return $retval;
}
 
 
/**
 * Convenience function to create date in "YYYYMMDD" format without punctuation (-).
**/
function smoothdate ( $year, $month, $day ) {
    return sprintf ('%04d', $year) . sprintf ('%02d', $month) . sprintf ('%02d', $day);
}
 
 
/**
 * Date Difference performs the actual calculations. This function is based on a function 
 * posted at http://www.tek-tips.com/faqs.cfm?fid=3493 on 2003-04-24 as 'faq434-3493'.
 *
 * == INPUT ==
 *  $first is FROM or STARTING date
 *  $second is TO or ENDING date
 *  Both arguments must be an associative array as follows:
 *     array ( 'year' => year_value, 'month' => month_value, 'day' => day_value )
 * 
 * == RULES ==
 *   It does not make use of 32-bit unix timestamps, so it will work for dates
 *   outside the range 1970-01-01 through 2038-01-19. This function works by
 *   taking the earlier date finding the maximum number of times it can
 *   increment the years, months, and days (in that order) before reaching
 *   the second date. The function does take yeap years into account, but does
 *   not take into account the 10 days removed from the calendar (specifically
 *   October 5 through October 14, 1582) by Pope Gregory XIII to fix calendar drift.
 *   
 *   The first input array is the earlier date, the second the later date. It
 *   will check to see that the two dates are well-formed, and that the first
 *   date is earlier than the second.
 *
 * == OUTPUT ==
 *   If successful, function returns an associative array as follows:
 *      array ( 'years' => years_different, 'months' => months_different, 'days' => days_different )
 *   
 *   If an error occurred, function returns a string value.
**/
function date_difference ( $first, $second ) {
    $month_lengths = array (31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	$retval = "";
	 
	$firstTime  = new DateTime($first['year'].'-'.$first['month'].'-'.$first['day']); #mktime(0,0,0,$first['month'],$first['day'],$first['year']);
	$secondTime = new DateTime($second['year'].'-'.$second['month'].'-'.$second['day']); #mktime(0,0,0,$second['month'],$second['day'],$second['year']);
	$diff = $firstTime->diff($secondTime);
/**
	 echo '<pre>';print_r(array(
	 'firstTime' => $firstTime,
	 'secondTime' => $secondTime,
	 'diff' => $diff
	 ));echo '</pre>';
**/
	
    if (!checkdate($first['month'], $first['day'], $first['year'])) {
		$retval = wfMsg('invalid-from',$first['year'],$first['month'],$first['day']);
	} elseif (!checkdate($second['month'], $second['day'], $second['year'])) {
		$retval = wfMsg('invalid-to',$second['year'],$second['month'],$second['day']);
	} elseif ($diff->format('%R%a') < 0) {
		$retval = wfMsg('from-first',$first['year'], $first['month'], $first['day'], $second['year'], $second['month'], $second['day']);
	} else {
        $start  = smoothdate ($first['year'],  $first['month'],  $first['day']);
        $target = smoothdate ($second['year'], $second['month'], $second['day']);
		
        if ($start <= $target) {
            $add_year = 0;
            while (smoothdate ($first['year']+ 1, $first['month'], $first['day']) <= $target) {
                $add_year++;
                $first['year']++;
            } //while years
 
            $add_month = 0;
            while (smoothdate ($first['year'], $first['month'] + 1, $first['day']) <= $target) {
                $add_month++;
                $first['month']++;
                if ($first['month'] > 12) {
                    $first['year']++;
                    $first['month'] = 1;
                }
            } //while months
 
            $add_day = 0;
            while (smoothdate ($first['year'], $first['month'], $first['day'] + 1) <= $target) {
                if (($first['year'] % 100 == 0) && ($first['year'] % 400 == 0)) {
                    $month_lengths[1] = 29;	//leap year adjustment
                } else {
                    if ($first['year'] % 4 == 0) {
                        $month_lengths[1] = 29; // leap year adjustment
                    }
                }
                $add_day++;
                $first['day']++;
                if ($first['day'] > $month_lengths[$first['month'] - 1]) {
                    $first['month']++;
                    $first['day'] = 1;
                    if ($first['month'] > 12) {
                        $first['month'] = 1;
                    }
                }
            } // while days
 
            $retval = array ('years' => $add_year, 'months' => $add_month, 'days' => $add_day);
        } else {
			$retval = wfMsg('from-first',$first['year'], $first['month'], $first['day'], $second['year'], $second['month'], $second['day']);
		}
    }// validation ok
 
    return $retval;
}
