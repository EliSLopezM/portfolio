<?php

namespace App\Http\Controllers\Admin;

use App\Models\StackCategory;
use App\Models\StackItem;
use App\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StackController extends AdminController
{
    private const ICON_URL = '#^(https://[^\s"\'<>]+|data:image/(svg\+xml|png|jpeg|webp|gif);base64,[A-Za-z0-9+/=]+)$#';

    public function __construct(private UploadService $uploads) {}

    public function index()
    {
        return $this->view('admin.stack.index', [
            'categories' => StackCategory::ordered()->with('items')->get(),
        ]);
    }

    // ── Categorías ──
    public function storeCategory(Request $request)
    {
        $data = $this->categoryData($request);
        StackCategory::create($data + ['slug' => $this->uniqueSlug($data['name'])]);

        return back()->with('status', 'Categoría creada.');
    }

    public function editCategory(StackCategory $category)
    {
        return $this->view('admin.stack.category', compact('category'));
    }

    public function updateCategory(Request $request, StackCategory $category)
    {
        $category->update($this->categoryData($request));

        return redirect($this->to('stack.index'))->with('status', 'Categoría actualizada.');
    }

    public function destroyCategory(StackCategory $category)
    {
        foreach ($category->items as $item) {
            $this->uploads->delete($item->icon);
        }
        $category->delete(); // las tecnologías se eliminan en cascada

        return back()->with('status', 'Categoría eliminada junto con sus tecnologías.');
    }

    // ── Tecnologías ──
    public function storeItem(Request $request)
    {
        $data = $this->itemData($request);
        StackItem::create($data);

        return back()->with('status', 'Tecnología agregada.');
    }

    public function editItem(StackItem $item)
    {
        return $this->view('admin.stack.item', ['item' => $item, 'categories' => StackCategory::ordered()->get()]);
    }

    public function updateItem(Request $request, StackItem $item)
    {
        $item->update($this->itemData($request, $item));

        return redirect($this->to('stack.index'))->with('status', 'Tecnología actualizada.');
    }

    public function destroyItem(StackItem $item)
    {
        $this->uploads->delete($item->icon);
        $item->delete();

        return back()->with('status', 'Tecnología eliminada.');
    }

    private function categoryData(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:60'],
            'description' => ['nullable', 'string', 'max:200'],
            'featured' => ['boolean'],
        ]);

        return $data + ['featured' => false];
    }

    private function itemData(Request $request, ?StackItem $item = null): array
    {
        $data = $request->validate([
            'stack_category_id' => ['required', 'exists:stack_categories,id'],
            'name' => ['required', 'string', 'max:60'],
            'type' => ['nullable', 'string', 'max:120'],
            'level' => ['required', Rule::in(array_keys(StackItem::LEVELS))],
            'icon_url' => ['nullable', 'string', 'max:8000', 'regex:'.self::ICON_URL],
            'icon_file' => ['nullable', ...UploadService::IMAGE_RULES],
        ]);

        $icon = $data['icon_url'] ?? $item?->icon;
        if ($request->hasFile('icon_file')) {
            $this->uploads->delete($item?->icon);
            $icon = $this->uploads->store($request->file('icon_file'), 'stack');
        } elseif ($item && ($data['icon_url'] ?? null) && $data['icon_url'] !== $item->icon) {
            $this->uploads->delete($item->icon);
        }

        return [
            'stack_category_id' => $data['stack_category_id'],
            'name' => $data['name'],
            'type' => $data['type'] ?? null,
            'level' => $data['level'],
            'icon' => $icon,
            'visible' => $item?->visible ?? true,
        ];
    }

    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name) ?: 'categoria';
        $slug = $base;
        for ($i = 2; StackCategory::where('slug', $slug)->exists(); $i++) {
            $slug = $base.'-'.$i;
        }

        return $slug;
    }
}
