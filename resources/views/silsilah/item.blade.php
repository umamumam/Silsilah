<li>
    <div class="d-inline-block">
        @if(!$person->ayah_id && !$person->ibu_id)
        <button class="btn-circle btn-circle-primary mb-2" data-bs-toggle="modal"
            data-bs-target="#modalOrangTua{{ $person->id }}" title="Tambah Orang Tua" data-testid="add-parent-btn-{{ $person->id }}">
            <i class="fa-solid fa-arrow-up"></i>
        </button>
        @endif

        <div class="node-group">
            <div id="person-node-{{ $person->id }}"
                class="node {{ $person->jenis_kelamin == 'P' ? 'female' : '' }} {{ $person->status == 'meninggal' ? 'deceased' : '' }}"
                data-id="{{ $person->id }}"
                data-parent="{{ $person->ayah_id ?? $person->ibu_id ?? '' }}"
                data-testid="node-{{ $person->id }}">

                <button class="btn-trace" onclick="highlightJalur('{{ $person->id }}')" title="Lacak Jalur" data-testid="trace-btn-{{ $person->id }}">
                    <i class="fa-solid fa-crosshairs"></i>
                </button>

                <div onclick="jQuery('#modalShow{{ $person->id }}').modal('show')" style="cursor: pointer;">
                    @if($person->foto)
                    <img src="{{ asset('storage/' . $person->foto) }}" alt="{{ $person->nama }}" loading="lazy">
                    @else
                    <div class="default-avatar {{ $person->jenis_kelamin == 'L' ? 'male' : 'female' }}">
                        <i class="fa-solid {{ $person->jenis_kelamin == 'L' ? 'fa-mars' : 'fa-venus' }}"></i>
                    </div>
                    @endif
                    <div class="node-name">{{ $person->nama }}</div>
                </div>
            </div>

            @if($person->pasangan)
            <div class="connector-spouse"></div>
            <div id="person-node-{{ $person->pasangan->id }}"
                class="node {{ $person->pasangan->jenis_kelamin == 'P' ? 'female' : '' }} {{ $person->pasangan->status == 'meninggal' ? 'deceased' : '' }}"
                data-id="{{ $person->pasangan->id }}"
                data-parent=""
                style="cursor: pointer;"
                onclick="jQuery('#modalShow{{ $person->pasangan->id }}').modal('show')"
                data-testid="node-{{ $person->pasangan->id }}">

                @if($person->pasangan->foto)
                <img src="{{ asset('storage/' . $person->pasangan->foto) }}" alt="{{ $person->pasangan->nama }}" loading="lazy">
                @else
                <div class="default-avatar {{ $person->pasangan->jenis_kelamin == 'L' ? 'male' : 'female' }}">
                    <i class="fa-solid {{ $person->pasangan->jenis_kelamin == 'L' ? 'fa-mars' : 'fa-venus' }}"></i>
                </div>
                @endif
                <div class="node-name">{{ $person->pasangan->nama }}</div>
            </div>

            @include('silsilah.modal_show', ['person' => $person->pasangan])
            @else
            <button class="btn-circle btn-circle-info ms-1" data-bs-toggle="modal"
                data-bs-target="#modalPasangan{{ $person->id }}" title="Tambah Pasangan" data-testid="add-spouse-btn-{{ $person->id }}">
                <i class="fa-solid fa-heart"></i>
            </button>
            @endif
        </div>

        <div class="mt-2">
            <button class="btn-circle btn-circle-warning" data-bs-toggle="modal"
                data-bs-target="#modalAnak{{ $person->id }}" title="Tambah Anak" data-testid="add-child-btn-{{ $person->id }}">
                <i class="fa-solid fa-arrow-down"></i>
            </button>
        </div>
    </div>

    @include('silsilah.modals', ['person' => $person])
    @include('silsilah.modal_show', ['person' => $person])

    @php
    $children = $person->anak;
    if($person->pasangan && $children->isEmpty()){
        $children = $person->pasangan->anak;
    }
    @endphp

    @if($children->count() > 0)
    <ul>
        @foreach($children as $child)
            @include('silsilah.item', ['person' => $child])
        @endforeach
    </ul>
    @endif
</li>
