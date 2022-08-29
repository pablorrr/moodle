<?php
namespace local_user_management;

class createvar
{
     public function create_vars(){

         $username = optional_param('username', 'Jake', PARAM_USERNAME);
         $password = optional_param('password', 'Moodle2012!', PARAM_TEXT);
         $idnumber = optional_param('idnumber', 'idnumbertest1', PARAM_TEXT);
         $firstname = optional_param('firstname', 'First Name User Test 1', PARAM_TEXT);
         $lastname = optional_param('lastname', 'Last Name User Test 1', PARAM_TEXT);
         $middlename = optional_param('middlename', 'Middle Name User Test 1', PARAM_TEXT);
         $lastnamephonetic = optional_param('lastnamephonetic', '最後のお名前のテスト一号', PARAM_TEXT);
         $firstnamephonetic = optional_param('firstnamephonetic', '最後のお名前のテスト一号', PARAM_TEXT);
         $alternatename = optional_param('alternatename', 'Alternate Name User Test 1', PARAM_TEXT);
         $email = optional_param('email', 'usertest1@email.com', PARAM_EMAIL);
         $description = optional_param('description', 'This is a description for user 1', PARAM_TEXT);
         $city = optional_param('city', 'Perth', PARAM_TEXT);
         $country = optional_param('country', 'au', PARAM_TEXT);

         $employee_number = optional_param('employee_number', '45', PARAM_INT);

         $organizational_unit_id = optional_param('organizational_unit_id', '45', PARAM_INT);

         $position_id = optional_param('position_id', '45', PARAM_INT);

         $location_vars = ['username', 'password', 'idnumber', 'firstname', 'lastname', 'middlename', 'lastnamephonetic',
             'firstnamephonetic', 'alternatename', 'email', 'description', 'city', 'country','employee_number','organizational_unit_id','position_id'];

         return compact($location_vars);
     }

}