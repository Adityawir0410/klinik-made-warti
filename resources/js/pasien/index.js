document.addEventListener('DOMContentLoaded', function () {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.getElementById('formTambah').addEventListener('submit', function (e) {
        e.preventDefault();
        const form = e.target;
        fetch('/pasien', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
            },
            body: new FormData(form)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const p = data.pasien;
                const row = `
                    <tr id="row-${p.id_pasien}">
                        <td>${p.nama_pasien}</td>
                        <td>${p.alamat_pasien}</td>
                        <td>${p.created_at.substring(0,10)}</td>
                        <td>
                            <button onclick="openEditModal(${p.id_pasien}, '${p.nama_pasien}', '${p.alamat_pasien}', '${p.created_at.substring(0,10)}')">Edit</button>
                            <button onclick="hapusPasien(${p.id_pasien})">Hapus</button>
                        </td>
                    </tr>`;
                document.querySelector('#tabelPasien tbody').insertAdjacentHTML('beforeend', row);
                form.reset();
                closeTambahModal();
            }
        });
    });

    document.getElementById('formEdit').addEventListener('submit', function (e) {
        e.preventDefault();
        const form = e.target;
        const id = document.getElementById('editId').value;

        fetch(`/pasien/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'X-HTTP-Method-Override': 'PUT'
            },
            body: new FormData(form)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const p = data.pasien;
                const row = document.querySelector(`#row-${id}`);
                row.innerHTML = `
                    <td>${p.nama_pasien}</td>
                    <td>${p.alamat_pasien}</td>
                    <td>${p.created_at.substring(0,10)}</td>
                    <td>
                        <button onclick="openEditModal(${p.id_pasien}, '${p.nama_pasien}', '${p.alamat_pasien}', '${p.created_at.substring(0,10)}')">Edit</button>
                        <button onclick="hapusPasien(${p.id_pasien})">Hapus</button>
                    </td>`;
                closeEditModal();
            }
        });
    });
});

function openTambahModal() {
    document.getElementById('modalTambah').style.display = 'block';
}
function closeTambahModal() {
    document.getElementById('modalTambah').style.display = 'none';
}
function openEditModal(id, nama, alamat, tanggal) {
    document.getElementById('editId').value = id;
    document.getElementById('editNama').value = nama;
    document.getElementById('editAlamat').value = alamat;
    document.getElementById('editTanggal').value = tanggal;
    document.getElementById('modalEdit').style.display = 'block';
}
function closeEditModal() {
    document.getElementById('modalEdit').style.display = 'none';
}
function hapusPasien(id) {
    if (!confirm("Yakin ingin hapus pasien ini?")) return;

    fetch(`/pasien/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-HTTP-Method-Override': 'DELETE',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`row-${id}`).remove();
        }
    });
}
