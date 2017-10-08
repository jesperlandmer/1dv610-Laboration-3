<?php

namespace view;

class DateTimeView {

	/**
	 * @return string
	 */
	public function showDateTimeFormat() 
	{
		// Creates format "[Day], the [Date] of [Month] [Year], The time is [hh:mm:ss]"
		$timeString = date('l, \t\h\e jS \of F Y, \T\h\e \t\i\m\e \i\s H:i:s');
		
		return '<p>' . $timeString . '</p>';
	}
}