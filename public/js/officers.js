if (window.location.pathname.includes('/panel-control/officers')) {
    document.addEventListener("DOMContentLoaded", async function () {
        try {
            const token = decodeURIComponent(getCookie('token'));
            if (!token) {
                window.location.href = '/';
                return;
            }

            const response = await axios.get('/api/panel-control/officers', {
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                withCredentials: true
            });

            displayOfficers(response.data.data);
        } catch (error) {
            console.error("Gagal memuat data petugas:", error);
            showErrorToast(error.response?.data?.message || "Terjadi kesalahan saat memuat data.");

            if ([401, 403].includes(error.response?.status)) {
                window.location.href = '/';
            }
        }

        document.getElementById("addOfficerBtn").addEventListener("click", function () {
            clearCreateFormErrors();
            document.getElementById("createOfficerForm").reset();
        });

        document.getElementById("createOfficerForm").addEventListener("submit", addOfficer);
        document.getElementById("editOfficerForm").addEventListener("submit", updateOfficer);
    });

    function showErrorToast(message) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            icon: 'error',
            title: message,
        });
    }

    function clearCreateFormErrors() {
        document.getElementById("createNameError").textContent = "";
        document.getElementById("createBadgeNumberError").textContent = "";
        document.getElementById("createRankError").textContent = "";
        document.getElementById("createAssignedAreaError").textContent = "";
    }

    function clearEditFormErrors() {
        document.getElementById("editNameError").textContent = "";
        document.getElementById("editBadgeNumberError").textContent = "";
        document.getElementById("editRankError").textContent = "";
        document.getElementById("editAssignedAreaError").textContent = "";
    }

    async function addOfficer(event) {
        event.preventDefault();
        clearCreateFormErrors();

        const token = decodeURIComponent(getCookie('token'));
        const name = document.getElementById("createName").value.trim();
        const badgeNumber = document.getElementById("createBadgeNumber").value.trim();
        const rank = document.getElementById("createRank").value.trim();
        const assignedArea = document.getElementById("createAssignedArea").value.trim();

        try {
            const response = await axios.post('/api/panel-control/officers', {
                name, badge_number: badgeNumber, rank, assigned_area: assignedArea
            }, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                },
                withCredentials: true
            });

            $('#createOfficerModal').modal('hide');
            Swal.fire({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, icon: 'success', title: response.data.message });
            setTimeout(() => location.reload(), 1000);
        } catch (error) {
            if (error.response?.status === 422) {
                const errors = error.response.data.errors;
                if (errors.name) document.getElementById("createNameError").textContent = errors.name[0];
                if (errors.badge_number) document.getElementById("createBadgeNumberError").textContent = errors.badge_number[0];
                if (errors.rank) document.getElementById("createRankError").textContent = errors.rank[0];
                if (errors.assigned_area) document.getElementById("createAssignedAreaError").textContent = errors.assigned_area[0];
            } else {
                showErrorToast(error.response?.data?.message || "Terjadi kesalahan saat menambahkan petugas.");
            }
        }
    }

    function displayOfficers(data) {
        const tableBody = document.getElementById("officersTableBody");
        tableBody.innerHTML = "";

        if (data.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="6" class="text-center">Data tidak tersedia</td></tr>`;
            return;
        }

        window.officerData = data;

        data.forEach((item, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <th>${index + 1}</th>
                <td>${item.name}</td>
                <td>${item.badge_number}</td>
                <td>${item.rank}</td>
                <td>${item.assigned_area}</td>
                <td>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editOfficerModal" onclick="showEditOfficerModal(${item.id}, ${index})">Edit</button>
                    <button class="btn btn-danger" onclick="confirmDeleteOfficer(${item.id})">Delete</button>
                </td>
            `;
            tableBody.appendChild(row);
        });

        $('#officersTable').DataTable({
            responsive: true,
            autoWidth: false,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ Entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                paginate: { first: "Pertama", last: "Terakhir", next: "Selanjutnya", previous: "Sebelumnya" },
            },
        });
    }

    function showEditOfficerModal(id, index) {
        clearEditFormErrors();
        const item = window.officerData[index];

        document.getElementById("editOfficerId").value = id;
        document.getElementById("editName").value = item.name;
        document.getElementById("editBadgeNumber").value = item.badge_number;
        document.getElementById("editRank").value = item.rank;
        document.getElementById("editAssignedArea").value = item.assigned_area;
    }

    async function updateOfficer(event) {
        event.preventDefault();
        clearEditFormErrors();

        const id = document.getElementById("editOfficerId").value;
        const name = document.getElementById("editName").value.trim();
        const badgeNumber = document.getElementById("editBadgeNumber").value.trim();
        const rank = document.getElementById("editRank").value.trim();
        const assignedArea = document.getElementById("editAssignedArea").value.trim();

        const token = decodeURIComponent(getCookie('token'));

        try {
            const response = await axios.put(`/api/panel-control/officers/${id}`, {
                name, badge_number: badgeNumber, rank, assigned_area: assignedArea
            }, {
                headers: { 'Authorization': `Bearer ${token}` },
                withCredentials: true
            });

            $('#editOfficerModal').modal('hide');
            Swal.fire({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, icon: 'success', title: response.data.message });
            setTimeout(() => location.reload(), 1000);
        } catch (error) {
            if (error.response?.status === 422) {
                const errors = error.response.data.errors;
                if (errors.name) document.getElementById("editNameError").textContent = errors.name[0];
                if (errors.badge_number) document.getElementById("editBadgeNumberError").textContent = errors.badge_number[0];
                if (errors.rank) document.getElementById("editRankError").textContent = errors.rank[0];
                if (errors.assigned_area) document.getElementById("editAssignedAreaError").textContent = errors.assigned_area[0];
            } else {
                showErrorToast(error.response?.data?.message || "Terjadi kesalahan saat memperbarui petugas.");
            }
        }
    }
}

async function confirmDeleteOfficer(id) {
    const result = await Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Tindakan ini tidak dapat dibatalkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!'
    });

    if (result.isConfirmed) {
        deleteOfficer(id);
    }
}

async function deleteOfficer(id) {
    try {
        const token = decodeURIComponent(getCookie('token'));
        const response = await axios.delete(`/api/panel-control/officers/${id}`, {
            headers: { 'Authorization': `Bearer ${token}` },
            withCredentials: true
        });

        Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            icon: 'success',
            title: response.data.message || 'Petugas berhasil dihapus.'
        });

        document.getElementById('officersTableBody').innerHTML = '';
        setTimeout(() => location.reload(), 1000);
    } catch (error) {
        showErrorToast(error.response?.data?.message || "Terjadi kesalahan saat menghapus data.");
    }
}