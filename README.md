# Csv-To-Objects
Quickly Convert a Csv String to an array of Std Objects in PHP
 
[![Build Status](https://travis-ci.org/projectivemotion/csv-to-objects.svg?branch=master)](https://travis-ci.org/projectivemotion/csv-to-objects)

## Usage
    $data   =   <<<NOWDOC
    HeaderOne,Header Two,Header_Three
    1,2,3
    4,5,6
    NOWDOC;
    
    $Csv    =   new \projectivemotion\Csv\Csv();
    $Csv->setString($data);
    
    $CsvObjects  =   $Csv->AsObjects();
    
    assert($CsvObjects[0]->HeaderOne === '1');
    assert($CsvObjects[1]->HeaderOne === '4');
    assert($CsvObjects[1]->{'Header Two'} === '5');
    
## Installation

With Composer:

    composer require projectivemotion/csv-to-objects
    
Manual download:

    git clone https://github.com/projectivemotion/csv-to-objects.git
    php -f csv-to-objects/examples/AsStdObjects.php
    
## License
The MIT License (MIT)

Copyright (c) 2016 Amado Martinez

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
