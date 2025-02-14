@extends('layouts.app')

@section('content')
    <div class="container" id="app"> 
    </div>

    <script>
        window.__user__ = @json(auth()->user()); 
    </script>    
@endsection
