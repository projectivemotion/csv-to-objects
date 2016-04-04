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
    print_r(func_get_args());
    exit(1);
});

//
//
//

$data   =   <<<NOWDOC
ColumnOne,Column Two,Header_Three
1,2,3
4,5,6
NOWDOC;

$Csv    =   new \projectivemotion\Csv\Csv();
$Csv->setString($data);

$CsvObjects  =   $Csv->AsObjects();

assert($CsvObjects[0]->ColumnOne === '1');
assert($CsvObjects[1]->ColumnOne === '4');
assert($CsvObjects[1]->{'Column Two'} === '5');

$ArrayObjects   =   $Csv->AsObjects('ArrayObject', ArrayObject::ARRAY_AS_PROPS);

//var_dump($ArrayObjects);
assert($ArrayObjects[1]->{'Column Two'}   == '5');
assert($ArrayObjects[0]['Column Two'] == '2');

foreach($Csv->generateObjects() as $obj)
{
    assert(isset($obj->ColumnOne));
    assert(isset($obj->{'Column Two'}));
    assert(isset($obj->Header_Three));
}

$users  =   \projectivemotion\Csv\Csv::StringToObjects(<<<ND
Username,Password
amado,abc123
ND
);

assert($users[0]->Username  ==  'amado');
assert($users[0]->Password  ==  'abc123');

$categories =   \projectivemotion\Csv\Csv::StringToObjects(<<<Cats
ID\tCategory
1\tLanguages
2\tPackages
3\tConcepts
Cats
    ,
    ["\n", "\t"]
);

assert($categories[1]->Category == 'Packages');

echo "Passed all Tests.";