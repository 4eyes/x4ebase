<?php

namespace X4e\X4ebase\Tests\Unit\Utility;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Philipp Seßner <philipp@4eyes.ch>, 4eyes GmbH
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
 * ************************************************************* */
use X4e\X4ebase\Utility\SecurityUtility;

/**
 * Test case for class X4e\X4ebase\Utility\SecurityUtility
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class SecurityUtilityTest extends \X4e\X4ebase\Tests\Unit\Base\TestCaseBase
{
    /** @var  \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|SecurityUtility */
    protected $subject;

    public function testSaltPassword()
    {
        $this->markTestIncomplete(
            'Untestable - Static method calls'
        );

        $testCases = [
            ['Lorem', ''],
            ['ipsum', ''],
            ['Dolor', ''],
            ['sit', ''],
        ];
        foreach ($testCases as $testCase) {
            $this->assertSame($testCase[1], SecurityUtility::saltPassword($testCase[0]));
        }
    }

    public function testIsSaltedHash()
    {
        $this->markTestIncomplete(
            'Untestable - Static method calls'
        );

        $testCases = [
            ['\$M', true],
            ['\$C', true],
            ['', false],
            ['', true]
        ];
        foreach ($testCases as $testCase) {
            $this->assertSame($testCase[1], SecurityUtility::isSaltedHash($testCase[0]));
        }
    }

    public function testIsSaltedHashReturnsBoolean()
    {
        $this->assertInternalType('boolean', SecurityUtility::isSaltedHash(''));
    }

    public function testCheckPasswordReturnsBoolean()
    {
        $password = 'faiVueveeM8SheiVo8iex0chohch0oobee';
        $saltedPassword = crypt($password);

        $this->assertInternalType('boolean', SecurityUtility::checkPassword($password, $saltedPassword));
    }
}
