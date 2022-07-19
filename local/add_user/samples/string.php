<?php
$str = 'username,email,firstname,lastname,employee_number,organizational_unit,position
Warrior,johnrambo@gmail.com,John,Rambo,1,IT,manager
Boxer,rockybalboa@gmail.com,Rocky,Balboa,2,HR,manager
Termionator,arnoldswarzeneger@gmail.com,Arnie,Swarzeneger,3,PR,manager';

echo '<pre>';

//echo $text;
echo '</pre>';


echo '<pre>';
$enoflinestring = str_replace("\n", 'endOfLine', $str);
//echo $text;
echo '</pre>';


echo '<pre>';
$arr = explode('endOfLine', $enoflinestring);
//print_r($arr);
echo '</pre>';


echo '<pre>';
//echo $arr[0];
echo '<br>';

$keys_arr = explode(',', $arr[0]);
//echo $arr[1];
array_shift($arr);
//print_r($arr);
echo '</pre>';

foreach ($arr as $item) {

    $new_arr[] =(object)array_combine($keys_arr,explode(',',$item) );
}

echo '<pre>';
print_r($new_arr);
echo '<br>';

echo '<pre>';
print_r($new_arr[0]->username);
echo '<br>';









/*$record = new stdClass();
$record->username;
$record->email;
$record->firstname;
$record->lastname;
$record->employee_number;
$record->organizational_unit;
$record->position;
var_dump($record);






$var = '["SupplierInvoiceReconciliation"]';
$var = json_decode($var, TRUE);
print_r($var);

echo '<br>';
$var = '["SupplierInvoiceReconciliation"]';
$var = json_decode($str, TRUE);
print_r($var);


$gameData = new stdClass();
$gameData->location = new stdClass();
$basementstring = "basement";


echo '<br>';
class tLocation {
    public $description;
}

$gameData->location->{'darkHouse'} = new tLocation;
$gameData->location->{"darkHouse"}->description = "You walkinto a dusty old house";


$gameData->location->{$basementstring} = new tLocation;
$gameData->location->{"basement"}->description = "its really damp down here.";

var_dump($gameData);*/

//echo $gameData->location->basement->description;


