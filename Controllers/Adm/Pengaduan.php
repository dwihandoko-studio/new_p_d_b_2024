<?php

namespace App\Controllers\Adm;

use App\Controllers\BaseController;
use App\Models\Adm\Pengaduan\PengaduanModel;
use Config\Services;
use App\Libraries\Profilelib;
use App\Libraries\Helplib;
use App\Libraries\Uuid;
use setasign\Fpdi\TcpdfFpdi;

class Pengaduan extends BaseController
{
    var $folderImage = 'masterdata';
    private $_db;
    private $_helpLib;

    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
        $this->_helpLib = new Helplib();
    }

    public function getAll()
    {
        $request = Services::request();
        $datamodel = new PengaduanModel($request);


        $lists = $datamodel->get_datatables();
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            $action = '<a class="btn btn-primary" href="./detail?id=' . $list->no_tiket . '&n=' . $list->nama_pengadu . '"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
                                ';

            $row[] = $action;
            $row[] = ucwords($list->jenis_pengaduan);
            $row[] = $list->nama_pengadu;
            $row[] = $list->no_tiket;

            $data[] = $row;
        }
        $output = [
            "draw" => $request->getPost('draw'),
            "recordsTotal" => $datamodel->count_all(),
            "recordsFiltered" => $datamodel->count_filtered(),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function index()
    {
        return redirect()->to(base_url('adm/pengaduan/data'));
    }

    public function data()
    {

        $Profilelib = new Profilelib();
        $user = $Profilelib->user();

        if (!$user || $user->status !== 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        // $layanan = json_decode(file_get_contents(FCPATH . "uploads/layanans_silastri.json"), true);
        // $data['layanans'] = [];
        // var_dump("PENG");
        // die;
        $data['user'] = $user->data;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;
        $data['title'] = 'Dashboard';
        return view('adm/pengaduan/index', $data);
    }

    public function detail()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $id = htmlspecialchars($this->request->getGet('id'), true);
        $name = htmlspecialchars($this->request->getGet('n'), true);

        $oldData = $this->_db->table('data_pengaduan a')
            ->where('a.no_tiket', $id)
            ->get()->getRowObject();

        if (!$oldData) {
            $data['error_tutup'] = "Data pengaduan tidak ditemukan dengan nomor tiket tersebut.";
            $data['error_url'] = base_url('adm/pengaduan');
        }
        $data['data'] = $oldData;

        $data['title'] = "DETAIL DATA PENGADUAN";
        $data['id'] = $id;
        $data['user'] = $user->data;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;

        return view('adm/pengaduan/detail', $data);
    }

    public function getPengaduan()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'tiket' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Tiket tidak boleh kosong. ',
                    ]
                ],
                'jenis' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Jenis pengaduan tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('tiket')
                    . $this->validator->getError('jenis');
                return json_encode($response);
            } else {
                $Profilelib = new Profilelib();
                $user = $Profilelib->user();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Session expired";
                    return json_encode($response);
                }

                $id = htmlspecialchars($this->request->getVar('tiket'), true);
                $jenis_pengaduan = htmlspecialchars($this->request->getVar('jenis'), true);

                if ($jenis_pengaduan == "belum punya akun") {
                    $oldData = $this->_db->table('data_pengaduan a')
                        ->select("b.*, c.npsn, c.nama as nama_sekolah_as, a.no_tiket, a.jenis_pengaduan, a.email_pengadu, a.nohp_pengadu, a.file, a.status, a.keterangan, a.created_at as created_pengaduan, a.updated_at as updated_pengaduan, a.admin_approve")
                        ->join('dapo_peserta_pengajuan b', 'a.no_tiket = b.id')
                        ->join('dapo_sekolah c', 'b.sekolah_id = c.sekolah_id')
                        ->where('a.no_tiket', $id)
                        ->get()->getRowObject();

                    if (!$oldData) {
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Data pengaduan tidak ditemukan.";
                        return json_encode($response);
                    }

                    $x['data'] = $oldData;
                    $x['props'] = $this->_db->table('ref_provinsi')
                        ->get()->getResult();
                    $x['kabs'] = $this->_db->table('ref_kabupaten')
                        ->where("left(id,2) = left('{$oldData->kode_wilayah}',2)")->get()->getResult();
                    $x['kecs'] = $this->_db->table('ref_kecamatan')
                        ->where("left(id_kabupaten,4) = left('{$oldData->kode_wilayah}',4)")->get()->getResult();
                    $x['kels'] = $this->_db->table('ref_kelurahan')
                        ->where("left(id_kecamatan,6) = left('{$oldData->kode_wilayah}',6)")->get()->getResult();
                    $x['dusuns'] = $this->_db->table('ref_dusun')->orderBy('urut', 'ASC')
                        ->get()->getResult();
                    $x['sek'] = $this->_db->table('dapo_sekolah')->select("npsn, nama, lintang, bujur")->where('sekolah_id', $oldData->sekolah_id)->get()->getRowObject();

                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Permintaan diizinkan";
                    if (substr($oldData->nisn, 0, 2) == "BS") {
                        $response->data = view('adm/pengaduan/belum_punya_akun_bs.php', $x);
                    } else {
                        $response->data = view('adm/pengaduan/belum_punya_akun.php', $x);
                    }
                    return json_encode($response);
                } else {
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function formTolak()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Id tidak boleh kosong. ',
                    ]
                ],
                'nama' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Nama tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('id')
                    . $this->validator->getError('nama');
                return json_encode($response);
            } else {
                $Profilelib = new Profilelib();
                $user = $Profilelib->user();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    return redirect()->to(base_url('auth'));
                }

                $id = htmlspecialchars($this->request->getVar('id'), true);
                $nama = htmlspecialchars($this->request->getVar('nama'), true);

                $oldData = $this->_db->table('data_pengaduan a')
                    ->where('a.no_tiket', $id)
                    ->get()->getRowObject();

                if (!$oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data tidak ditemukan.";
                    return json_encode($response);
                }

                $x['data'] = $oldData;

                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('adm/pengaduan/form_tolak', $x);
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function tolakSave()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                '_id_tolak' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Tiket tidak boleh kosong. ',
                    ]
                ],
                '_nama_tolak' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Nama pengadu tidak boleh kosong. ',
                    ]
                ],
                '_keterangan_penolakan' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Nama pengadu tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('_id_tolak')
                    . $this->validator->getError('_nama_tolak')
                    . $this->validator->getError('_keterangan_penolakan');
                return json_encode($response);
            } else {
                $Profilelib = new Profilelib();
                $user = $Profilelib->user();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Session expired";
                    return json_encode($response);
                }

                $id = htmlspecialchars($this->request->getVar('_id_tolak'), true);
                $nama = htmlspecialchars($this->request->getVar('_nama_tolak'), true);
                $keterangan = htmlspecialchars($this->request->getVar('_keterangan_penolakan'), true);

                $oldData = $this->_db->table('data_pengaduan a')
                    ->where('a.no_tiket', $id)
                    ->get()->getRowObject();

                if (!$oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data pengaduan tidak ditemukan.";
                    return json_encode($response);
                }

                $this->_db->transBegin();
                try {
                    $this->_db->table('data_pengaduan')->where('no_tiket', $oldData->no_tiket)->update([
                        'status' => 3,
                        'keterangan' => $keterangan,
                        'admin_approve' => $user->data->id,
                        'updated_at' => date('Y-m-d H:i:s'),
                        'date_approve' => date('Y-m-d H:i:s'),
                    ]);
                    if ($this->_db->affectedRows() > 0) {
                        $this->_db->transCommit();

                        $response = new \stdClass;
                        $response->status = 200;
                        $response->url = base_url('adm/pengaduan');
                        $response->message = "Data berhasil ditolak.";
                        return json_encode($response);
                    } else {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal menolak data.";
                        return json_encode($response);
                    }
                } catch (\Throwable $th) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menolak data. with error";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function proses()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Tiket tidak boleh kosong. ',
                    ]
                ],
                'nama' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Nama pengadu tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('id')
                    . $this->validator->getError('nama');
                return json_encode($response);
            } else {
                $Profilelib = new Profilelib();
                $user = $Profilelib->user();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Session expired";
                    return json_encode($response);
                }

                $id = htmlspecialchars($this->request->getVar('id'), true);
                $nama = htmlspecialchars($this->request->getVar('nama'), true);

                $oldData = $this->_db->table('data_pengaduan a')
                    ->where('a.no_tiket', $id)
                    ->get()->getRowObject();

                if (!$oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data pengaduan tidak ditemukan.";
                    return json_encode($response);
                }

                $this->_db->transBegin();
                try {
                    $this->_db->table('data_pengaduan')->where('no_tiket', $oldData->no_tiket)->update([
                        'status' => 1,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                    if ($this->_db->affectedRows() > 0) {
                        $this->_db->transCommit();

                        $response = new \stdClass;
                        $response->status = 200;
                        $response->message = "Data berhasil diproses.";
                        return json_encode($response);
                    } else {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal memperoses data.";
                        return json_encode($response);
                    }
                } catch (\Throwable $th) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal memperoses data. with error";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function verifikasiBelumSave()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                '_no_tiket_pd' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Tiket tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('_no_tiket_pd');
                return json_encode($response);
            } else {
                $Profilelib = new Profilelib();
                $user = $Profilelib->user();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Session expired";
                    return json_encode($response);
                }

                $id = htmlspecialchars($this->request->getVar('_no_tiket_pd'), true);

                $oldData = $this->_db->table('data_pengaduan a')
                    ->where('a.no_tiket', $id)
                    ->get()->getRowObject();

                $oldDataPd = $this->_db->table('dapo_peserta_pengajuan a')
                    ->where('a.id', $id)
                    ->get()->getRowObject();

                if (!($oldData || $oldDataPd)) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data pengaduan tidak ditemukan.";
                    return json_encode($response);
                }

                $refSeklah = $this->_db->table('dapo_sekolah a')
                    ->where('a.sekolah_id', $oldDataPd->sekolah_id)
                    ->get()->getRowObject();

                if (!($refSeklah)) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data ref sekolah tidak ditemukan.";
                    return json_encode($response);
                }

                $date = date('Y-m-d H:i:s');

                $this->_db->transBegin();
                try {
                    $this->_db->table('data_pengaduan')->where('no_tiket', $oldData->no_tiket)->update([
                        'status' => 2,
                        'admin_approve' => $user->data->id,
                        'updated_at' => $date,
                        'date_approve' => $date,
                    ]);
                    if ($this->_db->affectedRows() > 0) {

                        $cekAnyData = $this->_db->table('dapo_peserta')->where('peserta_didik_id', $oldDataPd->peserta_didik_id)->countAllResults();
                        if ($cekAnyData > 0) {
                            $this->_db->transRollback();
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = "Peserta didik id sudah ada pada data referensi pd.";
                            return json_encode($response);
                        }
                        // $this->_db->query("INSERT INTO dapo_peserta (peserta_didik_id, sekolah_id, kode_wilayah, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, nik, nisn, no_kk, kab, kec, kel, dusun, alamat_jalan, desa_kelurahan, rt, rw, nama_dusun, nama_ibu_kandung, pekerjaan_ibu, penghasilan_ibu, nama_ayah, pekerjaan_ayah, penghasilan_ayah, nama_wali, pekerjaan_wali, penghasilan_wali, kebutuhan_khusus, no_kip, no_pkh, lintang, bujur, tingkat_pendidikan_id, flag_pip, is_edited, is_verified, created_at, updated_at) SELECT peserta_didik_id, sekolah_id, kode_wilayah, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, nik, nisn, no_kk, kab, kec, kel, dusun, alamat_jalan, desa_kelurahan, rt, rw, nama_dusun, nama_ibu_kandung, pekerjaan_ibu, penghasilan_ibu, nama_ayah, pekerjaan_ayah, penghasilan_ayah, nama_wali, pekerjaan_wali, penghasilan_wali, kebutuhan_khusus, no_kip, no_pkh, lintang, bujur, tingkat_pendidikan_id, flag_pip, is_edited, is_verified, created_at, updated_at FROM dapo_peserta_pengajuan WHERE id = '$oldData->no_tiket'");
                        $this->_db->query(
                            "INSERT INTO dapo_peserta (peserta_didik_id, sekolah_id, kode_wilayah, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, nik, nisn, no_kk, kab, kec, kel, dusun, alamat_jalan, desa_kelurahan, rt, rw, nama_dusun, nama_ibu_kandung, pekerjaan_ibu, penghasilan_ibu, nama_ayah, pekerjaan_ayah, penghasilan_ayah, nama_wali, pekerjaan_wali, penghasilan_wali, kebutuhan_khusus, no_kip, no_pkh, lintang, bujur, tingkat_pendidikan_id, flag_pip, is_edited, is_verified, created_at, updated_at)
                                SELECT peserta_didik_id, sekolah_id, kode_wilayah, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, nik, nisn, no_kk, kab, kec, kel, dusun, alamat_jalan, desa_kelurahan, rt, rw, nama_dusun, nama_ibu_kandung, pekerjaan_ibu, penghasilan_ibu, nama_ayah, pekerjaan_ayah, penghasilan_ayah, nama_wali, pekerjaan_wali, penghasilan_wali, kebutuhan_khusus, no_kip, no_pkh, lintang, bujur, tingkat_pendidikan_id, flag_pip, is_edited, is_verified, created_at, updated_at
                                FROM dapo_peserta_pengajuan
                                WHERE id = ?",
                            [$oldData->no_tiket]
                        );
                        if ($this->_db->affectedRows() > 0) {
                            $characters = array_merge(range('A', 'Z'), range(0, 9));
                            $randomString = '';
                            for ($i = 0; $i < 6; $i++) {
                                $randomIndex = mt_rand(0, count($characters) - 1);
                                $randomString .= $characters[$randomIndex];
                            }
                            $password = $randomString;
                            $passwordFix = password_hash($password, PASSWORD_BCRYPT);

                            $uuidLib = new Uuid();

                            $dataUser = [
                                'id' => $uuidLib->v4(),
                                'username' => $oldDataPd->nisn,
                                'password' => $passwordFix,
                                'is_active' => 1,
                                'level' => 5,
                                'created_at' => date('Y-m-d H:i:s')
                            ];

                            $dataUserProfile = [
                                'user_id' => $dataUser['id'],
                                'peserta_didik_id' => $oldDataPd->peserta_didik_id,
                                'sekolah_id_asal' => $oldDataPd->sekolah_id,
                                'wilayah' => $oldDataPd->kel,
                                'nama' => $oldDataPd->nama,
                                'nama_sekolah_asal' => $refSeklah->nama,
                                'npsn_asal' => $refSeklah->npsn,
                                'tingkat_pendidikan_asal' => (int)$oldDataPd->tingkat_pendidikan_id,
                                'acc_reg' => $password,
                                'created_at' => $dataUser['created_at']
                            ];

                            $this->_db->table('_users_tb')->insert($dataUser);
                            if ($this->_db->affectedRows() > 0) {
                                $this->_db->table('_users_profile_pd')->insert($dataUserProfile);
                                if ($this->_db->affectedRows() > 0) {

                                    $this->_db->transCommit();

                                    $response = new \stdClass;
                                    $response->status = 200;
                                    $response->peserta_didik_id = $oldDataPd->peserta_didik_id;
                                    $response->nama = $oldDataPd->nama;
                                    $response->nohp = $oldData->nohp_pengadu;
                                    $response->email = $oldData->email_pengadu;
                                    $response->url = base_url('adm/pengaduan');
                                    $response->url_pdf = base_url('auth') . '/download?t=' . $oldData->no_tiket;
                                    $response->message = "Data berhasil disimpan.";
                                    return json_encode($response);
                                } else {
                                    $this->_db->transRollback();
                                    $response = new \stdClass;
                                    $response->status = 400;
                                    $response->message = "Gagal menyimpan data. pf e";
                                    return json_encode($response);
                                }
                            } else {
                                $this->_db->transRollback();
                                $response = new \stdClass;
                                $response->status = 400;
                                $response->message = "Gagal menyimpan data. ut e";
                                return json_encode($response);
                            }
                        } else {
                            $this->_db->transRollback();
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = "Gagal memvalidasi data.";
                            return json_encode($response);
                        }
                    } else {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal memperoses data.";
                        return json_encode($response);
                    }
                } catch (\Throwable $th) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal memperoses data. with error";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function verifikasiSudahSave()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                '_no_tiket_pd' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Tiket tidak boleh kosong. ',
                    ]
                ],
                '_peserta_didik_id_pd' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Peserta didik id tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('_no_tiket_pd')
                    . $this->validator->getError('_peserta_didik_id_pd');
                return json_encode($response);
            } else {
                $Profilelib = new Profilelib();
                $user = $Profilelib->user();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Session expired";
                    return json_encode($response);
                }

                $id = htmlspecialchars($this->request->getVar('_no_tiket_pd'), true);
                $pdId = htmlspecialchars($this->request->getVar('_peserta_didik_id_pd'), true);

                $oldData = $this->_db->table('data_pengaduan a')
                    ->where('a.no_tiket', $id)
                    ->get()->getRowObject();

                $oldDataPd = $this->_db->table('dapo_peserta_pengajuan a')
                    ->where('a.id', $id)
                    ->get()->getRowObject();

                if (!($oldData || $oldDataPd)) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data pengaduan tidak ditemukan.";
                    return json_encode($response);
                }

                $refSeklah = $this->_db->table('dapo_sekolah a')
                    ->where('a.sekolah_id', $oldDataPd->sekolah_id)
                    ->get()->getRowObject();

                if (!($refSeklah)) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data ref sekolah tidak ditemukan.";
                    return json_encode($response);
                }

                $date = date('Y-m-d H:i:s');

                $this->_db->transBegin();
                try {
                    $this->_db->table('data_pengaduan')->where('no_tiket', $oldData->no_tiket)->update([
                        'status' => 2,
                        'admin_approve' => $user->data->id,
                        'updated_at' => $date,
                        'date_approve' => $date,
                    ]);
                    if ($this->_db->affectedRows() > 0) {
                        $this->_db->table('dapo_peserta_pengajuan')->where('id', $oldDataPd->id)->update([
                            'peserta_didik_id' => $pdId,
                            'updated_at' => $date,
                        ]);
                        if ($this->_db->affectedRows() > 0) {
                            $cekAnyData = $this->_db->table('dapo_peserta')->where('peserta_didik_id', $pdId)->countAllResults();
                            if ($cekAnyData > 0) {
                                $this->_db->transRollback();
                                $response = new \stdClass;
                                $response->status = 400;
                                $response->message = "Peserta didik id sudah ada pada data referensi pd.";
                                return json_encode($response);
                            }
                            // $this->_db->query("INSERT INTO dapo_peserta (peserta_didik_id, sekolah_id, kode_wilayah, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, nik, nisn, no_kk, kab, kec, kel, dusun, alamat_jalan, desa_kelurahan, rt, rw, nama_dusun, nama_ibu_kandung, pekerjaan_ibu, penghasilan_ibu, nama_ayah, pekerjaan_ayah, penghasilan_ayah, nama_wali, pekerjaan_wali, penghasilan_wali, kebutuhan_khusus, no_kip, no_pkh, lintang, bujur, tingkat_pendidikan_id, flag_pip, is_edited, is_verified, created_at, updated_at) SELECT peserta_didik_id, sekolah_id, kode_wilayah, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, nik, nisn, no_kk, kab, kec, kel, dusun, alamat_jalan, desa_kelurahan, rt, rw, nama_dusun, nama_ibu_kandung, pekerjaan_ibu, penghasilan_ibu, nama_ayah, pekerjaan_ayah, penghasilan_ayah, nama_wali, pekerjaan_wali, penghasilan_wali, kebutuhan_khusus, no_kip, no_pkh, lintang, bujur, tingkat_pendidikan_id, flag_pip, is_edited, is_verified, created_at, updated_at FROM dapo_peserta_pengajuan WHERE id = '$oldData->no_tiket'");
                            $this->_db->query(
                                "INSERT INTO dapo_peserta (peserta_didik_id, sekolah_id, kode_wilayah, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, nik, nisn, no_kk, kab, kec, kel, dusun, alamat_jalan, desa_kelurahan, rt, rw, nama_dusun, nama_ibu_kandung, pekerjaan_ibu, penghasilan_ibu, nama_ayah, pekerjaan_ayah, penghasilan_ayah, nama_wali, pekerjaan_wali, penghasilan_wali, kebutuhan_khusus, no_kip, no_pkh, lintang, bujur, tingkat_pendidikan_id, flag_pip, is_edited, is_verified, created_at, updated_at)
                                SELECT peserta_didik_id, sekolah_id, kode_wilayah, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, nik, nisn, no_kk, kab, kec, kel, dusun, alamat_jalan, desa_kelurahan, rt, rw, nama_dusun, nama_ibu_kandung, pekerjaan_ibu, penghasilan_ibu, nama_ayah, pekerjaan_ayah, penghasilan_ayah, nama_wali, pekerjaan_wali, penghasilan_wali, kebutuhan_khusus, no_kip, no_pkh, lintang, bujur, tingkat_pendidikan_id, flag_pip, is_edited, is_verified, created_at, updated_at
                                FROM dapo_peserta_pengajuan
                                WHERE id = ?",
                                [$oldData->no_tiket]
                            );
                            if ($this->_db->affectedRows() > 0) {
                                $characters = array_merge(range('A', 'Z'), range(0, 9));
                                $randomString = '';
                                for ($i = 0; $i < 6; $i++) {
                                    $randomIndex = mt_rand(0, count($characters) - 1);
                                    $randomString .= $characters[$randomIndex];
                                }
                                $password = $randomString;
                                $passwordFix = password_hash($password, PASSWORD_BCRYPT);

                                $uuidLib = new Uuid();

                                $dataUser = [
                                    'id' => $uuidLib->v4(),
                                    'username' => $oldDataPd->nisn,
                                    'password' => $passwordFix,
                                    'is_active' => 1,
                                    'level' => 5,
                                    'created_at' => date('Y-m-d H:i:s')
                                ];

                                $dataUserProfile = [
                                    'user_id' => $dataUser['id'],
                                    'peserta_didik_id' => $pdId,
                                    'sekolah_id_asal' => $oldDataPd->sekolah_id,
                                    'wilayah' => $oldDataPd->kel,
                                    'nama' => $oldDataPd->nama,
                                    'nama_sekolah_asal' => $refSeklah->nama,
                                    'npsn_asal' => $refSeklah->npsn,
                                    'tingkat_pendidikan_asal' => (int)$oldDataPd->tingkat_pendidikan_id,
                                    'acc_reg' => $password,
                                    'created_at' => $dataUser['created_at']
                                ];

                                $this->_db->table('_users_tb')->insert($dataUser);
                                if ($this->_db->affectedRows() > 0) {
                                    $this->_db->table('_users_profile_pd')->insert($dataUserProfile);
                                    if ($this->_db->affectedRows() > 0) {

                                        $this->_db->transCommit();

                                        $response = new \stdClass;
                                        $response->status = 200;
                                        $response->peserta_didik_id = $pdId;
                                        $response->nama = $oldDataPd->nama;
                                        $response->nohp = $oldData->nohp_pengadu;
                                        $response->email = $oldData->email_pengadu;
                                        $response->url = base_url('adm/pengaduan');
                                        $response->url_pdf = base_url('auth') . '/download?t=' . $oldData->no_tiket;
                                        $response->message = "Data berhasil disimpan.";
                                        return json_encode($response);
                                    } else {
                                        $this->_db->transRollback();
                                        $response = new \stdClass;
                                        $response->status = 400;
                                        $response->message = "Gagal menyimpan data. pf e";
                                        return json_encode($response);
                                    }
                                } else {
                                    $this->_db->transRollback();
                                    $response = new \stdClass;
                                    $response->status = 400;
                                    $response->message = "Gagal menyimpan data. ut e";
                                    return json_encode($response);
                                }
                            } else {
                                $this->_db->transRollback();
                                $response = new \stdClass;
                                $response->status = 400;
                                $response->message = "Gagal memvalidasi data.";
                                return json_encode($response);
                            }
                        } else {
                            $this->_db->transRollback();
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = "Gagal memvalidasi data.";
                            return json_encode($response);
                        }
                    } else {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal memperoses data.";
                        return json_encode($response);
                    }
                } catch (\Throwable $th) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal memperoses data. with error";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function refkab()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'id tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('id');
                return json_encode($response);
            } else {
                $Profilelib = new Profilelib();
                $user = $Profilelib->user();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    return redirect()->to(base_url('auth'));
                }

                $id = htmlspecialchars($this->request->getVar('id'), true);

                $current = $this->_db->table('ref_kabupaten')
                    ->where("id_provinsi = '$id'")->get()->getResult();

                if (count($current) > 0) {
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Permintaan diizinkan";
                    $response->data = $current;
                    return json_encode($response);
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data tidak ditemukan";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function refkec()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'id tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('id');
                return json_encode($response);
            } else {
                $Profilelib = new Profilelib();
                $user = $Profilelib->user();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    return redirect()->to(base_url('auth'));
                }

                $id = htmlspecialchars($this->request->getVar('id'), true);

                $current = $this->_db->table('ref_kecamatan')
                    ->where("id_kabupaten = '$id'")->get()->getResult();

                if (count($current) > 0) {
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Permintaan diizinkan";
                    $response->data = $current;
                    return json_encode($response);
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data tidak ditemukan";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function refkel()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'id tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('id');
                return json_encode($response);
            } else {
                $Profilelib = new Profilelib();
                $user = $Profilelib->user();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    return redirect()->to(base_url('auth'));
                }

                $id = htmlspecialchars($this->request->getVar('id'), true);

                $current = $this->_db->table('ref_kelurahan')
                    ->where("id_kecamatan = '$id'")->get()->getResult();

                if (count($current) > 0) {
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Permintaan diizinkan";
                    $response->data = $current;
                    return json_encode($response);
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data tidak ditemukan";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function location()
    {
        if ($this->request->isAJAX()) {
            $Profilelib = new Profilelib();
            $user = $Profilelib->user();
            if ($user->status != 200) {
                delete_cookie('jwt');
                session()->destroy();
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session expired";
                return json_encode($response);
            }

            $lat = htmlspecialchars($this->request->getVar('lat'), true) ?? "";
            $long = htmlspecialchars($this->request->getVar('long'), true) ?? "";
            $sekolah_id = htmlspecialchars($this->request->getVar('sekolah_id'), true) ?? "";

            if ($lat == "" && $long == "") {
                $sek = $this->_db->table('dapo_sekolah')->select("lintang, bujur")->where('sekolah_id', $sekolah_id)->get()->getRowObject();
                if ($sek) {
                    if ($lat == "") {
                        $lat = $sek->lintang;
                    }
                    if ($long == "") {
                        $lat = $sek->bujur;
                    }
                }
            }

            $x['lat'] = $lat;
            $x['long'] = $long;

            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";
            $response->lat = $lat;
            $response->long = $long;
            $response->data = view('adm/layanan/pd/maps', $x);
            return json_encode($response);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function download()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Id tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('id');
                return json_encode($response);
            } else {
                $Profilelib = new Profilelib();
                $user = $Profilelib->user();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Session expired";
                    return json_encode($response);
                }

                $id = htmlspecialchars($this->request->getVar('id'), true);

                $pd = $this->_db->table('_users_profile_pd a')
                    ->select("c.username, b.peserta_didik_id, b.sekolah_id, b.nama, b.nisn, b.tempat_lahir, b.tanggal_lahir, b.jenis_kelamin, b.nik, a.user_id, a.nama_sekolah_asal, a.npsn_asal, a.acc_reg")
                    ->join('dapo_peserta b', 'a.peserta_didik_id = b.peserta_didik_id')
                    ->join('_users_tb c', 'a.user_id = c.id')
                    ->where('a.peserta_didik_id', $id)->get()->getRowObject();

                if (!$pd) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Akun PD tidak ditemukan.";
                    return json_encode($response);
                }

                $html = '<table border="0">
                        <tr>
                            <td>Nama Peserta Didik</td>
                            <td colspan="2">: {{ nama_peserta }}</td>
                        </tr>
                        <tr>
                            <td>NISN</td>
                            <td>: {{ nisn_peserta }}</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>NIK</td>
                            <td>: {{ nik_peserta }}</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Sekolah Asal</td>
                            <td colspan="2">: {{ sekolah_asal_peserta }}</td>
                        </tr>
                        <tr>
                            <td>NPSN Asal</td>
                            <td>: {{ npsn_asal_peserta }}</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Tempat Lahir</td>
                            <td>: {{ tempat_lahir_peserta }}</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir</td>
                            <td>: {{ tanggal_lahir_peserta }}</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>';

                $html1 = '<table>
                        <tr>
                            <td>Username</td>
                            <td>: <b>{{ username_peserta }}</b></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Password</td>
                            <td>: <b>{{ password_peserta }}</b></td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>';
                $html2 = '<p><center>Akun peserta PPDB ini digunakan untuk pendaftaran<br />PPDB ke sekolah jenjang berikutnya melalui laman: <br /><b>https://ppdb.lampungtengahkab.go.id</b></center></p>';

                $html = str_replace('{{ nama_peserta }}', $pd->nama, $html);
                $html = str_replace('{{ nisn_peserta }}', $pd->nisn, $html);
                $html = str_replace('{{ nik_peserta }}', $pd->nik, $html);
                $html = str_replace('{{ sekolah_asal_peserta }}', $pd->nama_sekolah_asal, $html);
                $html = str_replace('{{ npsn_asal_peserta }}', $pd->npsn_asal, $html);
                $html = str_replace('{{ tempat_lahir_peserta }}', $pd->tempat_lahir, $html);
                $html = str_replace('{{ tanggal_lahir_peserta }}', $pd->tanggal_lahir, $html);

                $html1 = str_replace('{{ username_peserta }}', $pd->username, $html1);
                $html1 = str_replace('{{ password_peserta }}', $pd->acc_reg, $html1);

                $kop = '<table border="0">
                    <tr>
                        <td width="17%" rowspan="4"><img src="https://ppdb.esline.id/favicon/apple-icon-120x120.png" style="width: 70px;" alt="Logo"></td>
                        <td width="83%">DINAS PENDIDIKAN DAN KEBUDAYAAN</td>
                    </tr>
                    <tr>
                        <td width="83%">KABUPATEN LAMPUNG TENGAH</td>
                    </tr>
                    <tr>
                        <td width="83%">PENERIMAAN PESERTA DIDIK BARU (PPDB)</td>
                    </tr>
                    <tr>
                        <td width="83%">TAHUN PELAJARAN 2024/2025</td>
                    </tr>
                </table>';
                $pdf = new TcpdfFpdi('P', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);

                // Load HTML content
                $pdf->AddPage();
                $pdf->SetFont('times', 'B', 12);
                $pdf->MultiCell(180, 10, $kop, 0, 'C', false, 1, 20, null, true, 0, true);
                $pdf->MultiCell(180, 10, '<hr />', 0, 'C', false, 1, 20, null, true, 0, true);
                // $pdf->Cell(200, 10, 'KARTU AKUN PPDB KAB. LAMPUNG TENGAH TAHUN 2024/2025', 0, 1, 'C');
                $pdf->Ln(10);
                $pdf->SetFont('times', 'N', 12);
                $pdf->MultiCell(180, 10, '<h4>DATA PESERTA DIDIK</h4>', 0, 'L', false, 1, 20, null, true, 0, true);
                $pdf->MultiCell(180, 10, $html, 0, 'L', false, 1, 20, null, true, 0, true);
                $pdf->Ln(10);
                $pdf->MultiCell(180, 10, '<h4>AKUN PESERTA PPDB</h4>', 0, 'L', false, 1, 20, null, true, 0, true);
                $pdf->MultiCell(180, 10, $html1, 0, 'L', false, 1, 20, null, true, 0, true);
                $pdf->Ln(20);
                $pdf->MultiCell(180, 10, $html2, 0, 'C', false, 1, 20, null, true, 0, true);
                $pdf->Ln(20);
                $pdf->MultiCell(70, 20, "PANITIA PPDB DINAS,", 0, 'L', false, 1, 130, null, true, 0, true);
                $pdf->Ln(10);
                $pdf->MultiCell(70, 20, $user->data->nama, 0, 'L', false, 1, 130, null, true, 0, true);

                // $pdf->WriteHTML($html);

                // Output PDF
                $dir = FCPATH . "uploads/temp";
                $filename = 'Akun_PPDB_' . $pd->nisn . '.pdf';
                $fileName = $dir . '/' . $filename;
                $pdf->Output($fileName, 'F'); // Generate and save to temporary file

                sleep(2);

                $fileContent = file_get_contents($fileName);
                $base64Data = base64_encode($fileContent);
                unlink($fileName); // Delete the temporary file

                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Akun Berhasil Didownload.";
                $response->data = $base64Data;
                $response->filename = $filename;
                return json_encode($response);
                // } else {
                //     $response = new \stdClass;
                //     $response->status = 400;
                //     $response->message = "Gagal mengenerate data.";
                //     return json_encode($response);
                // }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
