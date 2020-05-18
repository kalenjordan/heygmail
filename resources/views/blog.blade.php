<?php
/** @var \App\User $user */
/** @var \App\Blog $blog */
?>

@extends('_landing')

@section('title')
    <title>
        {{ $blog->title() }} | {{ Util::appName() }}
    </title>
@endsection

@section('content')
    <div class="mt-10 pb-20 mx-auto max-w-2xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 xl:mt-28">
        <div class="text-center">
            <h2 class="text-2xl sm:text-3xl  md:text-4xl tracking-tight leading-10 font-extrabold text-gray-900  sm:leading-none">
                {{ $blog->title() }}
            </h2>
            <div class="text-xl sm:text-2xl  max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 text-left markdown">
                {!!  $blog->contentRendered()  !!}
            </div>
        </div>
    </div>
@endsection
