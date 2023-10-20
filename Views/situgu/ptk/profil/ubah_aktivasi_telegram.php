<?php if (isset($data)) { ?>

    <div class="modal-body" style="padding-top: 0px; padding-bottom: 0px;">
        <div class="alert alert-danger" role="alert">
            Untuk mengubah Akun Nomor Telegram yang tertaut pada Akun anda.<br />Silahkan untuk mengirimkan pesan ke BOT Layanan Disdikbud Kab. Lampung Tengah (@layanandisdikbudlt_bot),<br />dengan format:<br />UBAHAKUN#nuptk#email_akunptk<br />Contoh: UBAHAKUN#1234567890123456#example@guru.sd.belajar.id
        </div>
        <!-- <div class="alert alert-danger" role="alert">
    Akun anda terdeteksi belum melakukan aktivasi Nomor Whatsapp.\nSilahkan untuk melakukan aktivasi Nomor Whatsapp terlebih dahulu.
</div> -->
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <a href="https://t.me/layanandisdikbudlt_bot" target="_blank" id="aktivasi-button-tele" class="btn btn-primary waves-effect waves-light aktivasi-button-tele">Aktivasi Sekarang</button>
    </div>

<?php } ?>