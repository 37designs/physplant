<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartsSubmitRequest extends FormRequest
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
		return [
				'tech' => 'required|integer',
				'wo' => array('required', 'regex:/([xX]-)[0-9]{8}/'),
				'parts.*.quantity' => 'required|integer',
				'parts.*.vendor' => 'required',
				'parts.*.expedite' => array('required', 'Regex:/^[0-1]$/'),
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
				'wo.regex' => 'Please make sure you have "x-" before your work order number. I.e x-12345678',
				'parts.*.quantity.required' => 'You need to specify the quantity for a part.',
				'parts.*.quantity.integer' => 'The part quantity can only be a number.',
				'parts.*.vendor.required' => 'You need to specify the vendor for a part.',
				'parts.*.expedite.required' => 'Please only put Yes or No for expedite.',
				'parts.*.expedite.regex' => 'Please only put Yes or No for expedite.',
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
		return parent::getValidatorInstance()->after(function ($validator) {
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
