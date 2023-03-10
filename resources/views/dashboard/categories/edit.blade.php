@extends('dashboard.layout.layout')

@section('body')
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="page-header-left">
                            
                            
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ol class="breadcrumb pull-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin') }}">
                                    <i data-feather="home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">Digital</li>
                            <li class="breadcrumb-item active">Sub Category</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">



                        </div>

                        <div class="card-body">

                            <div class="card-body">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="table-responsive table-desi">
                               
                                <form class="needs-validation" action="{{route('dashboard.categories.update',$category->id)}}" method="POST" enctype="multipart/form-data">
                                    <div class="form">
                                        @csrf
                                        @method("PUT")

                                        <div class="form-group">
                                            <label for="validationCustom01" class="mb-1">?????????? :</label>
                                            <input class="form-control" id="validationCustom01" type="text"
                                                name="name" value="{{$category->name}}">
                                        </div>
                                     
                                         @if ($category->child_count <1)                                 
                                            <div class="form-group">
                                                <label for="validationCustom01" class="mb-1">?????????? ?????????????? </label>
                                                <select name="parent_id" id="" class="form-control">
                                                    <option value="" @if ($category->parent_id == null) selected  @endif>?????? ??????????</option>
                                                    @foreach ($mainCategories as $category)
                                                        <option value="{{$category->id}}" @if ($category->id == $category->parent_id) selected @endif  >{{$category->name}}</option>
                                                    @endforeach                                                
                                                </select>
                                            </div>
                                        @endif

                                        <div class="form-group mb-0">
                                            <label for="validationCustom02" class="mb-1">???????????? :</label>
                                            <input class="form-control dropify" id="validationCustom02" type="file"
                                                name="image" data-default-file="">
                                        </div>



                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" type="submit">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->

    </div>
@endsection