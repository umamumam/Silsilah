<li>
    <div class="d-inline-block">
        @if(!$person->ayah_id && !$person->ibu_id)
        <button class="btn btn-success btn-sm btn-circle mb-1" data-bs-toggle="modal"
            data-bs-target="#modalOrangTua{{ $person->id }}">↑</button>
        @endif

        <div class="node-group">
            <div id="person-node-{{ $person->id }}"
                class="node {{ $person->jenis_kelamin == 'P' ? 'female' : '' }} {{ $person->status == 'meninggal' ? 'deceased' : '' }} shadow-sm"
                data-id="{{ $person->id }}"
                data-parent="{{ $person->ayah_id ?? $person->ibu_id ?? '' }}"
                style="transition: all 0.3s ease; position: relative;">

                <button class="btn-trace" onclick="highlightJalur('{{ $person->id }}')"
                    style="position: absolute; top: 2px; left: 2px; border: none; background: rgba(0,0,0,0.1); border-radius: 50%; width: 18px; height: 18px; font-size: 9px; cursor: pointer;">
                    <i class="fa-solid fa-crosshairs"></i>
                </button>

                <div onclick="jQuery('#modalShow{{ $person->id }}').modal('show')" style="cursor: pointer; padding-top: 5px;">
                    @if($person->foto)
                    <img src="{{ asset('storage/' . $person->foto) }}" alt="foto">
                    @endif
                    <div class="fw-bold" style="font-size: 13px;">{{ $person->nama }}</div>
                    {{-- <div class="text-muted" style="font-size: 10px;">{{ $person->tgl_lahir ?? '-' }}</div> --}}
                </div>
            </div>

            @if($person->pasangan)
            <div class="connector-spouse"></div>
            <div id="person-node-{{ $person->pasangan->id }}"
                class="node {{ $person->pasangan->jenis_kelamin == 'P' ? 'female' : '' }} {{ $person->pasangan->status == 'meninggal' ? 'deceased' : '' }} shadow-sm"
                data-id="{{ $person->pasangan->id }}"
                data-parent=""
                style="cursor: pointer; transition: all 0.3s ease;"
                data-bs-toggle="modal" data-bs-target="#modalShow{{ $person->pasangan->id }}">

                @if($person->pasangan->foto)
                <img src="{{ asset('storage/' . $person->pasangan->foto) }}" alt="foto">
                @endif
                <div class="fw-bold" style="font-size: 13px;">{{ $person->pasangan->nama }}</div>
                {{-- <div class="text-muted" style="font-size: 10px;">{{ $person->pasangan->tgl_lahir ?? '-' }}</div> --}}
            </div>

            @include('silsilah.modal_show', ['person' => $person->pasangan])
            @else
            <button class="btn btn-info btn-sm btn-circle ms-1 text-white" data-bs-toggle="modal"
                data-bs-target="#modalPasangan{{ $person->id }}">↔</button>
            @endif
        </div>

        <div class="mt-2">
            <button class="btn btn-warning btn-sm btn-circle" data-bs-toggle="modal"
                data-bs-target="#modalAnak{{ $person->id }}">↓</button>
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
