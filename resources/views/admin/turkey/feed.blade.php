@extends('admin.turkey.dashboard')
@section('styles')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
@endsection
@section('dash_content')
<div class="container mt-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Feed Stock</li>
    </ol>
    <div class="card mb-4">
        <div class="card-body">
           <div class="row">
               @if (session()->has('success'))
                <div class="alert alert-success col-md-12" role="alert">
                    <span>{{ session()->get('success')}} </span>
                </div>
               @endif
               @if (session()->has('error'))
                <div class="alert alert-danger col-md-12" role="alert">
                    <span>{{ session()->get('error')}} </span>
                </div>
               @endif
               @if ($errors->any())
                    <div class="alert alert-danger col-md-12" >
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
               <span>
                   <button type="button" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#addMortalityModal">
                        Add Feed
                    </button>
                </span>
                <span>
                    <a href="{{route('export.feed','turkey')}}"  class="btn btn-sm btn-primary ml-2">Export Data</a>
                </span>
           </div>
           {{-- modal --}}
           <div class="modal fade" id="addMortalityModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalCenterTitle">Enter Detials</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <form id="mortalityForm" method="POST" action="{{ route('admin.add.feed')}}">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control  @error('name') is-invalid @enderror" id="name" value="{{old('name')}}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="price">Price (GHS &#162;)</label>
                                    <input type="number" name="price" min="0" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" value="{{ old('price') }}">

                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="quantity">Quantity (Kg)</label>
                                    <input type="number" name="quantity" min="0" step="0.01" class="form-control @error('quantity') is-invalid @enderror" id="quantity" value="{{ old('quantity') }}">
                                    @error('quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="date">Date</label>
                                    <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                        <input type="text" name="date" class="form-control datetimepicker-input  @error('date') is-invalid @enderror"
                                        data-target="#datetimepicker1" value="{{ old('date')}}"/>
                                        <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        @error('date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="supplier">Supplier</label>
                                    <input type="text" name="supplier" class="form-control @error('supplier') is-invalid @enderror" id="supplier" value="{{ old('supplier') }}">
                                    @error('supplier')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="description">Description</label>
                                    <textarea  name="description"  rows="4" class="form-control @error('description') is-invalid @enderror" id="description">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <input type="text" name="feed_type" value="turkey" hidden>
                        </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="button" onclick="document.getElementById('mortalityForm').submit()" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-table mr-1"></i>Feed</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price (GHS &#162;)</th>
                            <th>Quantity (Kg)</th>
                            <th>Description</th>
                            <th>Supplier</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Price (GHS &#162;)</th>
                            <th>Quantity (Kg)</th>
                            <th>Description</th>
                            <th>Supplier</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
     {{-- edit form modal --}}
    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="editModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalCenterTitle">Edit Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editPenForm" method="POST" action="/edit">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edit_name">Name</label>
                                <input type="text" name="_name" class="form-control  @error('_name') is-invalid @enderror" id="edit_name" value="{{old('_name')}}">
                                @error('_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edit__price">Price (GHS &#162;)</label>
                                <input type="number" name="_price" min="0" step="0.01" class="form-control @error('_price') is-invalid @enderror" id="edit_price" value="{{ old('_price') }}">

                                @error('_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edit_quantity">Quantity (Kg)</label>
                                <input type="number" name="_quantity" min="0" step="0.01" class="form-control @error('_quantity') is-invalid @enderror" id="edit_quantity" value="{{ old('_quantity') }}">
                                @error('_quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edit_date">Date</label>
                                <div class="input-group date" id="edit_datetimepicker1" data-target-input="nearest">
                                    <input type="text" name="_date" id="edit_date" class="form-control datetimepicker-input  @error('date') is-invalid @enderror"
                                    data-target="#edit_datetimepicker1" value="{{ old('_date')}}"/>
                                    <div class="input-group-append" data-target="#edit_datetimepicker1" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    @error('_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edit_supplier">Supplier</label>
                                <input type="text" name="_supplier" class="form-control @error('_supplier') is-invalid @enderror" id="edit_supplier" value="{{ old('_supplier') }}">
                                @error('_supplier')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edit_description">Description</label>
                                <textarea  name="_description"  rows="4" class="form-control @error('_description') is-invalid @enderror" id="edit_description">{{ old('_description') }}</textarea>
                                @error('_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="document.getElementById('editPenForm').submit()" class="btn btn-primary">Update</button>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script-tags')
@parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
@endsection
@section('script')
    @parent
    $('#datetimepicker1,#edit_datetimepicker1').datetimepicker({
        format: 'L',
        icons: {
        time: "fa fa-clock",
        date: "fa fa-calendar",
        up: "fa fa-arrow-up",
        down: "fa fa-arrow-down"
    }});
    let table = $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('datatables.feed','turkey') }}",
        columns: [
            {data: 'name', name: 'name'},
            {data:'price',name:'price'},
            {data:'quantity',name:'quantity'},
            {data:'description',name:'description'},
            {data:'supplier',name:'supplier'},
            {data:'date',name:'date'},
            {data: 'action', name: 'Action', orderable: false, searchable: false},
        ]
    });

    table.on('click','.edit-btn',(e)=>{
        var tr = $(e.target).closest('tr');
        var data = table.row(tr).data();
        {{-- console.log(data) --}}
        $('#edit_name').val(data.name);
        $('#edit_price').val(data.price);
        $('#edit_quantity').val(data.quantity);
        $('#edit_supplier').val(data.supplier);
        $('#edit_description').val(data.description);
        let date = new Date(data.date);
        $('#edit_date').val(date.format())
        $('#editPenForm').attr('action',`/edit/feed/${data.id}`)
        $('#edit-modal').modal('show');
    });

    table.on('click','.delete-btn', (e)=>{
       if (confirm("Are you shure you want to delete record\nThis action will lead to permanent loss of data")) {
            let form = $(e.target).closest('form');
            form.submit();
        }
    });
@endsection
