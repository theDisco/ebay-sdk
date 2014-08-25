CHANGELOG
=========

0.1.2 (2014-08-25)
------------------

### Features

* Allow attachments to be sent and received. ([94288e3](https://github.com/davidtsadler/ebay-sdk/commit/94288e3a460d0d52a9cc2b6f2aca0a86130369ec) [David T. Sadler]

  The SDK now allows attachments to be sent as part of the request.
  Likewise attachments are handled if they appear in the response.

  To add an attachment to the request object simply call the `attachment`
  method passing in the binary data of the attachment as the first
  parameter. Note that you do not have to base64 encode the data!

  ```php
  $request->attachment(file_get_contents(__DIR__.'/picture.jpg'));
  ```

  To get the attachment from a response simply call the same method with
  no parmaters. The method will return an associative array with two keys.
  The key 'data' is the binary data of the attachment while the key
  'mimeType' returns the mime type.

  ```php
  $response = $service->downloadFile($request);

  $attachment = $response->attachment();

  $fp = fopen('attachment', 'wb');
  fwrite($fp, $attachment['data']);
  fclose($fp);
  ```

### Documentation

* Update requirements to recommend 64 bit systems. ([150abfa](https://github.com/davidtsadler/ebay-sdk/commit/150abfae02699875f86806fbb274d4ae98089e7f) [David T. Sadler]

0.1.1 (2014-08-14)
------------------

### Fixes

* Memory leak in XmlParser class. ([8bbd4ff](https://github.com/davidtsadler/ebay-sdk/commit/8bbd4ffde833f13936f1d1607ef559609e706a71), [#5](https://github.com/davidtsadler/ebay-sdk/issues/5)) [David T. Sadler]

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
