<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProjectController extends AdminController
{
    public function __construct(private UploadService $uploads) {}

    public function index()
    {
        return $this->view('admin.projects.index', ['projects' => Project::ordered()->get()]);
    }

    public function create()
    {
        return $this->view('admin.projects.form', ['project' => new Project(['visible' => true])]);
    }

    public function store(Request $request)
    {
        Project::create($this->data($request));

        return redirect($this->to('projects.index'))->with('status', 'Proyecto creado.');
    }

    public function edit(Project $project)
    {
        return $this->view('admin.projects.form', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $project->update($this->data($request, $project));

        return redirect($this->to('projects.index'))->with('status', 'Proyecto actualizado.');
    }

    public function destroy(Project $project)
    {
        $this->uploads->delete($project->image);
        $project->delete();

        return back()->with('status', 'Proyecto eliminado.');
    }

    private function data(Request $request, ?Project $project = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'company' => ['nullable', 'string', 'max:150'],
            'url' => ['nullable', 'url:https', 'max:255'],
            'github' => ['nullable', 'url:https', 'max:255'],
            'description' => ['required', 'string', 'max:1500'],
            'tags' => ['nullable', 'string', 'max:300'],
            'links' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', ...UploadService::imageRules()],
            'remove_image' => ['boolean'],
        ]);

        $image = $project?->image;
        if ($request->boolean('remove_image')) {
            $this->uploads->delete($image);
            $image = null;
        }

        return [
            'title' => $data['title'],
            'company' => $data['company'] ?? null,
            'url' => $data['url'] ?? null,
            'github' => $data['github'] ?? null,
            'description' => $data['description'],
            'tags' => collect(explode(',', $data['tags'] ?? ''))->map(fn ($t) => trim($t))->filter()->take(12)->values()->all(),
            'links' => $this->parseLinks($data['links'] ?? ''),
            'image' => $this->uploads->replaceImage($request->file('image'), $image, 'project'),
            'visible' => $project?->visible ?? true,
        ];
    }

    /** Una línea por enlace: «Etiqueta | https://url | destacado». */
    private function parseLinks(string $raw): array
    {
        $links = [];

        foreach (preg_split('/\R/', trim($raw), -1, PREG_SPLIT_NO_EMPTY) as $line) {
            [$label, $url, $flag] = array_pad(array_map('trim', explode('|', $line)), 3, '');

            if ($label === '' || mb_strlen($label) > 60 || ! filter_var($url, FILTER_VALIDATE_URL) || ! str_starts_with($url, 'https://')) {
                throw ValidationException::withMessages(['links' => "Enlace inválido: «{$line}». Usa «Etiqueta | https://url | destacado»."]);
            }

            $links[] = ['label' => $label, 'url' => $url, 'featured' => strtolower($flag) === 'destacado'];
        }

        return array_slice($links, 0, 6);
    }
}
