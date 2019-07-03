<?php

class CSV2XML {

    private $DELIMITER = ';';

    private $INPUT_FILE_NAME;
    private $OUTPUT_FILE_NAME;

    private $FILE_HEAD = array();

    private $XML_DOCUMENT;
    private $XML_ROOT_ELEMENT;

    function __construct ($inputFileName, $outputFileName)
    {
        $this->INPUT_FILE_NAME = $inputFileName;
        $this->OUTPUT_FILE_NAME = $outputFileName;
    
        $this->XML_DOCUMENT = new DomDocument();

        $this->XML_ROOT_ELEMENT = $this->XML_DOCUMENT->createElement('entityset');
        $this->XML_ROOT_ELEMENT = $this->XML_DOCUMENT->appendChild($this->XML_ROOT_ELEMENT);
    }

    function parseCSV()
    {
        $inputFile  = fopen($this->INPUT_FILE_NAME, 'rt');
       
        // Parse Head to FILE_HEAD
        $head = fgetcsv($inputFile, 0, $this->DELIMITER);
        foreach ($head as $element) {
            $this->FILE_HEAD[] = $this->encodeString($element);
        }

        // Parse Body to XML_ROOT_ELEMENT
        while (($row = fgetcsv($inputFile, 0, $this->DELIMITER)) !== FALSE)
        {
            $container = $this->XML_DOCUMENT->createElement('entity');
            //print_r($headers);
            foreach($this->FILE_HEAD as $i => $header)
            {
                //print_r($row);

                $child = $this->XML_DOCUMENT->createElement(''.$header);
                $child = $container->appendChild($child);
                $value = $this->XML_DOCUMENT->createTextNode($row[$i]);
                $value = $child->appendChild($value);

            }

            $this->XML_ROOT_ELEMENT->appendChild($container);
        }

    }
    
    function export()
    {
        $strxml = $this->XML_DOCUMENT->saveXML();
        $handle = fopen($this->OUTPUT_FILE_NAME, "w");
        fwrite($handle, $strxml);
        fclose($handle);
    }

    function encodeString($text)
    {
        $bom = pack('H*','EFBBBF'); //avoid bom coding
        return preg_replace("/^$bom/", '', $text);
    }
}