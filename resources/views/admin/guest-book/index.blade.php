@extends('layouts.app_admin')
@section('guestbook-index', 'active')
@section('main')
<button type="button" class="btn btn-sm btn-primary float-right" id="refreshTable"><i class="fas fa-sync"></i> Refresh</button>
<a href="{{ route('admin.guestbook.add') }}" class="btn btn-sm btn-success float-right"><i class="fas fa-plus"></i> Add</a>
<table id="guestbooklist" class="table table-bordered table-striped display nowrap text-center" style="width:100%">
    <thead>
        <tr>
            <th>No.</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Organization</th>
            <th>Province</th>
            <th>City</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
@endsection

@push('css')

<link rel="stylesheet" href="{{ asset('a-tmp/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('a-tmp/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('a-tmp/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush

@push('js')
<script src="{{ asset('a-tmp/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('a-tmp/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('a-tmp/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript">
  let delete_guestbook;  
  $(document).ready( function (){
    $("#guestbooklist").DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "{{ route('admin.guestbook.get_index_data') }}?type=datatable",
        "columns": [
            { "data": 'DT_RowIndex' },
            { "data": "first_name" },
            { "data": "last_name" },
            { 'data': 'organization'},
            { "data": "province.name" },
			{ "data": "city.name" },
			{ "data": "action", 'orderable': false, 'searchable': false },
        ],
    });

    $('#refreshTable').on('click', function(){
        $('#guestbooklist').DataTable().ajax.reload();
    });

    delete_guestbook = function(link){
        if(confirm("Are you sure you want to delete this data?")){
            return $.ajax({
                    url: link,
                    type: "post",
                    data: {
                    "_token": $('input[name="_token"]').attr('value'),
                    },
                    success: function (response) {
                        let resp = JSON.parse(response);
                        toastr.success(resp.status_message);
                        $('#guestbooklist').DataTable().ajax.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                    if(jqXHR.responseJSON.message.length >= 1){
                        toastr.error('Terjadi error:<br>'+jqXHR.responseJSON.message);
                    }
                    else{
                        toastr.error('Terjadi error:<br>'+jqXHR.responseText);
                    }
                }
            });
            }
        }
  });
</script>
@endpush