<?php

namespace App\Http\Controllers\Admin;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MessageController extends AdminController
{
    public function index(Request $request)
    {
        $statuses = array_keys(config('admin.message_statuses'));

        $messages = Message::query()
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = '%'.addcslashes($request->string('q'), '%_\\').'%';
                $q->where(fn ($w) => $w->where('nombre', 'like', $term)->orWhere('email', 'like', $term)->orWhere('asunto', 'like', $term));
            })
            ->when($request->input('estado') === 'nuevo', fn ($q) => $q->unread())
            ->when(in_array($request->input('estado'), $statuses, true), fn ($q) => $q->withStatus($request->input('estado')))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return $this->view('admin.messages.index', [
            'messages' => $messages,
            'counts' => collect($statuses)->mapWithKeys(fn ($s) => [$s => Message::withStatus($s)->count()])->put('nuevo', Message::unread()->count())->all(),
        ]);
    }

    public function show(Message $message)
    {
        if ($message->isUnread()) {
            $message->update(['statuses' => array_values(array_unique([...($message->statuses ?? []), 'leido']))]);
        }

        return $this->view('admin.messages.show', compact('message'));
    }

    public function update(Request $request, Message $message)
    {
        $data = $request->validate([
            'statuses' => ['nullable', 'array'],
            'statuses.*' => [Rule::in(array_keys(config('admin.message_statuses')))],
        ]);

        $message->update(['statuses' => array_values(array_unique($data['statuses'] ?? []))]);

        return back()->with('status', 'Estados actualizados.');
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return redirect($this->to('messages.index'))->with('status', 'Mensaje eliminado.');
    }

    /** Acciones sobre varios mensajes a la vez. */
    public function bulk(Request $request)
    {
        $statuses = array_keys(config('admin.message_statuses'));

        $data = $request->validate([
            'ids' => ['required', 'array', 'min:1', 'max:200'],
            'ids.*' => ['integer'],
            'action' => ['required', Rule::in(['add', 'remove', 'set', 'delete'])],
            'status' => ['required_unless:action,delete', 'nullable', Rule::in($statuses)],
        ], ['ids.required' => 'Selecciona al menos un mensaje.']);

        $messages = Message::whereIn('id', $data['ids'])->get();

        if ($data['action'] === 'delete') {
            Message::whereIn('id', $messages->pluck('id'))->delete();
        } else {
            foreach ($messages as $message) {
                $current = $message->statuses ?? [];
                $new = match ($data['action']) {
                    'add' => [...$current, $data['status']],
                    'remove' => array_diff($current, [$data['status']]),
                    'set' => [$data['status']],
                };
                $message->update(['statuses' => array_values(array_unique($new))]);
            }
        }

        return back()->with('status', $messages->count().' mensaje(s) actualizados.');
    }
}
