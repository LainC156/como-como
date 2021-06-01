<!-- MICRONUTRIENTS -->
<h5 class="card-title text-uppercase mb-0 text-center text-info">
    {{ __('Micronutrientes') }}</h5>
<div class="table-responsive">
    <table class="table align-items-center table-flush table-sm table-striped">
        <thead class="thead-light">
            <th scope="col">{{ __('Componente') }}</th>
            <th scope="col">{{ __('Total') }}</th>
            <th scope="col">{{ __('Estado') }}</th>
            <th scope="col">{{ __('Valor mín.') }}</th>
            </tr>
        </thead>
        @forelse ($results as $result)
            <tbody>
                <!-- calcium -->
                @if ($result->calciumStatus == 0)
                    <tr id="calDef" data-toggle="tooltip" data-placement="top" title="Deficiente">
                    @elseif( $result->calciumStatus == 2 )
                    <tr id="calExc" data-toggle="tooltip" data-placement="top" title="Excedente">
                    @elseif( $result->calciumStatus == 1 )
                    <tr id="calNorm" data-toggle="tooltip" data-placement="top" title="Bueno">
                @endif
                <td>
                    <p> <span class="h5 font-weight-bold mb-0">{{ __('Calcio') }}</span>
                    </p>
                </td>
                <td>{!! $result->calcium !!} {{ __('mg') }}.</td>
                @if ($result->calciumStatus == 0)
                    <td class="text-warning"><i class="fas fa-exclamation-circle"></i>{{ __('Deficiente') }}
                    </td>
                @elseif( $result->calciumStatus == 2 )
                    <td class="text-danger"><i class="fas fa-exclamation-circle"></i>{{ __('Excedente') }}
                    </td>
                @elseif( $result->calciumStatus == 1 )
                    <td class="text-success"><i class="fas fa-check"></i>{{ __('Bueno') }}
                    </td>
                @endif
                <td>{!! $minCalcium !!} {{ __('mg') }}.</td>
                </tr>
                <!-- phosphorus -->
                @if ($result->phosphorusStatus == 0)
                    <tr id="phosDef" data-toggle="tooltip" data-placement="top" title="Deficiente">
                    @elseif( $result->phosphorusStatus == 2 )
                    <tr id="phosExc" data-toggle="tooltip" data-placement="top" title="Excedente">
                    @elseif( $result->phosphorusStatus == 1 )
                    <tr id="phosNorm" data-toggle="tooltip" data-placement="top" title="Bueno">
                @endif
                <td>
                    <p> <span class="h5 font-weight-bold mb-0">{{ __('Fósforo') }}</span>
                    </p>
                </td>
                @if ($result->phosphorus == null)
                    <td>0 {{ __('mg') }}.</td>
                @else
                    <td>{!! $result->phosphorus !!} {{ __('mg') }}.</td>
                @endif
                @if ($result->phosphorusStatus == 0)
                    <td class="text-warning"><i class="fas fa-exclamation-circle"></i>{{ __('Deficiente') }}
                    </td>
                @elseif( $result->phosphorusStatus == 2 )
                    <td class="text-danger"><i class="fas fa-exclamation-circle"></i>{{ __('Excedente') }}
                    </td>
                @elseif( $result->phosphorusStatus == 1 )
                    <td class="text-success"><i class="fas fa-check"></i>{{ __('Bueno') }}
                    </td>
                @endif
                <td>{!! $minPhosphorus !!}</td>
                </tr>
                <!-- iron -->
                @if ($result->ironStatus == 0)
                    <tr id="ironDef" data-toggle="tooltip" data-placement="top" title="Deficiente">
                    @elseif( $result->ironStatus == 2 )
                    <tr id="ironExc" data-toggle="tooltip" data-placement="top" title="Excedente">
                    @elseif( $result->ironStatus == 1 )
                    <tr id="ironNorm" data-toggle="tooltip" data-placement="top" title="Bueno">
                @endif
                <td>
                    <p> <span class="h5 font-weight-bold mb-0">{{ __('Hierro') }}</span>
                    </p>
                </td>
                <td>{!! $result->iron !!} {{ __('mg') }}.</td>
                @if ($result->ironStatus == 0)
                    <td class="text-warning"><i class="fas fa-exclamation-circle"></i>{{ __('Deficiente') }}
                    </td>
                @elseif( $result->ironStatus == 2 )
                    <td class="text-danger"><i class="fas fa-exclamation-circle"></i>{{ __('Excedente') }}
                    </td>
                @elseif( $result->ironStatus == 1 )
                    <td class="text-success"><i class="fas fa-check"></i>{{ __('Bueno') }}
                    </td>
                @endif
                <td>{!! $minIron !!} {{ __('mg') }}.</td>
                </tr>
                <!-- magnesium -->
                @if ($result->magnesiumStatus == 0)
                    <tr id="magDef" data-toggle="tooltip" data-placement="top" title="Deficiente">
                    @elseif( $result->magnesiumStatus == 2 )
                    <tr id="magExc" data-toggle="tooltip" data-placement="top" title="Excedente">
                    @elseif( $result->magnesiumStatus == 1 )
                    <tr id="magNorm" data-toggle="tooltip" data-placement="top" title="Bueno">
                @endif
                <td>
                    <p> <span class="h5 font-weight-bold mb-0">{{ __('Magnesio') }}</span>
                    </p>
                </td>
                <td>{!! $result->magnesium !!} {{ __('mg') }}.</td>
                @if ($result->magnesiumStatus == 0)
                    <td class="text-warning"><i class="fas fa-exclamation-circle"></i>{{ __('Deficiente') }}
                    </td>
                @elseif( $result->magnesiumStatus == 2 )
                    <td class="text-danger"><i class="fas fa-exclamation-circle"></i>{{ __('Excedente') }}
                    </td>
                @elseif( $result->magnesiumStatus == 1 )
                    <td class="text-success"><i class="fas fa-check"></i>{{ __('Bueno') }}
                    </td>
                @endif
                <td>{!! $minMagnesium !!} {{ __('mg') }}.</td>
                </tr>
                <!-- sodium -->
                @if ($result->sodiumStatus == 0)
                    <tr id="sodDef" data-toggle="tooltip" data-placement="top" title="Deficiente">
                    @elseif( $result->sodiumStatus == 2 )
                    <tr id="sodExc" data-toggle="tooltip" data-placement="top" title="Excedente">
                    @elseif( $result->sodiumStatus == 1 )
                    <tr id="sodNorm" data-toggle="tooltip" data-placement="top" title="Bueno">
                @endif
                <td>
                    <p> <span class="h5 font-weight-bold mb-0">{{ __('Sodio') }}</span>
                    </p>
                </td>
                <td>{!! $result->sodium !!} {{ __('mg') }}.</td>
                @if ($result->sodiumStatus == 0)
                    <td class="text-warning"><i class="fas fa-exclamation-circle"></i>{{ __('Deficiente') }}
                    </td>
                @elseif( $result->sodiumStatus == 2 )
                    <td class="text-danger"><i class="fas fa-exclamation-circle"></i>{{ __('Excedente') }}
                    </td>
                @elseif( $result->sodiumStatus == 1 )
                    <td class="text-success"><i class="fas fa-check"></i>{{ __('Bueno') }}
                    </td>
                @endif
                <td>{!! $minSodium !!} {{ __('mg') }}.</td>
                </tr>
                <!-- potassium -->
                @if ($result->potassiumStatus == 0)
                    <tr id="potDef" data-toggle="tooltip" data-placement="top" title="Deficiente">
                    @elseif( $result->potassiumStatus == 2 )
                    <tr id="potExc" data-toggle="tooltip" data-placement="top" title="Excedente">
                    @elseif( $result->potassiumStatus == 1 )
                    <tr id="potNorm" data-toggle="tooltip" data-placement="top" title="Bueno">
                @endif
                <td>
                    <p> <span class="h5 font-weight-bold mb-0">{{ __('Potasio') }}</span>
                    </p>
                </td>
                <td>{!! $result->potassium !!} {{ __('mg') }}.</td>
                @if ($result->potassiumStatus == 0)
                    <td class="text-warning"><i class="fas fa-exclamation-circle"></i>{{ __('Deficiente') }}
                    </td>
                @elseif( $result->potassiumStatus == 2 )
                    <td class="text-danger"><i class="fas fa-exclamation-circle"></i>{{ __('Excedente') }}
                    </td>
                @elseif( $result->potassiumStatus == 1 )
                    <td class="text-success"><i class="fas fa-check"></i>{{ __('Bueno') }}
                    </td>
                @endif
                <td>{!! $minPotassium !!} {{ __('mg') }}.</td>
                </tr>
                <!-- zinc -->
                @if ($result->zincStatus == 0)
                    <tr id="zincDef" data-toggle="tooltip" data-placement="top" title="Deficiente">
                    @elseif( $result->zincStatus == 2 )
                    <tr id="zincExc" data-toggle="tooltip" data-placement="top" title="Excedente">
                    @elseif( $result->zincStatus == 1 )
                    <tr id="zincNorm" data-toggle="tooltip" data-placement="top" title="Bueno">
                @endif
                <td>
                    <p> <span class="h5 font-weight-bold mb-0">{{ __('Zinc') }}</span>
                    </p>
                </td>
                <td>{!! $result->zinc !!} {{ __('mg') }}.</td>
                @if ($result->zincStatus == 0)
                    <td class="text-warning"><i class="fas fa-exclamation-circle"></i>{{ __('Deficiente') }}
                    </td>
                @elseif( $result->zincStatus == 2 )
                    <td class="text-danger"><i class="fas fa-exclamation-circle"></i>{{ __('Excedente') }}
                    </td>
                @elseif( $result->zincStatus == 1 )
                    <td class="text-success"><i class="fas fa-check"></i>{{ __('Bueno') }}
                    </td>
                @endif
                <td>{!! $minZinc !!} {{ __('mg') }}.</td>
                </tr>
                <!-- vitamin A -->
                @if ($result->vitaminAStatus == 0)
                    <tr id="vADef" data-toggle="tooltip" data-placement="top" title="Deficiente">
                    @elseif( $result->vitaminAStatus == 2 )
                    <tr id="vAExc" data-toggle="tooltip" data-placement="top" title="Excedente">
                    @elseif( $result->vitaminAStatus == 1 )
                    <tr id="vANorm" data-toggle="tooltip" data-placement="top" title="Bueno">
                @endif
                <td>
                    <p> <span class="h5 font-weight-bold mb-0">{{ __('Vitamina A') }}</span>
                    </p>
                </td>
                <td>{!! $result->vitaminA !!} {{ __('ug') }}.</td>
                @if ($result->vitaminAStatus == 0)
                    <td class="text-warning"><i class="fas fa-exclamation-circle"></i>{{ __('Deficiente') }}
                    </td>
                @elseif( $result->vitaminAStatus == 2 )
                    <td class="text-danger"><i class="fas fa-exclamation-circle"></i>{{ __('Excedente') }}
                    </td>
                @elseif( $result->vitaminAStatus == 1 )
                    <td class="text-success"><i class="fas fa-check"></i>{{ __('Bueno') }}
                    </td>
                @endif
                <td>{!! $minVitaminA !!} {{ __('ug') }}.</td>
                </tr>
                <!-- vitamin B1 -->
                @if ($result->vitaminB1Status == 0)
                    <tr id="vB1Def" data-toggle="tooltip" data-placement="top" title="Deficiente">
                    @elseif( $result->vitaminB1Status == 2 )
                    <tr id="vB1Exc" data-toggle="tooltip" data-placement="top" title="Excedente">
                    @elseif( $result->vitaminB1Status == 1 )
                    <tr id="vB1Norm" data-toggle="tooltip" data-placement="top" title="Bueno">
                @endif
                <td>
                    <p> <span class="h5 font-weight-bold mb-0">{{ __('Vitamina B1') }}</span>
                    </p>
                </td>
                <td>{!! $result->vitaminB1 !!} {{ __('mg') }}.</td>
                @if ($result->vitaminB1Status == 0)
                    <td class="text-warning"><i class="fas fa-exclamation-circle"></i>{{ __('Deficiente') }}
                    </td>
                @elseif( $result->vitaminB1Status == 2 )
                    <td class="text-danger"><i class="fas fa-exclamation-circle"></i>{{ __('Excedente') }}
                    </td>
                @elseif( $result->vitaminB1Status == 1 )
                    <td class="text-success"><i class="fas fa-check"></i>{{ __('Bueno') }}
                    </td>
                @endif
                <td>{!! $minVitaminB1 !!} {{ __('mg') }}.</td>
                </tr>
                <!-- vitamin B2 -->
                @if ($result->vitaminB2Status == 0)
                    <tr id="vB2Def" data-toggle="tooltip" data-placement="top" title="Deficiente">
                    @elseif( $result->vitaminB2Status == 2 )
                    <tr id="vB2Exc" data-toggle="tooltip" data-placement="top" title="Excedente">
                    @elseif( $result->vitaminB2Status == 1 )
                    <tr id="vB2Norm" data-toggle="tooltip" data-placement="top" title="Bueno">
                @endif
                <td>
                    <p> <span class="h5 font-weight-bold mb-0">{{ __('Vitamina B2') }}</span>
                    </p>
                </td>
                <td>{!! $result->vitaminB2 !!} {{ __('mg') }}.</td>
                @if ($result->vitaminB2Status == 0)
                    <td class="text-warning"><i class="fas fa-exclamation-circle"></i>{{ __('Deficiente') }}
                    </td>
                @elseif( $result->vitaminB2Status == 2 )
                    <td class="text-danger"><i class="fas fa-exclamation-circle"></i>{{ __('Excedente') }}
                    </td>
                @elseif( $result->vitaminB2Status == 1 )
                    <td class="text-success"><i class="fas fa-check"></i>{{ __('Bueno') }}
                    </td>
                @endif
                <td>{!! $minVitaminB2 !!} {{ __('mg') }}.</td>
                </tr>
                <!-- vitamin B3-->
                @if ($result->vitaminB3Status == 0)
                    <tr id="vB3Def" data-toggle="tooltip" data-placement="top" title="Deficiente">
                    @elseif( $result->vitaminB3Status == 2 )
                    <tr id="vB3Exc" data-toggle="tooltip" data-placement="top" title="Excedente">
                    @elseif( $result->vitaminB3Status == 1 )
                    <tr id="vB3Norm" data-toggle="tooltip" data-placement="top" title="Bueno">
                @endif
                <td>
                    <p> <span class="h5 font-weight-bold mb-0">{{ __('Vitamina B3') }}</span>
                    </p>
                </td>
                <td>{!! $result->vitaminB3 !!} {{ __('mg') }}.</td>
                @if ($result->vitaminB3Status == 0)
                    <td class="text-warning"><i class="fas fa-exclamation-circle"></i>{{ __('Deficiente') }}
                    </td>
                @elseif( $result->vitaminB3Status == 2 )
                    <td class="text-danger"><i class="fas fa-exclamation-circle"></i>{{ __('Excedente') }}
                    </td>
                @elseif( $result->vitaminB3Status == 1 )
                    <td class="text-success"><i class="fas fa-check"></i>{{ __('Bueno') }}
                    </td>
                @endif
                <td>{!! $minVitaminB3 !!} {{ __('mg') }}.</td>
                </tr>
                <!-- vitamin B6 -->
                @if ($result->vitaminB6Status == 0)
                    <tr id="vB6Def" data-toggle="tooltip" data-placement="top" title="Deficiente">
                    @elseif( $result->vitaminB6Status == 2 )
                    <tr id="vB6Exc" data-toggle="tooltip" data-placement="top" title="Excedente">
                    @elseif( $result->vitaminB6Status == 1 )
                    <tr id="vB6Norm" data-toggle="tooltip" data-placement="top" title="Bueno">
                @endif
                <td>
                    <p> <span class="h5 font-weight-bold mb-0">{{ __('Vitamina B6') }}</span>
                    </p>
                </td>
                <td>{!! $result->vitaminB6 !!} {{ __('mg') }}.</td>
                @if ($result->vitaminB6Status == 0)
                    <td class="text-warning"><i class="fas fa-exclamation-circle"></i>{{ __('Deficiente') }}
                    </td>
                @elseif( $result->vitaminB6Status == 2 )
                    <td class="text-danger"><i class="fas fa-exclamation-circle"></i>{{ __('Excedente') }}
                    </td>
                @elseif( $result->vitaminB6Status == 1 )
                    <td class="text-success"><i class="fas fa-check"></i>{{ __('Bueno') }}
                    </td>
                @endif
                <td>{!! $minVitaminB6 !!} {{ __('mg') }}.</td>
                </tr>
                <!-- vitamin B9 -->
                @if ($result->vitaminB9Status == 0)
                    <tr id="vB9Def" data-toggle="tooltip" data-placement="top" title="Deficiente">
                    @elseif( $result->vitaminB9Status == 2 )
                    <tr id="vB9Exc" data-toggle="tooltip" data-placement="top" title="Excedente">
                    @elseif( $result->vitaminB9Status == 1 )
                    <tr id="vB9Norm" data-toggle="tooltip" data-placement="top" title="Bueno">
                @endif
                <td>
                    <p> <span class="h5 font-weight-bold mb-0">{{ __('Vitamina B9') }}</span>
                    </p>
                </td>
                <td>{!! $result->vitaminB9 !!} {{ __('ug') }}.</td>
                @if ($result->vitaminB9Status == 0)
                    <td class="text-warning"><i class="fas fa-exclamation-circle"></i>{{ __('Deficiente') }}
                    </td>
                @elseif( $result->vitaminB9Status == 2 )
                    <td class="text-danger"><i class="fas fa-exclamation-circle"></i>{{ __('Excedente') }}
                    </td>
                @elseif( $result->vitaminB9Status == 1 )
                    <td class="text-success"><i class="fas fa-check"></i>{{ __('Bueno') }}
                    </td>
                @endif
                <td>{!! $minVitaminB9 !!} {{ __('mg') }}.</td>
                </tr>
                <!-- vitamin B12-->
                @if ($result->vitaminB12Status == 0)
                    <tr id="vB12Def" data-toggle="tooltip" data-placement="top" title="Deficiente">
                    @elseif( $result->vitaminB12Status == 2 )
                    <tr id="vB12Exc" data-toggle="tooltip" data-placement="top" title="Excedente">
                    @elseif( $result->vitaminB12Status == 1 )
                    <tr id="vB12Norm" data-toggle="tooltip" data-placement="top" title="Bueno">
                @endif
                <td>
                    <p> <span class="h5 font-weight-bold mb-0">{{ __('Vitamina B12') }}</span>
                    </p>
                </td>
                <td>{!! $result->vitaminB12 !!} {{ __('ug') }}.</td>
                @if ($result->vitaminB12Status == 0)
                    <td class="text-warning"><i class="fas fa-exclamation-circle"></i>{{ __('Deficiente') }}
                    </td>
                @elseif( $result->vitaminB12Status == 2 )
                    <td class="text-danger"><i class="fas fa-exclamation-circle"></i>{{ __('Excedente') }}
                    </td>
                @elseif( $result->vitaminB12Status == 1 )
                    <td class="text-success"><i class="fas fa-check"></i>{{ __('Bueno') }}
                    </td>
                @endif
                <td>{!! $minVitaminB12 !!} {{ __('ug') }}.</td>
                </tr>
                <!-- vitamin C-->
                @if ($result->vitaminCStatus == 0)
                    <tr id="vCDef" data-toggle="tooltip" data-placement="top" title="Deficiente">
                    @elseif( $result->vitaminCStatus == 2 )
                    <tr id="vCExc" data-toggle="tooltip" data-placement="top" title="Excedente">
                    @elseif( $result->vitaminCStatus == 1 )
                    <tr id="vCNorm" data-toggle="tooltip" data-placement="top" title="Bueno">
                @endif
                <td>
                    <p> <span class="h5 font-weight-bold mb-0">{{ __('Vitamina C') }}</span>
                    </p>
                </td>
                <td>{!! $result->vitaminC !!} {{ __('mg') }}.</td>
                @if ($result->vitaminCStatus == 0)
                    <td class="text-warning"><i class="fas fa-exclamation-circle"></i>{{ __('Deficiente') }}
                    </td>
                @elseif( $result->vitaminCStatus == 2 )
                    <td class="text-danger"><i class="fas fa-exclamation-circle"></i>{{ __('Excedente') }}
                    </td>
                @elseif( $result->vitaminCStatus == 1 )
                    <td class="text-success"><i class="fas fa-check"></i>{{ __('Bueno') }}
                    </td>
                @endif
                <td>{!! $minVitaminC !!} {{ __('mg') }}.</td>
                </tr>
            </tbody>
        @empty
            <span>{{ __('No se pudieron generar los resultados, prueba con un menú no vacío') }}</span>
        @endforelse
    </table>
</div>
