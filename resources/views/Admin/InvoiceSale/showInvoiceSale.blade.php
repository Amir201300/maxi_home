@extends('Admin.includes.layouts.master')

@section('title')
    تفاصيل الفاتورة
@endsection

@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-5 align-self-center">
                    <h4 class="page-title">تفاصيل الفاتورة</h4>
                    <div class="d-flex align-items-center">

                    </div>
                </div>
                <div class="col-7 align-self-center">
                    <div class="d-flex no-block justify-content-end align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{route('admin.dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">تفاصيل الفاتورة</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-body printableArea">
                        <h3><b>فاتورة رقم</b> <span class="pull-right">#{{$invo->id}}</span></h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-left">
                                    <address>
                                        <h3> &nbsp;<b class="text-danger">{{$invo->client->name}}</b></h3>
                                        <p class="text-muted m-l-5">{{$invo->client->phone}}
                                            </p>
                                    </address>
                                </div>
                                <div class="pull-right text-right">
                                    <address>
                                        <h3>مسؤل المبيعات</h3>
                                        <h4 class="font-bold">{{$invo->sales->name}}</h4>
                                        <p class="text-muted m-l-30">{{$invo->sales->phone}}</p>
                                        <p class="m-t-30"><b>تاريخ الفاتورة :</b> <i class="fa fa-calendar"></i> {{$invo->created_at->format('d-m-Y')}}</p>
                                        <p><b>تاريخ التسليم :</b> <i class="fa fa-calendar"></i> {{$invo->delivery_date}}</p>
                                    </address>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive m-t-40" style="clear: both;">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>اسم المنتج</th>
                                            <th class="text-right">العدد</th>
                                            <th class="text-right">سعر القطعه</th>
                                            <th class="text-right">السعر الكلي</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                         @foreach($invo->products as $row)
                                        <tr>
                                            <td class="text-center">{{$row->id}}</td>
                                            <td>{{$row->name}}</td>
                                            <td class="text-right"> {{$row->pivot->quantity}} </td>
                                            <td class="text-right">{{$row->pivot->price ? $row->pivot->price : $row->price}} {{getCurrency()}}</td>
                                            <td class="text-right"> {{($row->pivot->price ? $row->pivot->price : $row->price) * $row->pivot->quantity}}{{getCurrency()}} </td>
                                        </tr>
                                             @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="pull-right m-t-30 text-right">
                                    <p>سعر المنتجات : {{$invo->product_cost}}</p>
                                    <p>سعر التوصيل : {{$invo->delivery_cost}}</p>
                                    <p>سعر المشال : {{$invo->cortex_cost}}</p>
                                    <p>الضريبة ({{$invo->tax}}%) : {{$invo->tax_cost}} </p>
                                    @if($invo->discount)
                                    <p>الخصم ({{$invo->discount}} {{ $invo->discount_type ==2 ? '%' : '' }}) : {{$invo->discount_cost}} </p>
                                    @endif
                                        <hr>
                                    <h3><b>الاجمالي :</b> {{$invo->total_price}}</h3>
                                </div>
                                <div class="clearfix"></div>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Right sidebar -->
            <!-- ============================================================== -->
            <!-- .right-sidebar -->
            <!-- ============================================================== -->
            <!-- End Right sidebar -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer text-center">
            All Rights Reserved by AdminBite admin. Designed and Developed by <a href="https://wrappixel.com">WrapPixel</a>.
        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>

@endsection
