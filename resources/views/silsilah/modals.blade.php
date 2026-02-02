{{-- Modal Orang Tua --}}
<div class="modal fade" id="modalOrangTua{{ $person->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('silsilah.tambahOrangTua', $person->id) }}" method="POST" enctype="multipart/form-data" class="modal-content text-start">
            @csrf
            <div class="modal-header">
                <h5>Tambah Orang Tua untuk {{ $person->nama }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <div class="col-md-6 border-end">
                    <h6>Data Ayah</h6>
                    <input type="text" name="nama_ayah" class="form-control mb-2" placeholder="Nama Ayah" required>
                    <input type="date" name="tgl_lahir_ayah" class="form-control mb-2">
                    <input type="file" name="foto_ayah" class="form-control mb-2">
                    <select name="status_ayah" class="form-control mb-2" onchange="const d = document.getElementById('death_ayah_{{$person->id}}'); this.value=='meninggal' ? d.classList.remove('d-none') : d.classList.add('d-none')">
                        <option value="hidup">Hidup</option>
                        <option value="meninggal">Meninggal</option>
                    </select>
                    <div id="death_ayah_{{$person->id}}" class="d-none mb-2">
                        <label class="small text-danger">Tanggal Meninggal Ayah</label>
                        <input type="date" name="tgl_meninggal_ayah" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <h6>Data Ibu</h6>
                    <input type="text" name="nama_ibu" class="form-control mb-2" placeholder="Nama Ibu" required>
                    <input type="date" name="tgl_lahir_ibu" class="form-control mb-2">
                    <input type="file" name="foto_ibu" class="form-control mb-2">
                    <select name="status_ibu" class="form-control mb-2" onchange="const d = document.getElementById('death_ibu_{{$person->id}}'); this.value=='meninggal' ? d.classList.remove('d-none') : d.classList.add('d-none')">
                        <option value="hidup">Hidup</option>
                        <option value="meninggal">Meninggal</option>
                    </select>
                    <div id="death_ibu_{{$person->id}}" class="d-none mb-2">
                        <label class="small text-danger">Tanggal Meninggal Ibu</label>
                        <input type="date" name="tgl_meninggal_ibu" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success text-white">Simpan Orang Tua</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Pasangan --}}
<div class="modal fade" id="modalPasangan{{ $person->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('silsilah.tambahPasangan', $person->id) }}" method="POST" enctype="multipart/form-data" class="modal-content text-start">
            @csrf
            <div class="modal-header">
                <h5>Tambah Pasangan {{ $person->nama }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <div class="col-md-6 border-end">
                    <label class="small fw-bold">Identitas</label>
                    <input type="text" name="nama" class="form-control mb-2" placeholder="Nama Pasangan" required>
                    <label class="small">Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" class="form-control mb-2">
                    <label class="small">Foto Pasangan</label>
                    <input type="file" name="foto" class="form-control mb-2">
                </div>
                <div class="col-md-6">
                    <label class="small fw-bold">Status & Lokasi</label>
                    <select name="status" class="form-control mb-2 shadow-sm" onchange="const d = document.getElementById('death_p_{{$person->id}}'); this.value=='meninggal' ? d.classList.remove('d-none') : d.classList.add('d-none')">
                        <option value="hidup">Hidup</option>
                        <option value="meninggal">Meninggal</option>
                    </select>
                    <div id="death_p_{{$person->id}}" class="d-none mb-2">
                        <label class="small text-danger">Tanggal Meninggal</label>
                        <input type="date" name="tgl_meninggal" class="form-control">
                    </div>
                    <textarea name="alamat" class="form-control mb-2" placeholder="Alamat Pasangan" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-info text-white">Simpan Pasangan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Anak --}}
<div class="modal fade" id="modalAnak{{ $person->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('silsilah.tambahAnak', $person->id) }}" method="POST" enctype="multipart/form-data" class="modal-content text-start">
            @csrf
            <div class="modal-header">
                <h5>Tambah Anak dari {{ $person->nama }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="small text-danger mb-3">*Jika belum memiliki pasangan, sistem otomatis membuat data pasangan.</p>
                <div class="row">
                    <div class="col-md-6 border-end">
                        <label class="small fw-bold">Data Diri</label>
                        <input type="text" name="nama" class="form-control mb-2" placeholder="Nama Anak" required>
                        <select name="jenis_kelamin" class="form-control mb-2">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                        <label class="small">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" class="form-control mb-2">
                        <label class="small">Foto Anak</label>
                        <input type="file" name="foto" class="form-control mb-2">
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold">Informasi Tambahan</label>
                        <select name="status" class="form-control mb-2 shadow-sm" onchange="const d = document.getElementById('death_a_{{$person->id}}'); this.value=='meninggal' ? d.classList.remove('d-none') : d.classList.add('d-none')">
                            <option value="hidup">Hidup</option>
                            <option value="meninggal">Meninggal</option>
                        </select>
                        <div id="death_a_{{$person->id}}" class="d-none mb-2">
                            <label class="small text-danger">Tanggal Meninggal</label>
                            <input type="date" name="tgl_meninggal" class="form-control">
                        </div>
                        <textarea name="alamat" class="form-control mb-2" placeholder="Alamat Anak" rows="4"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning text-white">Simpan Anak</button>
            </div>
        </form>
    </div>
</div>
