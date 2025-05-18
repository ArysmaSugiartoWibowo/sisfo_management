<?php if (!empty($p_aktif)) : ?>
    <?php if ($p_aktif['status'] == 'aktif') : ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-4 mx-auto">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Absensi</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body text-center">
                        <!-- Menampilkan Waktu Indonesia Barat -->
                        <div class="mb-3">
                            <h5><span id="waktu"></span></h5>
                        </div>
                        <div class="mb-3">
                            <h5><span id="waktu1"></span> (WIB)</h5>
                        </div>

                        <!-- Rentang Tanggal -->
                        <?php foreach ($peserta as $p): ?>
                            <div id="rentang-waktu" 
                                data-tanggal-mulai="<?= $p['tanggal_mulai']; ?>" 
                                data-tanggal-berakhir="<?= $p['tanggal_berakhir']; ?>">
                            </div>
                        <?php endforeach; ?>

                        <!-- Form Absen Masuk -->
                        <h5><strong>Pilih Salah Satu Opsi</strong></h5>
                        <form id="form-absen-masuk" method="post" action="<?= base_url('ControllerAbsensi/absen_masuk'); ?>" class="mb-4">
                            <?php foreach ($peserta as $p): ?>
                                <input type="hidden" name="id_peserta" value="<?= $p['id_pm']; ?>">
                            <?php endforeach; ?>
                            <button type="submit" class="btn btn-primary w-100">Absen Masuk</button>
                        </form>

                        <!-- Form Izin -->
                        <form id="form-absen-izin" method="post" action="<?= base_url('ControllerAbsensi/absen_izin'); ?>" class="mb-4">
                            <?php foreach ($peserta as $p): ?>
                                <input type="hidden" name="id_peserta" value="<?= $p['id_pm']; ?>">
                            <?php endforeach; ?>
                            <div class="mb-3">
                                <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Masukkan alasan izin" required>
                            </div>
                            <input type="hidden" name="status" value="Izin">
                            <button type="submit" class="btn btn-warning w-100">Ajukan Izin</button>
                        </form>

                        <hr style="border: 1px solid #000; width: 100%; margin: 20px auto;">

                        <!-- Form Absen Pulang -->
                        <form id="form-absen-pulang" method="post" action="<?= base_url('ControllerAbsensi/absen_pulang'); ?>" class="mb-4">
                            <?php foreach ($peserta as $p): ?>
                                <input type="hidden" name="id_peserta" value="<?= $p['id_pm']; ?>">
                            <?php endforeach; ?>
                            <button type="submit" class="btn btn-success w-100">Absen Pulang</button>
                        </form>

                        <!-- Notifikasi -->
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-dismissible fade show" role="alert">
                                <strong><?= $this->session->flashdata('success'); ?></strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong><?= $this->session->flashdata('error'); ?></strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>

<script>
    function updateTime() {
        var date = new Date();
        date.setHours(date.getHours() + 7); // Waktu Indonesia Barat (WIB)

        var year = date.getFullYear();
        var month = ('0' + (date.getMonth() + 1)).slice(-2);
        var day = ('0' + date.getDate()).slice(-2);
        var hours = ('0' + date.getHours()).slice(-2);
        var minutes = ('0' + date.getMinutes()).slice(-2);
        var seconds = ('0' + date.getSeconds()).slice(-2);

        var formattedTime = 'Tanggal :' + day + ' Bulan :' + month + ' Tahun :' + year;
        // var formattedTime2 = hours + ' Jam ' + minutes + ' Menit ' + seconds + ' Detik';

        document.getElementById('waktu').textContent = formattedTime;
        document.getElementById('waktu1').textContent = formattedTime2;
    }

    function isWithinRange(currentDate, startDate, endDate) {
        return currentDate >= startDate && currentDate <= endDate;
    }

    function validateApiAndHoliday(callback, year) {
        const apiUrl = `https://calendarific.com/api/v2/holidays?api_key=pCkxFCwrorJLMy077Gi9eGOVAUX8B09R&country=ID&year=${year}`;

        fetch(apiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error("API validation failed. Please try again later.");
                }
                return response.json();
            })
            .then(data => {
                const today = new Date().toISOString().split('T')[0]; // format YYYY-MM-DD
                const holidays = data.response.holidays;
                const isHoliday = holidays.some(holiday => holiday.date.iso === today);
                callback(isHoliday);
            })
            .catch(error => {
                console.error("Error validating API or fetching holiday data:", error);
                alert("Saat Ini Hari Libur, Anda Tidak Dapat Mengisi Absen");
                disableAllForms();
            });
    }

    function disableAllForms() {
        const formButtons = document.querySelectorAll("form button");
        formButtons.forEach(button => button.disabled = true);
    }

    function checkSunday() {
        const now = new Date();
        return now.getDay() === 0; // 0 adalah kode hari Minggu
    }

    document.addEventListener("DOMContentLoaded", function () {
        const rentangWaktu = document.getElementById('rentang-waktu');
        const tanggalMulai = new Date(rentangWaktu.dataset.tanggalMulai);
        const tanggalBerakhir = new Date(rentangWaktu.dataset.tanggalBerakhir);

        const tahunMulai = tanggalMulai.getFullYear();
        const tahunBerakhir = tanggalBerakhir.getFullYear();
        const tahunSekarang = new Date().getFullYear();

        if (checkSunday()) {
            alert("Hari ini adalah hari Minggu, Anda tidak dapat mengisi absen.");
            disableAllForms();
        } else {
            // Validasi API dan hari libur dengan tahun dinamis
            validateApiAndHoliday(function (isHoliday) {
                if (isHoliday) {
                    alert("Hari ini adalah hari libur, Anda tidak dapat mengisi absen.");
                    disableAllForms();
                } else {
                    // Validasi rentang waktu untuk setiap form
                    const forms = document.querySelectorAll("form");
                    forms.forEach((form) => {
                        form.addEventListener("submit", function (e) {
                            const now = new Date();
                            if (!isWithinRange(now, tanggalMulai, tanggalBerakhir)) {
                                e.preventDefault(); // Cegah pengiriman form
                                alert("Anda hanya dapat absen dalam rentang tanggal yang ditentukan!");
                            }
                        });
                    });
                }
            }, tahunSekarang); // Tahun dinamis sesuai dengan tahun sekarang
        }

        // Perbarui waktu setiap detik
        updateTime();
        setInterval(updateTime, 1000);
    });
</script>

<?php elseif ($p_aktif['status'] == 'selesai') : ?>
    <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-10 mx-auto">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Riwayat Absensi</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
        
                        <div class="table-responsive">

                        <table id="myTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Peserta</th>
                                    <th>Jurusan</th>
                                    <th>Universitas Asal Sekolah</th>
                                    <th>Bidang</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                   
                                        <tr>
                                            <td>
                      
                                                    <?= $p_aktif['nama']; ?>
                                            </td> 
                                            <td><?= $p_aktif['ps']; ?></td>
                                            <td><?= $p_aktif['institute']; ?></td>
                                            <td><?= $p_aktif['nama_bidang']; ?></td>
                                            <td><?= $p_aktif['status']; ?></td>
                                            <td colspan="2">      
                                                <!-- Tombol dengan ukuran lebih kecil -->
                                                <button class="btn btn-sm btn-primary view-absensi" data-id="<?= $p_aktif['id_pm'];?>"
                                                data-nama="<?= $p_aktif['nama'];?>"
                                                data-tm="<?= $p_aktif['tanggal_mulai'];  ?>"
                                                data-tb="<?= $p_aktif['tanggal_berakhir'];  ?>"
                                               
                                              
                                                ">
                                                Absensi
                                                </button>
                                                
                                            </td>        
                                        </tr>
                                   
                            </tbody>
                        </table>
                    </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>
<script src="<?= base_url('vendor') ?>/plugins/jquery/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
    $('#myTable').DataTable();
        
    });
</script>
<!-- Modal Bootstrap -->
<!-- Modal Bootstrap -->
<div class="modal fade" id="modalAbsensi" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTmTb1"><strong id="modalTmTb1"></strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 id="modalTmTb"></h5>
                <button id="printBtn" class="btn btn-sm btn-success mb-3 mt-2" onclick="printAbsensi()">Cetak Absensi</button>
                <table class="table table-striped" id="absensiTable">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Status Masuk</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="absensiData">
                        <!-- Data absensi akan diisi di sini melalui JavaScript -->
                    </tbody>
                </table>

                <!-- Tombol Cetak -->

            </div>
        </div>
    </div>
</div>

<script>
// Fungsi untuk mencetak tabel absensi
function printAbsensi() {
    const namaPeserta = document.getElementById('modalTmTb1').innerText; // Nama peserta
    const tableContent = document.getElementById('absensiTable').outerHTML; // Tabel yang akan dicetak

    // Membuat konten HTML untuk cetak
    const printWindow = window.open('', '', 'height=500, width=800');
    printWindow.document.write('<html><head><title>Cetak Absensi</title>');
    printWindow.document.write('<style>table { width: 100%; border-collapse: collapse; }');
    printWindow.document.write('th, td { border: 1px solid black; padding: 8px; text-align: left; }</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write(`<h3>${namaPeserta}</h3>`); // Menampilkan nama peserta
    printWindow.document.write(tableContent); // Menampilkan tabel absensi
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print(); // Mencetak
}
</script>


<!-- JavaScript -->
<script>
$(document).ready(function () {
    // Daftar tanggal libur dari API
    const holidayDates = [];
    const holidayDescriptions = {};

    // Mendapatkan data hari libur dari API
    function fetchHolidays(year) {
        $.ajax({
            url: `https://calendarific.com/api/v2/holidays?api_key=pCkxFCwrorJLMy077Gi9eGOVAUX8B09R&country=ID&year=${year}`,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response && response.response && response.response.holidays) {
                    response.response.holidays.forEach(holiday => {
                        const date = holiday.date.iso; // Tanggal libur (ISO 8601)
                        const description = holiday.name; // Deskripsi libur
                        holidayDates.push(date); // Menyimpan tanggal libur
                        holidayDescriptions[date] = description; // Menyimpan deskripsi libur
                    });
                }
            },
            error: function() {
                alert('Gagal mengambil data hari libur.');
            }
        });
    }

    // Memanggil fetchHolidays dengan tahun saat ini
    const currentYear = new Date().getFullYear();
    fetchHolidays(currentYear);

    // Fungsi untuk memformat tanggal ke format YYYY-MM-DD
    function formatDate(date) {
        const d = new Date(date);
        const year = d.getFullYear();
        const month = (d.getMonth() + 1).toString().padStart(2, '0');
        const day = d.getDate().toString().padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    // Fungsi untuk memeriksa apakah tanggal adalah hari libur atau Minggu
    function isHoliday(date) {
        const dayOfWeek = date.getDay(); // 0 = Minggu, 1 = Senin, ..., 6 = Sabtu
        const formattedDate = formatDate(date);
        return dayOfWeek === 0 || holidayDates.includes(formattedDate); // Cek Minggu atau tanggal libur
    }

    // Klik nama peserta untuk melihat absensi
    $('.view-absensi').on('click', function (e) {
        e.preventDefault(); // Mencegah reload halaman
        const id_pm = $(this).data('id');
        const tm = $(this).data('tm'); 
        const tb = $(this).data('tb'); 
        const nama = $(this).data('nama'); 

        $('#modalTmTb1').text(` Data Absensi  Atas Nama: ${nama}  `);
        $('#modalTmTb').text(` Dimulai Pada  ${tm}  Dan Berakhir Pada ${tb}`);

        // Ambil data absensi
        $.ajax({
            url: '<?= base_url('ControllerAbsensi/getAbsensiByPeserta'); ?>/' + id_pm,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                // Hapus data sebelumnya
                $('#absensiData').empty();

                let absensiDates = [];
                if (data.length > 0) {
                    data.forEach(item => {
                        absensiDates.push(item.tanggal);
                    });

                    let currentDate = new Date(tm);
                    const endDate = new Date(tb > new Date() ? new Date() : tb);

                    let lastStatus = null;

                    while (currentDate <= endDate) {
                        const formattedDate = formatDate(currentDate);

                        if (formattedDate <= formatDate(new Date())) {
                            if (isHoliday(currentDate)) {
                                const holidayDescription = holidayDescriptions[formattedDate] || "Hari Libur"; // Deskripsi hari libur
                                const row = `
                                    <tr>
                                        <td>${formattedDate}</td>
                                        <td>Hari Libur (${holidayDescription})</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                `;
                                $('#absensiData').append(row);
                            } else {
                                const absensiItem = data.find(item => item.tanggal === formattedDate);
                                const status = absensiItem ? absensiItem.status_masuk : "Tanpa Keterangan";
                                const row = `
                                    <tr>
                                        <td>${formattedDate}</td>
                                        <td>${status}</td>
                                        <td>${absensiItem ? absensiItem.jam_masuk : '-'}</td>
                                        <td>${absensiItem ? absensiItem.jam_keluar : '-'}</td>
                                        <td>${absensiItem ? absensiItem.keterangan : '-'}</td>
                                    </tr>
                                `;
                                $('#absensiData').append(row);
                                lastStatus = status;
                            }
                        }

                        currentDate.setDate(currentDate.getDate() + 1);
                    }
                } else {
                    let currentDate = new Date(tm);
                    const endDate = new Date(tb > new Date() ? new Date() : tb);

                    while (currentDate <= endDate) {
                        const formattedDate = formatDate(currentDate);

                        if (formattedDate <= formatDate(new Date())) {
                            if (isHoliday(currentDate)) {
                                const holidayDescription = holidayDescriptions[formattedDate] || "Hari Libur";
                                $('#absensiData').append(`
                                    <tr>
                                        <td>${formattedDate}</td>
                                        <td>Hari Libur (${holidayDescription})</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                `);
                            } else {
                                $('#absensiData').append(`
                                    <tr>
                                        <td>${formattedDate}</td>
                                        <td>Tanpa Keterangan</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                `);
                            }
                        }

                        currentDate.setDate(currentDate.getDate() + 1);
                    }
                }

                $('#modalAbsensi').modal('show');
            },
            error: function () {
                alert('Gagal mengambil data absensi. Silakan coba lagi.');
            }
        });
    });
});
</script>





<?php endif;?>
<?php endif;?>


