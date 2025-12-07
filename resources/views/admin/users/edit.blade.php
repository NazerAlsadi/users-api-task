@extends('layouts.app')

@section('content')
<div class="container">
    <h1>تعديل المستخدم</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">الاسم</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">كلمة المرور (اتركها فارغة إذا لا تريد تغييرها)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">الأدوار</label>
            @foreach ($roles as $role)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}"
                        {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray())) ? 'checked' : '' }}>
                    <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">تحديث</button>
        <a href="{{ route('admin.users') }}" class="btn btn-secondary">إلغاء</a>
    </form>
</div>
@endsection
