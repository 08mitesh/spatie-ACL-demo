@extends('layouts.admin')

@section('title')
Permissions
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Permission Table</h3>

              <div class="card-tools">
              <a href="{{ route('permission.create')}}" tooltip="Create New Permission" class="btn btn-primary"><i class="fas fa-plus-circle"></i></a>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Permission</th>
                    <th>Created On</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse ($permissions as $permission)
                        <tr>
                        <td>{{$permission->id}}</td>
                        <td>{{$permission->name}}</td>
                        <td>{{$permission->created_at}}</td>
                        <td>
                            <a href="{{route('permission.edit',$permission->id)}}" class="btn btn-primary">Edit</a>
                            {{-- <a href="{{route('permission.delete')}}" class="btn btn-danger">Delete</a></td> --}}
                        </tr>
                    @empty
                    <tr> No Data</tr>
                            
                        @endempty
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
</div>
@endsection
