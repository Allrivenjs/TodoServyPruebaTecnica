<?php

namespace App\Http\Requests;

use App\Models\Business;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreBusinessRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return array_merge(Business::rules,[
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    }
}
