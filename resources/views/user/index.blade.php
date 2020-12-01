@extends('layouts.admin')

@section('title')
User Management
@endsection

@section('content')
    @php 
        $create_permission = 0
    @endphp
    @can('create permission')
        @php 
            $create_permission = 1
        @endphp
    @endcan
<user-component :create_permission="{{ $create_permission }}"></user-component>
@endsection