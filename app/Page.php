<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
  /**
   * Functions sends email from Contact Us form
   *
   * @param string $name
   * @param string $from
   * @param string $message
   */
  public static function sendForm($name, $from, $message)
  {
    $to       = 'info@fluids.ac.uk';
    $subject  = 'Message from UKFN website';
    $headers  = 'From: ' . $name . ' <' .$from .'>' . "\r\n";
    $headers .= 'Reply-To: ' . $from . '' . "\r\n";
    $headers .= 'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);
  }
}

