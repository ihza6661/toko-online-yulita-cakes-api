<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'product_name' => 'required|string|max:50',
            'category_id' => 'required|exists:categories,id',
            'original_price' => 'required|integer|min:1',
            'sale_price' => 'nullable|integer|min:1',
            'stock' => 'required|integer|min:0',
            'weight' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'label' => 'nullable|string',
        ];

        if ($this->hasFile('images')) {
            $rules['images.*'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        if ($this->has('imagesToDelete')) {
            $rules['imagesToDelete'] = 'array';
            $rules['imagesToDelete.*'] = 'integer|exists:product_images,id';
        }

        return $rules;
    }



    public function messages()
    {
        return [
            'product_name.required' => 'Nama produk wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak ditemukan.',
            'original_price.required' => 'Harga asli produk wajib diisi.',
            'original_price.min' => 'Harga asli produk tidak boleh kurang dari 1.',
            'sale_price.min' => 'Harga diskon produk tidak boleh kurang dari 1.',
            'stock.required' => 'Stok produk wajib diisi.',
            'stock.min' => 'Stok tidak boleh kurang dari 0.',
            'weight.required' => 'Berat produk wajib diisi.',
            'weight.min' => 'Berat tidak boleh kurang dari 0.',
        ];
    }
}
