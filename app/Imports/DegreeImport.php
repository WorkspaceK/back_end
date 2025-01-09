<?php

namespace App\Imports;

use App\Models\Degree;
use Maatwebsite\Excel\Concerns\ToModel;

class DegreeImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        if ($row[0] === 'Mã học vị' || is_null($row[0])) {
            return null;
        }

        return new Degree([
            'code' => $row[0],  // Mã học vị
            'name' => $row[1],  // Tên học vị
            'description' => $row[2],  // Mô tả
            'is_default'  => filter_var($row[3], FILTER_VALIDATE_BOOLEAN),  // Mặc định
        ]);
    }
    public function rules(): array
    {
        return [
            '0' => ['required', 'string', 'max:50', 'unique:degrees,code'],
            '1' => ['required', 'string', 'max:100', 'unique:degrees,name'],
            '2' => ['nullable', 'string'],
            '3' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Tùy chọn thông báo lỗi cho từng trường.
     */
    public function customValidationMessages()
    {
        return [
            '0.required' => 'Trường này là bắt buộc.',
            '0.string' => 'Trường này phải là chuỗi ký tự.',
            '0.max' => 'Trường này không được vượt quá :max ký tự.',
            '0.unique' => 'Giá trị này đã tồn tại trong hệ thống.',

            '1.required' => 'Trường này là bắt buộc.',
            '1.string' => 'Trường này phải là chuỗi ký tự.',
            '1.max' => 'Trường này không được vượt quá :max ký tự.',
            '1.unique' => 'Giá trị này đã tồn tại trong hệ thống.',

            '2.string' => 'Trường này phải là chuỗi ký tự.',

            '3.boolean' => 'Trường này phải là giá trị đúng hoặc sai (TRUE/FALSE).',
        ];
    }
}
