# GenderizeIoClient

This library integrates [genderize.io](https://genderize.io/) API for PHP projects.

## Basic Usage

    use Jhg\GenderizeIoClient\Genderizer\Genderizer;
    use Jhg\GenderizeIoClient\Model\Name;

    $genderizer = new Genderizer();
    
    $nameObj = $genderizer->recognize('John');
    echo $nameObj->getGender();
    // shows "male"
    
## Hydration

By default, GenderizeIoClient works with Name objects, but if you prefer Genderizer can returns arrays.

**Object hydration**

    use Jhg\GenderizeIoClient\Model\Name;

    /** @var Name $nameObj */
    $nameObj = $genderizer->recognize('John', null, null, Name::HYDRATE_OBJECT);

    $name = $nameObj->getName();
    $gender = $nameObj->getGender();
    $count = $nameObj->getCount();
    $probability = $nameObj->getProbability();
    
    if ($nameObj->isFemale()) {
        // do something for female
    } elseif ($nameObj->isMale()) {
        // do something for male
    } elseif ($nameObj->isUnknown()) {
        // do something for unknown genres
    } 

**Array hydration**

    /** @var array $nameArray */
    $nameArray = $genderizer->recognize('John', null, null, Name::HYDRATE_ARRAY);
    
    $name = $nameArray['name'];
    $gender = $nameArray['gender'];
    $count = $nameArray['count'];
    $probability = $nameArray['probability'];
    
## Recognize name in one country

    use Jhg\GenderizeIoClient\Genderizer\CountryNotValidException;
    use Jhg\GenderizeIoClient\Model\Name;
    
    try {
        /** @var Name $nameObj */
        $nameObj = $genderizer->recognize('John', 'gb');
        // gets genre for people called John in GB
    } catch (CountryNotValidException $e) {
        // do something for invalid countries
    }
    
## Recognize name in an especific language

    use Jhg\GenderizeIoClient\Genderizer\LanguageNotValidException;
    use Jhg\GenderizeIoClient\Model\Name;
    
    try {
        /** @var Name $nameObj */
        $nameObj = $genderizer->recognize('John', null, 'en');
        // gets genre for people called John in English
    } catch (LanguageNotValidException $e) {
        // do something for invalid countries
    }

## Recognize muliple names

    use Jhg\GenderizeIoClient\Model\Name;
    
    /** @var Name[] $nameObjs */
    $nameObjs = $genderizer->recognize(['John','Mery']);
        
        