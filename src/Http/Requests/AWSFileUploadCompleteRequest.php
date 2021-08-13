<?php

namespace ChrisBraybrooke\S3DirectUpload\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AWSFileUploadCompleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (config('s3directupload.allow_public') && !auth()->check()) {
            return true;
        }
        return true;
        return $this->user()->can('create', config('s3directupload.file_model'));
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'name' => $this->filled('name') ? $this->name : $this->path,
            'disk' => config('s3directupload.upload_disk'),
            'created_by' => auth()->id()
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'disk' => 'required|string',
            'mime_type' => 'required|string',
            'size' => 'required|numeric',
            'name' => 'required|string',
            'description' => 'string',
            'created_by' => 'exists:users,id|nullable',
        ];
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation()
    {
        $this->merge([
            //
        ]);
    }
}
