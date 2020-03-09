<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ProjectInvitationsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('owner', $this->route('project'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => [
                'required',
                'exists:users,email',
                Rule::notIn([auth()->user()->email])
            ]
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'email.exists' => 'The user you are inviting must have an account.',
            'email.not_in' => 'User is already member of project.'
        ];
    }
}
