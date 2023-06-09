<?php

namespace App\Http\Requests\Submissions;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function rules(): array
  {
    return [
      'user_id' => 'required',
      'journal_id' => 'required',
      'file_revision' => 'nullable|mimes:pdf|max:10000',
      'comment' => 'required|string',
    ];
  }

  /**
   * Get the error messages for the defined validation rules.
   *
   */
  public function messages(): array
  {
    return [
      'user_id.required' => ':attribute tidak boleh dikosongkan',
      'journal_id.required' => ':attribute tidak boleh dikosongkan',
      'file_revision.image' => ':attribute tidak valid, pastikan memilih gambar',
      'file_revision.mimes' => ':attribute tidak valid, masukkan gambar dengan format jpg atau png',
      'file_revision.max' => ':attribute terlalu besar, maksimal :max kb',
      'comment.required' => ':attribute tidak boleh dikosongkan',
      'comment.string' => ':attribute tidak valid, masukkan yang benar',
    ];
  }

  /**
   * Get custom attributes for validator errors.
   *
   */
  public function attributes(): array
  {
    return [
      'user_id' => 'Pengguna',
      'journal_id' => 'Makalah',
      'file_revision' => 'File',
      'comment' => 'Komentar',
    ];
  }
}
