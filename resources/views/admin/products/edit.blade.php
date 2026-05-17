@extends('layouts.admin')
@section('title', 'Edit Product')
@section('page-title', 'Edit Product')
@section('page-subtitle', $product->name)

@section('content')
    @include('admin.products._form', [
        'action'   => route('admin.products.update', $product),
        'method'   => 'PUT',
        'product'  => $product,
        'btnLabel' => 'Save Changes',
    ])
@endsection
