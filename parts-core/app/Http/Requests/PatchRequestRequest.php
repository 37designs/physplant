<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatchRequestRequest extends FormRequest
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
				'part.*.vendor' => 'required',
				'part.*.approved' => 'required',
				'part.*.part_num' => 'required|integer',
				'part.*.quantity' => 'required|integer',
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
				'part.*.vendor.required' => 'You need to specify the vendor for a part.',
				'part.*.approved.required' => 'You need to specify if you want to approve or deny a part.',
				'part.*.part_num.required' => 'Part number was not included. Please notify IT of this error.',
				'part.*.part_num.integer' => 'Part number was not an integer. Please notify IT of this error.',
				'part.*.part_num.integer' => 'Part number was not an integer. Please notify IT of this error.',
				'part.*.part_num.required' => 'You need to specify the quantity for a part.',
				'part.*.part_num.integer' => 'Numbers are only allowed in the quantity input.',
		];
	}
}
