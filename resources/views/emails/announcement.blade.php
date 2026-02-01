@extends('emails.layout')

@section('content')
    <h3>{{ $announcement->title }}</h3>

    <p>
        {{ $announcement->message }}
    </p>

    <p>
        <strong>Effective:</strong>
        {{ \Carbon\Carbon::parse($announcement->start_date)->format('F d, Y') }}
    </p>
@endsection
