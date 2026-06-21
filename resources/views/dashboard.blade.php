@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <section style="max-width:900px;margin:3rem auto;padding:0 1.5rem">
        <div class="q-panel">
            <h1 style="font-family:var(--q-font-serif);font-size:1.4rem;color:var(--q-ink);margin-bottom:.5rem">
                Welcome back, {{ auth()->user()->name }}
            </h1>
            <p style="color:var(--q-muted);font-size:.9rem">
                Your subscription and learning area — coming soon.
            </p>
        </div>
    </section>
@endsection
