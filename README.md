Recognition of temporary e-mail addresses as validator for Laminas and Mezzio
-------

[![Latest Stable Version](http://poser.pugx.org/marcel-strahl/laminas-temporary-email-validator/v)](https://packagist.org/packages/marcel-strahl/laminas-temporary-email-validator) [![Total Downloads](http://poser.pugx.org/marcel-strahl/laminas-temporary-email-validator/downloads)](https://packagist.org/packages/marcel-strahl/laminas-temporary-email-validator) [![Latest Unstable Version](http://poser.pugx.org/marcel-strahl/laminas-temporary-email-validator/v/unstable)](https://packagist.org/packages/marcel-strahl/laminas-temporary-email-validator) [![License](http://poser.pugx.org/marcel-strahl/laminas-temporary-email-validator/license)](https://packagist.org/packages/marcel-strahl/laminas-temporary-email-validator)
[![composer.lock](http://poser.pugx.org/marcel-strahl/laminas-temporary-email-validator/composerlock)](https://packagist.org/packages/marcel-strahl/laminas-temporary-email-validator)
[![License](http://poser.pugx.org/marcel-strahl/laminas-temporary-email-validator/license)](https://packagist.org/packages/marcel-strahl/laminas-temporary-email-validator)
![Gitworkflow](https://github.com/Dropelikeit/laminas-temporary-email-validator/actions/workflows/ci.yml/badge.svg)

It is compatible and tested with PHP 8.+ on Laminas.

Installation:
-------

```bash
composer require marcel-strahl/laminas-temporary-email-validator
```

The following is an attribute example:
```php
namespace Application\Annotation;

use MarcelStrahl\LaminasTemporaryEmailValidator\Validator\IsNotTemporaryEmailValidator;

#[Annotation\Name("contact")]
class Contact
{
    #[Annotation\Validator(IsNotTemporaryEmailValidator::class)]
    public $email;
}
```

Hint:
-------

I am not the creator of the "Temporary Email Detection" but have changed the following package into a Symfony Validator!

Main Package Temporary E-Mail Detection: https://github.com/jprangenbergde/temporary-email-detection

Credits
-------

* Marcel Strahl <info@marcel-strahl.de>


License
-------

This bundle is under the MIT license.  
For the whole copyright, see the [LICENSE](LICENSE) file distributed with this source code.
