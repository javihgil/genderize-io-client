<?php

namespace Jhg\GenderizeIoClient\Genderizer;

use Jhg\GenderizeIoClient\HttpClient\GenderizeClient;
use Jhg\GenderizeIoClient\Genderizer\Exception\CountryNotValidException;
use Jhg\GenderizeIoClient\Genderizer\Exception\LanguageNotValidException;
use Jhg\GenderizeIoClient\Model\Name;
use Symfony\Component\Intl\Intl;

/**
 * Class Genderizer
 * 
 * @package Jhg\GenderizeIoClient\Genderizer
 */
class Genderizer
{
    /**
     * Hydrates a Name object
     */
    const HYDRATE_OBJECT = 1;

    /**
     * Hydrates an array
     */
    const HYDRATE_ARRAY = 2;

    /**
     * @var GenderizeClient
     */
    protected $genderizeClient;

    /**
     * @var array
     */
    protected $validCountries;

    /**
     * @var array
     */
    protected $validLanguages;

    /**
     * @param GenderizeClient $genderizeClient
     */
    public function __construct(GenderizeClient $genderizeClient = null)
    {
        if ($genderizeClient) {
            $this->genderizeClient = $genderizeClient;
        } else {
            // create default client
            $this->genderizeClient = new GenderizeClient(); ///'https://api.genderize.io/'
        }

        $this->validCountries = Intl::getRegionBundle()->getCountryNames();
        $this->validLanguages = Intl::getLanguageBundle()->getLanguageNames();
    }

    /**
     * @param string|array $nameOrNames
     * @param string|null  $country
     * @param string|null  $language
     * @param int          $hydration
     *
     * @return Name|array
     *
     * @throws CountryNotValidException
     * @throws LanguageNotValidException
     */
    public function recognize($nameOrNames, $country = null, $language = null, $hydration = self::HYDRATE_OBJECT)
    {
        if ($country !== null && ! isset($this->validCountries[strtoupper($country)])) {
            throw new CountryNotValidException(sprintf('Country %s is not valid', strtoupper($country)));
        }

        if ($language !== null && ! isset($this->validLanguages[strtolower($language)])) {
            throw new LanguageNotValidException(sprintf('Language %s is not valid', strtolower($language)));
        }

        $query = [
            'name' => $nameOrNames,
        ];

        if ($country !== null) {
            $query['country_id'] = $country;
        }

        if ($language !== null) {
            $query['language_id'] = $language;
        }

        $data = $this->genderizeClient->genderize($query);

        if ($hydration == self::HYDRATE_OBJECT) {
            if (is_array($nameOrNames)) {
                $collection = [];
                foreach ($data as $nameData) {
                    $collection[] = Name::factory($nameData);
                }
                // multiple query
                return $collection;
            } else {
                // single query
                return Name::factory($data);
            }
        } else {
            // multiple or single query
            return $data;
        }
    }
}