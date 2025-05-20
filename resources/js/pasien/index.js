document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Modal
    window.openModal = () => document.getElementById("modal").style.display = "block";
    window.closeModal = () => {
        document.getElementById("modal").style.display = "none";
        document.getElementById("formTambah").reset();
    };

    window.openEditModal = (id, nama, tanggal, alamat) => {
        document.getElementById("editId").value = id;
        document.getElementById("editNamaPasien").value = nama;
        document.getElementById("editTanggalDaftar").value = tanggal;
        document.getElementById("editAlamatPasien").value = alamat;
        document.getElementById("modalEdit").style.display = "block";
    };

    window.closeEditModal = () => {
        document.getElementById("modalEdit").style.display = "none";
    };

    // Tambah Pasien
    document.getElementById("formTambah").addEventListener("submit", function (e) {
        e.preventDefault();
        const form = e.target;

        fetch('/pasien', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                nama_pasien: form.nama_pasien.value,
                tanggal_daftar: form.tanggal_daftar.value,
                alamat_pasien: form.alamat_pasien.value,
            })
        }).then(res => res.text())
          .then(() => location.reload()); // Reload agar ID auto-generated bisa muncul
    });

    // Edit Pasien
    document.getElementById("formEdit").addEventListener("submit", function (e) {
        e.preventDefault();
        const form = e.target;
        const id = document.getElementById("editId").value;

        fetch(`/pasien/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-HTTP-Method-Override': 'PUT',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                nama_pasien: form.nama_pasien.value,
                tanggal_daftar: form.tanggal_daftar.value,
                alamat_pasien: form.alamat_pasien.value,
            })
        }).then(res => res.text())
          .then(() => location.reload());
    });

    // Hapus Pasien
    window.hapusPasien = function (id) {
        if (!confirm("Yakin ingin menghapus pasien ini?")) return;

        fetch(`/pasien/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-HTTP-Method-Override': 'DELETE',
                'Content-Type': 'application/json'
            }
        }).then(res => res.text())
          .then(() => location.reload());
    };
});
