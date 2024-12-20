<div class="form-group mt-2 liquid-input">
    <div class="row">
        <div class="col-1">
            <label for="order">Reihenfolge</label>
            <input type="number" class="form-control" id="order" name="orders[]" min="1" max="10" value="{{ $ingredient ? $ingredient->step + 1 : 1 }}">
        </div>
        <div class="col-3">
            <label for="liquid">Flüssigkeit</label>
            <select class="form-control" id="liquid" name="liquids[]">
                @foreach ($liquids as $liquid)
                    <option value="{{ $liquid->id }}" {{ $ingredient && $ingredient->liquid_id == $liquid->id ? 'selected' : '' }}>
                        {{ $liquid->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-3">
            <label for="amount">Menge (ml)</label>
            <input type="number" class="form-control" id="amount" name="amounts[]" min="1" value="{{ $ingredient ? $ingredient->amount : '' }}" required>
        </div>
        <div class="col-4 d-flex align-items-end">
            <button type="button" class="btn btn-danger remove-liquid">Entfernen</button>
        </div>
    </div>
</div>