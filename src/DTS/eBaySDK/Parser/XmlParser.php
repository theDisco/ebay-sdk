<?php
namespace DTS\eBaySDK\Parser;

class XmlParser
{
    private $parser;

    private $rootObjectClass;

    private $rootObject;

    private $metaStack;

    public function __construct($rootObjectClass)
    {
        $this->parser = xml_parser_create('UTF-8');

        xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($this->parser, XML_OPTION_SKIP_WHITE, 1);
        xml_set_object($this->parser, $this);
        xml_set_element_handler($this->parser, 'startElement', 'endElement');
        xml_set_character_data_handler($this->parser, 'cdata');

        $this->rootObjectClass = $rootObjectClass;

        $this->metaStack = new \SplStack();
    }

    public function __destruct()
    {
        if (is_resource($this->parser)) {
            xml_parser_free($this->parser);
        }
    }

    /**
     * Parse the passed xml to create a PHP object.
     *
     * @param string $xml The xml string to parse.
     *
     * @returns mixed     A PHP object derived from DTS\eBaySDK\Types\BaseType
     */
    public function parse($xml)
    {
        xml_parse($this->parser, $xml, true);

        return $this->rootObject;
    }

    private function startElement($parser, $name, array $attributes)
    {
        $this->metaStack->push($this->getPhpMeta($name, $attributes));
    }

    private function cdata($parser, $cdata)
    {
        $this->metaStack->top()->strData .= $cdata;
    }

    private function endElement($parser, $name)
    {
        $meta = $this->metaStack->pop();

        if (!$this->metaStack->isEmpty()) {
            // Element in the XML may not exist as a property name in the class.
            // This could happen if the SDK is out of date with what eBay return.
            // It could also happen if eBay return elements that are not mentioned in any WSDL.
            if ($meta->propertyName !== '') { 
                $parentObject = $this->getParentObject();
                // Parent object may not have been created if it didn't exist as a property name.
                if ($parentObject) {
                    if (!$meta->unbound) {
                        $parentObject->{$meta->propertyName} = $this->getValueToAssign($meta);
                    } else {
                        $parentObject->{$meta->propertyName}[] = $this->getValueToAssign($meta);
                    }
                }
            }
        } else {
            $this->rootObject = $meta->phpObject;
        }
    }

    private function getParentObject()
    {
        return $this->metaStack->top()->phpObject;
    }

    private function getPhpMeta($elementName, $attributes)
    {
        $meta = new \StdClass();
        $meta->propertyName = '';
        $meta->phpType = '';
        $meta->unbound = false;
        $meta->attribute = false;
        $meta->elementName = '';
        $meta->strData = '';

        if (!$this->metaStack->isEmpty()) {
            $parentObject = $this->getParentObject();
            if ($parentObject) {
                $elementMeta = $parentObject->elementMeta($elementName);
                if ($elementMeta) {
                    $meta->propertyName = $elementMeta['propertyName'];
                    $meta->phpType = $elementMeta['type'];
                    $meta->unbound = $elementMeta['unbound'];
                    $meta->attribute = $elementMeta['attribute'];
                    $meta->elementName = $elementMeta['elementName'];
                }
            }
        } else {
            $meta->phpType = $this->rootObjectClass;
        }

        $meta->phpObject = $this->newPhpObject($meta);

        if ($meta->phpObject) { 
            foreach ($attributes as $attribute => $value) {
                // These attribute will simply not exist in a PHP object.
                if ('xmlns' === $attribute) {
                    continue;
                }
                $attributeMeta = $meta->phpObject->elementMeta($attribute);
                // Attribute in the XML may not exist as a property name in the class.
                // This could happen if the SDK is out of date with what eBay return.
                // It could also happen if eBay return elements that are not mentioned in any WSDL.
                if ($attributeMeta) {
                    $meta->phpObject->{$attributeMeta['propertyName']} = $value;
                }
            }
        }

        return $meta;
    }

    private function newPhpObject($meta)
    {
        switch ($meta->phpType) {
            case 'integer':
            case 'string':
            case 'double':
            case 'boolean':
            case 'DateTime':
                break;
            default:
                return $meta->phpType !== '' ? new $meta->phpType() : null;
        }
    }

    private function getValueToAssign($meta)
    {
        if ($this->isSimplePhpType($meta)) {
            return $this->getValueToAssignToProperty($meta);
        } else {
            if ($this->setByValue($meta)) {
                $meta->phpObject->value = $this->getValueToAssignToValue($meta);
            }
            return $meta->phpObject;
        }
    }

    private function isSimplePhpType($meta)
    {
        switch ($meta->phpType) {
            case 'integer':
            case 'string':
            case 'double':
            case 'boolean':
            case 'DateTime':
                return true;
            default:
                return false;
        }
    }

    private function setByValue($meta)
    {
        return (
            is_subclass_of($meta->phpObject, '\DTS\eBaySDK\Types\Base64BinaryType', false) ||
            is_subclass_of($meta->phpObject, '\DTS\eBaySDK\Types\BooleanType', false) ||
            is_subclass_of($meta->phpObject, '\DTS\eBaySDK\Types\DecimalType', false) ||
            is_subclass_of($meta->phpObject, '\DTS\eBaySDK\Types\DoubleType', false) ||
            is_subclass_of($meta->phpObject, '\DTS\eBaySDK\Types\IntegerType', false) ||
            is_subclass_of($meta->phpObject, '\DTS\eBaySDK\Types\StringType', false) ||
            is_subclass_of($meta->phpObject, '\DTS\eBaySDK\Types\TokenType', false) ||
            is_subclass_of($meta->phpObject, '\DTS\eBaySDK\Types\URIType', false)
        );
    }

    private function getValueToAssignToProperty($meta)
    {
        switch ($meta->phpType) {
            case 'integer':
                return (integer)$meta->strData;
            case 'double':
                return (double)$meta->strData;
            case 'boolean':
                return $meta->strData === 'true';
            case 'DateTime':
                return new \DateTime($meta->strData, new \DateTimeZone('UTC'));
            case 'string':
            default:
                return $meta->strData;
        }
    }

    private function getValueToAssignToValue($meta)
    {
        if (is_subclass_of($meta->phpObject, '\DTS\eBaySDK\Types\Base64BinaryType', false)) {
            return $meta->strData;
        } else if (is_subclass_of($meta->phpObject, '\DTS\eBaySDK\Types\BooleanType', false)) {
            return $meta->strData === 'true';
        } else if (is_subclass_of($meta->phpObject, '\DTS\eBaySDK\Types\DecimalType', false)) {
            return (integer)$meta->strData;
        } else if (is_subclass_of($meta->phpObject, '\DTS\eBaySDK\Types\DoubleType', false)) {
            return (double)$meta->strData;
        } else if (is_subclass_of($meta->phpObject, '\DTS\eBaySDK\Types\IntegerType', false)) {
            return (integer)$meta->strData;
        } else if (is_subclass_of($meta->phpObject, '\DTS\eBaySDK\Types\StringType', false)) {
            return $meta->strData;
        } else if (is_subclass_of($meta->phpObject, '\DTS\eBaySDK\Types\TokenType', false)) {
            return $meta->strData;
        } else if (is_subclass_of($meta->phpObject, '\DTS\eBaySDK\Types\URIType', false)) {
            return $meta->strData;
        }

        return $meta->strData;
    }
}
