document.addEventListener("DOMContentLoaded", function () {
    try {
        const token = getCookie('token');

        if (!token) {
            console.warn("token not found");
            window.location.href = "/";
            return;
        }
    } catch (error) {
        console.error('Error:', error);

        if (error.response) {
            if (error.response.status === 401) {
                window.location.href = "/";
            } else {
                console.error('Terjadi kesalahan', error.response.data.message);
            }
        }
    }

    const logoutButton = document.querySelectorAll("#logoutBtn");
    logoutButton.forEach((button) => {
        button.addEventListener('click', logout);
    });
});

async function logout() {
    try {
        const rawToken = getCookie('token');

        if (!rawToken) {
            console.warn('token not found');
            performActionLogout();
            return;
        }

        const decodedToken = decodeURIComponent(rawToken);

        const response = await axios.post('/api/panel-control/logout', {}, {
            headers: { // perbaikan dari 'Headers' ke 'headers'
                'Authorization': `Bearer ${decodedToken}`, // perbaikan penggunaan template literal
            },
            withCredentials: true
        });

        Swal.fire({
            icon: 'success', // perbaikan typo dari 'succes' ke 'success'
            title: response.data.message || 'logout berhasil',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        });

        setTimeout(() => {
            performActionLogout();
        }, 2000);
    } catch (error) {
        console.error('Terjadi kesalahan', error);

        let errorMessage = 'logout gagal, silahkan coba lagi';
        if (error.response && error.response.data && error.response.data.message) {
            errorMessage = error.response.data.message;
        } else if (error.message) {
            errorMessage = error.message;
        }

        Swal.fire({
            icon: 'error',
            title: 'logout gagal',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        });

        setTimeout(() => {
            performActionLogout();
        }, 2000);
    }
} // <--- kurung penutup function logout ditambahkan di sini

function performActionLogout() {
    document.cookie = "token=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
    window.location.href = "/";
}
