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

        ajax: "{{ route('InvoiceSale.allData') }}",

        columns: [
            {data: 'checkBox', name: 'checkBox'},
            {data: 'id', name: 'id'},
            {data: 'user_id', name: 'user_id'},
            {data: 'sales_id', name: 'sales_id'},
            {data: 'total_price', name: 'total_price'},
            {data: 'delivery_date', name: 'delivery_date'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('#formSubmit').submit(function (e) {
        e.preventDefault();
        saveOrUpdate( save_method == 'add' ?"{{ route('InvoiceSale.create') }}" : "{{ route('InvoiceSale.update') }}");
    });


    function editFunction(id) {

        save_method = 'edit';

        $('#err').slideUp(200);

        $('#loadEdit_' + id).css({'display': ''});

        $.ajax({
            url: "/Admin/InvoiceSale/edit/" + id,
            type: "GET",
            dataType: "JSON",

            success: function (data) {

                $('#loadEdit_' + id).css({'display': 'none'});
                $('#save').text('تعديل');
                $('#titleOfModel').text('تعديل المورد');
                $('#formSubmit')[0].reset();
                $('#formModel').modal();
                $('#discount_type').val(data.discount_type);
                $('#discount').val(data.discount);
                $('#tax').val(data.tax);
                $('#cortex_cost').val(data.cortex_cost);
                $('#delivery_cost').val(data.delivery_cost);
                $('#invoice_status').val(data.invoice_status);
                $('#invoice_type').val(data.invoice_type);
                $('#deposit').val(data.deposit);
                $('#delivery_date').val(data.delivery_date);
                $('#note').val(data.note);
                $('#user_id ').val(data.user_id );
                $('#sales_id  ').val(data.sales_id  );
                $('#id').val(data.id);
            }
        });
    }


    function deleteFunction(id,type) {
        if (type == 2 && checkArray.length == 0) {
            alert('لم تقم بتحديد اي عناصر للحذف');
        } else if (type == 1){
            url =  "/Admin/InvoiceSale/destroy/" + id;
            deleteProccess(url);
        }else{
            url= "/Admin/InvoiceSale/destroy/" + checkArray + '?type=2';
            deleteProccess(url);
            checkArray=[];
        }
    }


</script>

<script>
    $('#seachForm').submit(function(e){
        e.preventDefault();
        var formData=$('#seachForm').serialize();
        table.ajax.url('/Admin/InvoiceSale/allData?'+formData);
        table.ajax.reload();
        Toset('تمت العملية بنجاح','success','',5000);

    })
</script>


<script>
    function showInvoiceSale(id) {
        window.open('/Admin/InvoiceSale/showInvoiceSale/' +id,'_blank');
    }
</script>