<?php
/**
 * Use this script to create an initial Administrator account.
 *
 * This script should only be used by people with root access
 * on the web server.

 * If you are planning on using local authentication, you must
 * provide a password here.  The password will be encrypted when
 * the new person's account is saved
 *
 * If you are doing Employee or CAS authentication you do
 * not need to save a password into the database.
 *
 * @copyright 2011-2016 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 * @author Cliff Ingham <inghamn@bloomington.in.gov>
 */
use Application\Models\Person;
use Application\Models\Email;

include '../bootstrap.inc';

$person = new Person();

// Fill these out as needed
$person->setFirstname('Admin');
$person->setLastname('Person');
$person->setUsername('administrator');
$person->setAuthenticationMethod('local');
#$person->setPassword('');

// You most likely want Administrator
$person->setRole('Administrator');
$person->save();

// Don't forget to create an email address
$email = new Email();
$email->setPerson($person);
$email->setEmail('admin@localhost');
$email->save();
