<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;


class ContactUsRequest extends Request
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
        'name' => 'required', 
        'message' => 'required',
        'email' => 'required|email'
      ];
    }
}
