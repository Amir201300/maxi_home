<?php


namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminType;
use Yajra\DataTables\DataTables;
use Auth, File;
use Illuminate\Support\Facades\Storage;


class AdminTypeController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @return mixed
     * @throws \Exception
     */
    public function allData()
    {
        $data = AdminType::get();
        return $this->mainFunction($data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('Admin.AdminType.index');
    }

    /**
     * @param Request $request
     * @return int
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        $AdminType = new AdminType;
        $AdminType->name = $request->name;
        $AdminType->commission_status = $request->commission_status;
        $AdminType->save();
        return $this->apiResponseMessage(1,'تم اضافة النوع بنجاح',200);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $AdminType = AdminType::find($id);
        return $AdminType;
    }

    /**
     * @param Request $request
     * @return int
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $AdminType = AdminType::find($request->id);
        $AdminType->name = $request->name;
        $AdminType->commission_status = $request->commission_status;
        $AdminType->save();
        return $this->apiResponseMessage(1,'تم تعديل النوع بنجاح',200);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function destroy($id,Request $request)
    {
        if ($request->type == 2) {
            $ids = explode(',', $id);
            $Categories = AdminType::whereIn('id', $ids)->get();
            foreach($Categories as $row){
                deleteFile('AdminType',$row->icon);
                $row->delete();
            }
        } else {
            $AdminType = AdminType::find($id);
            if (is_null($AdminType)) {
                return 5;
            }
            deleteFile('AdminType',$AdminType->icon);
            $AdminType->delete();
        }
        return response()->json(['errors' => false]);
    }

    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    private function mainFunction($data)
    {
        return Datatables::of($data)->addColumn('action', function ($data) {
            $options = '<td class="sorting_1"><button  class="btn btn-info waves-effect btn-circle waves-light" onclick="editFunction(' . $data->id . ')" type="button" ><i class="fa fa-spinner fa-spin" id="loadEdit_' . $data->id . '" style="display:none"></i><i class="fas fa-edit"></i></button>';
            $options .= '<button type="button" onclick="deleteFunction(' . $data->id . ',1)" class="btn btn-danger waves-effect btn-circle waves-light"><i class=" fas fa-trash"></i> </button></td>';
            return $options;
        })->addColumn('checkBox', function ($data) {
            $checkBox = '<td class="sorting_1">' .
                '<div class="custom-control custom-checkbox">' .
                '<input type="checkbox" class="mybox" id="checkBox_' . $data->id . '" onclick="check(' . $data->id . ')">' .
                '</div></td>';
            return $checkBox;
        })->editColumn('commission_status', function ($data) {
            $status = '<button class="btn waves-effect waves-light btn-rounded btn-success statusBut" style="cursor:pointer !important" >لديه نسبة</button>';
            if ($data->commission_status == 2)
                $status = '<button class="btn waves-effect waves-light btn-rounded btn-danger statusBut" style="cursor:pointer !important" title="">ليس لديه نسبة</button>';
            return $status;
        })->rawColumns(['action' => 'action', 'commission_status' => 'commission_status','checkBox'=>'checkBox'])->make(true);
    }
}
