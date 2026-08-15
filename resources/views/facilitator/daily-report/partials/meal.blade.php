<div class="card card-success">

    <div class="card-header">

        <h3 class="card-title">

            <i class="fas fa-utensils"></i>

            Catatan Makan & Minum

        </h3>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="text-center">

                    <tr class="bg-light">

                        <th width="25%">Jenis Makanan</th>
                        <th>Habis</th>
                        <th>Tidak Habis</th>
                        <th>Sisa Sedikit</th>
                        <th>Mandiri</th>
                        <th>Bantuan</th>
                        <!--<th width="25%">Catatan</th>-->

                    </tr>

                </thead>

                <tbody>
                    @foreach($meals as $meal)

                    <tr>

                        <td>
                            {{ $meal->name }}
                        </td>

                        <td class="text-center">
                            <input type="radio"
                                name="meal[{{ $meal->id }}][food_status]"
                                value="HABIS">
                        </td>

                        <td class="text-center">
                            <input type="radio"
                                name="meal[{{ $meal->id }}][food_status]"
                                value="SISA_SEDIKIT">
                        </td>

                        <td class="text-center">
                            <input type="radio"
                                name="meal[{{ $meal->id }}][food_status]"
                                value="TIDAK_HABIS">
                        </td>

                        <td class="text-center">
                            <input type="radio"
                                name="meal[{{ $meal->id }}][assistance]"
                                value="MANDIRI">
                        </td>

                        <td class="text-center">
                            <input type="radio"
                                name="meal[{{ $meal->id }}][assistance]"
                                value="BANTUAN">
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>
    </div>

</div>