<?php namespace App\Http\Requests;

class CreateDiscussionRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'topic' => 'required|exists:topics,id',
			'title' => 'required',
			'content' => 'required',
		];
	}

	public function messages()
	{
		return [
			'topic.required' => "Please select a topic for this discussion",
			'topic.exists' => "Please select a valid topic",
			'title.required' => "Please enter a title for this discussion",
			'content.required' => "Please enter your post for this discussion",
		];
	}

}
