<?php
/**
 * Project: CsvToObjects
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

// copied this from doctrine's bin/doctrine.php
$autoload_files = array( __DIR__ . '/../vendor/autoload.php',
    __DIR__ . '/../../../autoload.php');

foreach($autoload_files as $autoload_file)
{
    if(!file_exists($autoload_file)) continue;
    require_once $autoload_file;
}
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

foreach($Csv->generateObjects() as $obj)
{
    assert(isset($obj->HeaderOne));
    assert(isset($obj->{'Header Two'}));
    assert(isset($obj->Header_Three));
}