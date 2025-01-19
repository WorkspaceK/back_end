<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Exports\DegreeExport;
use App\Http\Controllers\Controller;
use App\Imports\DegreeImport;
use App\Models\Degree;
use App\Services\DegreeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Admin\App\Http\Requests\DegreeRequest;

class DegreeController extends Controller
{
    private $degreeService;

    public function __construct(DegreeService $degreeService)
    {
        $this->degreeService = $degreeService;
    }

    public function getAll()
    {
        try {
            if (!$data = $this->degreeService->getAll()) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }
    public function getByPage(Request $request)
    {
        try {
            if (!$data = $this->degreeService->getByPage($request->all())) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(DegreeRequest $request)
    {
        try {
            return $this->degreeService->store($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }

    }

    public function getById($id)
    {
        try {
            if (!$degree = $this->degreeService->find($id)) return response()->json("Bad request!", 404);
            return response()->json($degree);
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function update($id, DegreeRequest $request)
    {
        try {
            if (!$this->degreeService->update($id, $request->all())) return response()->json("Bad request!", 404);
            return response()->json(['message' => 'Update success']);
        } catch (\Exception $e){
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            if(!$this->degreeService->delete($id)) return response()->json("Bad request!", 404);
            return response()->json(['message' => 'Deleted successfully.']);
        } catch (\Exception $e){
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function massDelete(Request $request)
    {
        try {
            if(!$this->degreeService->massDelete($request->all())) {
                return response()->json(['message' => 'Deleted failed'], 404);
            }
            return response()->json(['message' => 'Deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function copy($id)
    {
        try {
            if (!$record = $this->degreeService->copy($id)) return response()->json("Bad request!", 404);
            return response()->json($record);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function massCopy(Request $request)
    {
        try {
            if (!$record = $this->degreeService->massCopy($request->all())) return response()->json("Bad request!", 404);
            return response()->json($record);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateStatus($id, Request $request)
    {
        try {
            if (!$this->degreeService->updateStatus($id, $request->all())) return response()->json("Bad request!", 404);
            return response()->json(['message' => 'Update success']);
        } catch (\Exception $e){
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function hasByCode($data)
    {
        try {
            if (!$search = $this->degreeService->hasByCode($data)) return response()->json("Bad request!", 404);
            return response()->json($search);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function hasByName($data)
    {
        try {
            if (!$search = $this->degreeService->hasByName($data)) return response()->json("Bad request!", 404);
            return response()->json($search);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }


    public function import(Request $request)
    {
        try{
            $request->validate([
                'file' => 'required|mimes:xlsx,csv',
            ]);
            if(!$result = Excel::import(new DegreeImport,$request->file('file'))) return response()->json("Bad request!", 404);
            return response()->json(['data'=>'Users imported successfully.', $result]);
        }catch(\Exception $e){
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function massExport(Request $request)
    {
        try {
            if (!$data = $this->degreeService->getByIds($request->all())) return response()->json("Bad request!", 404);
            $export = new DegreeExport([$data]);
            return Excel::download($export, 'Degree.xlsx');
        } catch (\Exception $e) {
            return response()->json(500);
        }
    }

//    public function export_by_id(ExportRequest $request)
//    {
//        return $this->degreeService->exportItemsToCsv($request->all());
//    }
//
//    public function exportXlsx(ExportRequest $request)
//    {
//        try {
//            return $this->degreeService->exportItemsToXlsx($request->all());
//        } catch (\Exception $e) {
//            return response()->json(500);
//        }
//    }

    public function getByIds(Request $request)
    {
        try {
            if (!$res = $this->degreeService->getByIds($request->input('ids'))) return response()->json("Bad request!", 404);
            return response()->json($res);
        } catch (\Exception $e) {
            return response()->json(500);
        }
    }

    public function getByCodes(Request $request)
    {
        try {
            if (!$res = $this->degreeService->getListByCodes($request->all())) return response()->json("Bad request!", 404);
            return response()->json($res);
        } catch (\Exception $e) {
            return response()->json(500);
        }
    }

//
//    //recycle
    public function recycle(Request $request)
    {
        try {
            if (!$data = $this->degreeService->onlyTrashed($request->all())) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function showRecycled($id)
    {
        try {
            if (!$data = $this->degreeService->onlyTrashedById($id)) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function restore($id)
    {
        try {
            if (!$data = $this->degreeService->restoreById($id)) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function restoreMultiple($ids)
    {
        try {
            if (!$data = $this->degreeService->restoreByIds($ids)) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function restoreAll()
    {
        try {
            if (!$data = $this->degreeService->restoreAll()) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function forceDelete($id)
    {
        try {
            if (!$data = $this->degreeService->forceDeleteById($id)) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function forceDeleteMultiple($ids)
    {
        try {
            if (!$data = $this->degreeService->forceDeleteByIds($ids)) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function forceDeleteAll()
    {
        try {
            if (!$data = $this->degreeService->forceDeleteAll()) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }
}
