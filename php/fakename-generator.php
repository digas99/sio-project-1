<!-- from https://thisinterestsme.com/generate-random-names-php/ -->
<?php

//PHP array containing forenames.
$names = array(
    'Ricardo',
    'Daniela',
    'João',
    'Carlos',
    'Diogo',
    'Afonso',
    'Rita',
    'Marta',
);

//PHP array containing surnames.
$surnames = array(
    'Correia',
    'Cardoso',
    'Tomás',
    'Costa',
    'Barraca',
    'Pereira',
    'Andrade',
    'Pinto',
    'Moreira',
    'Silva'
);

//Generate a random forename.
$random_name = $names[mt_rand(0, sizeof($names) - 1)];

//Generate a random surname.
$random_surname = $surnames[mt_rand(0, sizeof($surnames) - 1)];

//Combine them together and print out the result.
$random_fullname = $random_name . ' ' . $random_surname;