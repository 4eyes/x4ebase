<?php

require_once('../spyc.php');

function roundTrip($a)
{
    return Spyc::YAMLLoad(Spyc::YAMLDump(['x' => $a]));
}

class RoundTripTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
    }

    public function testNull()
    {
        $this->assertEquals(['x' => null], roundTrip(null));
    }

    public function testY()
    {
        $this->assertEquals(['x' => 'y'], roundTrip('y'));
    }

    public function testExclam()
    {
        $this->assertEquals(['x' => '!yeah'], roundTrip('!yeah'));
    }

    public function test5()
    {
        $this->assertEquals(['x' => '5'], roundTrip('5'));
    }

    public function testSpaces()
    {
        $this->assertEquals(['x' => 'x '], roundTrip('x '));
    }

    public function testApostrophes()
    {
        $this->assertEquals(['x' => "'biz'"], roundTrip("'biz'"));
    }

    public function testNewLines()
    {
        $this->assertEquals(['x' => "\n"], roundTrip("\n"));
    }

    public function testHashes()
    {
        $this->assertEquals(['x' =>  ['#color' => '#fff']], roundTrip(['#color' => '#fff']));
    }

    public function testWordWrap()
    {
        $this->assertEquals(['x' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaa  bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb'], roundTrip('aaaaaaaaaaaaaaaaaaaaaaaaaaaa  bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb'));
    }

    public function testABCD()
    {
        $this->assertEquals(['a', 'b', 'c', 'd'], Spyc::YAMLLoad(Spyc::YAMLDump(['a', 'b', 'c', 'd'])));
    }

    public function testABCD2()
    {
        $a = ['a', 'b', 'c', 'd']; // Create a simple list
        $b = Spyc::YAMLDump($a);        // Dump the list as YAML
        $c = Spyc::YAMLLoad($b);        // Load the dumped YAML
        $d = Spyc::YAMLDump($c);        // Re-dump the data
        $this->assertSame($b, $d);
    }
}
