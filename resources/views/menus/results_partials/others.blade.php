<!-- OTHERS -->
<h5 class="card-title text-uppercase mb-0 text-center text-default">
    {{ __('Otros') }}</h5>
<div class="table-responsive">
    <div>
        <table class="table align-items-center table-flush table-sm table-striped">
            <thead class="thead-light">
                <tr>
                    <th scope="col">{{ __('Componente') }}</th>
                    <th scope="col">{{ __('Total') }}</th>
                    <th scope="col">{{ __('Estado') }}</th>
                    <th scope="col">{{ __('Valor mín.') }}</th>
                    <th scope="col">{{ __('Valor máx.') }}</th>
                </tr>
            </thead>
            <tbody>
                <!-- energy(kcal) -->
                @if ($kcal > $maxKcal)
                    <tr id="kcalExc">
                    @elseif( $kcal < $minKcal ) <tr id="kcalDef">
                        @else
                    <tr id="kcalNorm">
                @endif
                <td>
                    <p>
                        <span class="h5 font-weight-bold mb-0">{{ __('Energía') }}
                            ({{ __('kcal') }}.)</span>
                    </p>
                </td>
                <td>{!! $kcal !!}</td>
                @if ($kcal < $minKcal)
                    <td class="text-warning"><i class="fas fa-exclamation-circle"></i>{{ __('Deficiente') }}
                    </td>
                @elseif( $kcal > $maxKcal )
                    <td class="text-danger"><i class="fas fa-exclamation-circle"></i>{{ __('Excedente') }}
                    </td>
                @else
                    <td class="text-success"><i class="fas fa-exclamation-check"></i>{{ __('Bueno') }}
                    </td>
                @endif
                <td>{!! $minKcal !!}</td>
                <td>{!! $maxKcal !!}</td>
                </tr>
                <!-- energy(KJ) -->
                @if ($kj > $maxKj)
                    <tr id="kjExc">
                    @elseif( $kj < $minKj ) <tr id="kjDef">
                        @else
                    <tr id="kjNorm">
                @endif
                <td>
                    <p> <span class="h5 font-weight-bold mb-0">{{ __('Energía') }}
                            ({{ __('kj') }}.)</span>
                    </p>
                </td>
                <td>{!! $kj !!}</td>
                @if ($kj < $minKj)
                    <td class="text-warning"><i class="fas fa-exclamation-circle"></i>{{ __('Deficiente') }}
                    </td>
                @elseif( $kj > $maxKj)
                    <td class="text-danger"><i class="fas fa-exclamation-circle"></i>{{ __('Excedente') }}
                    </td>
                @else
                    <td class="text-success"><i class="fas fa-exclamation-check"></i>{{ __('Bueno') }}
                    </td>
                @endif
                <td>{!! $minKj !!}</td>
                <td>{!! $maxKj !!}</td>
                </tr>
                <!-- water(ml) -->
                @if ($water < $minWater)
                    <tr id="waterDef">
                    @else
                    <tr id="waterNorm">
                @endif
                <td>
                    <p> <span class="h5 font-weight-bold mb-0">{{ __('Agua') }}
                            ({{ __('ml') }}.)</span>
                    </p>
                </td>
                <td>{!! $water !!}</td>
                @if ($water < $minWater)
                    <td class="text-warning"><i class="fas fa-exclamation-circle"></i>{{ __('Deficiente') }}
                    </td>
                @else
                    <td class="text-success"><i class="fas fa-check"></i>{{ __('Bueno') }}
                    </td>
                @endif
                <td>{!! $minWater !!}</td>
                <td>-</td>
                </tr>
                <!-- dietary fiber(gr) -->
                @if ($dietary_fiber < $minFiber)
                    <tr id="dfDef">
                    @else
                    <tr id="dfNorm">
                @endif
                <td>
                    <p> <span class="h5 font-weight-bold mb-0">{{ __('Fibra dietética') }}
                            ({{ __('gr') }}.)</span>
                    </p>
                </td>
                <td>{!! $dietary_fiber !!}</td>
                @if ($dietary_fiber < $minFiber)
                    <td class="text-warning"><i class="fas fa-exclamation-circle"></i>{{ __('Deficiente') }}
                    </td>
                @else
                    <td class="text-success"><i class="fas fa-check"></i>{{ __('Bueno') }}
                    </td>
                @endif
                <td>{!! $minFiber !!}</td>
                <td>-</td>
                </tr>
                <!-- cholesterol(mg) -->
                @if ($cholesterol > $maxCholesterol)
                    <tr id="choExc">
                    @else
                    <tr id="choNorm">
                @endif
                <td>
                    <p> <span class="h5 font-weight-bold mb-0">{{ __('Colesterol') }}
                            ({{ __('mg') }}.)</span>
                    </p>
                </td>
                <td>{!! $cholesterol !!}</td>
                @if ($cholesterol > $maxCholesterol)
                    <td class="text-danger"><i class="fas fa-exclamation-circle"></i>{{ __('Excedente') }}
                    </td>
                @else
                    <td class="text-success"><i class="fas fa-check"></i>{{ __('Bueno') }}
                    </td>
                @endif
                <td>-</td>
                <td>{!! $maxCholesterol !!}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>