@extends('layouts.app')
@section('content')
	<h1>Your organization code is {{ Auth::user()->id }}</h1>
	<router-view></router-view>
@endsection