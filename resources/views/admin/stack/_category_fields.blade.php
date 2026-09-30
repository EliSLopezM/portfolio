<div class="field"><label for="cname">Nombre</label><input type="text" id="cname" name="name" value="{{ old('name', $category->name) }}" maxlength="60" required placeholder="Backend, Frontend, Ciberseguridad, DevOps…"></div>
<div class="field"><label for="cdesc">Descripción</label><input type="text" id="cdesc" name="description" value="{{ old('description', $category->description) }}" maxlength="200"></div>
<div class="field"><label class="check"><input type="checkbox" name="featured" value="1" @checked(old('featured', $category->featured))> Destacada («★ Favorito»)</label></div>
