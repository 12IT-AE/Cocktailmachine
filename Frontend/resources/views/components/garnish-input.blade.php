<div class="form-group mt-2 garnish-input">
    <div class="row">
        <div class="col-4">
            <label for="garnish">Garnierung</label>
            <select class="form-control" id="garnish" name="garnishes[]">
                @foreach ($garnishes as $garnish)
                    <option value="{{ $garnish->id }}">{{ $garnish->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-2 d-flex align-items-end">
            <button type="button" class="btn btn-danger remove-garnish">Entfernen</button>
        </div>
    </div>
</div>