<?php


namespace App\Http\Controllers\Admin;

use App\Models\PaymentType;
use App\Reposatries\MoneyRepo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MoneyDaily;
use Yajra\DataTables\DataTables;
use Auth, File;
use Illuminate\Support\Facades\Storage;


class MoneyDailyController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @return mixed
     * @throws \Exception
     */
    public function allData(Request $request,MoneyRepo $moneyRepo)
    {
        $data = MoneyDaily::orderBy('id','desc');
        if($request->paymentType_id)
            $data=$data->where('paymentType_id',$request->paymentType_id);
        if($request->model_id)
            $data=$data->where('model_id',$request->model_id);
        if($request->modelType)
            $data=$data->where('modelType',$request->modelType);
        $data=$moneyRepo->filterMoney($request,$data);
        $data=$data->get();
        return $this->mainFunction($data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $types=PaymentType::all();
        return view('Admin.MoneyDaily.index',compact('types'));
    }

    /**
     * @param Request $request
     * @return int
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request,MoneyRepo $moneyRepo)
    {
        $MoneyDaily = new MoneyDaily;
        $moneyRepo->save_date($request,$MoneyDaily);
        return $this->apiResponseMessage(1,'تم اضافة القيمة بنجاح',200);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $MoneyDaily = MoneyDaily::find($id);
        return $MoneyDaily;
    }

    /**
     * @param Request $request
     * @param MoneyRepo $moneyRepo
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(Request $request,MoneyRepo $moneyRepo)
    {
        $MoneyDaily = MoneyDaily::find($request->id);
        $moneyRepo->save_date($request,$MoneyDaily);
        return $this->apiResponseMessage(1,'تم تعديل القيمة بنجاح',200);
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
            $Categories = MoneyDaily::whereIn('id', $ids)->get();
            foreach($Categories as $row){
                deleteFile('MoneyDaily',$row->icon);
                $row->delete();
            }
        } else {
            $MoneyDaily = MoneyDaily::find($id);
            if (is_null($MoneyDaily)) {
                return 5;
            }
            deleteFile('MoneyDaily',$MoneyDaily->icon);
            $MoneyDaily->delete();
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
        })->editColumn('image', function ($data) {
            $image = '<a href="'. getImageUrl('MoneyDaily',$data->icon).'" target="_blank">'
                .'<img  src="'. getImageUrl('MoneyDaily',$data->icon) . '" width="50px" height="50px"></a>';
            return $image;
        })->editColumn('paymentType_id', function ($data) {
            return $data->payment_type ? $data->payment_type->name : 'لا يوجد';
        })->editColumn('modelType', function ($data) {
            return getMoneyModelType($data->modelType);
        })->rawColumns(['action' => 'action', 'image' => 'image','checkBox'=>'checkBox'])->make(true);
    }
}
