@extends('layouts.admin')

@section('title')
Roles
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Roles Table</h3>

              <div class="card-tools">
              <a href="{{ route('role.create')}}" tooltip="Create New Role" class="btn btn-primary"><i class="fas fa-plus-circle"></i></a>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Roles</th>
                    <th>Created On</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <tr>
                            <td>{{$role->id}}</td>
                            <td>{{$role->name}}</td>
                            <td><span class="tag tag-success">{{$role->created_at}}</span></td>
                            <td>
                                @foreach ($role->permissions as $permission)
                                    <button class="btn btn-warning" role="button"><i class="fas fa-shield-alt"></i>{{$permission->name}}</button>
                                @endforeach
                                <a href="{{route('role.edit',$role->id)}}" class="btn btn-primary">Edit</a>
                                {{-- <a href="{{route('permission.delete')}}" class="btn btn-danger">Delete</a></td> --}}
                        </tr>
                    @empty
                    <tr><td> No Data</td></tr>
                @endforelse
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
