<?php
echo '<pre>';
// An array that represents a possible record set returned from a database
$a = array(
  array(
    'id' => 5698,
    'first_name' => 'Peter',
    'last_name' => 'Griffin',
  ),
  array(
    'id' => 4767,
    'first_name' => 'Ben',
    'last_name' => 'Smith',
  ),
  array(
    'id' => 3809,
    'first_name' => 'Joe',
    'last_name' => 'Doe',
  )
);

$last_names = array_column($a, 'last_name');
print_r($last_names);

//Get column of last names from a recordset, indexed by the "id" column:

$a = array(
  array(
    'id' => 5698,
    'first_name' => 'Peter',
    'last_name' => 'Griffin',
    'address'=>array('146','Raviwar peth','solapur')  
  ),
  array(
    'id' => 4767,
    'first_name' => 'Ben',
    'last_name' => 'Smith',
    'address'=>array('146','Raviwar peth','pune')
  ),
  array(
    'id' => 3809,
    'first_name' => 'Joe',
    'last_name' => 'Doe',
    'address'=>array('111')  
  )
);
$last_names = array_column($a, 'last_name', 'id');
$address = array_column($a, 'address', 'id');
print_r($last_names);
print_r($address);