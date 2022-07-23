<?php
$str = 'username,email,firstname,lastname,employee_number,organizational_unit,position
Warrior,johnrambo@gmail.com,John,Rambo,1,IT,manager
Boxer,rockybalboa@gmail.com,Rocky,Balboa,2,HR,manager
Termionator,arnoldswarzeneger@gmail.com,Arnie,Swarzeneger,3,PR,manager';

//echo '<pre>';

//echo $text;
//echo '</pre>';


//echo '<pre>';
$enoflinestring = str_replace("\n", 'endOfLine', $str);
//echo $text;
//echo '</pre>';


echo '<pre>print_r($arr)';
$arr = explode('endOfLine', $enoflinestring);
print_r($arr);
echo '</pre>';


//echo '<pre>';
//echo $arr[0];
//echo '<br>';

$additional_arr_key = ['description', 'imagealt', 'lastnamephonetic', 'firstnamephonetic', 'middlename', 'alternatename', 'moodlenetprofile'];
$keys_arr = array_merge(explode(',', trim($arr[0])), $additional_arr_key);

//var_dump($keys_arr);


array_shift($arr);

foreach ($arr as $key => $value) {
    $arr[$key] = $value . ',description,imagealt,lastnamephonetic,firstnamephonetic,middlename,alternatename,moodlenetprofile';

}
//todo: przestwic koljenosc wystepowania kluczy, MOODLE jednka nie wymaga identyczje kolejnosci kolumn przy isertowaniu!!!  

//var_dump($arr);

//print_r($arr);
//echo '</pre>';


foreach ($arr as $item) {
    echo '<br>';
    // echo $item;
    echo '<br>';
    $object_arr[] = (object)array_combine($keys_arr, explode(',', $item));

}


echo '<pre>';
//echo '<h1>object_arr</h1>';

//print_r($object_arr);
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


foreach ($user_object_arr as &$object) {
    $arr = (array)$object;
    $multi_arr[] = $arr;
}

var_dump($multi_arr);

$username_arr = array_column($multi_arr, 'username');

if (count($username_arr) !== count(array_unique($username_arr))) {

    echo 'usernames must be different';
} else {

    echo 'usernames are different good very good !!!';
}



//$username_arr =implode(',',array_column($multi_arr , 'username')) ;
var_dump($username_arr);

echo '<pre>';
echo '<h1>user_object_arr  conv to multi arr</h1>';
print_r($multi_arr);
echo '<br>';


//var_dump($multi_arr);


//$a1=array("a"=>"re","b"=>"gren","c"=>"ble","d"=>"yellow");
//$a2=array("e"=>"red","f"=>"green","g"=>"blue");


//print_r(array_intersect($a1,$a2));

//var_dump($result);


//var_dump($duplicate_title);


echo '<pre>';
echo '<h1>user_object_arr</h1>';
//print_r($user_object_arr);
echo '<br>';


foreach ($position_object_arr as $object) {
    unset($object->username);
    unset($object->lastname);
    unset($object->email);
    unset($object->firstname);
    unset($object->employee_number);
    unset($object->organizational_unit);
}

foreach ($position_object_arr as &$object) {
    $multi_arr[] = (array)$object;
}


echo '<pre>';
echo '<h1>multi conv arr</h1>';
//print_r($multi_arr);
echo '<br>';
echo '</pre>';


echo '<pre>';
echo '<h1>position_object_arr</h1>';
//print_r($position_object_arr);
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
//print_r($organizational_unit_object_arr);
echo '<br>';

echo '<pre>';
echo '<h1>object_arr</h1>';
//print_r($object_arr);
echo '<br>';


echo '<pre>';
echo '<h1>iterator test</h1>';
//print_r($object_arr);
echo '<br>';



//https://stackoverflow.com/questions/24558484/php-removing-duplicate-objects-from-array

/*function my_array_unique($array, $keep_key_assoc = false){
    $duplicate_keys = array();
    $tmp = array();

    foreach ($array as $key => $val){
        // convert objects to arrays, in_array() does not support objects
        if (is_object($val))
            $val = (array)$val;

        if (!in_array($val, $tmp))
            $tmp[] = $val;
        else
            $duplicate_keys[] = $key;
    }

    foreach ($duplicate_keys as $key)
        unset($array[$key]);

    return $keep_key_assoc ? $array : array_values($array);
}*/
