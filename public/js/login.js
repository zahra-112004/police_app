document.addEventListener("DOMContentLoaded", function (event) {
    const loginForm = document.getElementById("loginForm");

    loginForm.addEventListener("submit", async function (event) {
        event.preventDefault();

        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value.trim();
        const emailError = document.getElementById("emailError");
        const passwordError = document.getElementById("passwordError");

        // Hapus pesan error sebelumnya
        emailError.textContent = "";
        passwordError.textContent = "";

        try {
            const response = await axios.post('/api/login', {
                email: email,
                password: password
            }, {
                headers: {
                    "Content-Type": "application/json"
                },
                withCredentials: true
            });

            // Tampilkan notifikasi sukses
            Swal.fire({
                icon: 'success',
                title: response.data.message,
                text: 'Anda akan diarahkan ke dashboard',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });

            // Redirect setelah delay
            setTimeout(() => {
                window.location.href = 'panel-control/dashboard';
            }, 2000);

        } catch (error) {
            if (error.response) {
                const { status, data } = error.response;

                if (status === 422 && typeof data.errors === "object") {
                    Object.keys(data.errors).forEach((key) => {
                        const messages = data.errors[key];
                        messages.forEach((msg) => {
                            if (key === "email") emailError.textContent = msg;
                            if (key === "password") passwordError.textContent = msg;
                        });
                    });
                } else if (status === 401) {
                    Swal.fire({
                        icon: 'error',
                        title: data.status || 'Unauthorized',
                        text: data.message || 'Email atau password salah',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Login gagal',
                        text: data.message || 'Terjadi kesalahan, silakan coba lagi',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                }
            } else {
                // Jika tidak ada respons dari server
                Swal.fire({
                    icon: 'error',
                    title: 'Server tidak merespon',
                    text: 'Pastikan backend anda berjalan dengan benar',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            }
        }
    });
});