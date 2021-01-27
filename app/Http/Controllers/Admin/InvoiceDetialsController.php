<?php


namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\InvoiceDetials;
use App\Models\InvoiceSale;
use App\Models\ProductStore;
use App\Models\Store;
use App\Reposatries\InvoiceRepo;
use App\Reposatries\ProductReposatry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Yajra\DataTables\DataTables;
use Auth, File;
use Illuminate\Support\Facades\Storage;


class InvoiceDetialsController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function allData(Request $request,$id)
    {
        $data = InvoiceSale::find($id);
        $data=$data->products;
        return $this->mainFunction($data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id)
    {
        $product=Product::all();
        $stores=Store::all();
        return view('Admin.InvoiceDetials.index',compact('id','product','stores'));
    }

    /**
     * @param Request $request
     * @param ProductReposatry $detailsReposatry
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function create(Request $request  ,ProductReposatry $detailsReposatry,InvoiceRepo $invoiceRepo)
    {
        $invoice=InvoiceSale::find($request->invoice_id);
        $InvoiceDetials=InvoiceDetials::where('product_id',$request->product_id)->where('invoice_id',$request->invoice_id)
            ->first();
        $msg='تم التعديل بنجاح';
        if(is_null($InvoiceDetials)){
            $InvoiceDetials=new InvoiceDetials;
            $InvoiceDetials->product_id= $request->product_id;
            $InvoiceDetials->store_id= $request->store_id;
            $InvoiceDetials->store_id= $request->store_id;
            $msg='تمت الاضافة بنجاح';
        }
        $InvoiceDetials->quantity = $request->quantity;
        $InvoiceDetials->color = $request->color;
        $InvoiceDetials->cloth = $request->cloth;
        $InvoiceDetials->note = $request->note;
        $InvoiceDetials->price = $request->price;
        $InvoiceDetials->save();
        $invoiceRepo->updatePrices($invoice);
        $invoiceRepo->saveInMoney($invoice);
        $detailsReposatry->updateQuantity($request->product_id);
        return $this->apiResponseMessage(1,$msg,200);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $Product = InvoiceDetials::find($id);
        return $Product;
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function destroy($id,Request $request)
    {

        $Product = InvoiceDetials::find($id);
        if (is_null($Product)) {
            return 5;
        }
        $Product->delete();

        return response()->json(['errors' => false]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProduct ($id){
        $product=InvoiceDetials::find($id);
        return view('Admin.Product.showProduct',compact('product'));

    }

    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    private function mainFunction($data)
    {
        return Datatables::of($data)->addColumn('action', function ($data) {
            $options = '<td class="sorting_1"><button  class="btn btn-info waves-effect btn-circle waves-light" onclick="editFunction(' . $data->pivot->id . ')" type="button" ><i class="fa fa-spinner fa-spin" id="loadEdit_' . $data->pivot->id . '" style="display:none"></i><i class="fas fa-edit"></i></button>';
            $options .= '<button type="button" onclick="deleteFunction(' . $data->pivot->id . ',1)" class="btn btn-danger waves-effect btn-circle waves-light"><i class=" fas fa-trash"></i> </button></td>';
            return $options;
        })->addColumn('checkBox', function ($data) {
            $checkBox = '<td class="sorting_1">' .
                '<div class="custom-control custom-checkbox">' .
                '<input type="checkbox" class="mybox" id="checkBox_' . $data->id . '" onclick="check(' . $data->id . ')">' .
                '</div></td>';
            return $checkBox;
        })->editColumn('quantity', function ($data) {
            $type_id = $data->pivot->quantity;
            return $type_id;
        })->editColumn('color', function ($data) {
            $type_id = $data->pivot->color;
            return $type_id;
        })->editColumn('cloth', function ($data) {
            $type_id = $data->pivot->cloth;
            return $type_id;
        })->editColumn('price', function ($data) {
            $price = $data->pivot->price ? $data->pivot->price : $data->price;
            return $price;
        })->rawColumns(['action' => 'action', 'price' => 'price','checkBox'=>'checkBox'])->make(true);
    }
}
