<?php
namespace DTS\eBaySDK\Parser;

class Xml
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
        $meta = $this->getPhpMeta($name);

        $this->metaStack->push($meta);
    }

    private function cdata($parser, $cdata)
    {

        $this->metaStack->top()->strData .= $cdata;
    }

    private function endElement($parser, $name)
    {
        $meta = $this->metaStack->pop();

        if (!$this->metaStack->isEmpty()) {
            if ($this->isSimplePhpType($meta)) {
                if (!$meta->unbound) {
                    $this->metaStack->top()->phpObject->{$meta->propertyName} = $this->strDataToSimplePhpType($meta);
                } else {
                    $this->metaStack->top()->phpObject->{$meta->propertyName}[] = $this->strDataToSimplePhpType($meta);
                }
            } else {
                if ($this->setByValue($meta)) {
                    $meta->phpObject->value = $this->strDataToSimplePhpValueType($meta);
                }

                if (!$meta->unbound) {
                    $this->metaStack->top()->phpObject->{$meta->propertyName} = $meta->phpObject;
                } else {
                    $this->metaStack->top()->phpObject->{$meta->propertyName}[] = $meta->phpObject;
                }
            }
        } else {
            $this->rootObject = $meta->phpObject;
        }
    }

    private function getPhpMeta($elementName)
    {
        $meta = new \StdClass();

        if (!$this->metaStack->isEmpty()) {
            $elementMeta = $this->metaStack->top()->phpObject->elementMeta($elementName);
            $meta->propertyName = $elementMeta['propertyName'];
            $meta->type = $elementMeta['type'];
            $meta->unbound = $elementMeta['unbound'];
            $meta->attribute = $elementMeta['attribute'];
            $meta->elementName = $elementMeta['elementName'];
        } else {
            $meta->type = $this->rootObjectClass;
        }

        $meta->strData = '';
        $meta->phpObject = $this->newPhpObject($meta);

        return $meta;
    }

    private function newPhpObject($meta)
    {
        switch ($meta->type) {
            case 'integer':
            case 'string':
            case 'double':
            case 'boolean':
            case 'DateTime':
                break;
            default:
                return new $meta->type();
        }
    }

    private function isSimplePhpType($meta)
    {
        switch ($meta->type) {
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
        return is_subclass_of($meta->phpObject, '\DTS\eBaySDK\Types\DoubleType', false);
    }

    private function strDataToSimplePhpType($meta)
    {
        switch ($meta->type) {
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

    private function strDataToSimplePhpValueType($meta)
    {
        if (is_subclass_of($meta->phpObject, '\DTS\eBaySDK\Types\DoubleType', false)) {
            return (double)$meta->strData;
        }

        return $meta->strData;
    }
}
