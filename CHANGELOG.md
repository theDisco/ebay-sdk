CHANGELOG
=========

0.1.0 (2014-07-05)
------------------

### Breaking changes

* Change callOperation to accept a request object. ([34c44ba](https://github.com/davidtsadler/ebay-sdk/commit/34c44ba166fc9fcac0656073ed6a68b7c5f97eea)) [David T. Sadler]
    
  This is a breaking change as the paramters of the method
  BaseService::callOperation have changed. Code calling this method must
  now pass an instance of the BaseType class as the second parameter. The
  method will now construct the XML request within itself by calling the
  BaseType::toRequestXml method on the passed request object.

* Change visibility of method BaseType::toXml. ([999e6f3](https://github.com/davidtsadler/ebay-sdk/commit/999e6f3877fdb4d6cd04e9615772e63b5dd53931)) [David T. Sadler]

  This is a breaking change as the visibility of the method BaseType::toXml has been
  changed from `public` to `private`. Client code should now call the new public method
  BaseType::toRequestXml instead.
  
  The class property `$requestXmlRootElementNames` has also been added to
  the BaseType class. This is a breaking change as classes derived from
  BaseType may have to assign a value to this property in their
  constructor.
  
  ```php
  if (!array_key_exists(__CLASS__, self::$requestXmlRootElementNames)) {
      self::$requestXmlRootElementNames[__CLASS__] = '<ELEMENT NAME>';
  }
  ```
  
  Classes are only required to do this if instances of the class are used
  as request objects. The value assigned to `$requestXmlRootElementNames`
  will be used as the name of the root element in the request XML.

### Documentation

* Correct stated minimum PHP version. ([e5b9a6a](https://github.com/davidtsadler/ebay-sdk/commit/e5b9a6ab3a4eb4a5435be9116c69c797e68d4faf)) [David T. Sadler]

### Tests

* Update travis settings. ([541304c](https://github.com/davidtsadler/ebay-sdk/commit/541304ca8a50d6ea7328967c0d3ab145d8384627)) [David T. Sadler]
* Add phpunit configuration file. ([f95a253](https://github.com/davidtsadler/ebay-sdk/commit/f95a2538b4ca89553f3beda4e1fe1ae3f030a05c)) [David T. Sadler]

0.0.7 (2014-06-25)
------------------

### Refactoring

*  Make Guzzle client a return string. ([3f4be5b](https://github.com/davidtsadler/ebay-sdk/commit/3f4be5b78230af5db521ef7fc87da86c17f31b22)) [David T. Sadler]
