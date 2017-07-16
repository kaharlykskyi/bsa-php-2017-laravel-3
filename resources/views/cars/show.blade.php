@extends('cars.base')

@section('title', $model)
@section('list-active','active')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">{{ $model }}</div>
        <div class="panel-body">
            <p><span class="text-muted">Color:</span>&nbsp;{{ $color }}</p>
            <p><span class="text-muted">Price:</span>&nbsp;{{ $price }}</p>
            <p><span class="text-muted">Year:</span>&nbsp;{{ $year }}</p>
            <p><span class="text-muted">Registration number:</span>&nbsp;{{ $registration_number }}</p>
        </div>
        <div class="panel-footer">
            <a href="{{ URL::route('cars-edit', $id) }}" class="btn btn-warning edit-button">Edit</a>
            <a href="{{ URL::route('cars-delete', $id) }}" class="btn btn-danger delete-button">Delete</a>
        </div>
    </div>
@endsection
