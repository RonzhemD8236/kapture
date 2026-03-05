@extends('layouts.base')
@section('body')
    @include('layouts.flash-messages')
    <div class="container">

        <div class="d-flex justify-content-between align-items-center my-3">
            <h2>Users List</h2>
            <a href="{{ route('users.create') }}" class="btn btn-success">+ New User</a>
        </div>

        <hr>
        {{ $dataTable->table() }}
    </div>

    @push('scripts')
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
        <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
        <script src="/vendor/datatables/buttons.server-side.js"></script>
        {!! $dataTable->scripts() !!}
    @endpush
@endsection