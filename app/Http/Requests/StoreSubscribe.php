<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubscribe extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'last_name'  => 'nullable|string|max:50',
            'first_name' => 'nullable|string|max:50',
            'email'      => 'bail|required|email|max:40|unique:App\Subscribe,email',
            'user_id'    => 'nullable|bail|integer|max:16777215|exists:App\User,id',
        ];

        if ($this->getMethod() == 'PUT') $rules['email'] .= ',' . request()->get('email') . ',email';

        return $rules;
    }

    /**
     * Custom messages for validation.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required'       => 'A :attribute kitöltése kötelező!',
            'string'         => 'A :attribute értékének szövegnek kell lennie!',
            'integer'        => 'A :attribute mező értékének természetes számnak kell lennie!',
            'last_name.max'  => 'A :attribute mező értéke maximum :max karakter hosszú lehet!',
            'first_name.max' => 'A :attribute mező értéke maximum :max karakter hosszú lehet!',
            'email.max'      => 'A :attribute mező értéke maximum :max karakter hosszú lehet!',
            'user_id.max'    => 'A :attribute mező maximális értéke :max lehet!',
            'email.unique'   => 'Ez az e-mail cím már rajta van a listán!',
            'email.email'    => 'Érvénytelen e-mail!',
            'user_id.exists' => 'A megadott azonosítóval nem létezik regisztrált felhasználó!',
        ];
    }

    /**
     * Custom attributes for validation.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'last_name'  => 'vezetéknév',
            'first_name' => 'keresztnév',
            'email'      => 'feliratkozási e-mail cím',
            'user_id'    => 'felhasználó azonosító',
        ];
    }
}
