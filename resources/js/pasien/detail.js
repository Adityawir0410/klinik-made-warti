document.addEventListener('DOMContentLoaded', function () {
    const pasienId = window.pasienId; // ambil dari global window
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    window.openTambahModal = function () {
        document.getElementById("modalTambah").style.display = "block";
    };

    window.closeTambahModal = function () {
        document.getElementById("modalTambah").style.display = "none";
        document.getElementById("formTambah").reset();
    };

    window.openEditModal = function (id, tanggal, keluhan, biaya) {
        document.getElementById("editId").value = id;
        document.getElementById("editTanggal").value = tanggal;
        document.getElementById("editKeluhan").value = keluhan;
        document.getElementById("editBiaya").value = biaya;
        document.getElementById("modalEdit").style.display = "block";
    };

    window.closeEditModal = function () {
        document.getElementById("modalEdit").style.display = "none";
    };

    document.getElementById("formTambah").addEventListener("submit", function (e) {
        e.preventDefault();
        const form = e.target;

        fetch(`/rekam-medis/${pasienId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                tanggal_kunjungan: form.tanggal_kunjungan.value,
                keluhan: form.keluhan.value,
                biaya: form.biaya.value
            })
        }).then(res => res.json())
        .then(data => {
            if (data.success) {
                const r = data.rekam;
                const row = `
                    <tr id="row-${r.id_rekam}">
                        <td>${r.tanggal_kunjungan}</td>
                        <td>${r.keluhan}</td>
                        <td>${parseInt(r.biaya).toLocaleString()}</td>
                        <td>
                            <button onclick="openEditModal('${r.id_rekam}', '${r.tanggal_kunjungan}', \`${r.keluhan}\`, '${r.biaya}')">Edit</button> |
                            <button onclick="hapusRekam('${r.id_rekam}')">Hapus</button>
                        </td>
                    </tr>`;
                document.querySelector("#tabelRekam tbody").insertAdjacentHTML('beforeend', row);
                closeTambahModal();
            }
        });
    });

    document.getElementById("formEdit").addEventListener("submit", function (e) {
        e.preventDefault();
        const id = document.getElementById("editId").value;
        const form = e.target;

        fetch(`/rekam-medis/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'X-HTTP-Method-Override': 'PUT'
            },
            body: JSON.stringify({
                tanggal_kunjungan: form.tanggal_kunjungan.value,
                keluhan: form.keluhan.value,
                biaya: form.biaya.value
            })
        }).then(res => res.json())
        .then(data => {
            if (data.success) {
                const row = document.getElementById("row-" + id);
                row.innerHTML = `
                    <td>${form.tanggal_kunjungan.value}</td>
                    <td>${form.keluhan.value}</td>
                    <td>${parseInt(form.biaya.value).toLocaleString()}</td>
                    <td>
                        <button onclick="openEditModal('${id}', '${form.tanggal_kunjungan.value}', \`${form.keluhan.value}\`, '${form.biaya.value}')">Edit</button> |
                        <button onclick="hapusRekam('${id}')">Hapus</button>
                    </td>`;
                closeEditModal();
            }
        });
    });

    window.hapusRekam = function (id) {
        if (!confirm("Yakin hapus data?")) return;

        fetch(`/rekam-medis/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-HTTP-Method-Override': 'DELETE',
                'Content-Type': 'application/json'
            }
        }).then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById("row-" + id).remove();
            } else {
                alert("Gagal menghapus data.");
            }
        });
    }
});
