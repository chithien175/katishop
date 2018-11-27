@extends('layouts.frontend_layout.frontend_design')

@section('css')
<link rel="stylesheet" type="text/css" href="{{  asset('frontend/styles/responsive.css') }}">
@endsection

@section('content')
	@include('frontend.home_sections.top_banner')

	@include('frontend.home_sections.characteristics')

	@include('frontend.home_sections.deals_week')

	{{-- @include('frontend.home_sections.popular_categories') --}}

	@include('frontend.home_sections.mid_banner')

	@include('frontend.home_sections.hot_new')

	{{-- @include('frontend.home_sections.best_sellers') --}}

	@include('frontend.home_sections.adverts')

	{{-- @include('frontend.home_sections.trends') --}}

	{{-- @include('frontend.home_sections.reviews') --}}

	@include('frontend.home_sections.recently_viewed')

	@include('frontend.home_sections.brands')

	@include('frontend.home_sections.newsletter')

@endsection

@section('js')
<script src="{{ asset('frontend/js/custom.js') }}"></script>
@endsection