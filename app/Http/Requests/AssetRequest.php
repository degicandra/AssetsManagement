<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'company' => 'required|string|max:255',
            'asset_code' => 'required|string|unique:assets,asset_code',
            'serial_number' => 'nullable|string|max:255',
            'model' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'type_id' => 'required|exists:asset_types,id',
            'status' => 'required|in:ready_to_deploy,deployed,archive,broken,service,request_disposal,disposed',
            'location_id' => 'required|exists:locations,id',
            'department_id' => 'required|exists:departments,id',
            'person_in_charge' => 'required|string|max:255',
            'purchase_date' => 'required|date',
            'warranty_expiration' => 'nullable|date|after:purchase_date',
            'processor' => 'nullable|string|max:255',
            'storage_type' => 'nullable|in:HDD,SSD',
            'storage_size' => 'nullable|string|max:255',
            'ram' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'notes' => 'nullable|string',
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['asset_code'] = 'required|string|unique:assets,asset_code,' . $this->asset->id;
        }

        return $rules;
    }
}
