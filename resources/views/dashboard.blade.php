@extends('layouts.app')

@section('content')
    <div class="container" id="app"> 
    </div>

    <script>
        var user = @json(auth()->user()); // Lấy user từ Laravel
        if (user) {
            localStorage.setItem('user', JSON.stringify(user));
        }
    </script>    
@endsection
