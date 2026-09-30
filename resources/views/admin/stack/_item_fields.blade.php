<div class="field"><label for="stack_category_id">Categoría</label>
  <select id="stack_category_id" name="stack_category_id" required>@foreach($categories as $c)<option value="{{ $c->id }}" @selected(old('stack_category_id', $item->stack_category_id) == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
<div class="row">
  <div class="field"><label for="name">Nombre</label><input type="text" id="name" name="name" value="{{ old('name', $item->name) }}" maxlength="60" required></div>
  <div class="field"><label for="level">Estado</label><select id="level" name="level">@foreach(\App\Models\StackItem::LEVELS as $k => $l)<option value="{{ $k }}" @selected(old('level', $item->level) === $k)>{{ $l }}</option>@endforeach</select></div>
</div>
<div class="field"><label for="type">Descripción corta</label><input type="text" id="type" name="type" value="{{ old('type', $item->type) }}" maxlength="120" placeholder="Framework backend"></div>
<div class="field"><label for="icon_url">Icono (URL https)</label><input type="text" id="icon_url" name="icon_url" value="{{ old('icon_url', \Illuminate\Support\Str::startsWith($item->icon, 'uploads/') ? '' : $item->icon) }}" maxlength="8000" placeholder="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg"></div>
<div class="field"><label for="icon_file">…o subir icono (PNG/JPG/WEBP)</label>@include('admin.partials.img-input', ['name' => 'icon_file', 'preset' => 'icon', 'id' => 'icon_file'])</div>
