<div class="card card-info">

    <div class="card-header">

        <h3 class="card-title">

            <i class="fas fa-brain"></i>

            Stimulasi

        </h3>

    </div>

    <div class="card-body">

        @foreach($stimulationCategories as $category)

        <div class="mb-4">

            <h5 class="text-primary">
                {{ $category->name }}
            </h5>

            <div class="row">

                @foreach($category->items as $item)

                <div class="col-md-4">

                    <div class="form-check mb-2">

                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="stimulations[]"
                            value="{{ $item->id }}"
                            id="stim_{{ $item->id }}">

                        <label
                            class="form-check-label"
                            for="stim_{{ $item->id }}">

                            {{ $item->name }}

                        </label>

                    </div>

                </div>

                @endforeach

            </div>

        </div>

        @endforeach

    </div>

</div>