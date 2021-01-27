@extends('Admin.includes.layouts.master')

@section('title')
    اليومية
@endsection

@section('content')

    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-5 align-self-center">
                    <h4 class="page-title">الرئيسية</h4>
                    <div class="d-flex align-items-center">

                    </div>
                </div>
                <div class="col-7 align-self-center">
                    <div class="d-flex no-block justify-content-end align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{route('admin.dashboard')}}">الرشيسية</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">اليومية</li>
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
            <!-- basic table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex no-block align-items-center m-b-30">
                                <h4 class="card-title">اليومية</h4>
                                <div class="ml-auto">
                                    <div class="btn-group">
                                        <button type="button" id="showmenu" class="btn btn-dark fillterNew">
                                            <i class="fas fa-filter"></i>
                                        </button>

                                        <button  class="btn btn-dark" id="titleOfText" data-toggle="modal" onclick="addFunction()">
                                            اضافة قيمة جديدة
                                        </button>
                                        &nbsp;
                                        <button  class="btn btn-danger " data-toggle="modal" onclick="deleteFunction(0,2)">
                                            حذف المحدد
                                        </button>

                                    </div>

                                </div>

                            </div>
                            <div class="menuFilter" style="display: none;">
                                <form id="seachForm">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-2">
                                            <div class="form-group">
                                                <select name="paymentType_id" class="custom-select mr-sm-2"  id="inlineFormCustomSelect">
                                                    <option value="">كل البنود</option>
                                                    @foreach($types as $row)
                                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <div class="form-group">
                                                <select name="modelType" class="custom-select mr-sm-2"  id="inlineFormCustomSelect">
                                                    <option value="">النوع</option>
                                                    @foreach(getMoneyModelTypes() as $row)
                                                        <option value="{{$row[1]}}">{{$row[0]}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-2" >
                                            <div class="form-group">
                                                <select name="type" class="custom-select mr-sm-2" onchange="filterDiv()" id="dateF">
                                                    <option value="">وقت العمليات</option>
                                                    <option value="1">عمليات اليوم</option>
                                                    <option value="2">عمليات الشهر</option>
                                                    <option value="3">عمليات السنة</option>
                                                    <option value="4">عمليات تاريخ معين</option>
                                                    <option value="5">عمليات فترة معينة</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-2" style="display: none;" id="fromDiv">
                                            <div class="form-group">
                                                <input type="date" name="from" class="custom-select mr-sm-2"  id="inlineFormCustomSelect">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-2" style="display: none;" id="toDiv">
                                            <div class="form-group">
                                                <input type="date" name="to" class="custom-select mr-sm-2"  id="inlineFormCustomSelect">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-1">
                                            <div class="form-actions">
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-info">بحث</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="table-responsive" style="overflow: hidden;">
                                <table id="datatable" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="sorting_asc" tabindex="0" aria-controls="file_export" rowspan="1" colspan="1" aria-sort="ascending" aria-label=" : activate to sort column descending" style="width: 0px;"> </th>
                                        <th>#</th>
                                        <th>القيمة</th>
                                        <th>البند </th>
                                        <th>البيان </th>
                                        <th>التاريخ </th>
                                        <th>النوع </th>
                                        <th>الاختيارات</th>

                                    </tr>
                                    </thead>
                                    <tbody>


                                </table>
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
    @include('Admin.MoneyDaily.form')

    <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('#showmenu').click(function() {
                $('.menuFilter').toggle("slide");
            });
        });
    </script>
    @include('Admin.MoneyDaily.script')

@endsection
