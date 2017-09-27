<?php

namespace X4e\X4ebase\Tests\Unit\Domain\Repository;

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
 * Test case for class \X4e\X4ebase\Domain\Repository\AbstractRepository
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class AbstractRepositoryTest extends \X4e\X4ebase\Tests\Unit\Base\RepositoryTestBase
{

    /**
     * @test
     */
    public function testGetTranslation()
    {
        $this->mockSubject('getSystemLanguages', 'createQuery');

        $record = $this->getAccessibleMock(\TYPO3\CMS\Documentation\Domain\Model\Document::class, ['getPid'], [], '', false);
        $record->expects($this->once())->method('getPid')->willReturn(1);
        $languageIconTitles = [
            '0' => 1
        ];

        $this->subject->expects($this->once())->method('getSystemLanguages')->willReturn($languageIconTitles);

        $mockQueryResult = $this->getAccessibleMock(\TYPO3\CMS\Extbase\Persistence\Generic\QueryResult::class, ['getFirst'], [], '', false);
        $mockQueryResult->expects($this->once())->method('getFirst');

        $mockQuerySettings = $this->getAccessibleMock(\TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings::class, ['setRespectSysLanguage', 'setRespectSysLanguageAlternative', 'setSysLanguageUid'], [], '', false);
        $mockQuerySettings->expects($this->once())->method('setRespectSysLanguage')->with(false);
        $mockQuerySettings->expects($this->once())->method('setRespectSysLanguageAlternative')->with(true);
        $mockQuerySettings->expects($this->once())->method('setSysLanguageUid');

        $mockQuery = $this->getAccessibleMock(\TYPO3\CMS\Extbase\Persistence\Generic\Query::class, ['createQuery', 'getQuerySettings', 'matching', 'equals', 'execute'], [], '', false);
        $this->subject->expects($this->once())->method('createQuery')->willReturn($mockQuery);
        $mockQuery->expects($this->exactly(3))->method('getQuerySettings')->willReturn($mockQuerySettings);
        $mockQuery->expects($this->once())->method('matching')->willReturn($mockQuery);
        $mockQuery->expects($this->once())->method('execute')->willReturn($mockQueryResult);

        $this->subject->getTranslation($record, 0);
    }

    public function testGetTranslation_WithoutSysLanguageUid_ReturnsNull()
    {
        $this->mockSubject('getSystemLanguages');
        $languageIconTitles = [];
        $this->subject->expects($this->once())->method('getSystemLanguages')->willReturn($languageIconTitles);

        $record = $this->getAccessibleMock(\TYPO3\CMS\Documentation\Domain\Model\Document::class, ['getPid'], [], '', false);
        $record->expects($this->once())->method('getPid')->willReturn(1);
        $this->assertFalse($this->subject->getTranslation($record, 1));
    }

    /**
     * @test
     */
    public function testGetTranslateTools_ReturnsTranslateTools()
    {
        $this->mockSubject();
        $translateTools = $this->getAccessibleMock(\TYPO3\CMS\Backend\Configuration\TranslationConfigurationProvider::class, [], [], '', false);
        $this->subject->_set('translateTools', $translateTools);
        $this->assertSame($translateTools, $this->subject->_call('getTranslateTools'));
    }

    /**
     * @test
     */
    public function testGetTranslateTools_CreatesTranslateTools()
    {
        $this->markTestIncomplete(
            'Untestable - Static method calls'
        );
    }

    /**
     * @test
     */
    public function testGetSystemLanguages()
    {
        $this->mockSubject('getTranslateTools');
        $cachedLanguageIconTitles = [
            '0' => 'test'
        ];

        $translateTools = $this->getAccessibleMock(\TYPO3\CMS\Backend\Configuration\TranslationConfigurationProvider::class, ['getSystemLanguages'], [], '', false);
        $translateTools->expects($this->once())->method('getSystemLanguages')->willReturn($cachedLanguageIconTitles['0']);
        $this->subject->expects($this->once())->method('getTranslateTools')->willReturn($translateTools);

        $this->subject->_call('getSystemLanguages');
        $this->assertEquals($cachedLanguageIconTitles, $this->subject->_get('cachedLanguageIconTitles'));
    }
}
