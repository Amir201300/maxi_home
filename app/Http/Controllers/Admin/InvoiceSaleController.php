<?php


namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Category;
use App\Models\InvoiceSaleStore;
use App\Models\MoneyDaily;
use App\Models\Store;
use App\Models\User;
use App\Reposatries\InvoiceRepo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InvoiceSale;
use Yajra\DataTables\DataTables;
use Auth, File;
use Illuminate\Support\Facades\Storage;


class InvoiceSaleController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function allData(Request $request)
    {
        $data = InvoiceSale::orderBy('id','desc');
        if($request->cat_id)
            $data=$data->where('cat_id',$request->cat_id);
        $data=$data->get();
        return $this->mainFunction($data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users=User::get();
        $admins=Admin::whereHas('type',function($q){
            $q->where('commission_status',1);
        })->get();
        return view('Admin.InvoiceSale.index',compact('users','admins'));
    }

    /**
     * @param Request $request
     * @return int
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request,InvoiceRepo $invoiceRepo)
    {
         $invoiceRepo->save_date($request,new InvoiceSale);
        return $this->apiResponseMessage(1,'تم اضافة الفاتورة بنجاح',200);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $InvoiceSale = InvoiceSale::find($id);
        return $InvoiceSale;
    }

    /**
     * @param Request $request
     * @param InvoiceRepo $invoiceRepo
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(Request $request,InvoiceRepo $invoiceRepo)
    {
        $InvoiceSale = InvoiceSale::find($request->id);
        $invoiceRepo->save_date($request,$InvoiceSale);
        $InvoiceSale->save();
        return $this->apiResponseMessage(1,'تم تعديل الفاتورة بنجاح',200);
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
            $Categories = InvoiceSale::whereIn('id', $ids)->get();
            foreach($Categories as $row){
                deleteFile('InvoiceSale',$row->icon);
                MoneyDaily::where('model_id',$row->id)->where('modelType',5)->delete();
                $row->delete();
            }
        } else {
            $InvoiceSale = InvoiceSale::find($id);
            if (is_null($InvoiceSale)) {
                return 5;
            }
            deleteFile('InvoiceSale',$InvoiceSale->icon);
            MoneyDaily::where('model_id',$id)->where('modelType',5)->delete();
            $InvoiceSale->delete();
        }
        return response()->json(['errors' => false]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showInvoiceSale ($id){
        $invo=InvoiceSale::find($id);
        return view('Admin.InvoiceSale.showInvoiceSale',compact('invo'));
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
            $options .= ' <button type="button" onclick="showInvoiceSale('. $data->id .')" class="btn btn-success waves-effect btn-circle waves-light" title="تفاصيل الفاتورة"><i class=" fas fa-eye"></i> </button></td>';
            $options .= ' <a  href="/Admin/InvoiceDetials/index/'.$data->id.'" class="btn btn-secondary waves-effect btn-circle waves-light" title="اضافة منتجات" target="_blank"><i class=" fas fa-plus"></i> </a></td>';
            return $options;
        })->addColumn('checkBox', function ($data) {
            $checkBox = '<td class="sorting_1">' .
                '<div class="custom-control custom-checkbox">' .
                '<input type="checkbox" class="mybox" id="checkBox_' . $data->id . '" onclick="check(' . $data->id . ')">' .
                '</div></td>';
            return $checkBox;
        })->editColumn('sales_id', function ($data) {
            $sales_id='لا يوجد';
            if($data->sales)
                $sales_id = $data->sales->name;
            return $sales_id;
        })->editColumn('user_id', function ($data) {
            $user_id='لا يوجد';
            if($data->client)
                $user_id = $data->client->name;
            return $user_id;
        })->rawColumns(['action' => 'action', 'image' => 'image','checkBox'=>'checkBox'])->make(true);
    }
}
