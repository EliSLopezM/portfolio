<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

abstract class AdminController extends Controller
{
    /** Área actual ("dcc" o "develop"), fijada por el middleware `area`. */
    protected function area(): string
    {
        return request()->route('area', 'develop');
    }

    protected function to(string $name, mixed $params = []): string
    {
        return route('admin.'.$this->area().'.'.$name, $params);
    }

    protected function view(string $view, array $data = [])
    {
        return view($view, $data + ['area' => $this->area()]);
    }
}
