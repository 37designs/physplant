<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialRequest extends FormRequest
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
				'part.*.status' => 'required|integer',
				'part.*.part_num' => 'required|integer',
				'part.*.eta' => 'required|date',
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
				'part.*.status.required' => 'You need to set the status of a part.',
				'part.*.status.integer' => 'Failed to submit part int. Notify IT of this error.',
				'part.*.part_num.integer' => 'Part Number failed to submit. Notify IT of this error.',
				'part.*.part_num.required' => 'Part Number failed to submit. Notify IT of this error.',
				'part.*.eta.required' => 'You need to fill out an ETA for a part.',
				'part.*.eta.date' => 'Your ETA has to be in date format. mm/dd/yyyy',
		];
	}
}
