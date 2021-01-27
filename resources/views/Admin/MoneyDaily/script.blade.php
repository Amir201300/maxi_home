@include('Admin.includes.scripts.dataTableHelper')

<script type="text/javascript">

    var table = $('#datatable').DataTable({
        bLengthChange: false,
        searching: false,
        responsive: true,
        'processing': true,
        'language': {
            'loadingRecords': '&nbsp;',
            'processing': '<div class="spinner"></div>'
        },
        serverSide: true,

        order: [[0, 'desc']],

        buttons: ['copy', 'excel', 'pdf'],

        ajax: "{{ route('MoneyDaily.allData') }}",

        columns: [
            {data: 'checkBox', name: 'checkBox'},
            {data: 'id', name: 'id'},
            {data: 'amount', name: 'amount'},
            {data: 'paymentType_id', name: 'paymentType_id'},
            {data: 'desc', name: 'desc'},
            {data: 'created_at', name: 'created_at'},
            {data: 'modelType', name: 'modelType'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('#formSubmit').submit(function (e) {
        e.preventDefault();
        saveOrUpdate( save_method == 'add' ?"{{ route('MoneyDaily.create') }}" : "{{ route('MoneyDaily.update') }}");
    });


    function editFunction(id) {

        save_method = 'edit';

        $('#err').slideUp(200);

        $('#loadEdit_' + id).css({'display': ''});

        $.ajax({
            url: "/Admin/MoneyDaily/edit/" + id,
            type: "GET",
            dataType: "JSON",

            success: function (data) {

                $('#loadEdit_' + id).css({'display': 'none'});

                $('#save').text('تعديل');

                $('#titleOfModel').text('تعديل المورد');

                $('#formSubmit')[0].reset();

                $('#formModel').modal();

                $('#amount').val(data.amount);

                $('#modelType').val(data.modelType);
                $('#paymentType_id').val(data.paymentType_id);
                $('#note').val(data.note);
                $('#desc').val(data.desc);

                $('#id').val(data.id);
            }
        });
    }


    function deleteFunction(id,type) {
        if (type == 2 && checkArray.length == 0) {
            alert('لم تقم بتحديد اي عناصر للحذف');
        } else if (type == 1){
            url =  "/Admin/MoneyDaily/destroy/" + id;
            deleteProccess(url);
        }else{
            url= "/Admin/MoneyDaily/destroy/" + checkArray + '?type=2';
            deleteProccess(url);
            checkArray=[];
        }
    }


</script>

<script>
    $('#seachForm').submit(function(e){
        e.preventDefault();
        var formData=$('#seachForm').serialize();
        table.ajax.url('/Admin/MoneyDaily/allData?'+formData);
        table.ajax.reload();
        Toset('تمت العملية بنجاح','success','',5000);

    })
</script>


<script>
    function filterDiv() {
        var type = $('#dateF').val();
        if(type == 4){
            $('#fromDiv').show();
        }else if(type ==5){
            $('#fromDiv').show();
            $('#toDiv').show();
        }else{
            $('#fromDiv').hide(300);
            $('#toDiv').hide();
        }
    }
</script>