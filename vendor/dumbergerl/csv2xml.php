<?php

class CSV2XML {

    private $INPUT_FILE_NAME;
    private $OUTPUT_FILE_NAME;

    private $FILE_HEAD = array();

    private $XML_DOCUMENT;

    function __construct ($inputFileName, $outputFileName)
    {
        echo "i am constructed!";
        $this->INPUT_FILE_NAME = $inputFileName;
        $this->OUTPUT_FILE_NAME = $outputFileName;
    
        $this->DOCUMENT = new DomDocument();
    }

    function parseCSV()
    {
        $inputFile  = fopen($this->INPUT_FILE_NAME, 'rt');
       
        // Parse Head to FILE_HEAD
        $head = fgetcsv($inputFile, 0, ';');
        foreach ($head as $element) {
            $this->FILE_HEAD[] = $this->encodeString($element);
        }

    }
    
    function export()
    {
        $strxml = $this->DOCUMENT->saveXML();
        $handle = fopen($outputFilename, "w");
        fwrite($handle, $strxml);
        fclose($hanlde);
    }

    function encodeString($text)
    {
        $bom = pack('H*','EFBBBF'); //avoid bom coding
        return preg_replace("/^$bom/", '', $text);
    }
}