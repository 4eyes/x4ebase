<?php
namespace X4E\X4ebase\Tests\Unit\Utility;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Alessandro Bellafronte <alessandro@4eyes.ch>, 4eyes GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class \X4E\X4ebase\Utility\DateTimeUtility.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Alessandro Bellafronte <alessandro@4eyes.ch>
 */
class DateTimeUtilityTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {

	protected $dateTimeUtility = NULL;
	
	public function setUp() {
		$this->dateTimeUtility = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('X4E\X4ebase\Utility\DateTimeUtility');
	}

	public function tearDown() {
		$this->dateTimeUtility = NULL;
	}
	
	/**
	 * Test for getTimestampFromDate() method
	 *
	 * @return void
	 */
	public function testDateToTimestampConversion() {
		$cases = array(
			// Case 1: $value: null
			array(
				'title' => 'Case 1: $value: null',
				'value' => null,
				'expectedResult' => function() { return time(); }
			),
			//Case 2: $value: timestamp integer
			array(
				'title' => 'Case 2: $value: timestamp integer',
				'value' => 1411738837,
				'expectedResult' => 1411738837
			),
			// Case 3: $value: timestamp string
			array(
				'title' => 'Case 3: $value: timestamp string',
				'value' => '1411738837',
				'expectedResult' => 1411738837
			),
			// Case 4: $value: incorrect string
			array(
				'title' => 'Case 4: $value: invalid timestamp string',
				'value' => '14117T_TROLOLO_38837',
				'expectedResult' => NULL
			),
			// Case 5: $value: DateTime object,
			array(
				'title' => 'Case 5: $value: DateTime object',
				'value' => new \DateTime(),
				'expectedResult' => (new \DateTime())->getTimestamp(),
			),
			// Case 6: $value: object,
			array(
				'title' => 'Case 6: $value: random object',
				'value' => new \stdClass(),
				'expectedResult' => NULL
			),
			// Case 7: $value: random array(),
			array(
				'title' => 'Case 7: $value: random array()',
				'value' => array((string) rand(0, 666)),
				'expectedResult' => NULL
			)
		);

		foreach ($cases as $case) {
			$value = ( is_callable($case['value']) ? $case['value']() : $case['value'] );
			$expectedResult = ( is_callable($case['expectedResult']) ? $case['expectedResult']() : $case['expectedResult'] );
			$actualResult = $this->callInaccessibleMethod($this->dateTimeUtility, 'getTimestampFromDate', $value);
			$this->assertEquals($actualResult, $expectedResult, $case['title']);
		}
	}
	
	
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
	public function testRelativeDate() {
		$now = strtotime('2014-06-13 12:14:07');
		
		$cases = array(
			array(
				'title' => 'More than a month ago',
				'referenceDate' => strtotime('2014-01-13 12:14:07'),
				'offsetType' => -11,
				'offset' => 0
			),
			array(
				'title' => 'Last month',
				'referenceDate' => strtotime('2014-05-13 12:14:07'),
				'offsetType' => -10,
				'offset' => 1
			),
			array(
				'title' => 'x weeks ago',
				'referenceDate' => strtotime('2014-06-01 12:14:07'),
				'offsetType' => -9,
				'offset' => 2
			),
			array(
				'title' => 'Last week',
				'referenceDate' => strtotime('2014-06-06 12:14:07'),
				'offsetType' => -8,
				'offset' => 1
			),
			array(
				'title' => 'x days ago',
				'referenceDate' => strtotime('2014-06-10 12:14:07'),
				'offsetType' => -7,
				'offset' => 3
			),
			array(
				'title' => 'Yesterday',
				'referenceDate' => strtotime('2014-06-12 12:14:07'),
				'offsetType' => -6,
				'offset' => 1
			),
			array(
				'title' => 'x hours ago',
				'referenceDate' => strtotime('2014-06-13 09:14:07'),
				'offsetType' => -5,
				'offset' => 3
			),
			array(
				'title' => '1 hours ago',
				'referenceDate' => strtotime('2014-06-13 11:14:07'),
				'offsetType' => -4,
				'offset' => 1
			),
			array(
				'title' => 'x minutes ago',
				'referenceDate' => strtotime('2014-06-13 12:00:07'),
				'offsetType' => -3,
				'offset' => 14
			),
			array(
				'title' => '1 minute ago',
				'referenceDate' => strtotime('2014-06-13 12:13:07'),
				'offsetType' => -2,
				'offset' => 1
			),
			array(
				'title' => 'Just now',
				'referenceDate' => strtotime('2014-06-13 12:14:00'),
				'offsetType' => -1,
				'offset' => 0
			),
			array(
				'title' => 'Now',
				'referenceDate' => strtotime('2014-06-13 12:14:07'),
				'offsetType' => 0,
				'offset' => 0
			),
			array(
				'title' => 'Soon',
				'referenceDate' => strtotime('2014-06-13 12:14:17'),
				'offsetType' => 1,
				'offset' => 0
			),
			array(
				'title' => 'In 1 minute',
				'referenceDate' => strtotime('2014-06-13 12:15:07'),
				'offsetType' => 2,
				'offset' => 1
			),
			array(
				'title' => 'In x minutes',
				'referenceDate' => strtotime('2014-06-13 12:23:07'),
				'offsetType' => 3,
				'offset' => 9
			),
			array(
				'title' => 'In 1 hour',
				'referenceDate' => strtotime('2014-06-13 13:14:07'),
				'offsetType' => 4,
				'offset' => 1
			),
			array(
				'title' => 'In x hours',
				'referenceDate' => strtotime('2014-06-13 18:14:07'),
				'offsetType' => 5,
				'offset' => 6
			),
			array(
				'title' => 'Tomorrow',
				'referenceDate' => strtotime('2014-06-14 12:14:07'),
				'offsetType' => 6,
				'offset' => 1
			),
			array(
				'title' => 'In x days',
				'referenceDate' => strtotime('2014-06-15 12:14:07'),
				'offsetType' => 7,
				'offset' => 2
			),
			array(
				'title' => 'Next week',
				'referenceDate' => strtotime('2014-06-18 12:14:07'),
				'offsetType' => 8,
				'offset' => 1
			),
			array(
				'title' => 'In x weeks',
				'referenceDate' => strtotime('2014-06-28 12:14:07'),
				'offsetType' => 9,
				'offset' => 3
			),
			array(
				'title' => 'Next month',
				'referenceDate' => strtotime('2014-07-13 12:14:07'),
				'offsetType' => 10,
				'offset' => 1
			),
			array(
				'title' => 'In more than a month',
				'referenceDate' => strtotime('2015-06-13 12:14:07'),
				'offsetType' => 11,
				'offset' => 0
			)
		);

		$count = 1;
		foreach ($cases as $case) {
			$title = $case['title'];
			$referenceDate = $case['referenceDate'];
			$offsetType = $case['offsetType'];
			$offset = $case['offset'];
			
			$difference = abs($referenceDate - $now);
			
			$expectedResult = array(
				$offsetType,
				$offset,
				$difference
			);
			
			$actualResult = $this->dateTimeUtility->relativeDate($now, $referenceDate);
			$this->assertEquals($actualResult, $expectedResult, 'Case ' . $count . ': ' . $title);
			
			$count++;
		}
	}

}
