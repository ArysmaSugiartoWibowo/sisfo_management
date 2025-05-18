<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-10 mx-auto">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Data Riwayat Peserta Aktif Magang</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
        
                        <div class="table-responsive">

                        <table id="myTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Peserta</th>
                                    <th>Jurusan</th>
                                    <th>Universitas / Asal Sekolah</th>
                                    <th>Bidang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($peserta_magang)): ?>
                                    <?php foreach ($peserta_magang as $peserta): ?>
                                        <tr>
                                            <td>
                      
                                                    <?= $peserta['nama']; ?>
                                            </td> 
                                            <td><?= $peserta['ps']; ?></td>
                                            <td><?= $peserta['institute']; ?></td>
                                            <td><?= $peserta['nama_bidang']; ?></td>
                                            <td colspan="2">      
                                                <!-- Tombol dengan ukuran lebih kecil -->
                                                <button class="btn btn-sm btn-primary view-absensi" data-id="<?= $peserta['id_pm'];?>"
                                                data-nama="<?= $peserta['nama'];?>"
                                                data-tm="<?= $peserta['tanggal_mulai'];  ?>"
                                                data-tb="<?= $peserta['tanggal_berakhir'];  ?>"
                                               
                                              
                                                ">
                                                Absensi
                                                </button>
                                                
                                            <?php if($peserta['status'] == 'proses'): ?>
                                                <!-- Tombol Aktifkan dengan data-id untuk id peserta -->

                                                <?php elseif($peserta['status'] == 'aktif'): ?>
                                                    <?= anchor(site_url("/ControllerAbsensi/ubah_status_selesai/" . $peserta['id_pm']), '<i class="fa fa-check"></i> Selesai', 'class="btn btn-success btn-sm" title="Selesai"') ?>
                                            <?php endif; ?>
                                            </td>        
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="1" class="text-center">Tidak ada data peserta magang.</td>
                                    </tr>
                                <?php endif; ?>
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




