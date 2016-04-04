<?php
/**
 * Project: CsvToObjects
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

// copied this from doctrine's bin/doctrine.php
require_once __DIR__ . '/../src/Csv.php';
// end autoloader finder

assert_options(ASSERT_BAIL, 0);
assert_options(ASSERT_WARNING, 0);
assert_options(ASSERT_CALLBACK, function (){
    exit(1);
});

//
//
//

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

foreach($Csv->generateObjects() as $obj)
{
    assert(isset($obj->HeaderOne));
    assert(isset($obj->{'Header Two'}));
    assert(isset($obj->Header_Three));
}