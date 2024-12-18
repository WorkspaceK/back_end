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
        return $this->personRepository->get_by_page($request);
    }

    public function search($dataSearch)
    {
        return $this->personRepository->search($dataSearch);
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

    public function deleteMultiple(array $ids)
    {
        return $this->personRepository->deleteMultiple($ids);
    }

    public function record($id)
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

    public function recordMulti($ids)
    {
        $data = [];
        foreach ($ids as $id) {
            if (!$person = $this->personRepository->find($id)) return abort(404);
            $baseIdentification = preg_replace('/\(\d+\)$/', '', $person->code);
            $baseIdentification = preg_replace('/-copy/', '', $baseIdentification);
            $existingPersons = $this->personRepository->getByBaseIdentification($baseIdentification);
            $highestNumber = 0;
            foreach ($existingPersons as $existingClass) {
                preg_match('/\((\d+)\)$/', $existingClass->code, $matches);
                if (!empty($matches[1])) {
                    $highestNumber = max($highestNumber, (int)$matches[1]);
                }
            }
            $newIdentification = $baseIdentification . '-copy(' . ($highestNumber + 1) . ')';
            $person->code = $newIdentification;
            $baseEmail = preg_replace('/\(\d+\)$/', '', $person->name);
            $baseEmail = preg_replace('/-copy/', '', $baseEmail);
            $newEmail = $baseEmail . '-copy(' . ($highestNumber + 1) . ')';
            $person->email = $newEmail;
            $newClass = $person->replicate();
            $newClass->save();
            $data[] = $newClass;
        }
        return $data;
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
