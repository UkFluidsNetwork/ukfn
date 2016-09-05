<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
  /**
   * Function adds email address to subcription table and sends confirmation e-mail
   * 
   * @param string $email Subscription email taken from form
   * @author Robert Barczyk <rb783@cam.ac.uk>
   */
  public static function addEmail($email)
  {
    // check if existing email exists
    $existingEmail = \DB::table('subscriptions')->where('email', '=', $email)->get();

    if(empty($existingEmail)) {
      $subscription = new Subscription();
      $subscription->email = $email;
      $subscription->save();

      $from     = 'noreply@ukfluids.net';
      $name     = 'UKFN Mailing List';
      $to       = $email;
      $message  = "Thank you for signing up to our mailing list\n\n";
      $message  .= "UK Fluids Network";

      $subject  = 'UKFN Mailing List';
      $headers  = 'From: ' . $name . ' <' .$from .'>' . "\r\n";
      $headers .= 'X-Mailer: PHP/' . phpversion();

      mail($to, $subject, $message, $headers);
    }
  }
}

