{{-- resources/views/admin/products/create.blade.php --}}
@extends('layouts.admin')
@section('title', 'Add Product')
@section('page-title', 'Add New Product')
@section('page-subtitle', 'Fill in the details to create a new product')

@section('content')
    @include('admin.products._form', [
        'action'  => route('admin.products.store'),
        'method'  => 'POST',
        'product' => null,
        'btnLabel' => 'Create Product',
    ])
@endsection
