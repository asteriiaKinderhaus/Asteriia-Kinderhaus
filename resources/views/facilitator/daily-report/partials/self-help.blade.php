<div class="card card-success">

    <div class="card-header">
        <h3 class="card-title">
            Self Help
        </h3>
    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <thead>

                <tr>
                    <th>Aktivitas</th>
                    <th class="text-center">Mandiri</th>
                    <th class="text-center">Bantuan</th>
                </tr>

            </thead>

            <tbody>

                @foreach($selfHelps as $selfHelp)

                <tr>

                    <td>{{ $selfHelp->name }}</td>

                    <td class="text-center">
                        <input
                            type="radio"
                            name="self_help[{{ $selfHelp->id }}][assistance]"
                            value="MANDIRI">
                    </td>

                    <td class="text-center">
                        <input
                            type="radio"
                            name="self_help[{{ $selfHelp->id }}][assistance]"
                            value="BANTUAN">
                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>