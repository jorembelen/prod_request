@extends('layouts.dashboard')

@section('content')
    <div class="full-height" id="app">
        <main-app></main-app>
    </div>
@endsection

@section('custom-scripts')
   <script>
       // When using select tag, default should be hidden since we are using select2.
       // To avoid loading basic selec and non select2
       // Show after on load
        // setTimeout(() => {
        //     $('select').fadeOut()
        // }, 500)
    </script>
@endsection