<?php if (isset($data)) { ?>

    <div class="modal-body" style="padding-top: 0px; padding-bottom: 0px;">
        <div class="alert alert-danger" role="alert">
            Akun anda terdeteksi belum melakukan aktivasi Nomor Telegram.<br />Silahkan untuk melakukan aktivasi Nomor Telegram terlebih dahulu.
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