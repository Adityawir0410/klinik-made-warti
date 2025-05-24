document.addEventListener('DOMContentLoaded', function () {
    const pasienId = window.pasienId;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // ===== MODAL HANDLERS =====
    window.openTambahModal = () => {
        document.getElementById("modalTambah").style.display = "block";
    };

    window.closeTambahModal = () => {
        document.getElementById("modalTambah").style.display = "none";
        document.getElementById("formTambah").reset();
    };

    window.openEditModal = (id, tanggal, keluhan, biaya) => {
        document.getElementById("editId").value = id;
        document.getElementById("editTanggal").value = tanggal;
        document.getElementById("editKeluhan").value = keluhan;
        document.getElementById("editBiaya").value = biaya;
        document.getElementById("modalEdit").style.display = "block";
    };

    window.closeEditModal = () => {
        document.getElementById("modalEdit").style.display = "none";
    };

    window.closeDeleteModal = () => {
        document.getElementById("modalDelete").style.display = "none";
    };

    // ===== TAMBAH =====
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
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const newRow = generateRowHTML(data.rekam);
                document.getElementById("rekamTable").insertAdjacentHTML('beforeend', newRow);
                closeTambahModal();
            }
        });
    });

    // ===== EDIT =====
    document.getElementById("formEdit").addEventListener("submit", function (e) {
        e.preventDefault();
        const form = e.target;
        const id = document.getElementById("editId").value;

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
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const row = document.getElementById("row-" + id);
                row.outerHTML = generateRowHTML(data.rekam);
                closeEditModal();
            }
        });
    });

    // ===== DELETE =====
    document.getElementById("formDelete").addEventListener("submit", function (e) {
        e.preventDefault();

        const action = e.target.action;
        const id = action.split('/').pop();

        fetch(action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-HTTP-Method-Override': 'DELETE',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const row = document.getElementById("row-" + id);
                if (row) row.remove();
                closeDeleteModal();
            } else {
                alert("Gagal menghapus data.");
            }
        });
    });

    // ===== OPEN DELETE MODAL =====
    window.openDeleteModal = (id) => {
        const form = document.getElementById("formDelete");
        form.action = `/rekam-medis/${id}`;
        document.getElementById("modalDelete").style.display = "block";
    };
});

// ===== GENERATE ROW HTML =====
function generateRowHTML(r) {
    return `
<tr id="row-${r.id_rekam}" class="bg-white hover:bg-blue-50 transition rounded-lg shadow-sm">
    <td class="px-6 py-4 text-sm">${r.tanggal_kunjungan}</td>
    <td class="px-6 py-4 text-sm">${r.keluhan}</td>
    <td class="px-6 py-4 text-sm">Rp${parseInt(r.biaya).toLocaleString('id-ID')}</td>
    <td class="px-6 py-4 text-center space-x-2">
        <button onclick="openEditModal('${r.id_rekam}', '${r.tanggal_kunjungan}', \`${r.keluhan}\`, '${r.biaya}')"
            class="inline-flex items-center px-3 py-1 text-sm text-yellow-600 border border-yellow-200 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition">
            Edit
        </button>
        <button onclick="openDeleteModal('${r.id_rekam}')"
            class="inline-flex items-center px-3 py-1 text-sm text-red-600 border border-red-200 bg-red-50 rounded-lg hover:bg-red-100 transition">
            Hapus
        </button>
    </td>
</tr>`;
}
