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
 * Test case for class \X4e\X4ebase\Domain\Repository\AbstractFilterRepository
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class AbstractFilterRepositoryTest extends \X4e\X4ebase\Tests\Unit\Base\RepositoryTestBase
{

    /**
     * @test
     */
    public function testFilterByParameter_WithoutFilters()
    {
        $this->mockSubject();

        $filterMethod = 'equals';
        $parameterName = 'lorem';
        $parameterValue = [];

        $query = $this->getMock(\TYPO3\CMS\Extbase\Persistence\Generic\Query::class, ['logicalOr', 'like', 'equals'], [], '', false);
        $query->expects($this->never())->method('logicalOr');
        $query->expects($this->never())->method($filterMethod)->with($parameterName, $parameterValue);

        $this->assertNull($this->subject->_callRef('filterByParameter', $query, $filterMethod, $parameterName, $parameterValue));
    }

    /**
     * @test
     */
    public function testFilterByParameter()
    {
        $this->mockSubject('logicalOr', 'equals', 'contains');
        $testCases = [
            [
                'filterMethod' => 'equals',
                'parameterName' => 'lorem',
                'parameterValue' => ['test']
            ],
            [
                'filterMethod' => 'like',
                'parameterName' => 'lorem',
                'parameterValue' => ['test']
            ],
        ];

        foreach ($testCases as $testCase) {
            $query = $this->getMock(\TYPO3\CMS\Extbase\Persistence\Generic\Query::class, ['logicalOr', 'like', 'equals'], [], '', false);
            $query->expects($this->once())->method('logicalOr');
            $query->expects($this->once())->method($testCase['filterMethod'])->with($testCase['parameterName'], $testCase['parameterValue'][0]);

            $this->subject->_callRef(filterByParameter, $query, $testCase['filterMethod'], $testCase['parameterName'], $testCase['parameterValue']);
        }
    }

    /**
     * @test
     */
    public function testSearchByParameter_WithoutSearchableParameters()
    {
        $this->mockSubject();
        $searchableParameters = [];
        $searchString = 'test';

        $query = $this->getMock(\TYPO3\CMS\Extbase\Persistence\Generic\Query::class, ['logicalOr', 'like'], [], '', false);
        $query->expects($this->never())->method('logicalOr');
        $query->expects($this->never())->method('like');

        $this->assertNull($this->subject->searchByParameter($query, $searchableParameters, $searchString));
    }

    /**
     * @test
     */
    public function testSearchByParameter()
    {
        $this->mockSubject();
        $searchableParameters = [
            'lorem' => 'like',
            'ipsum' => 'equals'
        ];
        $searchString = 'test';

        $query = $this->getMock(\TYPO3\CMS\Extbase\Persistence\Generic\Query::class, ['logicalOr', 'like', 'equals'], [], '', false);
        $query->expects($this->once())->method('logicalOr');
        $query->expects($this->once())->method('like')->with('lorem', '%test%');
        $query->expects($this->once())->method('equals')->with('ipsum', '%test%');

        $this->subject->searchByParameter($query, $searchableParameters, $searchString);
    }

    /**
     * @test
     */
    public function testCreateMatching_WithoutConstraints()
    {
        $this->mockSubject('filterByParameter', 'searchByParameter');

        /** @var \X4e\X4ebase\Template\FilterTemplate|\PHPUnit_Framework_MockObject_MockObject $filterTemplate */
        $filterTemplate = $this->getMock(\X4e\X4ebase\Template\FilterTemplate::class, ['getFilterArray', 'getFilterMethodForParameter', 'getSearchStrings', 'getSearchableParameters']);
        $filterTemplate->expects($this->once())->method('getFilterArray')->willReturn([]);
        $filterTemplate->expects($this->never())->method('getFilterMethodForParameter');
        $filterTemplate->expects($this->once())->method('getSearchStrings')->willReturn([]);
        $filterTemplate->expects($this->never())->method('getSearchableParameters');

        $this->subject->expects($this->never())->method('filterByParameter');
        $this->subject->expects($this->never())->method('searchByParameter');

        $query = $this->getMock(\TYPO3\CMS\Extbase\Persistence\Generic\Query::class, ['matching', 'logicalAnd'], [], '', false);
        $query->expects($this->never())->method('matching');
        $query->expects($this->never())->method('logicalAnd');

        $this->subject->createMatching($query, $filterTemplate);
    }

    /**
     * @test
     */
    public function testCreateMatching()
    {
        $this->mockSubject('filterByParameter', 'searchByParameter');
        $filterArray = [
            'lorem' => [1, 2],
            'ipsum' => ['test']
        ];
        $filterMethods = [
            'lorem' => 'equals',
            'ipsum' => 'equals'
        ];
        $searchStrings = ['dolor', 'sit'];
        $searchableParameters = [
            'amet' => 'like'
        ];

        /** @var \X4e\X4ebase\Template\FilterTemplate|\PHPUnit_Framework_MockObject_MockObject $filterTemplate */
        $filterTemplate = $this->getMock(\X4e\X4ebase\Template\FilterTemplate::class, ['getFilterArray', 'getFilterMethodForParameter', 'getSearchStrings', 'getSearchableParameters']);
        $filterTemplate->expects($this->once())->method('getFilterArray')->willReturn($filterArray);
        $filterTemplate->expects($this->exactly(2))->method('getFilterMethodForParameter')->willReturn('equals');
        $filterTemplate->expects($this->once())->method('getSearchStrings')->willReturn($searchStrings);
        $filterTemplate->expects($this->exactly(2))->method('getSearchableParameters')->willReturn($searchableParameters);

        $this->subject->expects($this->at(0))->method('filterByParameter')->willReturn(null);
        $this->subject->expects($this->at(1))->method('filterByParameter')->willReturn(1);
        $this->subject->expects($this->exactly(2))->method('searchByParameter')->willReturn(2);

        $constraints = [
            1, 2, 2
        ];

        $query = $this->getMock(\TYPO3\CMS\Extbase\Persistence\Generic\Query::class, ['matching', 'logicalAnd'], [], '', false);
        $query->expects($this->once())->method('matching')->willReturn($query);
        $query->expects($this->once())->method('logicalAnd')->with($constraints);

        $this->subject->createMatching($query, $filterTemplate);
    }

    /**
     * @test
     */
    public function testPerformSearch()
    {
        $this->mockSubject('createQuery', 'createMatching');

        $filterTemplate = $this->getMock(\X4e\X4ebase\Template\FilterTemplate::class, ['setSearchableParameters', 'setFilterMethods']);
        $filterTemplate->expects($this->once())->method('setSearchableParameters');
        $filterTemplate->expects($this->once())->method('setFilterMethods');

        $documents = $this->getMock(\TYPO3\CMS\Extbase\Persistence\Generic\QueryResult::class, [], [], '', false);

        $query = $this->getMock(\TYPO3\CMS\Extbase\Persistence\Generic\Query::class, ['execute'], [], '', false);
        $query->expects($this->once())->method('execute')->willReturn($documents);

        $this->subject->expects($this->once())->method('createQuery');
        $this->subject->expects($this->once())->method('createMatching')->willReturn($query);

        $this->subject->performSearch($filterTemplate);
    }
}
