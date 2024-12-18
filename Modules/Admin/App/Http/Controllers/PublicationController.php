<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\PublicationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\App\Http\Requests\PublicationRequest;

class PublicationController extends Controller
{

    private $publicationService;

    public function __construct(PublicationService $publicationService)
    {
        $this->publicationService = $publicationService;
    }
    public function index(PublicationRequest $request)
    {
        try {
            if (!$data = $this->publicationService->getListOrderBy($request->all())) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function search(PublicationRequest $request)
    {
        try {
            if (!$search = $this->publicationService->search($request->all())) return response()->json("Bad request!", 404);
            return response()->json($search);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function hasByIdentifi($code)
    {
        try {
            if (!$search = $this->publicationService->hasByIdentifi($code)) return response()->json("Bad request!", 404);
            return response()->json($search);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function hasByEmail($name)
    {
        try {
            if (!$search = $this->publicationService->hasByEmail($name)) return response()->json("Bad request!", 404);
            return response()->json($search);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function getClassList(PublicationRequest $request)
    {
        try {
            if (!$data = $this->publicationService->getAll()) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function showClassListByCode(PublicationRequest $request)
    {
        try {
            try {
                if (!$data = $this->publicationService->getListByCodes($request->all())) return response()->json("Bad request!", 404);
                return response()->json($data);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
            }
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function showStudentList($publicationId)
    {
        try {
            if (!$students = $this->publicationService->getStudentsByClassId($publicationId)) return response()->json("Bad request!", 404);
            return response()->json($students);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function hasStudentList()
    {
        try {
            if (!$data = $this->publicationService->hasStudents())  return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e){
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            if (!$publication = $this->publicationService->find($id)) return response()->json("Bad request!", 404);
            return response()->json($publication);
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(PublicationRequest $request)
    {
        try {
            return $this->publicationService->store($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }

    }

    public function update($id, PublicationRequest $request)
    {
        try {
            if (!$this->publicationService->update($id, $request->all())) return response()->json("Bad request!", 404);
            return response()->json(['message' => 'Update success']);
//            return response()->json($d)
        } catch (\Exception $e){
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateStatus($id, PublicationRequest $request)
    {
        try {
            if (!$this->publicationService->updateStatus($id, $request->all())) return response()->json("Bad request!", 404);
            return response()->json(['message' => 'Update success']);
        } catch (\Exception $e){
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            if(!$this->publicationService->delete($id)) return response()->json("Bad request!", 404);
            return response()->json(['message' => 'Deleted successfully.']);
        } catch (\Exception $e){
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function deleteMultiple(PublicationRequest $request)
    {
        try {
            if(!$data = $this->publicationService->deleteMultiple($request->all())) {
                return response()->json(['message' => 'Deleted failed'], 404);
            }
            return response()->json(['message' => 'Deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function record($id)
    {
        try {
            if (!$record = $this->publicationService->record($id)) return response()->json("Bad request!", 404);
            return response()->json($record);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function recordMultiple(PublicationRequest $request)
    {
        try {
            if (!$record = $this->publicationService->recordMulti($request->all())) return response()->json("Bad request!", 404);
            return response()->json($record);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function importExcelData(PublicationRequest $request)
    {
        try{
            $request->validate([
                'file' => 'required|mimes:xlsx,csv',
            ]);
            if (!$import = Excel::import(new ClassesImport, $request->file('file'))) return response()->json("Bad request!", 404);
            return response()->json(['data'=>'Users imported successfully.', $import]);
        }catch(\Exception $e){
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function exportCsv(ExportRequest $request)
    {
        return $this->publicationService->exportItemsToCsv($request->all());
    }

    public function exportXlsx(ExportRequest $request)
    {
        try {
            return $this->publicationService->exportItemsToXlsx($request->all());
        } catch (\Exception $e) {
            return response()->json(500);
        }
    }

//    public function search(PublicationRequest $request)
//    {
//        try {
//            $data = $request->all();
//            if (empty($data)) {
//                if (!$search = $this->publicationService->getAll()) return abort(404);
//            } else {
//                if (!$search = $this->publicationService->search($request->all())) return abort(404);
//            }
//            return response()->json($search);
//        } catch (\Exception $e) {
//            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
//        }
//    }

    //recycle
    public function recycle(PublicationRequest $request)
    {
        try {
            if (!$data = $this->publicationService->onlyTrashed($request->all())) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function showRecycled($id)
    {
        try {
            if (!$data = $this->publicationService->onlyTrashedById($id)) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function restore($id)
    {
        try {
            if (!$data = $this->publicationService->restoreById($id)) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function restoreMultiple($ids)
    {
        try {
            if (!$data = $this->publicationService->restoreByIds($ids)) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function restoreAll()
    {
        try {
            if (!$data = $this->publicationService->restoreAll()) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function forceDelete($id)
    {
        try {
            if (!$data = $this->publicationService->forceDeleteById($id)) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function forceDeleteMultiple($ids)
    {
        try {
            if (!$data = $this->publicationService->forceDeleteByIds($ids)) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function forceDeleteAll()
    {
        try {
            if (!$data = $this->publicationService->forceDeleteAll()) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }
}
