# Validator

Independent library allows to simple validation other objects

Install
=======

Using composer
```
composer require ayeo/validator
```

Example objects
===============

Let's consider simplified objects as below
```php
class Company
{
    /** @var Address */
    private $address;
    
    /** @var string */ 
    public $name;
    
    /** @var Address */
    public function getAddress()
    {
        return $this->address();
    }
}
```

```php
class Address
{
    /** @var string */ 
    public $street;
    
    /** @var string */ 
    public $town;
    
    /** @var string */ 
    public $countries;
    
}
```

Validation rules
================

To process validation we need to define our rules
```php
use Ayeo\Validator\ValidationRules

class CompanyValidationRules extends ValidationRules
{
    public function getRules()
    {
        return
        [
            ['company',
                [
                    ['name', new MinLength(5)],
                    ['address',
                        ['street', new MinLength(5)],
                        ['town', new MinLength(5)],
                        ['country', new OneOf(['USA', 'UK', 'Poland'])]
                    ]
                ] 
        ];            
    }
}
```

It is not too sophisticated but works just fine. As you can see we are able to validate nested objects. Validator is smart enough to get private and protected properties (if we got getter). Validator usage:

```php
$company = new Company;
$company->name = "Test Company";

$validator = new Validator(new CompanyValidationRules);
$isValid = $validator->validate($company);
$errors = $validator->getErrors();
```

Default values
==============

Version 1.2 introduced default values support. In order to set default value you need to pass it as third argument. Default value will be used only if field value is null. Be aware that default value as still subject of further validation - if you set invalid default value it will result with error
```php
use Ayeo\Validator\ValidationRules

class CompanyValidationRules extends ValidationRules
{
    public function getRules()
    {
        return [['company', [['name', new MinLength(5), "Unknown name"]]];            
    }
}
```

Allow null
==========

By default given validator will skip checking in case of null value. Of course you need some of them to check even null value. If constraint class implements CheckNull interface validator will force check field even if it is null. At the moment only NotNull constraint it one of this kind.


Availaible constraints
======================

- Length
- MinLength
- MaxLength
- Integer
- Numeric
- NumericMin
- NumericMax
- NotNull
- NonEmpty
- ClassInstance
- NotClassInstance
- LowerThanField

Feel free to add some more!
