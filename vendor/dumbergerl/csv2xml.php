<?php

namespace DumbergerL;

use DomDocument;
use Exception;

class CSV2XML {

    private $DELIMITER = ';';

    private $INPUT_FILE_NAME;
    private $OUTPUT_FILE_NAME;

    private $TEMPLATE_CODE = '';

    private $FILE_HEAD = array();

    private $XML_DOCUMENT;
    private $XML_ROOT_ELEMENT;

    function __construct ($inputFileName, $outputFileName)
    {
        $this->INPUT_FILE_NAME = $inputFileName;
        $this->OUTPUT_FILE_NAME = $outputFileName;
    
        $this->TEMPLATE_CODE = explode( '.', $this->INPUT_FILE_NAME)[0];

        $this->XML_DOCUMENT = new DomDocument();

        $this->XML_ROOT_ELEMENT = $this->XML_DOCUMENT->createElement('entityset');
        $this->XML_ROOT_ELEMENT = $this->XML_DOCUMENT->appendChild($this->XML_ROOT_ELEMENT);
    }

    function parseCSV()
    {
        if(!file_exists($this->INPUT_FILE_NAME)){
            ErrHandler::handle(new Exception("File to convert does not exist!"));
            return;
        }

        $inputFile  = fopen($this->INPUT_FILE_NAME, 'rt');
        
        try{
            // Parse Head to FILE_HEAD
            $head = fgetcsv($inputFile, 0, $this->DELIMITER);
            foreach ($head as $element) {
                $this->FILE_HEAD[] = $this->encodeString($element);
            }
        }catch(Exception $e){
            ErrHandler::handle($e);
        }

        try{
            // Parse Body to XML_ROOT_ELEMENT
            while (($row = fgetcsv($inputFile, 0, $this->DELIMITER)) !== FALSE)
            {
                $container = $this->XML_DOCUMENT->createElement('entity');

                $templateCode = $this->XML_DOCUMENT->createElement('template');
                $templateCode->setAttribute('code', $this->TEMPLATE_CODE);

                $templateCode = $container->appendChild($templateCode);

                //print_r($headers);
                foreach($this->FILE_HEAD as $i => $header)
                {
                    
                    $attributeElement = $this->XML_DOCUMENT->createElement('attribute');
                    $attributeElement->setAttribute('code', $header);
                    $valueElement = $this->XML_DOCUMENT->createElement('value');
                    $textElement = $this->XML_DOCUMENT->createTextNode($row[$i]);

                    $textElement = $valueElement->appendChild($textElement);
                    $valueElement = $attributeElement->appendChild($valueElement);
                    $attributeElement = $container->appendChild($attributeElement);

                    /*$child = $this->XML_DOCUMENT->createElement(''.$header);
                    $child = $container->appendChild($child);
                    $value = $this->XML_DOCUMENT->createTextNode($row[$i]);
                    $value = $child->appendChild($value);*/

                }

                $this->XML_ROOT_ELEMENT->appendChild($container);
            }
        }catch(Exception $e){
            ErrHandler::handle($e);
        }        

    }
    
    function export()
    {
        try{
            $strxml = $this->XML_DOCUMENT->saveXML();
            $handle = fopen($this->OUTPUT_FILE_NAME, "w");
            fwrite($handle, $strxml);
            fclose($handle);
        }catch(Exception $e)
        {
            ErrHandler::handle($e, true);
        }
    }

    function encodeString($text)
    {
        $bom = pack('H*','EFBBBF'); //avoid bom coding
        return preg_replace("/^$bom/", '', $text);
    }
}