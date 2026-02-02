{{-- Modal Orang Tua --}}
<div class="modal fade" id="modalOrangTua{{ $person->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="{{ route('silsilah.tambahOrangTua', $person->id) }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa-solid fa-users me-2"></i>
                    Tambah Orang Tua untuk {{ $person->nama }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <!-- Data Ayah -->
                    <div class="col-md-6">
                        <div class="section-header">
                            <i class="fa-solid fa-mars"></i>
                            <h6>Data Ayah</h6>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Ayah</label>
                            <input type="text" name="nama_ayah" class="form-control" placeholder="Masukkan nama ayah..." required data-testid="nama-ayah-input-{{ $person->id }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tgl_lahir_ayah" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Foto Ayah</label>
                            <input type="file" name="foto_ayah" class="form-control" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status_ayah" class="form-select" onchange="const d = document.getElementById('death_ayah_{{$person->id}}'); this.value=='meninggal' ? d.classList.remove('d-none') : d.classList.add('d-none')">
                                <option value="hidup">Hidup</option>
                                <option value="meninggal">Meninggal</option>
                            </select>
                        </div>
                        <div id="death_ayah_{{$person->id}}" class="d-none mb-3">
                            <label class="form-label text-danger">
                                <i class="fa-solid fa-cross me-1"></i>
                                Tanggal Meninggal
                            </label>
                            <input type="date" name="tgl_meninggal_ayah" class="form-control">
                        </div>
                    </div>
                    
                    <!-- Data Ibu -->
                    <div class="col-md-6">
                        <div class="section-header">
                            <i class="fa-solid fa-venus"></i>
                            <h6>Data Ibu</h6>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Ibu</label>
                            <input type="text" name="nama_ibu" class="form-control" placeholder="Masukkan nama ibu..." required data-testid="nama-ibu-input-{{ $person->id }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tgl_lahir_ibu" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Foto Ibu</label>
                            <input type="file" name="foto_ibu" class="form-control" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status_ibu" class="form-select" onchange="const d = document.getElementById('death_ibu_{{$person->id}}'); this.value=='meninggal' ? d.classList.remove('d-none') : d.classList.add('d-none')">
                                <option value="hidup">Hidup</option>
                                <option value="meninggal">Meninggal</option>
                            </select>
                        </div>
                        <div id="death_ibu_{{$person->id}}" class="d-none mb-3">
                            <label class="form-label text-danger">
                                <i class="fa-solid fa-cross me-1"></i>
                                Tanggal Meninggal
                            </label>
                            <input type="date" name="tgl_meninggal_ibu" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-modern btn-modern-outline" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark me-1"></i> Batal
                </button>
                <button type="submit" class="btn btn-modern btn-modern-primary" data-testid="simpan-ortu-btn-{{ $person->id }}">
                    <i class="fa-solid fa-check me-1"></i> Simpan Orang Tua
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Pasangan --}}
<div class="modal fade" id="modalPasangan{{ $person->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="{{ route('silsilah.tambahPasangan', $person->id) }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header" style="background: linear-gradient(135deg, #5DADE2, #3498DB);">
                <h5 class="modal-title">
                    <i class="fa-solid fa-heart me-2"></i>
                    Tambah Pasangan untuk {{ $person->nama }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="section-header">
                            <i class="fa-solid fa-id-card"></i>
                            <h6>Identitas</h6>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Pasangan</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama pasangan..." required data-testid="nama-pasangan-input-{{ $person->id }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tgl_lahir" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Foto</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="section-header">
                            <i class="fa-solid fa-info-circle"></i>
                            <h6>Status & Lokasi</h6>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" onchange="const d = document.getElementById('death_p_{{$person->id}}'); this.value=='meninggal' ? d.classList.remove('d-none') : d.classList.add('d-none')">
                                <option value="hidup">Hidup</option>
                                <option value="meninggal">Meninggal</option>
                            </select>
                        </div>
                        <div id="death_p_{{$person->id}}" class="d-none mb-3">
                            <label class="form-label text-danger">
                                <i class="fa-solid fa-cross me-1"></i>
                                Tanggal Meninggal
                            </label>
                            <input type="date" name="tgl_meninggal" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" placeholder="Masukkan alamat..." rows="4"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-modern btn-modern-outline" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark me-1"></i> Batal
                </button>
                <button type="submit" class="btn btn-modern" style="background: linear-gradient(135deg, #5DADE2, #3498DB); color: white;" data-testid="simpan-pasangan-btn-{{ $person->id }}">
                    <i class="fa-solid fa-heart me-1"></i> Simpan Pasangan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Anak --}}
<div class="modal fade" id="modalAnak{{ $person->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="{{ route('silsilah.tambahAnak', $person->id) }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header" style="background: linear-gradient(135deg, #F5B041, #E67E22);">
                <h5 class="modal-title">
                    <i class="fa-solid fa-baby me-2"></i>
                    Tambah Anak dari {{ $person->nama }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert" style="background: #FFF5E6; border: 1px solid #F5B041; border-radius: 12px; color: #9A5C0F;">
                    <i class="fa-solid fa-info-circle me-2"></i>
                    <small>Jika belum memiliki pasangan, sistem akan otomatis membuat data pasangan.</small>
                </div>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="section-header">
                            <i class="fa-solid fa-child"></i>
                            <h6>Data Diri</h6>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Anak</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama anak..." required data-testid="nama-anak-input-{{ $person->id }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tgl_lahir" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Foto</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="section-header">
                            <i class="fa-solid fa-clipboard-list"></i>
                            <h6>Informasi Tambahan</h6>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" onchange="const d = document.getElementById('death_a_{{$person->id}}'); this.value=='meninggal' ? d.classList.remove('d-none') : d.classList.add('d-none')">
                                <option value="hidup">Hidup</option>
                                <option value="meninggal">Meninggal</option>
                            </select>
                        </div>
                        <div id="death_a_{{$person->id}}" class="d-none mb-3">
                            <label class="form-label text-danger">
                                <i class="fa-solid fa-cross me-1"></i>
                                Tanggal Meninggal
                            </label>
                            <input type="date" name="tgl_meninggal" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" placeholder="Masukkan alamat..." rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-modern btn-modern-outline" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark me-1"></i> Batal
                </button>
                <button type="submit" class="btn btn-modern" style="background: linear-gradient(135deg, #F5B041, #E67E22); color: white;" data-testid="simpan-anak-btn-{{ $person->id }}">
                    <i class="fa-solid fa-child me-1"></i> Simpan Anak
                </button>
            </div>
        </form>
    </div>
</div>
