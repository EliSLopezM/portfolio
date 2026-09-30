<?php

namespace App\Http\Controllers\Admin;

use App\Models\CalendarEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EventController extends AdminController
{
    public function index()
    {
        return $this->view('admin.events.index', [
            'upcoming' => CalendarEvent::upcoming()->get(),
            'past' => CalendarEvent::whereDate(DB::raw('COALESCE(ends_on, starts_on)'), '<', today())->orderByDesc('starts_on')->limit(20)->get(),
        ]);
    }

    public function create()
    {
        return $this->view('admin.events.form', ['event' => new CalendarEvent(['type' => 'especial', 'visible' => true, 'starts_on' => today()])]);
    }

    public function store(Request $request)
    {
        CalendarEvent::create($this->validated($request));

        return redirect($this->to('events.index'))->with('status', 'Fecha agregada al calendario.');
    }

    public function edit(CalendarEvent $event)
    {
        return $this->view('admin.events.form', compact('event'));
    }

    public function update(Request $request, CalendarEvent $event)
    {
        $event->update($this->validated($request));

        return redirect($this->to('events.index'))->with('status', 'Fecha actualizada.');
    }

    public function destroy(CalendarEvent $event)
    {
        $event->delete();

        return back()->with('status', 'Fecha eliminada.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:1000'],
            'type' => ['required', Rule::in(array_keys(config('admin.event_types')))],
            'starts_on' => ['required', 'date'],
            'ends_on' => ['nullable', 'date', 'after_or_equal:starts_on'],
            'starts_at' => ['nullable', 'date_format:H:i'],
            'location' => ['nullable', 'string', 'max:150'],
            'visible' => ['boolean'],
        ]);

        return $data + ['visible' => false];
    }
}
