<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;


class SendMailRequest extends Request
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
      return true;
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
        'subject' => 'required',
        'message' => 'required'
      ];
    }
}
