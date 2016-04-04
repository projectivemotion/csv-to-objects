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

    public function __construct($lineSeparator = "\t", $columnSeparator = ",")
    {
        $this->setLineSeparator($lineSeparator);
        $this->setColumnSeparator($columnSeparator);
    }

    public function setLineSeparator($lineSeparator)
    {
        $this->lineSeparator = $lineSeparator;
    }

    public function setColumnSeparator($columnSeparator)
    {
        $this->columnSeparator = $columnSeparator;
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

    public function reset()
    {
        $this->headers  =   NULL;
        rewind($this->fh);
    }

    public function generateAssocArrays()
    {
        $this->reset();
        
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

    public function AsObjects($class = '')
    {
        $data   =   [];
        $args   = func_get_args();

        foreach($this->generateAssocArrays() as $obj)
        {
            if($class)
            {
                $RC =   new \ReflectionClass($class);
                $args[0]    =   $obj;
                $data[] =   $RC->newInstanceArgs($args);
            }else
                $data[] =   (object)$obj;
        }

        return $data;
    }

    public static function StringToObjects($datastring, $separators = ["\n", ","])
    {
        $Csv    =   new Csv($separators[0], $separators[1]);
        $Csv->setString($datastring);

        return $Csv->AsObjects();
    }
}