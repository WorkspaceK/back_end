<?php

namespace App\Services;

use App\Repository\Person\PersonRepository;
use Illuminate\Support\Facades\Storage;

class PersonService
{
    private $personRepository;

    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    public function get_all()
    {
        return $this->personRepository->all();
    }

    public function get_by_page($request)
    {
        $data = $this->personRepository->get_by_page($request);
        return $data;
    }

    public function getListById($ids)
    {
        return $this->personRepository->findByIds($ids);
    }

    public function getListByCodes($request)
    {
        return $this->personRepository->findByCodes($request);
    }

    public function find($id)
    {
        return $this->personRepository->find($id);
    }

    public function getStudentsByClassId($personId)
    {
        return $this->personRepository->getStudentsByClassId($personId);
    }

    public function hasStudents()
    {
        return $this->personRepository->hasStudent();
    }

    public function hasByIdentifi($identifi)
    {
        return $this->personRepository->hasByIdentifi($identifi);
    }

    public function hasByEmail($email)
    {
        return $this->personRepository->hasByEmail($email);
    }

    public function getListUpdateOrderByDesc($data)
    {
        return $this->personRepository->getListUpdateOrderByDesc($data);
    }

    public function store($data)
    {
        if (isset($data['avatar'])) {
            $path = $data['avatar']->store('public/profile');
            $urlImage = substr($path, strlen('public/'));
        } else {
            $urlImage = '';
        }
        $dataStore = [
            'identification' => $data['identification'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'avatar' => $urlImage,
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'degree_id' => $data['degree_id'],
            'academic_rank_id' => $data['academic_rank_id'],
            'created_at' => now(),
            'updated_at' => now(),
        ];
        return $this->personRepository->store($dataStore);
    }

    public function update($id, $data)
    {
        if (isset($data['avatar'])) {
            $path = $data['avatar']->store('public/profile');
            $urlImage = substr($path, strlen('public/'));
        } else {
            $urlImage = '';
        }

        $dataUpdate = [
            'identification' => $data['identification'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'avatar' => $urlImage,
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'degree_id' => $data['degree_id'],
            'academic_rank_id' => $data['academic_rank_id'],
            'updated_at' => now(),
        ];
        return $this->personRepository->update($id, $dataUpdate);
    }

    public function updateStatus($id, $data)
    {
        $dataUpdate = [ 'status' => $data['status'], 'updated_at' => now() ];
        return $this->personRepository->update($id, $dataUpdate);
    }

    public function delete($id)
    {
        return $this->personRepository->delete($id);
    }

    public function mass_delete(array $ids)
    {
        return $this->personRepository->mass_delete($ids);
    }

    public function copy($id)
    {
        if(!$person = $this->personRepository->find($id)) return abort(404);

        //edit identification
        $baseCode = preg_replace('/\(\d+\)$/', '', $person->identification);
        $baseCode = preg_replace('/-copy/', '', $baseCode);
        $existingPersons = $this->personRepository->getByBaseIdentification($baseCode);

        $highestNumber = 0;
        foreach ($existingPersons as $existingPerson) {
            preg_match('/\((\d+)\)$/', $existingPerson->identification, $matches);
            if (!empty($matches[1])) {
                $highestNumber = max($highestNumber, (int)$matches[1]);
            }
        }
//        dd($highestNumber);
        $newCode = $baseCode . '-copy(' . ($highestNumber + 1) . ')';
        $person->identification = $newCode;

        //edit name
        $baseEmail = preg_replace('/\(\d+\)$/', '', $person->email);
        $baseEmail = preg_replace('/-copy/', '', $baseEmail);
        $newEmail = $baseEmail . '-copy(' . ($highestNumber + 1) . ')';
        $person->email = $newEmail;

        //end
        $newClass = $person->replicate();
        $newClass->save();

        return $newClass;
    }

    public function mass_copy(array $ids)
    {
//        $data = [];
//        foreach ($ids as $id) {
//            if (!$person = $this->personRepository->find($id)) return abort(404);
//            $baseIdentification = preg_replace('/\(\d+\)$/', '', $person->code);
//            $baseIdentification = preg_replace('/-copy/', '', $baseIdentification);
//            $existingPersons = $this->personRepository->getByBaseIdentification($baseIdentification);
//            $highestNumber = 0;
//            foreach ($existingPersons as $existingClass) {
//                preg_match('/\((\d+)\)$/', $existingClass->code, $matches);
//                if (!empty($matches[1])) {
//                    $highestNumber = max($highestNumber, (int)$matches[1]);
//                }
//            }
//            $newIdentification = $baseIdentification . '-copy(' . ($highestNumber + 1) . ')';
//            $person->code = $newIdentification;
//
//            // Chỉnh sửa email
//            $baseEmail = preg_replace('/\(\d+\)$/', '', $person->name);
//            $baseEmail = preg_replace('/-copy/', '', $baseEmail);
//            $newEmail = $baseEmail . '-copy(' . ($highestNumber + 1) . ')';
//            $person->email = $newEmail;
//
//            // Kết thúc: tạo bản sao và lu
//            $newClass = $person->replicate();
//            $newClass->save();
//            $data[] = $newClass;
//        }
//        return $data;

        $newPersons = []; // Mảng lưu trữ các bản sao mới

        foreach ($ids as $id) {
            if (!$person = $this->personRepository->find($id)) {
                abort(404, "Person with ID $id not found.");
            }

            // Chỉnh sửa identification
            $baseCode = preg_replace('/\(\d+\)$/', '', $person->identification);
            $baseCode = preg_replace('/-copy/', '', $baseCode);
            $existingPersons = $this->personRepository->getByBaseIdentification($baseCode);

            $highestNumber = 0;
            foreach ($existingPersons as $existingPerson) {
                preg_match('/\((\d+)\)$/', $existingPerson->identification, $matches);
                if (!empty($matches[1])) {
                    $highestNumber = max($highestNumber, (int)$matches[1]);
                }
            }

            $newCode = $baseCode . '-copy(' . ($highestNumber + 1) . ')';
            $person->identification = $newCode;

            // Chỉnh sửa email
            $baseEmail = preg_replace('/\(\d+\)$/', '', $person->email);
            $baseEmail = preg_replace('/-copy/', '', $baseEmail);
            $newEmail = $baseEmail . '-copy(' . ($highestNumber + 1) . ')';
            $person->email = $newEmail;

            // Kết thúc: Tạo bản sao và lưu
            $newClass = $person->replicate();
            $newClass->save();

            $newPersons[] = $newClass; // Thêm bản sao mới vào mảng
        }

        return $newPersons; // Trả về danh sách bản sao mới
    }

//    public function exportItemsToCsv($ids)
//    {
//        $persons = $this->personRepository->findByIds($ids);
//        return Excel::download(new PersonsExport($persons), 'persons.csv');
//    }
//
//    public function exportItemsToXlsx($ids)
//    {
//        $persons = $this->personRepository->findByIds($ids);
//        if ($persons->isEmpty()) {
//            throw new \Exception('No persons found for the provided IDs.');
//        }
//        return Excel::download(new PersonsExport($persons), 'persons.xlsx');
//    }
}
