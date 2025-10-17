@extends('layouts.app')
@section('content')
<form action="{{ route('educations.update',$education) }}" method="POST" class="card p-4">
    @csrf @method('PUT')
    <h4>Edit Education</h4>
    <input name="degree" value="{{ $education->degree }}" class="form-control mb-2">
    <input name="institute" value="{{ $education->institute }}" class="form-control mb-2">
    <input type="date" name="start_date" value="{{ $education->start_date }}" class="form-control mb-2">
    <input name="end_year" value="{{ $education->end_year }}" class="form-control mb-2">
    <button class="btn btn-success">Update</button>
</form>
@endsection
