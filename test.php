<?php

require('SendGrid.php');
require('config.php');

$crm = new SendGrid(SENDGRID_URL, SENDGRID_APIKEY);


// Get contact
// $email = 'bettyrodriguezrn@yahoo.com';
// echo "getContact:";
// var_dump($crm->getContact($email));
// echo "<hr/>\n\n";

// Create new contact
// $data = array(
//   'email' => 'david@davidrios.me',
//   'attributes' => array(
//     'FIRSTNAME' => 'David',
//     'LASTNAME' => 'Ríos',
//     'NUMERO_IDENTIFICACION' => '42828318',
//     'PAIS'=> 'Colombia',
//     'CIUDAD' => 'Sabaneta',
//     'DIRECCION' => 'Cra 34#81 a sur 37',
//     'CELLPHONE' => '573003255451',
//     'ANO_NACIMIENTO' => '1985',
//     'MES_NACIMIENTO' => '5',
//     'DIA_NACIMIENTO' => '7',
//     'EPS' => 'Sura',
//     'PACIENTE_CANCER' => 'Si',
//     'TIPO_CANCER' => 'Unilateral - Bilateral',
//     'TRATAMIENTO_CANCER' => 'Quimioterapia',
//     'ANO_DIAGNOSTICO' => '2021',
//     'MES_DIAGNOSTICO' => '10',
//     'DIA_DIAGNOSTICO' => '4',
//     'COMO_CONOCIO_ALMAROSA' => 'Ninguno|',
//     'COMO_CONOCIO_MASVIVA' => 'Redes sociales',
//   )
// );
// echo "createContact:";
// var_dump($crm->createContact($data, SENDGRID_LIST));
// echo "<hr/>\n\n";


// Add contact to list
// $email = 'david@davidrios.me';
// echo "addContactToList:";
// // var_dump($crm->addContactToList($email, 'SENDGRID_LIST'));
// var_dump($crm->addContactToList($email, '8e737656-dd32-47eb-bc4f-8b518025a51f'));
// echo "<hr/>\n\n";


// Send email
// $data = array(
//   'email' => 'david@davidrios.co',
//   'firstname' => 'David'
// );
// var_dump($crm->sendEmail(SENDGRID_TEMPLATE, $data));