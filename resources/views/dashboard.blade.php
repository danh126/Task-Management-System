@extends('layouts.app')

@section('content')
    <div id="app"> 
    </div>

    <script>
        window.__user__ = @json(auth()->user()); 
    </script>    
@endsection
