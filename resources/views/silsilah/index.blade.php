@extends('layouts.silsilah')

@section('content')
<div class="mb-4 text-center" style="margin-top: 10px;">
    <div class="d-inline-flex gap-3 align-items-center">
        <button class="btn btn-primary px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahAwal">
            <i class="fa-solid fa-user-plus me-1"></i>
            Tambah Orang Pertama
        </button>

        <div class="input-group shadow-sm" style="width: 450px;">
            <input type="text" id="inputCari" class="form-control" placeholder="Cari nama keluarga...">

            <button class="btn btn-outline-primary" type="button" onclick="jalankanCari()">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>

            <button class="btn btn-secondary ms-1" type="button" onclick="resetHighlight()" title="Reset Tampilan">
                <i class="fa-solid fa-rotate-left"></i>
            </button>

            <button class="btn btn-danger ms-2" type="button" onclick="exportSilsilah()">
                <i class="fa-solid fa-file-image me-1"></i>
                Export Gambar
            </button>
        </div>
    </div>
</div>

<div class="tree-container">
    <div class="tree">
        <div id="judul-export" style="display: none; text-align: center; margin-bottom: 30px;">
            <h1 style="font-family: Arial, sans-serif; font-weight: bold; color: #333;">
                Silsilah Keluarga Besar Mbah Buyut Abdul Jalil - Karmiji
            </h1>
            <hr style="width: 50%; margin: 10px auto; border: 1px solid #ccc;">
        </div>

        <ul>
            @foreach($roots as $person)
                @include('silsilah.item', ['person' => $person])
            @endforeach
        </ul>
    </div>
</div>

<div class="modal fade" id="modalTambahAwal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('silsilah.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5>Tambah Data Awal</h5>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label>Foto</label>
                        <input type="file" name="foto" class="form-control">
                    </div>
                </div>
                <div class="mb-2">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" class="form-control">
                </div>
                <div class="mb-2">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    function jalankanCari() {
        const kataKunci = document.getElementById('inputCari').value.toLowerCase().trim();
        const semuaNode = document.querySelectorAll('.node');
        let ditemukan = false;

        semuaNode.forEach(node => {
            node.style.boxShadow = "";
            node.style.transform = "scale(1)";
            node.style.borderWidth = "2px";
            node.style.borderColor = "";
            node.style.opacity = "1";
        });

        if (kataKunci === "") return;

        semuaNode.forEach(node => {
            const nama = node.querySelector('.fw-bold').innerText.toLowerCase();

            if (nama.includes(kataKunci)) {
                node.style.boxShadow = "0 0 20px 5px #ffc107";
                node.style.transform = "scale(1.1)";
                node.style.borderWidth = "4px";
                node.style.borderColor = "#ffc107";
                node.style.zIndex = "100";

                if (!ditemukan) {
                    node.scrollIntoView({ behavior: 'smooth', block: 'center', inline: 'center' });
                    ditemukan = true;
                }
            } else {
                node.style.opacity = "0.2";
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

        if (targetNode.classList.contains('active-trace')) {
            resetHighlight();
            return;
        }

        semuaNode.forEach(node => {
            node.classList.remove('active-trace');
            node.style.opacity = "0.15";
            node.style.filter = "grayscale(100%)";
        });

        let currentId = personId;
        while (currentId) {
            const node = document.querySelector(`.node[data-id="${currentId}"]`);
            if (node) {
                node.classList.add('active-trace');
                node.style.opacity = "1";
                node.style.filter = "grayscale(0%)";
                node.style.borderColor = "#0d6efd";
                node.style.boxShadow = "0 0 20px rgba(13, 110, 253, 0.6)";
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
            node.style.transform = "scale(1)";
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

        // Sembunyikan semua tombol navigasi dan ikon lacak sebelum capture
        judul.style.display = 'block';
        const elementsToHide = document.querySelectorAll('.btn-circle, .btn-trace, .node img');
        elementsToHide.forEach(el => el.style.display = 'none');

        html2canvas(tree, {
            scale: 2,
            useCORS: true,
            backgroundColor: "#ffffff"
        }).then(canvas => {
            const link = document.createElement('a');
            link.download = 'Silsilah-AbdulJalil-Karmiji.png';
            link.href = canvas.toDataURL("image/png");
            link.click();

            // Tampilkan kembali elemen setelah capture selesai
            judul.style.display = 'none';
            elementsToHide.forEach(el => el.style.display = '');
        });
    }
</script>
@endpush
@endsection
