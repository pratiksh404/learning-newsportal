@extends('adminetic::admin.layouts.app')

@section('content')
<x-adminetic-show-page name="category" route="category" :model="$category">
    <x-slot name="content">
        @isset($category->categories)
        @livewire('admin.category.reorder-children-category', ['category_id' => $category->id])
        @endisset
    </x-slot>
</x-adminetic-show-page>

@endsection

@section('custom_js')
@include('admin.layouts.modules.category.scripts')
@endsection