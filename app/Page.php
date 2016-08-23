<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
  /**
   * Functions sends email from Contact Us form
   * 
   * @author Robert Barczyk <robert@barczyk.net>
   */
  public static function sendForm($name, $from, $message) 
  {
    $to       = 'webmaster@ukfluids.net';
    $subject  = 'Message from UKFN website';
    $headers  = 'From: ' . $name . ' <' .$from .'>' . "\r\n";
    $headers .= 'Reply-To: ' . $from . '' . "\r\n";
    $headers .= 'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);
  }
}
