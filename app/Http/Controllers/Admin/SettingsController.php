<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use App\Services\PortfolioContent;
use Illuminate\Http\Request;

class SettingsController extends AdminController
{
    public function edit()
    {
        $content = PortfolioContent::get();

        return $this->view('admin.settings', [
            'github' => $content['github'],
            'linkedin' => $content['linkedin'],
            'available' => $content['available'],
            'stats' => $content['stats'],
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'github' => ['required', 'url:https', 'max:255'],
            'linkedin' => ['required', 'url:https', 'max:255'],
            'available' => ['boolean'],
            'stats' => ['required', 'array', 'size:4'],
            'stats.*.value' => ['required', 'string', 'max:12'],
            'stats.*.label' => ['required', 'string', 'max:60'],
        ]);

        Setting::updateOrCreate(['key' => 'github'], ['value' => $data['github']]);
        Setting::updateOrCreate(['key' => 'linkedin'], ['value' => $data['linkedin']]);
        Setting::updateOrCreate(['key' => 'available'], ['value' => $request->boolean('available')]);
        Setting::updateOrCreate(['key' => 'stats'], ['value' => array_values(array_map(
            fn ($s) => ['value' => $s['value'], 'label' => $s['label']],
            $data['stats'],
        ))]);

        return back()->with('status', 'Ajustes guardados.');
    }
}
