<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;


class SubscriptionRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public function authorize()
    {
      // allow everybody  
      return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public function rules()
    {
      return [
        'subscription-email' => 'required|email'
      ];
    }
}
