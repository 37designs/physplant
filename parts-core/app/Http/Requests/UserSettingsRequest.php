<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSettingsRequest extends FormRequest
{
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
		return [
				'shop' => 'required|integer|min:0',
		];
	}

	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array
	 */
	public function messages()
	{
		return [
				'shop.min' => 'You have to select a shop!',
		];
	}

	/**
	 * Get the validator instance for the request and
	 * add attach callbacks to be run after validation
	 * is completed.
	 *
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function getValidatorInstance()
	{
		return parent::getValidatorInstance()->after(function ($validator)
		{
			$this->after($validator);
		});
	}

	/**
	 * Attach callbacks to be run after validation is completed.
	 *
	 * @param  \Illuminate\Contracts\Validation\Validator $validator
	 * @return callback
	 */
	public function after($validator)
	{
		/* Here we can check for special errors and report them.
		 * if (Technician::where('name', 'like', Input::get('tech'))) {
		 * $validator->errors()->add('tech', 'That Technician does not exist!');
		}*/
	}
}
