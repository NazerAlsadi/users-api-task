@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">Admin Panel - Users Management</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Users List</h5>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Created</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="badge bg-info">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                            
                            <td>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm" style="display:block;">Edit</a>
                                <br/>
                                <form method="POST" action="{{ route('admin.users.delete', $user->id) }}"
                                      onsubmit="return confirm('Are you sure you want to delete this user?');"
                                      style="display:block;">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm w-100">
                                        Delete
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection
