@extends('layouts.silsilah')

@section('content')
<!-- Floating Toolbar -->
<div class="floating-toolbar" style="
    position: fixed;
    top: 85px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 100;
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
    justify-content: center;
    padding: 0.75rem 1rem;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(234, 230, 216, 0.5);
    max-width: 95%;
">
    <button class="btn btn-modern btn-modern-primary" data-bs-toggle="modal" data-bs-target="#modalTambahAwal" data-testid="add-first-person-btn">
        <i class="fa-solid fa-user-plus me-2"></i>
        <span class="d-none d-sm-inline">Tambah Orang Pertama</span>
        <span class="d-sm-none">Tambah</span>
    </button>

    <div class="input-group" style="width: auto; min-width: 200px; max-width: 350px;">
        <input type="text" id="inputCari" class="form-control" placeholder="Cari nama..." style="border-radius: 12px 0 0 12px;" data-testid="search-input">
        <button class="btn btn-modern-primary" type="button" onclick="jalankanCari()" style="border-radius: 0; padding: 0 1rem;" data-testid="search-btn">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
        <button class="btn btn-modern-outline" type="button" onclick="resetHighlight()" title="Reset" style="border-radius: 0 12px 12px 0; padding: 0 0.75rem;" data-testid="reset-btn">
            <i class="fa-solid fa-rotate-left"></i>
        </button>
    </div>

    <button class="btn btn-modern btn-modern-secondary" type="button" onclick="exportSilsilah()" data-testid="export-btn">
        <i class="fa-solid fa-download me-1"></i>
        <span class="d-none d-sm-inline">Export</span>
    </button>
</div>

<!-- Tree Container -->
<div class="tree-container" style="padding-top: 100px;">
    <div class="tree">
        <div id="judul-export" style="display: none; text-align: center; margin-bottom: 30px; padding: 20px;">
            <h1 style="font-family: 'Fraunces', serif; font-weight: bold; color: #3D405B; font-size: 2rem;">
                Silsilah Keluarga Besar Mbah Buyut Abdul Jalil - Karmiji
            </h1>
            <div style="width: 120px; height: 4px; background: linear-gradient(90deg, #81B29A, #E07A5F); margin: 15px auto; border-radius: 2px;"></div>
        </div>

        <ul>
            @foreach($roots as $person)
                @include('silsilah.item', ['person' => $person])
            @endforeach
        </ul>
        
        @if($roots->isEmpty())
        <div style="text-align: center; padding: 4rem 2rem;">
            <div style="
                width: 100px;
                height: 100px;
                background: linear-gradient(135deg, #81B29A, #6D9A84);
                border-radius: 24px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 1.5rem;
                font-size: 2.5rem;
                color: white;
                box-shadow: 0 8px 24px rgba(129, 178, 154, 0.3);
            ">
                <i class="fa-solid fa-tree"></i>
            </div>
            <h3 style="font-family: 'Fraunces', serif; color: #3D405B; margin-bottom: 0.75rem;">Mulai Silsilah Keluarga Anda</h3>
            <p style="color: #8D909B; max-width: 400px; margin: 0 auto 1.5rem;">
                Klik tombol "Tambah Orang Pertama" untuk memulai membuat pohon silsilah keluarga Anda.
            </p>
            <button class="btn btn-modern btn-modern-primary" data-bs-toggle="modal" data-bs-target="#modalTambahAwal" data-testid="add-first-person-empty-btn">
                <i class="fa-solid fa-user-plus me-2"></i>
                Tambah Orang Pertama
            </button>
        </div>
        @endif
    </div>
</div>

<!-- Modal Tambah Awal -->
<div class="modal fade" id="modalTambahAwal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="{{ route('silsilah.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa-solid fa-user-plus me-2"></i>
                    Tambah Anggota Keluarga Pertama
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">
                            <i class="fa-solid fa-user me-1" style="color: #81B29A;"></i>
                            Nama Lengkap
                        </label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap..." required data-testid="nama-input">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fa-solid fa-venus-mars me-1" style="color: #81B29A;"></i>
                            Jenis Kelamin
                        </label>
                        <select name="jenis_kelamin" class="form-select" data-testid="gender-select">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fa-solid fa-camera me-1" style="color: #81B29A;"></i>
                            Foto (Opsional)
                        </label>
                        <input type="file" name="foto" class="form-control" accept="image/*" data-testid="foto-input">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fa-solid fa-calendar me-1" style="color: #81B29A;"></i>
                            Tanggal Lahir
                        </label>
                        <input type="date" name="tgl_lahir" class="form-control" data-testid="tgl-lahir-input">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fa-solid fa-heart-pulse me-1" style="color: #81B29A;"></i>
                            Status
                        </label>
                        <select name="status" class="form-select" id="statusAwal" onchange="toggleDeathDateAwal()" data-testid="status-select">
                            <option value="hidup">Hidup</option>
                            <option value="meninggal">Meninggal</option>
                        </select>
                    </div>
                    <div class="col-md-6 d-none" id="deathDateAwal">
                        <label class="form-label text-danger">
                            <i class="fa-solid fa-cross me-1"></i>
                            Tanggal Meninggal
                        </label>
                        <input type="date" name="tgl_meninggal" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label">
                            <i class="fa-solid fa-location-dot me-1" style="color: #81B29A;"></i>
                            Alamat
                        </label>
                        <textarea name="alamat" class="form-control" rows="2" placeholder="Masukkan alamat..." data-testid="alamat-input"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-modern btn-modern-outline" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark me-1"></i> Batal
                </button>
                <button type="submit" class="btn btn-modern btn-modern-primary" data-testid="simpan-btn">
                    <i class="fa-solid fa-check me-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function toggleDeathDateAwal() {
        const status = document.getElementById('statusAwal').value;
        const deathDate = document.getElementById('deathDateAwal');
        if (status === 'meninggal') {
            deathDate.classList.remove('d-none');
        } else {
            deathDate.classList.add('d-none');
        }
    }

    function jalankanCari() {
        const kataKunci = document.getElementById('inputCari').value.toLowerCase().trim();
        const semuaNode = document.querySelectorAll('.node');
        let ditemukan = false;

        semuaNode.forEach(node => {
            node.style.boxShadow = "";
            node.style.transform = "";
            node.style.borderWidth = "2px";
            node.style.borderColor = "";
            node.style.opacity = "1";
        });

        if (kataKunci === "") return;

        semuaNode.forEach(node => {
            const namaEl = node.querySelector('.node-name');
            if (!namaEl) return;
            const nama = namaEl.innerText.toLowerCase();

            if (nama.includes(kataKunci)) {
                node.style.boxShadow = "0 0 0 4px rgba(129, 178, 154, 0.4), 0 10px 30px rgba(129, 178, 154, 0.3)";
                node.style.transform = "scale(1.08)";
                node.style.borderWidth = "3px";
                node.style.borderColor = "#81B29A";
                node.style.zIndex = "100";

                if (!ditemukan) {
                    node.scrollIntoView({ behavior: 'smooth', block: 'center', inline: 'center' });
                    ditemukan = true;
                }
            } else {
                node.style.opacity = "0.25";
            }
        });

        if (!ditemukan) {
            alert("Nama tidak ditemukan");
            resetHighlight();
        }
    }

    function highlightJalur(personId) {
        event.stopPropagation();
        const semuaNode = document.querySelectorAll('.node');
        const targetNode = document.querySelector(`.node[data-id="${personId}"]`);

        if (targetNode && targetNode.classList.contains('active-trace')) {
            resetHighlight();
            return;
        }

        semuaNode.forEach(node => {
            node.classList.remove('active-trace');
            node.style.opacity = "0.2";
            node.style.filter = "grayscale(80%)";
        });

        let currentId = personId;
        while (currentId) {
            const node = document.querySelector(`.node[data-id="${currentId}"]`);
            if (node) {
                node.classList.add('active-trace');
                node.style.opacity = "1";
                node.style.filter = "grayscale(0%)";
                currentId = node.getAttribute('data-parent');
            } else {
                currentId = null;
            }
        }
    }

    function resetHighlight() {
        const semuaNode = document.querySelectorAll('.node');
        semuaNode.forEach(node => {
            node.classList.remove('active-trace');
            node.style.opacity = "1";
            node.style.filter = "grayscale(0%)";
            node.style.transform = "";
            node.style.borderWidth = "2px";
            node.style.borderColor = "";
            node.style.boxShadow = "";
            node.style.zIndex = "10";
        });
        document.getElementById('inputCari').value = "";
    }

    document.getElementById('inputCari').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') jalankanCari();
    });

    function exportSilsilah() {
        const tree = document.querySelector('.tree');
        const judul = document.getElementById('judul-export');
        const toolbar = document.querySelector('.floating-toolbar');

        // Hide toolbar and show title
        toolbar.style.display = 'none';
        judul.style.display = 'block';
        
        // Hide action buttons
        const elementsToHide = document.querySelectorAll('.btn-circle, .btn-trace');
        elementsToHide.forEach(el => el.style.display = 'none');

        html2canvas(tree, {
            scale: 2,
            useCORS: true,
            backgroundColor: "#FDFBF7",
            logging: false
        }).then(canvas => {
            const link = document.createElement('a');
            link.download = 'Silsilah-Keluarga.png';
            link.href = canvas.toDataURL("image/png");
            link.click();

            // Restore visibility
            toolbar.style.display = 'flex';
            judul.style.display = 'none';
            elementsToHide.forEach(el => el.style.display = '');
        });
    }

    // Add staggered animation to nodes
    document.addEventListener('DOMContentLoaded', function() {
        const nodes = document.querySelectorAll('.node');
        nodes.forEach((node, index) => {
            node.style.animationDelay = `${index * 0.05}s`;
        });
    });
</script>
@endpush
@endsection
