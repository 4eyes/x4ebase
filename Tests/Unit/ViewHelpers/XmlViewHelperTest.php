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
 * Test case for class \X4e\X4ebase\ViewHelpers\XmlViewHelper
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class XmlViewHelperTest extends \X4e\X4ebase\Tests\Unit\Base\ViewHelperTestBase
{

    /** @var  \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\X4e\X4ebase\ViewHelpers\XmlViewHelper */
    protected $subject;

    /**
     * @test
     */
    public function testRender_GetsContentFromChildren()
    {
        $this->mockSubject('renderChildren', 'formatXmlString');
        $this->subject->expects($this->once())->method('renderChildren');
        $this->subject->expects($this->once())->method('formatXmlString');
        $this->subject->render();
    }

    /**
     * @test
     */
    public function testRender_WithContent()
    {
        $this->mockSubject('renderChildren', 'formatXmlString');
        $this->subject->expects($this->never())->method('renderChildren');
        $this->subject->expects($this->once())->method('formatXmlString');
        $this->subject->render('test');
    }

    public function testFormatXmlString()
    {
        $this->mockSubject('removeEmptyNodes', 'createNewSimpleXmlElement', 'createDomDocument');

        $this->markTestIncomplete(
            'unserialize(): Error at offset 41 of 42 bytes'
        );
        $simpleXmlElement = $this->getAccessibleMock(\SimpleXMLElement::class, ['asXML'], [], '', false);
        $simpleXmlElement->expects($this->once())->method('asXML');

        $domDocument = $this->getAccessibleMock(\DOMDocument::class, ['loadXML', 'saveXML'], [1.0]);
        $domDocument->expects($this->once())->method('loadXML');
        $domDocument->expects($this->once())->method('saveXML');

        $this->subject->expects($this->once())->method('createNewSimpleXmlElement')->willReturn($simpleXmlElement);
        $this->subject->expects($this->once())->method('createDomDocument')->willReturn($domDocument);
        $this->subject->expects($this->once())->method('removeEmptyNodes');
        $this->subject->_set('removeEmptyNodes', true);

        $this->subject->_call('formatXmlString');
    }

    public function testFormatXmlString_WithoutRemoveEmptyNodes_RemovesNoNodes()
    {
        $this->mockSubject('removeEmptyNodes', 'createNewSimpleXmlElement', 'createDomDocument');

        $this->markTestIncomplete(
            'unserialize(): Error at offset 41 of 42 bytes'
        );
        $simpleXmlElement = $this->getAccessibleMock(\SimpleXMLElement::class, ['asXML'], [], '', false);
        $simpleXmlElement->expects($this->once())->method('asXML');
        $domDocument = $this->getAccessibleMock(\DOMDocument::class, ['loadXML', 'saveXML'], [], '', false);
        $domDocument->expects($this->once())->method('loadXML');
        $domDocument->expects($this->once())->method('saveXML');

        $this->subject->expects($this->once())->method('createNewSimpleXmlElement')->willReturn($simpleXmlElement);
        $this->subject->expects($this->once())->method('createDomDocument')->willReturn($domDocument);
        $this->subject->expects($this->never())->method('removeEmptyNodes');
        $this->subject->_set('removeEmptyNodes', false);

        $this->subject->_call('formatXmlString');
    }

    public function testCreateNewObject_CreatesObject_WithParameters()
    {
        $this->mockSubject();
        $object = $this->subject->_call('createNewObject', \X4e\X4ebase\Tests\Unit\ViewHelpers\XmlViewHelperTestClass::class, 'Hello', 'World');
        $this->assertInstanceOf(\X4e\X4ebase\Tests\Unit\ViewHelpers\XmlViewHelperTestClass::class, $object);
        $this->assertEquals('Hello', $object->lorem);
        $this->assertEquals('World', $object->ipsum);
    }

    public function testRemoveEmptyNodes()
    {
        $this->markTestIncomplete(
            'TODO - Not sure how this method really works'
        );
    }
}

class XmlViewHelperTestClass
{
    public $lorem = null;
    public $ipsum = null;

    public function __construct($lorem, $ipsum = null)
    {
        $this->lorem = $lorem;
        $this->ipsum = $ipsum;
    }
}
