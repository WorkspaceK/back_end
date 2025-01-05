<?php

namespace App\Services;

use App\Repository\Degree\DegreeRepository;

class DegreeService
{
    private $degreeRepository;

    public function __construct(DegreeRepository $degreeRepository)
    {
        $this->degreeRepository = $degreeRepository;
    }

    public function getAll()
    {
        return $this->degreeRepository->all();
    }

    public function getByPage($request)
    {
        $data = $this->degreeRepository->getByPage($request);
        return $data;
    }

    public function getListById($ids)
    {
        return $this->degreeRepository->findByIds($ids);
    }

    public function getListByCodes($request)
    {
        return $this->degreeRepository->findByCodes($request);
    }

    public function find($id)
    {
        return $this->degreeRepository->find($id);
    }

    public function store($data)
    {
        $dataStore = [
            'code' => $data['code'],
            'name' => $data['name'],
            'created_at' => now(),
            'updated_at' => now(),
        ];

        if (!empty($data['is_default'])) {
            $dataStore['is_default'] = $data['is_default'];
        }
        return $this->degreeRepository->store($dataStore);
    }

    public function update($id, $data)
    {

        $dataUpdate = [
            'code' => $data['code'],
            'name' => $data['name'],
            'is_default' => $data['is_default'],
            'updated_at' => now(),
        ];
        return $this->degreeRepository->update($id, $dataUpdate);
    }

    public function updateStatus($id, $data)
    {
        $dataUpdate = [ 'is_default' => $data['is_default'], 'updated_at' => now() ];
        return $this->degreeRepository->update($id, $dataUpdate);
    }

    public function delete($id)
    {
        return $this->degreeRepository->delete($id);
    }

    public function massDelete(array $ids)
    {
        return $this->degreeRepository->massDelete($ids);
    }

    public function copy($id)
    {
        if(!$degree = $this->degreeRepository->find($id)) return abort(404);

        //edit code
        $baseCode = preg_replace('/\(\d+\)$/', '', $degree->code);
        $baseCode = preg_replace('/-copy/', '', $baseCode);
        $existingCodes = $this->degreeRepository->getByBaseCode($baseCode);

        $highestNumber = 0;
        foreach ($existingCodes as $existingCode) {
            preg_match('/\((\d+)\)$/', $existingCode->code, $matches);
            if (!empty($matches[1])) {
                $highestNumber = max($highestNumber, (int)$matches[1]);
            }
        }
//        dd($highestNumber);
        $newCode = $baseCode . '-copy(' . ($highestNumber + 1) . ')';
        $degree->code = $newCode;

        //edit name
        $baseName = preg_replace('/\(\d+\)$/', '', $degree->name);
        $baseName = preg_replace('/-copy/', '', $baseName);
        $existingNames = $this->degreeRepository->getByBaseName($baseName);

        $highestNumber = 0;
        foreach ($existingNames as $existingName) {
            preg_match('/\((\d+)\)$/', $existingName->name, $matches);
            if (!empty($matches[1])) {
                $highestNumber = max($highestNumber, (int)$matches[1]);
            }
        }
//        dd($highestNumber);
        $newName = $baseName . '-copy(' . ($highestNumber + 1) . ')';
        $degree->name = $newName;

        //end
        $newClass = $degree->replicate();
        $newClass->save();

        return $newClass;
    }

    public function massCopy(array $ids)
    {

        $newDegrees = []; // Mảng lưu trữ các bản sao mới

        foreach ($ids as $id) {
            if (!$degree = $this->degreeRepository->find($id)) {
                abort(404, "Degree with ID $id not found.");
            }

            // Chỉnh sửa code
            $baseCode = preg_replace('/\(\d+\)$/', '', $degree->code);
            $baseCode = preg_replace('/-copy/', '', $baseCode);
            $existingDegrees = $this->degreeRepository->getByBaseCode($baseCode);

            $highestNumber = 0;
            foreach ($existingDegrees as $existingDegree) {
                preg_match('/\((\d+)\)$/', $existingDegree->code, $matches);
                if (!empty($matches[1])) {
                    $highestNumber = max($highestNumber, (int)$matches[1]);
                }
            }

            $newCode = $baseCode . '-copy(' . ($highestNumber + 1) . ')';
            $degree->code = $newCode;

            // Kết thúc: Tạo bản sao và lưu
            $newClass = $degree->replicate();
            $newClass->save();

            $newDegrees[] = $newClass; // Thêm bản sao mới vào mảng
        }

        return $newDegrees; // Trả về danh sách bản sao mới
    }

    public function hasByCode($data)
    {
        return $this->degreeRepository->hasByCode($data);
    }

    public function hasByName($data)
    {
        return $this->degreeRepository->hasByName($data);
    }

//    public function exportItemsToCsv($ids)
//    {
//        $degrees = $this->degreeRepository->findByIds($ids);
//        return Excel::download(new DegreesExport($degrees), 'degrees.csv');
//    }
//
//    public function exportItemsToXlsx($ids)
//    {
//        $degrees = $this->degreeRepository->findByIds($ids);
//        if ($degrees->isEmpty()) {
//            throw new \Exception('No degrees found for the provided IDs.');
//        }
//        return Excel::download(new DegreesExport($degrees), 'degrees.xlsx');
//    }


}
