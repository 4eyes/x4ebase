<?php

namespace X4e\X4ebase\Tests\Unit\ViewHelpers;

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

/**
 * Test case for class \X4e\X4ebase\ViewHelpers\YouTubeVideoViewHelper
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class YouTubeVideoHelperTest extends \X4e\X4ebase\Tests\Unit\Base\ViewHelperTestBase
{

    /** @var  \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\X4e\X4ebase\ViewHelpers\YouTubeVideoViewHelper */
    protected $subject;

    public function testRetrieveYoutubeHash()
    {
        $testCases = [
            ['https://www.youtube.com/watch?v=4BXpi7056RM', '4BXpi7056RM'],
            ['4BXpi7056RM', '4BXpi7056RM']
        ];

        foreach ($testCases as $testCase) {
            $this->assertEquals($testCase[1], $this->subject->_callRef('retrieveYoutubeHash', $testCase[0]));
        }
    }

    public function testGetThumbnail()
    {
        $videoHash = null;
        $thumbType = null;

        $testCases = [
            [
                'videoHash' => '4BXpi7056RM',
                'thumbType' => '',
                'expectedResult' => 'https://i3.ytimg.com/vi/4BXpi7056RM/0.jpg'
            ],
        ];

        foreach ($testCases as $testCase) {
            $this->assertEquals($testCase['expectedResult'], $this->subject->getThumbnail($testCase['videoHash'], $testCase['thumbType']));
        }
    }

    public function testGetThumbnail_WithThumbnailType()
    {
        $testCases = ['0','1','2','3','default','hqdefault','mqdefault','sddefault','maxresdefault'];

        foreach ($testCases as $testCase) {
            $this->assertNotFalse(strpos($this->subject->getThumbnail('Hello', $testCase), '/' . $testCase . '.jpg'));
        }
    }

    public function testRender()
    {
        $this->mockSubject('retrieveYoutubeHash', 'renderChildren', 'getThumbnail');
        $this->templateVariableContainer->expects($this->exactly(2))->method('add');
        $this->templateVariableContainer->expects($this->exactly(2))->method('remove');
        $this->subject->_set('templateVariableContainer', $this->templateVariableContainer);
        $this->subject->expects($this->once())->method('retrieveYoutubeHash')->willReturn('4BXpi7056RM');
        $this->subject->expects($this->once())->method('renderChildren');
        $this->subject->expects($this->once())->method('getThumbnail')->willReturn('https://i3.ytimg.com/vi/4BXpi7056RM/0.jpg');

        $this->subject->render('https://www.youtube.com/watch?v=4BXpi7056RM');
    }
}
