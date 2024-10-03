<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>

    <!-- google font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- AOS animate -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.min.css">
    <script src="https://cdn.datatables.net/2.1.7/js/dataTables.min.js"></script>
</head>

<!-- mycss -->
<style>
    .select2-selection__rendered {
        line-height: 35px !important;
    }

    .select2-container .select2-selection--single {
        height: 39px !important;
    }

    .select2-selection__arrow {
        height: 39px !important;
    }

    .border-notcurve {
        border-radius: 0px;
    }

    .bg-card-header-primaryx {
        background-color: #8f2dff;
        color: white;
    }

    .bg-primaryx {
        background-color: #212529;
        border-color: #8f2dff;
    }

    .btn-primaryx {
        background-color: #212529;
        border-color: #8f2dff;
        color: white;
        width: 80%;
    }

    .text-primaryx {
        color: #8f2dff;
    }

    .hr-primaryx {
        border-color: #8f2dff;
        border: 2px solid;
        color: #8f2dff;
    }

    .input-primaryx {
        background-color: #212529;
        border-top: none;
        border-left: none;
        border-right: none;
        border-color: #8f2dff;
        color: white;
    }
</style>

<body>
    <nav class="navbar" style="background-color: #8f2dff;" data-bs-theme="light">
        <div class="container">
            <a class="navbar-brand text-white ms-auto"><i class="fa-solid fa-landmark fa-2x"></i> <span class="fw-bold">MANAGEMENT KEUANGAN</span></a>
        </div>
    </nav>

    <div class="row mt-3">
        <div class="col-md-12 col-12">
            <div class="container">
                <?= $content ?>
            </div>
        </div>
    </div>

    <!-- bootstrap 5.3.3 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <!-- myscript -->
    <script>
        $(document).ready(function() {
            // load password
            $("#open_pass").hide()

            // load select2
            $(".select2_global").select2({
                placeholder: $(this).data('placeholder'),
                width: '100%',
                allowClear: true,
            });

            // load aos animate
            AOS.init();
        })

        const siteUrl = '<?= site_url() ?>'

        function isValidNumberInput(input) {
            // Menggunakan regex untuk memeriksa input
            const regex = /^[0-9,]*$/;
            return regex.test(input);
        }

        // change format rp
        function change_format(num, id) {
            if (isValidNumberInput(num) == false) {
                $('#' + id).val(0)

                return Swal.fire("Format Salah", "Harus berupa angka, silahkan coba lagi!", "warning")
            }

            $('#' + id).val(formatRp(num))
        }

        // format rp
        function formatRp(num) {
            num = num.toString().replace(/\$|\,/g, '');

            num = Math.ceil(num);

            if (isNaN(num)) num = "0";

            sign = (num == (num = Math.abs(num)));
            num = Math.floor(num * 100 + 0.50000000001);
            cents = num % 100;
            num = Math.floor(num / 100).toString();

            if (cents < 10) cents = "0" + cents;

            for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++) {
                num = num.substring(0, num.length - (4 * i + 3)) + ',' + num.substring(num.length - (4 * i + 3));
            }

            return (((sign) ? '' : '-') + '' + num);
        }

        // password
        function pass() {
            if (document.getElementById("password").type == "password") { // jika icon password gembok di klik
                // ubah tipe password menjadi text
                document.getElementById("password").type = "text"

                // tampilkan icon buka
                $("#open_pass").show()

                // sembunyikan icon gembok
                $("#lock_pass").hide()
            } else { // selain itu
                // ubah tipe password menjadi passwword
                document.getElementById("password").type = "password"
                // sembunyikan icon buka
                $("#open_pass").hide()

                // tampilkan icon gembok
                $("#lock_pass").show()
            }
        }
    </script>
</body>

</html>