<?php
/**
 * Project: CsvToObjects
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

namespace projectivemotion\Csv;


class Csv
{
    protected $fh   =   NULL;
    protected $lineLength   =   NULL;
    protected $lineSeparator    =   "\n";
    protected $columnSeparator    =   ",";
    protected $headers  =   [];

    public function __construct()
    {

    }

    public function getLineSeparator()
    {
        return $this->lineSeparator;
    }

    public function getColumnSeparator()
    {
        return $this->columnSeparator;
    }

    public function getLineLength()
    {
        return $this->lineLength;
    }

    public function setString($string)
    {
        $this->fh   =   fopen('data://text/plain;base64,' . base64_encode($string), 'r');
    }

    function __destruct()
    {
        fclose($this->fh);
    }

    public function generateRows()
    {
        while($line =   $this->getCurrentLine())
            yield $line;
    }

    protected function getCurrentLine()
    {
        return fgetcsv($this->fh, $this->getLineLength(), $this->getColumnSeparator());
    }

    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    public function getHeaders()
    {
        if(!$this->headers)
        {
            $this->setHeaders($this->getCurrentLine());
        }

        return $this->headers;
    }

    public function generateAssocArrays()
    {
        $headers    =   $this->getHeaders();
        foreach($this->generateRows() as $line)
        {
            $object =   array_combine($headers, $line);
            yield $object;
        }
    }

    public function generateObjects()
    {
        foreach($this->generateAssocArrays() as $line)
        {
            yield (object)$line;
        }
    }

    public function AsObjects()
    {
        $data   =   [];
        foreach($this->generateAssocArrays() as $obj)
            $data[] =   (object)$obj;

        return $data;
    }
}