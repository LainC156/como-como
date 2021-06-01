<!-- MACRONUTRIENTS -->
<h5 class="card-title text-uppercase mb-0 text-center text-primary">
    {{ __('Macronutrientes') }}</h5>
<div class="table-responsive">
    <div>
        <table class="table align-items-center table-flush table-sm table-striped">
            <thead class="thead-light">
                <tr>
                    <th scope="col">{{ __('Componente') }}</th>
                    <th scope="col">{{ __('Total') }} ({{ __('kcal') }}.)
                    </th>
                    <th scope="col">{{ __('Estado') }}</th>
                    <th scope="col">{{ __('Valor mín.') }}
                        ({{ __('kcal') }}.)</th>
                    <th scope="col">{{ __('Valor máx.') }}
                        ({{ __('kcal') }}.)</th>
                </tr>
            </thead>
            @forelse ($results as $result)
                <tbody>
                    <!-- carbohydrates -->
                    @if ($result->carbohydratesStatus == 2)
                        <tr id="carbExc">
                        @elseif( $result->carbohydratesStatus == 0 )
                        <tr id="carbDef">
                        @elseif( $result->carbohydratesStatus == 1 )
                        <tr id="carbNorm">
                    @endif
                    <td>
                        <p>
                            <span class="h5 font-weight-bold mb-0">{{ __('Carbohidratos') }}</span>
                        </p>
                    </td>
                    <td>{!! $result->carbohydrates !!}</td>
                    @if ($result->carbohydratesStatus == 0)
                        <td class="text-warning"><i class="fas fa-exclamation-circle"></i>{{ __('Deficiente') }}
                        </td>
                    @elseif( $result->carbohydratesStatus == 2 )
                        <td class="text-danger"><i class="fas fa-exclamation-circle"></i>{{ __('Excedente') }}
                        </td>
                    @elseif( $result->carbohydratesStatus == 1 )
                        <td class="text-success"><i class="fas fa-exclamation-check"></i>{{ __('Bueno') }}
                        </td>
                    @endif
                    <td>{!! $minCaloriesInCarbohydrates !!}</td>
                    <td>{!! $maxCaloriesInCarbohydrates !!}</td>
                    </tr>
                    <!-- proteins -->
                    @if ($result->proteinsStatus == 0)
                        <tr id="protDef">
                        @elseif( $result->carbohydratesStatus == 2 )
                        <tr id="protExc">
                        @elseif( $result->proteinsStatus == 1 )
                        <tr id="protNorm">
                    @endif
                    <td>
                        <p> <span class="h5 font-weight-bold mb-0">{{ __('Proteínas') }}</span>
                        </p>
                    </td>
                    <td>{!! $result->proteins !!}</td>
                    @if ($result->proteinsStatus == 0)
                        <td class="text-warning"><i class="fas fa-exclamation-circle"></i>{{ __('Deficiente') }}
                        </td>
                    @elseif( $result->proteinsStatus == 2 )
                        <td class="text-danger"><i class="fas fa-exclamation-circle"></i>{{ __('Excedente') }}
                        </td>
                    @elseif( $result->proteinsStatus == 1 )
                        <td class="text-success"><i class="fas fa-exclamation-check"></i>{{ __('Bueno') }}
                        </td>
                    @endif
                    <td>{!! $minCaloriesInProteins !!}</td>
                    <td>{!! $maxCaloriesInProteins !!}</td>
                    </tr>
                    <!-- lipids -->
                    @if ($result->lipidsStatus == 0)
                        <tr id="lipDef">
                        @elseif( $result->lipidsStatus == 2 )
                        <tr id="lipExc">
                        @elseif( $result->lipidsStatus == 1 )
                        <tr id="lipNorm">
                    @endif
                    <td>
                        <p>
                            <span class="h5 font-weight-bold mb-0">{{ __('Lípidos') }}</span>
                        </p>
                    </td>
                    <td>{!! $result->lipids !!}</td>
                    @if ($result->lipidsStatus == 0)
                        <td class="text-warning"><i class="fas fa-exclamation-circle"></i>{{ __('Deficiente') }}
                        </td>
                    @elseif( $result->lipidsStatus == 2 )
                        <td class="text-danger"><i class="fas fa-exclamation-circle"></i>{{ __('Excedente') }}
                        </td>
                    @elseif( $result->lipidsStatus == 1 )
                        <td class="text-success"><i class="fas fa-check"></i>{{ __('Bueno') }}
                        </td>
                    @endif
                    <td>{!! $minCaloriesInLipids !!}</td>
                    <td>{!! $maxCaloriesInLipids !!}</td>
                    </tr>
                </tbody>
            @empty
                <span>{{ __('No se pudieron generar los resultados, prueba con un menú no vacío') }}</span>
            @endforelse
        </table>
    </div>
</div>
<br>
