<?php

namespace Jhg\GenderizeIoClient\Tests\Model;

use Jhg\GenderizeIoClient\Model\Name;
use \Mockery as m;

/**
 * Class NameTest
 * 
 * @package Jhg\GenderizeIoClient\Tests\Model
 */
class NameTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test name getter an setter
     */
    public function testName()
    {
        $name = new Name();
        $name->setName('testValue');
        $this->assertEquals('testValue', $name->getName());
    }

    /**
     * Test gender getter an setter
     */
    public function testGender()
    {
        $name = new Name();
        $name->setGender('testValue');
        $this->assertEquals('testValue', $name->getGender());
    }

    /**
     * Test probability getter an setter
     */
    public function testProbability()
    {
        $name = new Name();
        $name->setProbability(0.21);
        $this->assertEquals(0.21, $name->getProbability());
    }

    /**
     * Test count getter an setter
     */
    public function testCount()
    {
        $name = new Name();
        $name->setCount(1);
        $this->assertEquals(1, $name->getCount());
    }

    /**
     * Test country getter an setter
     */
    public function testCountry()
    {
        $name = new Name();
        $name->setCountry('fr');
        $this->assertEquals('fr', $name->getCountry());
    }

    /**
     * Test language getter an setter
     */
    public function testLanguage()
    {
        $name = new Name();
        $name->setLanguage('es');
        $this->assertEquals('es', $name->getLanguage());
    }


    /**
     * Test gender boolean functions
     */
    public function testGenderBools()
    {
        $female = new Name();
        $female->setGender(Name::FEMALE);
        $this->assertTrue($female->isFemale());
        $this->assertFalse($female->isMale());
        $this->assertFalse($female->isUnkwown());

        $male = new Name();
        $male->setGender(Name::MALE);
        $this->assertFalse($male->isFemale());
        $this->assertTrue($male->isMale());
        $this->assertFalse($male->isUnkwown());

        $unknown = new Name();
        $this->assertFalse($unknown->isFemale());
        $this->assertFalse($unknown->isMale());
        $this->assertTrue($unknown->isUnkwown());
    }

    /**
     * Test factory with minimum data
     */
    public function testFactoryWithBasicData()
    {
        $data = [
            'name' => 'John',
            'gender' => 'male',
        ];

        $name = Name::factory($data);

        $this->assertEquals('John', $name->getName());
        $this->assertEquals('male', $name->getGender());
        $this->assertNull($name->getCount());
        $this->assertNull($name->getCountry());
        $this->assertNull($name->getLanguage());
        $this->assertNull($name->getProbability());
        $this->assertTrue($name->isMale());
        $this->assertFalse($name->isFemale());
        $this->assertFalse($name->isUnkwown());
    }

    /**
     * Test factory with all data
     */
    public function testFactoryWithCompleteData()
    {
        $data = [
            'name' => 'Mery',
            'gender' => 'female',
            'count' => 40,
            'probability' => 0.48,
            'country_id' => 'gb',
            'language_id' => 'en',
        ];

        $name = Name::factory($data);

        $this->assertEquals('Mery', $name->getName());
        $this->assertEquals('female', $name->getGender());
        $this->assertEquals(40, $name->getCount());
        $this->assertEquals('gb', $name->getCountry());
        $this->assertEquals('en', $name->getLanguage());
        $this->assertEquals(0.48, $name->getProbability());
        $this->assertFalse($name->isMale());
        $this->assertTrue($name->isFemale());
        $this->assertFalse($name->isUnkwown());
    }
}