<?php

require_once 'PHPUnit/Framework.php';
require_once('../spyc.php');

class ParseTest extends PHPUnit_Framework_TestCase
{
    protected $yaml;

    protected function setUp()
    {
        $this->yaml = spyc_load_file('../spyc.yaml');
    }

    public function testMergeHashKeys()
    {
        $Expected =   [
         ['step' => ['instrument' => 'Lasik 2000', 'pulseEnergy' => 5.4, 'pulseDuration' => 12, 'repetition' => 1000, 'spotSize' => '1mm']],
         ['step' => ['instrument' => 'Lasik 2000', 'pulseEnergy' => 5.4, 'pulseDuration' => 12, 'repetition' => 1000, 'spotSize' => '2mm']],
      ];
        $Actual = spyc_load_file('indent_1.yaml');
        $this->assertEquals($Expected, $Actual['steps']);
    }

    public function testDeathMasks()
    {
        $Expected =  ['sad' => 2, 'magnificent' => 4];
        $Actual = spyc_load_file('indent_1.yaml');
        $this->assertEquals($Expected, $Actual['death masks are']);
    }

    public function testDevDb()
    {
        $Expected =  ['adapter' => 'mysql', 'host' => 'localhost', 'database' => 'rails_dev'];
        $Actual = spyc_load_file('indent_1.yaml');
        $this->assertEquals($Expected, $Actual['development']);
    }

    public function testNumericKey()
    {
        $this->assertEquals('Ooo, a numeric key!', $this->yaml[1040]);
    }

    public function testMappingsString()
    {
        $this->assertEquals("Anyone's name, really.", $this->yaml['String']);
    }

    public function testMappingsInt()
    {
        $this->assertSame(13, $this->yaml['Int']);
    }

    public function testMappingsBooleanTrue()
    {
        $this->assertSame(true, $this->yaml['True']);
    }

    public function testMappingsBooleanFalse()
    {
        $this->assertSame(false, $this->yaml['False']);
    }

    public function testMappingsZero()
    {
        $this->assertSame(0, $this->yaml['Zero']);
    }

    public function testMappingsNull()
    {
        $this->assertSame(null, $this->yaml['Null']);
    }

    public function testMappingsNotNull()
    {
        $this->assertSame('null', $this->yaml['NotNull']);
    }

    public function testMappingsFloat()
    {
        $this->assertSame(5.34, $this->yaml['Float']);
    }

    public function testMappingsNegative()
    {
        $this->assertSame(-90, $this->yaml['Negative']);
    }

    public function testMappingsSmallFloat()
    {
        $this->assertSame(0.7, $this->yaml['SmallFloat']);
    }

    public function testNewline()
    {
        $this->assertSame("\n", $this->yaml['NewLine']);
    }

    public function testSeq0()
    {
        $this->assertEquals('PHP Class', $this->yaml[0]);
    }

    public function testSeq1()
    {
        $this->assertEquals('Basic YAML Loader', $this->yaml[1]);
    }

    public function testSeq2()
    {
        $this->assertEquals('Very Basic YAML Dumper', $this->yaml[2]);
    }

    public function testSeq3()
    {
        $this->assertEquals(['YAML is so easy to learn.',
                                            'Your config files will never be the same.'], $this->yaml[3]);
    }

    public function testSeqMap()
    {
        $this->assertEquals(['cpu' => '1.5ghz', 'ram' => '1 gig',
                                            'os' => 'os x 10.4.1'], $this->yaml[4]);
    }

    public function testMappedSequence()
    {
        $this->assertEquals(['yaml.org', 'php.net'], $this->yaml['domains']);
    }

    public function testAnotherSequence()
    {
        $this->assertEquals(['program' => 'Adium', 'platform' => 'OS X',
                                            'type' => 'Chat Client'], $this->yaml[5]);
    }

    public function testFoldedBlock()
    {
        $this->assertEquals("There isn't any time for your tricks!\nDo you understand?", $this->yaml['no time']);
    }

    public function testLiteralAsMapped()
    {
        $this->assertEquals("There is nothing but time\nfor your tricks.", $this->yaml['some time']);
    }

    public function testCrazy()
    {
        $this->assertEquals([ ['name' => 'spartan', 'notes' =>
                                                                            [ 'Needs to be backed up',
                                                                                         'Needs to be normalized' ],
                                                                             'type' => 'mysql' ]], $this->yaml['databases']);
    }

    public function testColons()
    {
        $this->assertEquals('like', $this->yaml["if: you'd"]);
    }

    public function testInline()
    {
        $this->assertEquals(['One', 'Two', 'Three', 'Four'], $this->yaml[6]);
    }

    public function testNestedInline()
    {
        $this->assertEquals(['One', ['Two', 'And', 'Three'], 'Four', 'Five'], $this->yaml[7]);
    }

    public function testNestedNestedInline()
    {
        $this->assertEquals([ 'This', ['Is', 'Getting', ['Ridiculous', 'Guys']],
                                    'Seriously', ['Show', 'Mercy']], $this->yaml[8]);
    }

    public function testInlineMappings()
    {
        $this->assertEquals(['name' => 'chris', 'age' => 'young', 'brand' => 'lucky strike'], $this->yaml[9]);
    }

    public function testNestedInlineMappings()
    {
        $this->assertEquals(['name' => 'mark', 'age' => 'older than chris',
                                             'brand' => ['marlboro', 'lucky strike']], $this->yaml[10]);
    }

    public function testReferences()
    {
        $this->assertEquals(['Perl', 'Python', 'PHP', 'Ruby'], $this->yaml['dynamic languages']);
    }

    public function testReferences2()
    {
        $this->assertEquals(['C/C++', 'Java'], $this->yaml['compiled languages']);
    }

    public function testReferences3()
    {
        $this->assertEquals([
                                                                        ['Perl', 'Python', 'PHP', 'Ruby'],
                                                                        ['C/C++', 'Java']
                                                                     ], $this->yaml['all languages']);
    }

    public function testEscapedQuotes()
    {
        $this->assertEquals("you know, this shouldn't work.  but it does.", $this->yaml[11]);
    }

    public function testEscapedQuotes_2()
    {
        $this->assertEquals("that's my value.", $this->yaml[12]);
    }

    public function testEscapedQuotes_3()
    {
        $this->assertEquals("again, that's my value.", $this->yaml[13]);
    }

    public function testQuotes()
    {
        $this->assertEquals("here's to \"quotes\", boss.", $this->yaml[14]);
    }

    public function testQuoteSequence()
    {
        $this->assertEquals([ 'name' => "Foo, Bar's", 'age' => 20], $this->yaml[15]);
    }

    public function testShortSequence()
    {
        $this->assertEquals([ 0 => 'a', 1 =>  [0 => 1, 1 => 2], 2 => 'b'], $this->yaml[16]);
    }

    public function testHash_1()
    {
        $this->assertEquals('Hash', $this->yaml['hash_1']);
    }

    public function testHash_2()
    {
        $this->assertEquals('Hash #and a comment', $this->yaml['hash_2']);
    }

    public function testHash_3()
    {
        $this->assertEquals('Hash (#) can appear in key too', $this->yaml['hash#3']);
    }

    public function testEndloop()
    {
        $this->assertEquals('Does this line in the end indeed make Spyc go to an infinite loop?', $this->yaml['endloop']);
    }

    public function testReallyLargeNumber()
    {
        $this->assertEquals('115792089237316195423570985008687907853269984665640564039457584007913129639936', $this->yaml['a_really_large_number']);
    }

    public function testFloatWithZeros()
    {
        $this->assertSame('1.0', $this->yaml['float_test']);
    }

    public function testFloatWithQuotes()
    {
        $this->assertSame('1.0', $this->yaml['float_test_with_quotes']);
    }

    public function testFloatInverse()
    {
        $this->assertEquals('001', $this->yaml['float_inverse_test']);
    }

    public function testIntArray()
    {
        $this->assertEquals([1, 2, 3], $this->yaml['int array']);
    }

    public function testArrayOnSeveralLines()
    {
        $this->assertEquals([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19], $this->yaml['array on several lines']);
    }

    public function testmoreLessKey()
    {
        $this->assertEquals('<value>', $this->yaml['morelesskey']);
    }

    public function testArrayOfZero()
    {
        $this->assertSame([0], $this->yaml['array_of_zero']);
    }

    public function testSophisticatedArrayOfZero()
    {
        $this->assertSame(['rx' =>  ['tx' =>  [0]]], $this->yaml['sophisticated_array_of_zero']);
    }

    public function testSwitches()
    {
        $this->assertEquals([ ['row' => 0, 'col' => 0, 'func' =>  ['tx' => [0, 1]]]], $this->yaml['switches']);
    }

    public function testEmptySequence()
    {
        $this->assertSame([], $this->yaml['empty_sequence']);
    }

    public function testEmptyHash()
    {
        $this->assertSame([], $this->yaml['empty_hash']);
    }

    public function testEmptykey()
    {
        $this->assertSame(['' =>  ['key' => 'value']], $this->yaml['empty_key']);
    }

    public function testMultilines()
    {
        $this->assertSame([['type' => 'SomeItem', 'values' =>  ['blah', 'blah', 'blah', 'blah'], 'ints' => [2, 54, 12, 2143]]], $this->yaml['multiline_items']);
    }

    public function testManyNewlines()
    {
        $this->assertSame('A quick
fox


jumped
over





a lazy



dog', $this->yaml['many_lines']);
    }

    public function testWerte()
    {
        $this->assertSame(['1' => 'nummer 1', '0' => 'Stunde 0'], $this->yaml['werte']);
    }

    /* public function testNoIndent() {
      $this->assertSame (array(
        array ('record1'=>'value1'),
        array ('record2'=>'value2')
      )
      , $this->yaml['noindent_records']);
    } */

    public function testColonsInKeys()
    {
        $this->assertSame([1000], $this->yaml['a:1']);
    }

    public function testColonsInKeys2()
    {
        $this->assertSame([2000], $this->yaml['a:2']);
    }

    public function testSpecialCharacters()
    {
        $this->assertSame('[{]]{{]]', $this->yaml['special_characters']);
    }

    public function testAngleQuotes()
    {
        $Quotes = Spyc::YAMLLoad('quotes.yaml');
        $this->assertEquals(['html_tags' =>  ['<br>', '<p>'], 'html_content' =>  ['<p>hello world</p>', 'hello<br>world'], 'text_content' =>  ['hello world']],
          $Quotes);
    }

    public function testFailingColons()
    {
        $Failing = Spyc::YAMLLoad('failing1.yaml');
        $this->assertSame(['MyObject' =>  ['Prop1' =>  ['key1:val1']]],
          $Failing);
    }
}
