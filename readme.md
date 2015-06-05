# Validator

Undependent library allows to simple validation other objects

Install
=======

Using composer
```
composer require 'ayeo/validator:1.0.1'
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

Availaible constraints
======================

- MinLength
- Length
- MinLength
- Integer
- Numeric
- NumericMin
- NumericMax
- NotNull
- ClassInstance
- NotClassInstance
- LowerThanField

Feel free to add some more!
