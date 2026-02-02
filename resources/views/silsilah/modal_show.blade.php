<div class="modal fade" id="modalShow{{ $person->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, {{ $person->jenis_kelamin == 'L' ? '#3D5A80, #4a6fa5' : '#EE6C4D, #f08a6d' }});">
                <h5 class="modal-title">
                    <i class="fa-solid fa-user me-2"></i>
                    {{ $person->nama }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-0">
                <!-- Modern Tabs -->
                <div class="nav nav-tabs nav-tabs-modern mx-3 my-3" id="tabPerson{{ $person->id }}" role="tablist">
                    <button class="nav-link active" id="detail-tab-{{ $person->id }}" data-bs-toggle="tab"
                        data-bs-target="#detail{{ $person->id }}" type="button" role="tab" data-testid="detail-tab-{{ $person->id }}">
                        <i class="fa-solid fa-info-circle me-1"></i>
                        Detail
                    </button>
                    <button class="nav-link" id="edit-tab-{{ $person->id }}" data-bs-toggle="tab"
                        data-bs-target="#edit{{ $person->id }}" type="button" role="tab" data-testid="edit-tab-{{ $person->id }}">
                        <i class="fa-solid fa-pen me-1"></i>
                        Edit
                    </button>
                </div>

                <div class="tab-content px-3 pb-3">
                    <!-- Tab Detail -->
                    <div class="tab-pane fade show active" id="detail{{ $person->id }}">
                        <div class="row g-4">
                            <div class="col-md-4 text-center">
                                <div class="profile-image-container">
                                    @if($person->foto)
                                    <img src="{{ asset('storage/'.$person->foto) }}" 
                                        class="profile-image" 
                                        alt="{{ $person->nama }}">
                                    @else
                                    <div style="
                                        width: 180px;
                                        height: 180px;
                                        border-radius: 20px;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        font-size: 4rem;
                                        color: white;
                                        margin: 0 auto;
                                        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
                                        background: linear-gradient(135deg, {{ $person->jenis_kelamin == 'L' ? '#3D5A80, #4a6fa5' : '#EE6C4D, #f08a6d' }});
                                    ">
                                        <i class="fa-solid {{ $person->jenis_kelamin == 'L' ? 'fa-mars' : 'fa-venus' }}"></i>
                                    </div>
                                    @endif
                                </div>
                                <div class="mt-3">
                                    <span class="badge badge-modern {{ $person->status == 'hidup' ? 'badge-success' : 'badge-danger' }}">
                                        <i class="fa-solid {{ $person->status == 'hidup' ? 'fa-heart-pulse' : 'fa-cross' }} me-1"></i>
                                        {{ ucfirst($person->status ?? 'hidup') }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <table class="info-table">
                                    <tr>
                                        <th><i class="fa-solid fa-user me-2" style="color: #81B29A;"></i>Nama</th>
                                        <td>{{ $person->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fa-solid fa-venus-mars me-2" style="color: #81B29A;"></i>Gender</th>
                                        <td>{{ $person->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fa-solid fa-calendar me-2" style="color: #81B29A;"></i>Tgl Lahir</th>
                                        <td>{{ $person->tgl_lahir ? \Carbon\Carbon::parse($person->tgl_lahir)->format('d F Y') : '-' }}</td>
                                    </tr>
                                    @if($person->status == 'meninggal')
                                    <tr>
                                        <th><i class="fa-solid fa-cross me-2 text-danger"></i>Tgl Wafat</th>
                                        <td class="text-danger">{{ $person->tgl_meninggal ? \Carbon\Carbon::parse($person->tgl_meninggal)->format('d F Y') : '-' }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th><i class="fa-solid fa-location-dot me-2" style="color: #81B29A;"></i>Alamat</th>
                                        <td>{{ $person->alamat ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Edit -->
                    <div class="tab-pane fade" id="edit{{ $person->id }}">
                        <form action="{{ route('silsilah.update', $person->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fa-solid fa-user me-1" style="color: #81B29A;"></i>
                                        Nama Lengkap
                                    </label>
                                    <input type="text" name="nama" value="{{ $person->nama }}" class="form-control" required data-testid="edit-nama-{{ $person->id }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fa-solid fa-venus-mars me-1" style="color: #81B29A;"></i>
                                        Jenis Kelamin
                                    </label>
                                    <select name="jenis_kelamin" class="form-select">
                                        <option value="L" {{ $person->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ $person->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fa-solid fa-calendar me-1" style="color: #81B29A;"></i>
                                        Tanggal Lahir
                                    </label>
                                    <input type="date" name="tgl_lahir" value="{{ $person->tgl_lahir }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fa-solid fa-camera me-1" style="color: #81B29A;"></i>
                                        Foto Baru
                                    </label>
                                    <input type="file" name="foto" class="form-control" accept="image/*">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fa-solid fa-heart-pulse me-1" style="color: #81B29A;"></i>
                                        Status
                                    </label>
                                    <select name="status" class="form-select"
                                        onchange="const d = document.getElementById('death_edit_{{$person->id}}'); this.value=='meninggal' ? d.classList.remove('d-none') : d.classList.add('d-none')">
                                        <option value="hidup" {{ $person->status == 'hidup' || !$person->status ? 'selected' : '' }}>Hidup</option>
                                        <option value="meninggal" {{ $person->status == 'meninggal' ? 'selected' : '' }}>Meninggal</option>
                                    </select>
                                </div>
                                <div class="col-md-6 {{ $person->status == 'meninggal' ? '' : 'd-none' }}" id="death_edit_{{$person->id}}">
                                    <label class="form-label text-danger">
                                        <i class="fa-solid fa-cross me-1"></i>
                                        Tanggal Meninggal
                                    </label>
                                    <input type="date" name="tgl_meninggal" value="{{ $person->tgl_meninggal }}" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">
                                        <i class="fa-solid fa-location-dot me-1" style="color: #81B29A;"></i>
                                        Alamat
                                    </label>
                                    <textarea name="alamat" class="form-control" rows="2">{{ $person->alamat }}</textarea>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-modern btn-modern-primary" data-testid="update-btn-{{ $person->id }}">
                                        <i class="fa-solid fa-check me-1"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal-footer justify-content-between">
                <div>
                    @auth
                    <form action="{{ route('silsilah.destroy', $person->id) }}" method="POST"
                        onsubmit="return confirm('Hapus data {{ $person->nama }}? Ini juga akan memutuskan relasi keluarga terkait.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-modern" style="background: #FEE2E2; color: #DC2626; border: 1px solid #FECACA;" data-testid="delete-btn-{{ $person->id }}">
                            <i class="fa-solid fa-trash me-1"></i> Hapus
                        </button>
                    </form>
                    @else
                    <span class="badge" style="background: #F3F4F6; color: #6B7280; padding: 0.5rem 1rem; border-radius: 10px;">
                        <i class="fa-solid fa-lock me-1"></i> Mode Read-Only
                    </span>
                    @endauth
                </div>
                <button type="button" class="btn btn-modern btn-modern-outline" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
