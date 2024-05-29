<?php

namespace App\Imports;

use App\Models\Account;
use App\Models\ClassStudent;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row): \Illuminate\Database\Eloquent\Model|Student|null
    {
        $account = Account::create([
            'email' => $row['email'],
            'password' => bcrypt('123456'), // Thay 'default_password' bằng mật khẩu mặc định của bạn
            'role' => '3', // Thay 'default_role' bằng vai trò mặc định của bạn
            'locked' => '0', // Giả sử tài khoản không bị khóa khi tạo
        ]);

        return new Student([
            'code' => $row['code'],
            'name' => $row['name'],
            'phone' => $row['phone'],
            'address' => $row['address'],
            'gender' => $row['gender'],
            'date_of_birth' => $row['birthday'],
            'class_student_id' => $this->getClassIdByName($row['class']),
            'account_id' => $account->id,
        ]);
    }

    public function getClassIdByName($name){
        return ClassStudent::where('name', $name)->first()->id;
    }
}
