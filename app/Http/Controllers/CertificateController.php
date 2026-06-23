<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CertificateController extends Controller
{
    public function download(Request $request, Certificate $certificate): Response
    {
        abort_unless($certificate->user_id === auth()->id(), 403);

        $certificate->load(['user', 'course']);

        $pdf = Pdf::loadView('certificates.template', [
            'userName'       => $certificate->user->name,
            'courseTitle'    => $certificate->course->title,
            'completionDate' => $certificate->issued_at->format('d F Y'),
            'certNumber'     => $certificate->certificate_number,
            'siteName'       => setting('site_name', config('app.name')),
        ])->setPaper('a4', 'landscape');

        $filename = 'certificate-' . $certificate->certificate_number . '.pdf';

        return $request->query('download')
            ? $pdf->download($filename)
            : $pdf->stream($filename);
    }
}
