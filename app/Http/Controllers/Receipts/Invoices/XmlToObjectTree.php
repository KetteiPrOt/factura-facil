<?php

namespace App\Http\Controllers\Receipts\Invoices;

use Exception;

class XmlToObjectTree
{
    public $name;
    public $attributes = [];
    public $value = null;
    public $children = [];

    public function __construct($name, $attributes = [], $value = null)
    {
        $this->name = $name;
        $this->attributes = $attributes;
        $this->value = $value;
    }

    public static function fromXmlString($xmlString)
    {
        $xml = simplexml_load_string($xmlString, "SimpleXMLElement", LIBXML_NOCDATA);
        if (!$xml) {
            throw new Exception("Invalid XML provided.");
        }
        return self::fromSimpleXMLElement($xml);
    }

    private static function fromSimpleXMLElement($element)
    {
        $object = new self(
            $element->getName(),
            (array)$element->attributes(),
            trim((string)$element)
        );

        foreach ($element->children() as $child) {
            $object->children[] = self::fromSimpleXMLElement($child);
        }

        return $object;
    }

    public function toArray()
    {
        $array = [
            "name" => $this->name,
            "attributes" => $this->attributes,
            "value" => $this->value,
            "children" => []
        ];

        foreach ($this->children as $child) {
            $array["children"][] = $child->toArray();
        }

        return $array;
    }

    public function __get($name)
    {
        foreach($this->children as $children){
            if($children->name == $name){
                return $children;
            }
        }

        throw new Exception("Property '{$name}' does not exist on this node.");
    }
}