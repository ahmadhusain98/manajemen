<form method="POST" id="form_manajemen">
    <div class="row">
        <div class="col-sm-12 col-12">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-12 col-12">
            <label for="biaya">Biaya</label>
            <input type="text" name="biaya" id="biaya" class="form-control text-end" value="0" onkeyup="change_format(this.value, 'biaya')">
        </div>
    </div>
    <br>
    <div class="row text-center">
        <div class="col-sm-12 col-12">
            <button type="button" class="btn btn-success" id="btnMasuk" onclick="proses(1)"><i class="fa-regular fa-face-smile-beam"></i> Pemasukan</button>
            <button class="btn btn-success" type="button" id="btnMasukLoading" disabled>
                <span class="spinner-grow spinner-grow-sm" aria-hidden="true"></span>
                <span role="status">Loading...</span>
            </button>
            <button type="button" class="btn btn-danger" id="btnKeluar" onclick="proses(0)"><i class="fa-regular fa-face-meh-blank"></i> Pengeluaran</button>
            <button class="btn btn-danger" type="button" id="btnKeluarLoading" disabled>
                <span class="spinner-grow spinner-grow-sm" aria-hidden="true"></span>
                <span role="status">Loading...</span>
            </button>
        </div>
    </div>
    <br>
    <hr>
    <br>
    <div class="row">
        <div class="col-md-5" style="margin-bottom: 5px;">
            <input type="date" name="dari" id="dari" title="Dari" value="<?= date('Y-m-d'); ?>" max="<?= date('Y-m-d'); ?>" class="form-control">
        </div>
        <div class="col-md-5" style="margin-bottom: 5px;">
            <input type="date" name="sampai" id="sampai" title="Sampai" value="<?= date('Y-m-d'); ?>" class="form-control">
        </div>
        <div class="col-md-2">
            <button type="button" style="width: 100%;" class="btn btn-info" title="Filter" onclick="filterdata()"><i class="fa-solid fa-filter"></i></button>
        </div>
    </div>
    <br>
    <div class="table-responsive">
        <table class="table table-striped table-hover" style="width: 100%; border-radius: 10px;" id="tableHome">
            <thead>
                <tr class="text-center">
                    <th style="background-color: #8f2dff; color: white; border-radius: 10px 0px 0px 0px; width: 5%;">No</th>
                    <th style="background-color: #8f2dff; color: white;">Keterangan</th>
                    <th style="background-color: #8f2dff; color: white;">Biaya</th>
                    <th style="background-color: #8f2dff; color: white; border-radius: 0px 10px 0px 0px; width: 5%;">Hapus</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</form>

<script>
    var table = $('#tableHome');

    table.DataTable({
        "destroy": true,
        "processing": true,
        "responsive": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": `<?= site_url() ?>Home/list_home/1`,
            "type": "POST",
        },
        "scrollCollapse": false,
        "paging": true,
        "language": {
            "emptyTable": "<div class='text-center'>Data Kosong</div>",
            "infoEmpty": "",
            "infoFiltered": "",
            "search": "",
            "searchPlaceholder": "Cari data...",
            "info": " Jumlah _TOTAL_ Data (_START_ - _END_)",
            "lengthMenu": "_MENU_ Baris",
            "zeroRecords": "<div class='text-center'>Data Kosong</div>",
            "paginate": {
                "previous": "Sebelumnya",
                "next": "Berikutnya"
            }
        },
        "lengthMenu": [
            [10, 25, 50, 75, 100, -1],
            [10, 25, 50, 75, 100, "Semua"]
        ],
        "columnDefs": [{
            "targets": [-1],
            "orderable": false,
        }],
    });

    function filterdata() {
        var tgl1 = document.getElementById("dari").value;
        var tgl2 = document.getElementById("sampai").value;
        var id = 2;
        var str = id + '~' + tgl1 + '~' + tgl2;
        table.DataTable().ajax.url("<?= site_url() ?>Home/list_home/" + str).load();
    }
</script>

<script>
    // variable
    const form = $('#form_manajemen')
    const btnMasuk = $('#btnMasuk')
    const btnMasukLoading = $('#btnMasukLoading')
    const btnKeluar = $('#btnKeluar')
    const btnKeluarLoading = $('#btnKeluarLoading')
    let keterangan = $('#keterangan')
    let biaya = $('#biaya')

    // first load
    $(document).ready(function() {
        btnMasukLoading.hide()
        btnKeluarLoading.hide()
    });

    function proses(param) {
        if (param == 1) {
            btnMasuk.hide()
            btnMasukLoading.show()

            if (!keterangan.val() || keterangan.val() === null) {
                btnMasuk.show()
                btnMasukLoading.hide()

                return Swal.fire("Biaya", "Form sudah diisi?", "warning")
            }

            if (!biaya.val() || biaya.val() === null) {
                btnMasuk.show()
                btnMasukLoading.hide()

                return Swal.fire("Biaya", "Form sudah diisi?", "warning")
            }
        } else {
            btnKeluar.hide()
            btnKeluarLoading.show()

            if (!keterangan.val() || keterangan.val() === null) {
                btnKeluar.show()
                btnKeluarLoading.hide()

                return Swal.fire("Biaya", "Form sudah diisi?", "warning")
            }

            if (!biaya.val() || biaya.val() === null) {
                btnKeluar.show()
                btnKeluarLoading.hide()

                return Swal.fire("Biaya", "Form sudah diisi?", "warning")
            }
        }

        $.ajax({
            url: `${siteUrl}Home/proses/${param}`,
            type: `POST`,
            dataType: `JSON`,
            data: form.serialize(),
            success: function(success) {
                if (success.result == 1) {
                    Swal.fire("Proses", "Berhasil dilakukan!", "success").then(() => {
                        location.href = `${siteUrl}Home`
                    })
                } else {
                    Swal.fire("Proses", "Gagal dilakukan, silahkan dicoba lagi!", "warning")
                }
            },
            error: function(error) {
                if (param == 1) {
                    btnMasuk.show()
                    btnMasukLoading.hide()
                } else {
                    btnKeluar.show()
                    btnKeluarLoading.hide()
                }

                Swal.fire("Error's", "Terdapat kesalahan dalam proses!", "error")
            }
        })

    }

    function hapusData(id) {
        $.ajax({
            url: `${siteUrl}Home/delData/${id}`,
            type: `POST`,
            dataType: `JSON`,
            success: function(success) {
                if (success.result == 1) {
                    Swal.fire("Hapus", "Berhasil dilakukan!", "success").then(() => {
                        location.href = `${siteUrl}Home`
                    })
                } else {
                    Swal.fire("Hapus", "Gagal dilakukan, silahkan dicoba lagi!", "warning")
                }
            },
            error: function(error) {
                Swal.fire("Error's", "Terdapat kesalahan dalam proses!", "error")
            }
        })
    }
</script>