<?php

namespace Jhg\GenderizeIoClient\Model;

/**
 * Class Name
 * 
 * @package Jhg\GenderizeIoClient\Model
 */
class Name
{
    const MALE = 'male';
    const FEMALE = 'female';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $gender;

    /**
     * @var float
     */
    protected $probability;

    /**
     * @var int
     */
    protected $count;

    /**
     * @var string
     */
    protected $country;

    /**
     * @var string
     */
    protected $language;

    /**
     * @param array $data
     *
     * @return Name
     */
    public static function factory(array $data)
    {
        $name = new self();

        $name->setName($data['name']);
        $name->setGender($data['gender']);

        if (isset($data['probability'])) {
            $name->setProbability(floatval($data['probability']));
        }

        if (isset($data['count'])) {
            $name->setCount($data['count']);
        }

        if (isset($data['country_id'])) {
            $name->setCountry($data['country_id']);
        }

        if (isset($data['language_id'])) {
            $name->setLanguage($data['language_id']);
        }

        return $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     *
     * @return $this
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return float
     */
    public function getProbability()
    {
        return $this->probability;
    }

    /**
     * @param float $probability
     *
     * @return $this
     */
    public function setProbability($probability)
    {
        $this->probability = $probability;

        return $this;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param int $count
     *
     * @return $this
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     *
     * @return $this
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     *
     * @return $this
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return bool
     */
    public function isMale()
    {
        return $this->getGender() == self::MALE;
    }

    /**
     * @return bool
     */
    public function isFemale()
    {
        return $this->getGender() == self::FEMALE;
    }

    /**
     * @return bool
     */
    public function isUnkwown()
    {
        return $this->getGender() == null;
    }
}