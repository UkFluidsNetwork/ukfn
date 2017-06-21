<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;


class SigSubscriptionRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
      // allow all requests
      return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      return [
        'subscribe-sig-email' => 'required|email',
        'sig_id' => 'required'
      ];
    }
}
