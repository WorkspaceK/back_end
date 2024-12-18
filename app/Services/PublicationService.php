<?php

namespace App\Services;

use App\Repository\Publication\PublicationRepository;

class PublicationService
{

    private $publicationRepository;

    public function __construct(PublicationRepository $publicationRepository)
    {
        $this->publicationRepository = $publicationRepository;
    }

    public function getAll()
    {
        return $this->publicationRepository->all();
    }

    public function getListOrderBy($request)
    {
        return $this->publicationRepository->getListOrderBy($request);
    }

    public function search($dataSearch)
    {
        return $this->publicationRepository->search($dataSearch);
    }

    public function getListById($ids)
    {
        return $this->publicationRepository->findByIds($ids);
    }

    public function getListByCodes($request)
    {
        return $this->publicationRepository->findByCodes($request);
    }

    public function find($id)
    {
        return $this->publicationRepository->find($id);
    }

    public function getStudentsByClassId($publicationId)
    {
        return $this->publicationRepository->getStudentsByClassId($publicationId);
    }

    public function hasStudents()
    {
        return $this->publicationRepository->hasStudent();
    }

    public function hasByIdentifi($identifi)
    {
        return $this->publicationRepository->hasByIdentifi($identifi);
    }

    public function hasByEmail($email)
    {
        return $this->publicationRepository->hasByEmail($email);
    }

    public function getListUpdateOrderByDesc($data)
    {
        return $this->publicationRepository->getListUpdateOrderByDesc($data);
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
        return $this->publicationRepository->store($dataStore);
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
        return $this->publicationRepository->update($id, $dataUpdate);
    }

    public function updateStatus($id, $data)
    {
        $dataUpdate = [ 'status' => $data['status'], 'updated_at' => now() ];
        return $this->publicationRepository->update($id, $dataUpdate);
    }

    public function delete($id)
    {
        return $this->publicationRepository->delete($id);
    }

    public function deleteMultiple(array $ids)
    {
        return $this->publicationRepository->deleteMultiple($ids);
    }

    public function record($id)
    {
        if(!$publication = $this->publicationRepository->find($id)) return abort(404);

        //edit identification
        $baseCode = preg_replace('/\(\d+\)$/', '', $publication->identification);
        $baseCode = preg_replace('/-copy/', '', $baseCode);
        $existingPublications = $this->publicationRepository->getByBaseIdentification($baseCode);

        $highestNumber = 0;
        foreach ($existingPublications as $existingPublication) {
            preg_match('/\((\d+)\)$/', $existingPublication->identification, $matches);
            if (!empty($matches[1])) {
                $highestNumber = max($highestNumber, (int)$matches[1]);
            }
        }
//        dd($highestNumber);
        $newCode = $baseCode . '-copy(' . ($highestNumber + 1) . ')';
        $publication->identification = $newCode;

        //edit name
        $baseEmail = preg_replace('/\(\d+\)$/', '', $publication->email);
        $baseEmail = preg_replace('/-copy/', '', $baseEmail);
        $newEmail = $baseEmail . '-copy(' . ($highestNumber + 1) . ')';
        $publication->email = $newEmail;

        //end
        $newClass = $publication->replicate();
        $newClass->save();

        return $newClass;
    }

    public function recordMulti($ids)
    {
        $data = [];
        foreach ($ids as $id) {
            if (!$publication = $this->publicationRepository->find($id)) return abort(404);
            $baseIdentification = preg_replace('/\(\d+\)$/', '', $publication->code);
            $baseIdentification = preg_replace('/-copy/', '', $baseIdentification);
            $existingPublications = $this->publicationRepository->getByBaseIdentification($baseIdentification);
            $highestNumber = 0;
            foreach ($existingPublications as $existingClass) {
                preg_match('/\((\d+)\)$/', $existingClass->code, $matches);
                if (!empty($matches[1])) {
                    $highestNumber = max($highestNumber, (int)$matches[1]);
                }
            }
            $newIdentification = $baseIdentification . '-copy(' . ($highestNumber + 1) . ')';
            $publication->code = $newIdentification;
            $baseEmail = preg_replace('/\(\d+\)$/', '', $publication->name);
            $baseEmail = preg_replace('/-copy/', '', $baseEmail);
            $newEmail = $baseEmail . '-copy(' . ($highestNumber + 1) . ')';
            $publication->email = $newEmail;
            $newClass = $publication->replicate();
            $newClass->save();
            $data[] = $newClass;
        }
        return $data;
    }

//    public function exportItemsToCsv($ids)
//    {
//        $publications = $this->publicationRepository->findByIds($ids);
//        return Excel::download(new PublicationsExport($publications), 'publications.csv');
//    }
//
//    public function exportItemsToXlsx($ids)
//    {
//        $publications = $this->publicationRepository->findByIds($ids);
//        if ($publications->isEmpty()) {
//            throw new \Exception('No publications found for the provided IDs.');
//        }
//        return Excel::download(new PublicationsExport($publications), 'publications.xlsx');
//    }
}
