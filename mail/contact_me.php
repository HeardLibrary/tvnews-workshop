<?php
/*****
Requires an additional config file, address.php, which defines the particular email addresses used in this script. Create address.php in this same directory and define the following variables in it: $to, $from, $replyto.

This file is maintained in the repo for version control purposes only -- the live script must be on a php-enabled server, as php is not supported by Github Pages.
*****/

header("Access-Control-Allow-Origin: *");

if (isset($_POST['name']) &&
   (isset($_POST['email']) && filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) &&
   isset($_POST['phone']) &&
   isset($_POST['institution'])) {
   // get form values -- not escaped since no database interaction is involved
   // existence (and validity of email) already checked on client side
   // required fields
   $name = $_POST['name'];
   $email = $_POST['email'];
   $phone = $_POST['phone'];
   $institution = $_POST['institution'];
   // optional field
   if (isset($_POST['special_needs'])) $special_needs = $_POST['special_needs'];
   if (isset($_POST['why_participate'])) $why_participate = $_POST['why_participate'];

   // create the email and send the registration message to the folks in charge
   // $to, $from, $replyto are set in address.php config file for exclusion from the Github repo
   include ("address.php");
   $email_subject = "Sustaining Television News Registration for $name";
   $email_body = "Registration for Sustaining Television News for the Next Generation, March 8-9, 2018\n\nName: $name\nEmail: $email\nPhone: $phone\nInstitution: $institution\nSpecial Needs: ";
   if (!empty($special_needs)) $email_body .= $special_needs;
   else $email_body .= "None";
   $email_body .= "\nWhy participate: ";
   if (!empty($why_participate)) $email_body .= $why_participate;
   else $email_body .= "[No response given]";
   $headers = "From: $from\n";
   $headers .= "Reply-To: $replyto";
   mail($to,$email_subject,$email_body,$headers);
   return true;
}

else {
   return false;
}

?>
