<?php

namespace Jhg\GenderizeIoClient\Tests\Genderizer;

use Jhg\GenderizeIoClient\Genderizer\Genderizer;
use Jhg\GenderizeIoClient\Model\Name;
use \Mockery as m;

/**
 * Class GenderizerTest
 * 
 * @package Jhg\GenderizeIoClient\Tests\Genderizer
 */
class GenderizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * testRecognize data provider
     *
     * @return array
     */
    public function recognizeProvider()
    {
        return [
            [
                // invalid country test
                'John',
                'zz',
                null,
                Genderizer::HYDRATE_OBJECT,
                [],
                'Jhg\GenderizeIoClient\Genderizer\Exception\CountryNotValidException'
            ],
            [
                // invalid language test
                'John',
                null,
                'zz',
                Genderizer::HYDRATE_OBJECT,
                [],
                'Jhg\GenderizeIoClient\Genderizer\Exception\LanguageNotValidException'
            ],
            [
                // basic name in object
                'John',
                null,
                null,
                Genderizer::HYDRATE_OBJECT,
                [
                    'name' => 'John',
                    'gender' => 'male',
                ],
                ''
            ],
            [
                // basic name in array
                'John',
                null,
                null,
                Genderizer::HYDRATE_ARRAY,
                [
                    'name' => 'John',
                    'gender' => 'male',
                ],
                ''
            ],
            [
                // multiple name in objects
                ['John', 'Mery'],
                null,
                null,
                Genderizer::HYDRATE_OBJECT,
                [
                    [
                        'name' => 'John',
                        'gender' => 'male',
                    ],
                    [
                        'name' => 'Mery',
                        'gender' => 'female',
                    ],
                ],
                ''
            ],
            [
                // multiple name in array
                ['John', 'Mery'],
                null,
                null,
                Genderizer::HYDRATE_ARRAY,
                [
                    [
                        'name' => 'John',
                        'gender' => 'male',
                    ],
                    [
                        'name' => 'Mery',
                        'gender' => 'female',
                    ],
                ],
                ''
            ],
            [
                // complete name in object
                'John',
                'gb',
                'en',
                Genderizer::HYDRATE_OBJECT,
                [
                    'name' => 'John',
                    'gender' => 'male',
                    'probability' => 0.3,
                    'count' => 10,
                    'country_id' => 'gb',
                    'language_id' => 'en',
                ],
                ''
            ],
            [
                // complete name in array
                'John',
                'gb',
                'en',
                Genderizer::HYDRATE_ARRAY,
                [
                    'name' => 'John',
                    'gender' => 'male',
                    'probability' => 0.3,
                    'count' => 10,
                    'country_id' => 'gb',
                    'language_id' => 'en',
                ],
                ''
            ],
        ];
    }


    /**
     * @param string|array $nameOrNames
     * @param string       $country
     * @param string       $language
     * @param int          $hydration
     * @param array        $apiResponse
     * @param string       $expectedExceptionName
     *
     * @dataProvider recognizeProvider
     */
    public function testRecognize($nameOrNames, $country, $language, $hydration, $apiResponse, $expectedExceptionName)
    {
        if ($expectedExceptionName) {
            $this->setExpectedException($expectedExceptionName);
        }

        $genderizerClientMock = m::mock('Jhg\GenderizeIoClient\HttpClient\GenderizeClient');
        $genderizerClientMock->shouldReceive('genderize')->andReturn($apiResponse);
        $genderizer = new Genderizer($genderizerClientMock);

        $returnedResults = $genderizer->recognize($nameOrNames, $country, $language, $hydration);

        if (is_array($nameOrNames)) {
            $this->assertEquals(sizeof($nameOrNames), sizeof($returnedResults));
        } else {
            $returnedResults = [$returnedResults];
            $apiResponse = [$apiResponse];
        }

        foreach ($returnedResults as $i => $result) {
            switch ($hydration) {
                case Genderizer::HYDRATE_OBJECT:
                    $this->assertNameObject($apiResponse[$i], $result);
                    break;

                case Genderizer::HYDRATE_ARRAY:
                    $this->assertEquals($apiResponse[$i], $result);
                    break;

                default:
                    $this->fail('Invalid hydration mode');
            }
        }
    }

    /**
     * @param array $expectedData
     * @param Name  $object
     */
    protected function assertNameObject(array $expectedData, Name $object)
    {
        $this->assertInstanceOf('Jhg\GenderizeIoClient\Model\Name', $object);
        $this->assertEquals($expectedData['name'], $object->getName());
        $this->assertEquals($expectedData['gender'], $object->getGender());
        if (isset($expectedData['count'])) {
            $this->assertEquals($expectedData['count'], $object->getCount());
        }
        if (isset($expectedData['probability'])) {
            $this->assertEquals($expectedData['probability'], $object->getProbability());
        }
        if (isset($expectedData['country_id'])) {
            $this->assertEquals($expectedData['country_id'], $object->getCountry());
        }
        if (isset($expectedData['language_id'])) {
            $this->assertEquals($expectedData['language_id'], $object->getLanguage());
        }
    }

    /**
     * Tests constructor without custom client, so creates new one
     */
    public function testConstructorWithoutClient()
    {
        $genderizer = new Genderizer();

        $this->assertInstanceOf('Jhg\GenderizeIoClient\Genderizer\Genderizer', $genderizer);
    }
}