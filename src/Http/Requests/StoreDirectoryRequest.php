<?php

namespace Okorpheus\DocumentLibrary\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Okorpheus\DocumentLibrary\Enums\VisibilityValues;
use Okorpheus\DocumentLibrary\Models\Directory;

class StoreDirectoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'visibility' => ['required', Rule::enum(VisibilityValues::class)],
            'parent_id' => ['nullable', Rule::exists(Directory::class, 'id')],
        ];
    }

    public function authorize(): bool
    {
        $parentDirectory = $this->parent_id
            ? Directory::find($this->parent_id)
            : null;

        return $this->user()->can('create', [Directory::class, $parentDirectory]);
    }

    public function validated($key = null, $default = null): mixed
    {
        $validated = parent::validated();
        $validated['visibility'] = VisibilityValues::from($validated['visibility']);

        if ($key === null) {
            return $validated;
        }

        return data_get($validated, $key, $default);
    }
}
