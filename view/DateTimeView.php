<?php

namespace view;

class DateTimeView {

	public function showDateTimeFormat() : string
	{
		// [Day], the [Date] of [Month] [Year], The time is [hh:mm:ss]
		// Example: "Thursday, the 12th of October 2017, The time is 06:24:26"
		$timeString = date('l, \t\h\e jS \of F Y, \T\h\e \t\i\m\e \i\s H:i:s');
		
		return '<p>' . $timeString . '</p>';
	}
}