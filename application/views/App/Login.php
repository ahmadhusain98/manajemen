<form method="post" id="form-login">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mt-5" data-aos="fade-up">
                <div class="card-header p-3 text-primary">
                    <div class="row text-center">
                        <div class="col-md-12">
                            <i class="fa-solid fa-landmark fa-2x"></i> <span class="fw-bold">MANAGEMENT KEUANGAN</span></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <button type="button" class="btn btn-primary" onclick="login()" id="btnLogin">Login</button>
                    <button class="btn btn-primary" type="button" id="btnLoginLoading" disabled>
                        <span class="spinner-grow spinner-grow-sm" aria-hidden="true"></span>
                        <span role="status">Loading...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    // variable
    const form = $('#form-login')
    const btnLogin = $('#btnLogin')
    const btnLoginLoading = $('#btnLoginLoading')
    let email = $('#email')
    let password = $('#password')

    // first load
    $(document).ready(function() {
        btnLoginLoading.hide()
    });

    // fungsi
    function login() {
        btnLogin.hide()
        btnLoginLoading.show()

        if (!email.val() || email.val() === null) { // email kosong
            btnLogin.show()
            btnLoginLoading.hide()

            return Swal.fire("Email", "Form sudah diisi?", "warning")
        }

        if (!password.val() || password.val() === null) { // password kosong
            btnLogin.show()
            btnLoginLoading.hide()

            return Swal.fire("Password", "Form sudah diisi?", "warning")
        }

        $.ajax({
            url: `${siteUrl}App/login_proses`,
            type: `POST`,
            dataType: `JSON`,
            data: form.serialize(),
            success: function(success) {
                if (success.result == 1) {
                    location.href = `${siteUrl}Home`;
                } else if (success.result == 2) {
                    btnLogin.show()
                    btnLoginLoading.hide()

                    Swal.fire("Password", "Salah, silahkan coba lagi!", "warning")
                } else {
                    btnLogin.show()
                    btnLoginLoading.hide()

                    Swal.fire("Akun", "Tidak ditemukan!", "warning")
                }
            },
            error: function(error) {
                btnLogin.show()
                btnLoginLoading.hide()

                Swal.fire("Error's", "Terdapat kesalahan dalam proses!", "error")
            }
        })
    }
</script>