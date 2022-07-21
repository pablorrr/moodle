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

$additional_arr_key = ['description', 'imagealt', 'lastnamephonetic', 'firstnamephonetic', 'middlename', 'alternatename', 'moodlenetprofile'];
$keys_arr = array_merge(explode(',', trim($arr[0])), $additional_arr_key);

var_dump($keys_arr);


array_shift($arr);

foreach ($arr as $key => $value) {
    $arr[$key] = $value . ',description,imagealt,lastnamephonetic,firstnamephonetic,middlename,alternatename,moodlenetprofile';

}
//todo: przestwic koljenosc wystepowania kluczy, MOODLE jednka nie wymaga identyczje kolejnosci kolumn przy isertowaniu!!!  

var_dump($arr);

//print_r($arr);
echo '</pre>';


foreach ($arr as $item) {
    echo '<br>';
    echo $item;
    echo '<br>';
    $object_arr[] = (object)array_combine($keys_arr, explode(',', $item));

}


echo '<pre>';
echo '<h1>object_arr</h1>';

print_r($object_arr);
echo '<br>';

echo '<pre>';
//print_r($object_arr[2]);
echo '<br>';

echo '<pre>';
//print_r($object_arr[2]->lastname);
echo '<br>';


echo '<pre>';
//print_r($object_arr[2]);
echo '<br>';

echo '<pre>';
//print_r($object_arr);
echo '<br>';

foreach ($object_arr as $clon) {
    $user_object_arr[] = clone $clon;
    $position_object_arr[] = clone $clon;
    $organizational_unit_object_arr[] = clone $clon;
}
//todo autoinkrentacja pol kluczy obcych przy dodawaniu nowego usera!!!
//todo poprawienie dodoawania kluczy

foreach ($user_object_arr as $object) {
    unset($object->organizational_unit);
    unset($object->position);
}
/////////////////////////////////////////////
/// //////////////////////////////////////
/// 

echo '<pre>';
echo '<h1>user_object_arr</h1>';
print_r($user_object_arr);
echo '<br>';
//[username] => Termionator
//            [email] => arnoldswarzeneger@gmail.com
//            [firstname] => Arnie
//            [lastname] => Swarzeneger
//            [employee_number] => 3
//
//
//            [organizational_unit] => PR

//ususnac [imagealt] => imagealt
//            [lastnamephonetic] => lastnamephonetic
//            [firstnamephonetic] => firstnamephonetic
//            [middlename] => middlename
//            [alternatename] => alternatename
//            [moodlenetprofile] => moodlenetprofile
//dodoac pole

foreach ($position_object_arr as $object) {
    unset($object->username);
    unset($object->lastname);
    unset($object->email);
    unset($object->firstname);
    unset($object->employee_number);
    unset($object->organizational_unit);
}

echo '<pre>';
echo '<h1>position_object_arr</h1>';
print_r($position_object_arr);
echo '<br>';
echo '</pre>';

foreach ($organizational_unit_object_arr as $object) {
    unset($object->username);
    unset($object->lastname);
    unset($object->email);
    unset($object->firstname);
    unset($object->employee_number);
    unset($object->position);

}


echo '<pre>';
echo '<h1>organizational_unit_object_arr</h1>';
print_r($organizational_unit_object_arr);
echo '<br>';

echo '<pre>';
echo '<h1>object_arr</h1>';
print_r($object_arr);
echo '<br>';