@extends('layouts.admin')

@section('title')
Create Role
@endsection

@section('content')
<section class="content">
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                    <h4>Edit Role {{$role_id}}</h4>
                    </div>
                    <div class="card-body">
                        {{-- role name : {{ $data['role_name'] }}
                        <br>
                        @foreach ($data['permissions'] as $permission)
                            <p>{{$permission->name}}</p><br>
                            
                        @endforeach --}}
                        <edit-role :role_id="{{$role_id}}"></edit-role>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- <script type="text/JavaScript"> 
     var d_var = "{{$role_id}}" 
</script> --}}
@endsection
