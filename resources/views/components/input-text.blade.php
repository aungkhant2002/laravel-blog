<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $title }}</label>
    <input type="text" name="{{ $name }}" id="$name"
           class="form-control @error($name) is-invalid @enderror"
           value="{{ old($name) }}">
    @error($name)
    <small class="text-danger fw-bolder">{{ $message }}</small>
    @enderror
</div>
