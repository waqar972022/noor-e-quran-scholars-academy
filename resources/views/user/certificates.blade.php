@extends('layouts.user')

@section('title', 'My Certificates')

@section('content')

        <div class="q-user-page-head">
            <h1>My Certificates</h1>
            <p>Certificates earned by completing all lessons in a course.</p>
        </div>

        @if ($certificates->isEmpty())
            <div class="q-panel" style="text-align:center;padding:2.5rem 1.5rem">
                <div style="font-family:var(--q-font-serif);font-size:1.5rem;color:var(--q-gold);margin-bottom:.75rem">&#x2605;</div>
                <div class="q-panel-title" style="margin-bottom:.5rem">No Certificates Yet</div>
                <p style="color:var(--q-muted);font-size:.88rem;max-width:40ch;margin:0 auto 1.5rem;line-height:1.7">
                    Complete all video lessons in any course to earn a certificate.
                </p>
                <a href="{{ route('user.learning') }}" class="q-btn q-btn-primary">Go to My Learning</a>
            </div>
        @else
            <div style="display:flex;flex-direction:column;gap:1rem">
                @foreach ($certificates as $cert)
                    <div class="q-panel" style="border-left:4px solid var(--q-gold)">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem">
                            <div>
                                <div style="font-family:var(--q-font-serif);font-size:1rem;font-weight:700;color:var(--q-ink);margin-bottom:.25rem">
                                    {{ $cert->course->title }}
                                </div>
                                <div style="font-size:.8rem;color:var(--q-muted)">
                                    Issued {{ $cert->issued_at->format('d F Y') }}
                                    &nbsp;&middot;&nbsp;
                                    <span style="letter-spacing:.04em">No: {{ $cert->certificate_number }}</span>
                                </div>
                            </div>
                            <div style="display:flex;gap:.6rem;flex-wrap:wrap;align-items:center">
                                <a href="{{ route('certificate.download', $cert->id) }}"
                                   target="_blank"
                                   class="q-btn q-btn-outline q-btn-sm">
                                    View
                                </a>
                                <a href="{{ route('certificate.download', $cert->id) }}?download=1"
                                   class="q-btn q-btn-primary q-btn-sm">
                                    Download PDF
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

@endsection
