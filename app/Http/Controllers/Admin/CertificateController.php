<?php

namespace App\Http\Controllers\Admin;

use App\Models\Certificate;
use App\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CertificateController extends AdminController
{
    public function __construct(private UploadService $uploads) {}

    public function index()
    {
        return $this->view('admin.certificates.index', ['certificates' => Certificate::ordered()->get()]);
    }

    public function create()
    {
        return $this->view('admin.certificates.form', ['certificate' => new Certificate(['year' => date('Y'), 'category' => 'curso', 'visible' => true])]);
    }

    public function store(Request $request)
    {
        Certificate::create($this->data($request));

        return redirect($this->to('certificates.index'))->with('status', 'Certificado creado.');
    }

    public function edit(Certificate $certificate)
    {
        return $this->view('admin.certificates.form', compact('certificate'));
    }

    public function update(Request $request, Certificate $certificate)
    {
        $certificate->update($this->data($request, $certificate));

        return redirect($this->to('certificates.index'))->with('status', 'Certificado actualizado.');
    }

    public function destroy(Certificate $certificate)
    {
        $this->uploads->delete($certificate->pdf);
        $this->uploads->delete($certificate->preview);
        $certificate->delete();

        return back()->with('status', 'Certificado eliminado.');
    }

    private function data(Request $request, ?Certificate $certificate = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'platform' => ['required', 'string', 'max:100'],
            'year' => ['required', 'digits:4', 'integer', 'between:1990,2100'],
            'category' => ['required', Rule::in(array_keys(Certificate::CATEGORIES))],
            'pdf' => ['nullable', ...UploadService::PDF_RULES],
            'preview' => ['nullable', ...UploadService::IMAGE_RULES],
        ]);

        return [
            'title' => $data['title'],
            'platform' => $data['platform'],
            'year' => $data['year'],
            'category' => $data['category'],
            'pdf' => $this->uploads->replace($request->file('pdf'), $certificate?->pdf, 'certificates'),
            'preview' => $this->uploads->replace($request->file('preview'), $certificate?->preview, 'certificates'),
            'visible' => $certificate?->visible ?? true,
        ];
    }
}
