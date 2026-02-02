<div class="modal fade" id="modalShow{{ $person->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Profil: {{ $person->nama }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="nav nav-tabs mb-3" id="tabPerson{{ $person->id }}" role="tablist">
                    <button class="nav-link active" id="detail-tab-{{ $person->id }}" data-bs-toggle="tab"
                        data-bs-target="#detail{{ $person->id }}" type="button" role="tab">
                        Detail Informasi
                    </button>

                    <button class="nav-link" id="edit-tab-{{ $person->id }}" data-bs-toggle="tab"
                        data-bs-target="#edit{{ $person->id }}" type="button" role="tab">
                        Edit Data
                    </button>
                </div>


                <div class="tab-content">
                    <div class="tab-pane fade show active" id="detail{{ $person->id }}">
                        <div class="row">
                            <div class="col-md-4 text-center mb-3">
                                <img src="{{ $person->foto ? asset('storage/'.$person->foto) : 'https://via.placeholder.com/150' }}"
                                    class="img-fluid rounded shadow-sm border"
                                    style="max-height: 250px; object-fit: cover;">
                            </div>
                            <div class="col-md-8">
                                <table class="table table-sm">
                                    <tr>
                                        <th width="30%">Nama</th>
                                        <td>: {{ $person->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>Gender</th>
                                        <td>: {{ $person->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tgl Lahir</th>
                                        <td>: {{ $person->tgl_lahir ? \Carbon\Carbon::parse($person->tgl_lahir)->format('d M Y') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>:
                                            <span
                                                class="badge {{ $person->status == 'hidup' ? 'bg-success' : 'bg-danger' }}">
                                                {{ ucfirst($person->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @if($person->status == 'meninggal')
                                    <tr>
                                        <th class="text-danger">Tgl Wafat</th>
                                        <td>: {{ $person->tgl_meninggal ?
                                            \Carbon\Carbon::parse($person->tgl_meninggal)->format('d M Y') : '-' }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th>Alamat</th>
                                        <td>: {{ $person->alamat ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="edit{{ $person->id }}">
                        <form action="{{ route('silsilah.update', $person->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row text-start">
                                <div class="col-md-6 mb-2">
                                    <label class="small fw-bold">Nama Lengkap</label>
                                    <input type="text" name="nama" value="{{ $person->nama }}" class="form-control"
                                        required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="small fw-bold">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control">
                                        <option value="L" {{ $person->jenis_kelamin == 'L' ? 'selected' : ''
                                            }}>Laki-laki</option>
                                        <option value="P" {{ $person->jenis_kelamin == 'P' ? 'selected' : ''
                                            }}>Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="small fw-bold">Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir" value="{{ $person->tgl_lahir }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="small fw-bold">Foto Baru (Opsional)</label>
                                    <input type="file" name="foto" class="form-control">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="small fw-bold">Status</label>
                                    <select name="status" class="form-control shadow-sm"
                                        onchange="const d = document.getElementById('death_edit_{{$person->id}}'); this.value=='meninggal' ? d.classList.remove('d-none') : d.classList.add('d-none')">
                                        <option value="hidup" {{ $person->status == 'hidup' ? 'selected' : '' }}>Hidup
                                        </option>
                                        <option value="meninggal" {{ $person->status == 'meninggal' ? 'selected' : ''
                                            }}>Meninggal</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2 {{ $person->status == 'meninggal' ? '' : 'd-none' }}"
                                    id="death_edit_{{$person->id}}">
                                    <label class="small fw-bold text-danger">Tanggal Meninggal</label>
                                    <input type="date" name="tgl_meninggal" value="{{ $person->tgl_meninggal }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label class="small fw-bold">Alamat</label>
                                    <textarea name="alamat" class="form-control"
                                        rows="2">{{ $person->alamat }}</textarea>
                                </div>
                            </div>
                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal-footer justify-content-between bg-light">
                <div>
                    @auth
                    {{-- HANYA MUNCUL JIKA LOGIN (BREEZE) --}}
                    <form action="{{ route('silsilah.destroy', $person->id) }}" method="POST"
                        onsubmit="return confirm('Hapus data {{ $person->nama }}? Ini juga akan memutuskan relasi keluarga terkait.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">Hapus Permanen</button>
                    </form>
                    @else
                    <span class="badge bg-secondary">Mode Read-Only</span>
                    @endauth
                </div>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
