<?php

namespace App\Http\Controllers\Admin;

use App\Models\CalendarEvent;
use App\Models\Certificate;
use App\Models\MediaItem;
use App\Models\Project;
use App\Models\StackCategory;
use App\Models\StackItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/** Orden y visibilidad de cualquier recurso administrable, con lista blanca de modelos. */
class OrderController extends AdminController
{
    private const RESOURCES = [
        'media' => MediaItem::class,
        'stack-items' => StackItem::class,
        'stack-categories' => StackCategory::class,
        'projects' => Project::class,
        'certificates' => Certificate::class,
        'events' => CalendarEvent::class,
    ];

    private function model(string $resource): string
    {
        return self::RESOURCES[$resource] ?? abort(404);
    }

    public function reorder(Request $request, string $resource): JsonResponse
    {
        $model = $this->model($resource);
        abort_if($resource === 'events', 404);

        $ids = $request->validate(['ids' => ['required', 'array', 'max:500'], 'ids.*' => ['integer']])['ids'];

        DB::transaction(function () use ($model, $ids) {
            foreach (array_values($ids) as $position => $id) {
                $instance = $model::find($id);
                $instance?->update(['position' => $position + 1]);
            }
        });

        return response()->json(['ok' => true]);
    }

    public function toggle(string $resource, int $id): RedirectResponse
    {
        /** @var Model $item */
        $item = $this->model($resource)::findOrFail($id);
        $item->update(['visible' => ! $item->visible]);

        return back()->with('status', $item->visible ? 'Ahora es visible en el sitio.' : 'Ocultado del sitio.');
    }
}
