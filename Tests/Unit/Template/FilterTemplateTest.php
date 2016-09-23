<?php

namespace X4e\X4ebase\Tests\Unit\Template;

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
 * Test case for class \X4e\X4ebase\Template\FilterTemplate
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class FilterTemplateTest extends \X4e\X4ebase\Tests\Unit\Base\ModelTestBase
{

    /** @var  \X4e\X4ebase\Template\FilterTemplate|\PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface */
    protected $subject;

    /**
     * @test
     */
    public function testInitialValues()
    {
        $this->initialValueTest('filterArray', []);
        $this->initialValueTest('searchStrings', []);
        $this->initialValueTest('searchableParameters', []);
        $this->initialValueTest('filterMethods', []);
    }

    /**
     * @test
     */
    public function testGettersSetters()
    {
        $this->arrayGetterSetterTest('filterArray');
        $this->arrayGetterSetterTest('searchStrings');
        $this->arrayGetterSetterTest('searchableParameters');
        $this->arrayGetterSetterTest('filterMethods');
    }

    /**
     * @test
     */
    public function testAddSearchableParameterAddsParameterOnlyOnce()
    {
        $this->subject->setSearchableParameters([]);
        $testCases = [
            ['lorem', ['lorem']],
            ['ipsum', ['lorem', 'ipsum']],
            ['dolor', ['lorem', 'ipsum', 'dolor']],
            ['lorem', ['lorem', 'ipsum', 'dolor']],
        ];
        foreach ($testCases as $testCase) {
            $this->subject->addSearchableParameter($testCase[0]);
            $this->assertSame($testCase[1], $this->subject->getSearchableParameters());
        }
    }

    /**
     * @test
     */
    public function testAddMultipleSearchableParametersCallsAddSearchableParameterNTimes()
    {
        $this->mockSubject('addSearchableParameter');
        $testCases = [
            [['lorem'], 1],
            [['lorem', 'ipsum'], 2],
            [['lorem', 'ipsum', 'dolor'], 3],
            [['lorem', 'ipsum', 'dolor', 'sit'], 4]
        ];

        foreach ($testCases as $testCase) {
            $i = 0;
            foreach ($testCase[0] as $testParameter) {
                $this->subject
                    ->expects($this->at($i))
                    ->method('addSearchableParameter')
                    ->with($testParameter);
                $i++;
            }
            $this->subject->addMultipleSearchableParameters($testCase[0]);
        }
    }

    /**
     * @test
     */
    public function testRemoveSearchableParameter()
    {
        $initialState = ['lorem', 'ipsum', 'dolor', 'sit', 'amet'];
        //array($parameter, $result)
        $testCases = [
            ['ipsum', ['lorem', 'dolor', 'sit', 'amet']],
            ['lorem', ['ipsum', 'dolor', 'sit', 'amet']],
        ];
        foreach ($testCases as $testCase) {
            $this->subject->setSearchableParameters($initialState);
            $this->subject->removeSearchableParameter($testCase[0]);
            $this->assertSame($testCase[1], $this->subject->getSearchableParameters());
        }
    }

    /**
     * @test
     */
    public function testAddFilterToFilterArray()
    {
        $this->subject->setFilterArray([]);
        //array(filterKey, filterValue, expectedResult)
        $testCases = [
            ['lorem', 'a', ['lorem' => 'a']],
            ['ipsum', 'a', ['lorem' => 'a', 'ipsum' => 'a']],
            ['dolor', 'b', ['lorem' => 'a', 'ipsum' => 'a', 'dolor' => 'b']],
            ['lorem', 'b', ['lorem' => 'b', 'ipsum' => 'a', 'dolor' => 'b']],
        ];
        foreach ($testCases as $testCase) {
            $this->subject->addFilterToFilterArray($testCase[0], $testCase[1]);
            $this->assertSame($testCase[2], $this->subject->getFilterArray());
        }
    }

    /**
     * @test
     */
    public function testRemoveFilterFromFilterArray()
    {
        $initialState = ['lorem' => 'a', 'ipsum' => 'a', 'dolor' => 'b', 'sit' => 'b', 'amet' => 'c'];
        $testCases = [
            ['lorem', ['ipsum' => 'a', 'dolor' => 'b', 'sit' => 'b', 'amet' => 'c']],
            ['dolor', ['lorem' => 'a', 'ipsum' => 'a', 'sit' => 'b', 'amet' => 'c']],
        ];
        foreach ($testCases as $testCase) {
            $this->subject->setFilterArray($initialState);
            $this->subject->removeFilterFromFilterArray($testCase[0]);
            $this->assertSame($testCase[1], $this->subject->getFilterArray());
        }
    }

    /**
     * @test
     */
    public function testSetSearchStringsFromSpaceSeparatedList()
    {
        $testCases = [
            ['Lorem', ['Lorem']],
            ['Lorem! Ipsum', ['Lorem!', 'Ipsum']],
            ['Lorem ! Ipsum', ['Lorem', '!', 'Ipsum']]
        ];
        foreach ($testCases as $testCase) {
            $this->subject->setSearchStringsFromSpaceSeparatedList($testCase[0]);
            $this->assertSame($testCase[1], $this->subject->getSearchStrings());
        }
    }

    /**
     * @test
     */
    public function testGetFilterMethodForParameter()
    {
        $initialState = ['lorem' => 'a', 'ipsum' => 'a', 'dolor' => 'b', 'sit' => 'b', 'amet' => 'c'];
        $testCases = [
            ['lorem', 'a'],
            ['amet', 'c'],
            ['sit', 'b']
        ];
        foreach ($testCases as $testCase) {
            $this->subject->setFilterMethods($initialState);
            $this->assertSame($testCase[1], $this->subject->getFilterMethodForParameter($testCase[0]));
        }
    }
}
