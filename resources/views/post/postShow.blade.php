@extends('layouts.app')

@section('content')
    <x-card :posts="$posts" />
    {{ $posts->links() }}
@endsection
