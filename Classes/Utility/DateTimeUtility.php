<?php
namespace X4E\X4ebase\Utility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Christoph Dörfel <christoph@4eyes.ch>, 4eyes GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 * @package x4ebase
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class DateTimeUtility {
	
	/**
	 * Offet types:
	 * 0:		Now
	 * 1/-1:	Just now / Soon
	 * 2/-2:	1 minute ago / In 1 minute
	 * 3/-3:	x minutes ago / In x minutes
	 * 4/-4:	1 hours ago / In 1 hours
	 * 5/-5:	x hours ago / In x hours
	 * 6/-6:	Yesterday / Tomorrow
	 * 7/-7:	x days ago / In x days
	 * 8/-8:	Last week / Next week
	 * 9/-9:	x weeks ago / In x weeks
	 * 10/-10:	Last month / Next month
	 * 11/-11:	More than a month ago / In more than a month
	 * 
	 * @param integer|string|DateTime $date
	 * @param integer|string|DateTime $referenceDate
	 * @return array Returns an array with 3 elements.
	 * Index 0 is one of the Relative_Time constants indicating the type of the offset.
	 * Index 1 is an integer indicating the difference in values of the type given in index 0 (days, weeks, months).
	 * Index 2 is the difference between $date and $referenceDate as an integer value
	 */
	static public function relativeDate($date, $referenceDate = NULL) {
		if (is_object($date)) {
			$date = $date->getTimestamp();
		} elseif (!ctype_digit($date)) {
			$date = strtotime($date);
		}
		
		if ($referenceDate === NULL) {
			$referenceDate = time();
		} elseif (is_object($referenceDate)) {
			$referenceDate = $referenceDate->getTimestamp();
		} elseif (!ctype_digit($referenceDate)) {
			$referenceDate = strtotime($referenceDate);
		}
		
		$difference = $referenceDate - $date;
		
		if ($difference === 0) {
			return array(0, 0, 0);
			
		} else  {
			$x = 0;
			$t = 0;
			$i = 1;
			if ($difference < 0) {
				$i = -1;
				$difference = (int)abs($difference);
			}
			
			$differenceInDays = (int)floor($difference / 86400);
			
			// Same day
			if ($differenceInDays === 0) {
				// Just now / Soon
				if ($difference < 60) {
					$x = 1;
				// 1 minute ago / in one minute
				} elseif ($difference < 120) {
					$x = 2;
					$t = 1;
				// x minutes ago / in x minutes
				} elseif ($difference < 3600) {
					$x = 3;
					$t = (int)floor($difference / 60);
				// 1 hour ago / in 1 hour
				} elseif ($difference < 7200) {
					$x = 4;
					$t = 1;
				// under a day
				} elseif ($difference < 86400) {
					$day1 = (int)date('w', $date);
					$day2 = (int)date('w', $referenceDate);
					//  x hours ago / in x hours
					if ($day1 === $day2) {
						$x = 5;
						$t = (int)floor($difference / 3600);
					// Yesterday / Tomorrow
					} else {
						$x = 6;
						$t = 1;
					}
				}
			
			// More than one day off
			} else {
				// Yesterday / Tomorrow
				if ($differenceInDays === 1) {
					$x = 6;
					$t = 1;
				// under a week
				} elseif ($differenceInDays < 7) {
					$week1 = (int)date('W', $date);
					$week2 = (int)date('W', $referenceDate);
					// Same week
					// x days ago / in x days
					if ($week1 === $week2) {
						$x = 7;
						$t = $differenceInDays;
					// last week / next week
					} else {
						$x = 8;
						$t = 1;
					}
				// under one month
				} elseif ($differenceInDays < 31) {
					$week1 = (int)date('W', $date);
					$week2 = (int)date('W', $referenceDate);
					$month1 = (int)date('n', $date);
					$month2 = (int)date('n', $referenceDate);
					// last week / next week
					if (abs($week1 - $week2) === 1) {
						$x = 8;
						$t = 1;
					// Same month
					// x weeks ago / in x weeks
					} elseif ($month1 === $month2) {
						$x = 9;
						$t = (int)ceil($differenceInDays / 7);
					// last month / next month
					} else {
						$x = 10;
						$t = 1;
					}
				// last month / next month
				// @todo: February with 28 days?
				} elseif ($differenceInDays < 60) {
					$x = 10;
					$t = 1;
				// more than 1 month
				} else {
					$x = 11;
					$t = 0;
				}
			}
			
			return array(
				$i * $x,
				$t,
				$difference
			);
		}
	}
}