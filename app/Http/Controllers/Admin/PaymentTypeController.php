<?php


namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PaymentType;
use Yajra\DataTables\DataTables;
use Auth, File;
use Illuminate\Support\Facades\Storage;


class PaymentTypeController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @return mixed
     * @throws \Exception
     */
    public function allData()
    {
        $data = PaymentType::get();
        return $this->mainFunction($data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('Admin.PaymentType.index');
    }

    /**
     * @param Request $request
     * @return int
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        $PaymentType = new PaymentType;
        $PaymentType->name = $request->name;
        $PaymentType->type = $request->type;
        $PaymentType->save();
        return $this->apiResponseMessage(1,'تم اضافة البند بنجاح',200);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $PaymentType = PaymentType::find($id);
        return $PaymentType;
    }

    /**
     * @param Request $request
     * @return int
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $PaymentType = PaymentType::find($request->id);
        $PaymentType->name = $request->name;
        $PaymentType->type = $request->type;
        $PaymentType->save();
        return $this->apiResponseMessage(1,'تم تعديل البند بنجاح',200);
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
            $Categories = PaymentType::whereIn('id', $ids)->get();
            foreach($Categories as $row){
                deleteFile('PaymentType',$row->icon);
                $row->delete();
            }
        } else {
            $PaymentType = PaymentType::find($id);
            if (is_null($PaymentType)) {
                return 5;
            }
            deleteFile('PaymentType',$PaymentType->icon);
            $PaymentType->delete();
        }
        return response()->json(['errors' => false]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return int
     */
    public function ChangeStatus(Request $request,$id){
        $PaymentType=PaymentType::find($id);
        $PaymentType->status=$request->status;
        $PaymentType->save();
        return 1;
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
        })->editColumn('type', function ($data) {
            $status = '<button class="btn waves-effect waves-light btn-rounded btn-success statusBut" style="cursor:pointer !important" >مدفوعات</button>';
            if ($data->type == 2)
                $status = '<button class="btn waves-effect waves-light btn-rounded btn-danger statusBut"  style="cursor:pointer !important" >مقبوضات</button>';
            return $status;
        })->rawColumns(['action' => 'action', 'type' => 'type','checkBox'=>'checkBox'])->make(true);
    }
}
