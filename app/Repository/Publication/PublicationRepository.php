<?php

namespace App\Repository\Publication;

use App\Models\Publication;

class PublicationRepository
{

    private $publicationModel;

    public function __construct(Publication $publicationModel)
    {
        return $this->publicationModel = $publicationModel;
    }

    public function all()
    {
        return $this->publicationModel->all();
    }

    public function getListUpdateOrderByDesc($dataSearch)
    {
        $data = $this->publicationModel;
        if (!empty($request['last_name']))
        {
            $data = $data->whereRaw('LOWER(last_name) like ?', ['%' . strtolower($request['last_name']) . '%']);
        }
        return $data->orderBy('updated_at', 'desc')->paginate($dataSearch['pageSize']);
    }

    public function getListOrderBy($request)
    {
        $data = $this->publicationModel;
        if (!empty($request['last_name']))
        {
            $data = $data->whereRaw('LOWER(last_name) like ?', ['%' . strtolower($request['last_name']) . '%']);
        }
//        if (!empty($request['first_name']))
//        {
//            $data = $data->whereRaw('LOWER(first_name) like ?', ['%' . strtolower($request['first_name']) . '%']);
//        }
//        if (!empty($request['identification']))
//        {
//            $data = $data->whereRaw('LOWER(identification) like ?', ['%' . strtolower($request['identification']) . '%']);
//        }
        return $data->orderBy($request['field'], $request['sortOrder'])->with('persons')->paginate($request['pageSize']);
    }

    public function search($request)
    {
        $data = $this->publicationModel;
        if (!empty($request['last_name']))
        {
            $data = $data->whereRaw('LOWER(last_name) like ?', ['%' . strtolower($request['last_name']) . '%']);
        }
        return $data->get();
    }

    public function getByBaseIdentification($baseCode)
    {
        return $this->publicationModel->whereRaw('LOWER(identification) like ?', ['%' . strtolower($baseCode) . '%'])->get();
    }

    public function hasByIdentifi($identification)
    {
        return$this->publicationModel->where('identification', $identification)->exists();
    }

    public function hasByEmail($email)
    {
        return$this->publicationModel->where('email', $email)->exists();
    }

    public function searchByMentor($dataSearch)
    {
        $data = $this->publicationModel;
        if (!empty($dataSearch['code']))
        {
            $data = $data->where('mentor', 'like', '%'.$dataSearch['mentor'].'%');
        }
        return $data->orderBy('updated_at', 'desc')->paginate($dataSearch['pageSize']);
    }

    public function find($id)
    {
        return $this->publicationModel->where('id', $id)->first();
    }

    public function findByIds($ids)
    {
        return $this->publicationModel->whereIn('id', $ids)->get();
    }

    public function findByCodes($request)
    {
        $data = $this->publicationModel->whereIn('code', $request['codes']);
        if (!empty($request['name']))
        {
            $data = $data->whereRaw('LOWER(name) like ?', ['%' . strtolower($request['name']) . '%']);
        }
        return $data->orderBy($request['field'], $request['sortOrder'])->withCount('students')->paginate($request['pageSize']);

    }

    public function getStudentsByClassId($classId)
    {
        return $this->publicationModel->with('students')->find($classId);
    }

    public function hasStudent()
    {
        return $this->publicationModel->withCount('students')->get();
    }

    public function store($data)
    {

        return $this->publicationModel->insertGetId($data);
    }

    public function update($id, $data)
    {
        return $this->publicationModel->where('id', $id)->update($data);
    }

    public function delete($id)
    {

        return $this->publicationModel->destroy($id);
    }

    public function deleteMultiple(array $ids)
    {
        return $this->publicationModel->whereIn('id', $ids)->delete();
    }
}
