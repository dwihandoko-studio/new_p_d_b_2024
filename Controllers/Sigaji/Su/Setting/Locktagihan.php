<?php

namespace App\Controllers\Sigaji\Su\Setting;

use App\Controllers\BaseController;
use App\Models\Sigaji\Su\LocktagihanModel;
use Config\Services;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Sigaji\Acclib;

class Locktagihan extends BaseController
{
    var $folderImage = 'masterdata';
    private $_db;
    private $_acc_lib;
    private $model;

    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect('sigaji');
        $this->_acc_lib      = new Acclib();
    }

    public function getAll()
    {
        $request = Services::request();
        $datamodel = new LocktagihanModel($request);


        $lists = $datamodel->get_datatables();
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            $isLocked = $this->_acc_lib->getLockedSIPD($list->id);
            if ($isLocked) {
                $action = '<div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                        <div class="dropdown-menu" style="">
                            <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->id . '\', \'' . $list->tahun . '\', \'' . $list->bulan . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
                        </div>
                    </div>';
            } else {
                $action = '<div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                        <div class="dropdown-menu" style="">
                            <a class="dropdown-item" href="javascript:actionLock(\'' . $list->id . '\', \'' . $list->tahun . '\', \'' . $list->bulan . '\');"><i class="fas fa-lock font-size-16 align-middle"></i> &nbsp;Kunci Tagihan</a>
                        </div>
                    </div>';
            }
            // $action = '<a href="javascript:actionDetail(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama) . '\');"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bxs-show font-size-16 align-middle"></i></button>
            //     </a>
            //     <a href="javascript:actionSync(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->kode_kecamatan . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-transfer-alt font-size-16 align-middle"></i></button>
            //     </a>
            //     <a href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama) . '\');" class="delete" id="delete"><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-trash font-size-16 align-middle"></i></button>
            //     </a>';
            $row[] = $action;
            $row[] = $list->tahun;
            $row[] = $list->bulan;
            $row[] = $list->bulan_name;
            $row[] = $isLocked ? '<span class="badge rounded-pill bg-success">TERKUNCI</span>' : '<span class="badge rounded-pill bg-danger">TERBUKA</span>';

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
        return redirect()->to(base_url('sigaji/su/setting/locktagihan/data'));
    }

    public function data()
    {
        $data['title'] = 'DATA LOCK TAGIHAN';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        // $data['status_mt'] = $this->_db->table('_tb_maintenance')->where(['id' => 1, 'status' => 1])->countAllResults();

        $data['user'] = $user->data;

        return view('sigaji/su/setting/locktagihan/index', $data);
    }

    // public function detail()
    // {
    //     if ($this->request->getMethod() != 'post') {
    //         $response = new \stdClass;
    //         $response->status = 400;
    //         $response->message = "Permintaan tidak diizinkan";
    //         return json_encode($response);
    //     }

    //     $rules = [
    //         'id' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Id tidak boleh kosong. ',
    //             ]
    //         ],
    //     ];

    //     if (!$this->validate($rules)) {
    //         $response = new \stdClass;
    //         $response->status = 400;
    //         $response->message = $this->validator->getError('id');
    //         return json_encode($response);
    //     } else {
    //         $id = htmlspecialchars($this->request->getVar('id'), true);

    //         $current = $this->_db->table('_users_tb')
    //             ->where('uid', $id)->get()->getRowObject();

    //         if ($current) {
    //             $data['data'] = $current;
    //             $response = new \stdClass;
    //             $response->status = 200;
    //             $response->message = "Permintaan diizinkan";
    //             $response->data = view('a/setting/pengguna/detail', $data);
    //             return json_encode($response);
    //         } else {
    //             $response = new \stdClass;
    //             $response->status = 400;
    //             $response->message = "Data tidak ditemukan";
    //             return json_encode($response);
    //         }
    //     }
    // }

    // public function edit()
    // {
    //     if ($this->request->getMethod() != 'post') {
    //         $response = new \stdClass;
    //         $response->status = 400;
    //         $response->message = "Permintaan tidak diizinkan";
    //         return json_encode($response);
    //     }

    //     $rules = [
    //         'id' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Id tidak boleh kosong. ',
    //             ]
    //         ],
    //     ];

    //     if (!$this->validate($rules)) {
    //         $response = new \stdClass;
    //         $response->status = 400;
    //         $response->message = $this->validator->getError('id');
    //         return json_encode($response);
    //     } else {
    //         $id = htmlspecialchars($this->request->getVar('id'), true);

    //         $current = $this->_db->table('_users_tb')
    //             ->where('uid', $id)->get()->getRowObject();

    //         if ($current) {
    //             $data['data'] = $current;
    //             $response = new \stdClass;
    //             $response->status = 200;
    //             $response->message = "Permintaan diizinkan";
    //             $response->data = view('a/setting/pengguna/edit', $data);
    //             return json_encode($response);
    //         } else {
    //             $response = new \stdClass;
    //             $response->status = 400;
    //             $response->message = "Data tidak ditemukan";
    //             return json_encode($response);
    //         }
    //     }
    // }

    public function unlock()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

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
            $id = htmlspecialchars($this->request->getVar('id'), true);

            $this->_db->transBegin();
            try {
                $this->_db->table('tb_gaji_sipd')->where(['tahun' => $id, 'is_locked' => 1])->update(['is_locked' => 0]);

                if ($this->_db->affectedRows() > 0) {
                    $this->_db->transCommit();
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Berhasil membuka kunci tagihan.";
                    return json_encode($response);
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal membuka kunci tagihan.";
                    return json_encode($response);
                }
            } catch (\Throwable $th) {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal membuka kunci tagihan.";
                return json_encode($response);
            }
        }
    }

    public function lock()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

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
            $id = htmlspecialchars($this->request->getVar('id'), true);

            $this->_db->transBegin();
            try {
                $this->_db->table('tb_gaji_sipd')->where(['tahun' => $id, 'is_locked' => 0])->update(['is_locked' => 1]);

                if ($this->_db->affectedRows() > 0) {
                    $this->_db->transCommit();
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Berhasil Mengunci tagihan.";
                    return json_encode($response);
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal Mengunci Tagihan.";
                    return json_encode($response);
                }
            } catch (\Throwable $th) {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal Mengunci Tagihan.";
                return json_encode($response);
            }
        }
    }

    // public function delete()
    // {
    //     if ($this->request->getMethod() != 'post') {
    //         $response = new \stdClass;
    //         $response->status = 400;
    //         $response->message = "Permintaan tidak diizinkan";
    //         return json_encode($response);
    //     }

    //     $rules = [
    //         'id' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Id tidak boleh kosong. ',
    //             ]
    //         ],
    //     ];

    //     if (!$this->validate($rules)) {
    //         $response = new \stdClass;
    //         $response->status = 400;
    //         $response->message = $this->validator->getError('id');
    //         return json_encode($response);
    //     } else {
    //         $id = htmlspecialchars($this->request->getVar('id'), true);

    //         $Profilelib = new Profilelib();
    //         $user = $Profilelib->user();
    //         if ($user->status != 200) {
    //             delete_cookie('jwt');
    //             session()->destroy();
    //             $response = new \stdClass;
    //             $response->status = 401;
    //             $response->message = "Permintaan diizinkan";
    //             return json_encode($response);
    //         }
    //         $current = $this->_db->table('_users_tb')
    //             ->where('uid', $id)->get()->getRowObject();

    //         if ($current) {
    //             $this->_db->transBegin();
    //             try {
    //                 $this->_db->table('_users_tb')->where('uid', $id)->delete();

    //                 if ($this->_db->affectedRows() > 0) {
    //                     try {
    //                         $dir = FCPATH . "uploads/user";
    //                         unlink($dir . '/' . $current->image);
    //                     } catch (\Throwable $err) {
    //                     }
    //                     $this->_db->transCommit();
    //                     $response = new \stdClass;
    //                     $response->status = 200;
    //                     $response->message = "Data berhasil dihapus.";
    //                     return json_encode($response);
    //                 } else {
    //                     $this->_db->transRollback();
    //                     $response = new \stdClass;
    //                     $response->status = 400;
    //                     $response->message = "Data gagal dihapus.";
    //                     return json_encode($response);
    //                 }
    //             } catch (\Throwable $th) {
    //                 $this->_db->transRollback();
    //                 $response = new \stdClass;
    //                 $response->status = 400;
    //                 $response->message = "Data gagal dihapus.";
    //                 return json_encode($response);
    //             }
    //         } else {
    //             $response = new \stdClass;
    //             $response->status = 400;
    //             $response->message = "Data tidak ditemukan";
    //             return json_encode($response);
    //         }
    //     }
    // }

    // public function editSave()
    // {
    //     if ($this->request->getMethod() != 'post') {
    //         $response = new \stdClass;
    //         $response->status = 400;
    //         $response->message = "Permintaan tidak diizinkan";
    //         return json_encode($response);
    //     }

    //     $rules = [
    //         'id' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Id buku tidak boleh kosong. ',
    //             ]
    //         ],
    //         'nama' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Nama tidak boleh kosong. ',
    //             ]
    //         ],
    //         'email' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Email tidak boleh kosong. ',
    //             ]
    //         ],
    //         'nohp' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'No handphone tidak boleh kosong. ',
    //             ]
    //         ],
    //         'nip' => [
    //             'rules' => 'required',
    //             'errors' => [
    //                 'required' => 'NIP tidak boleh kosong. ',
    //             ]
    //         ],
    //         'alamat' => [
    //             'rules' => 'required',
    //             'errors' => [
    //                 'required' => 'Alamat tidak boleh kosong. ',
    //             ]
    //         ],
    //         'status' => [
    //             'rules' => 'required',
    //             'errors' => [
    //                 'required' => 'Status tidak boleh kosong. ',
    //             ]
    //         ],
    //     ];

    //     $filenamelampiran = dot_array_search('file.name', $_FILES);
    //     if ($filenamelampiran != '') {
    //         $lampiranVal = [
    //             'file' => [
    //                 'rules' => 'uploaded[file]|max_size[file,512]|is_image[file]',
    //                 'errors' => [
    //                     'uploaded' => 'Pilih gambar profil terlebih dahulu. ',
    //                     'max_size' => 'Ukuran gambar profil terlalu besar. ',
    //                     'is_image' => 'Ekstensi yang anda upload harus berekstensi gambar. '
    //                 ]
    //             ],
    //         ];
    //         $rules = array_merge($rules, $lampiranVal);
    //     }

    //     if (!$this->validate($rules)) {
    //         $response = new \stdClass;
    //         $response->status = 400;
    //         $response->message = $this->validator->getError('nama')
    //             . $this->validator->getError('id')
    //             . $this->validator->getError('email')
    //             . $this->validator->getError('nohp')
    //             . $this->validator->getError('nip')
    //             . $this->validator->getError('alamat')
    //             . $this->validator->getError('status')
    //             . $this->validator->getError('file');
    //         return json_encode($response);
    //     } else {
    //         $Profilelib = new Profilelib();
    //         $user = $Profilelib->user();
    //         if ($user->status != 200) {
    //             delete_cookie('jwt');
    //             session()->destroy();
    //             $response = new \stdClass;
    //             $response->status = 401;
    //             $response->message = "Permintaan diizinkan";
    //             return json_encode($response);
    //         }

    //         $id = htmlspecialchars($this->request->getVar('id'), true);
    //         $nama = htmlspecialchars($this->request->getVar('nama'), true);
    //         $email = htmlspecialchars($this->request->getVar('email'), true);
    //         $nohp = htmlspecialchars($this->request->getVar('nohp'), true);
    //         $nip = htmlspecialchars($this->request->getVar('nip'), true);
    //         $alamat = htmlspecialchars($this->request->getVar('alamat'), true);
    //         $status = htmlspecialchars($this->request->getVar('status'), true);

    //         $oldData =  $this->_db->table('_users_tb')->where('uid', $id)->get()->getRowObject();

    //         if (!$oldData) {
    //             $response = new \stdClass;
    //             $response->status = 400;
    //             $response->message = "Data tidak ditemukan.";
    //             return json_encode($response);
    //         }

    //         if (
    //             $nama === $oldData->fullname
    //             && $email === $oldData->email
    //             && $nohp === $oldData->no_hp
    //             && $nip === $oldData->nip
    //             && $alamat === $oldData->alamat
    //             && (int)$status === (int)$oldData->is_active
    //         ) {
    //             if ($filenamelampiran == '') {
    //                 $response = new \stdClass;
    //                 $response->status = 201;
    //                 $response->message = "Tidak ada perubahan data yang disimpan.";
    //                 $response->redirect = base_url('a/setting/pengguna/data');
    //                 return json_encode($response);
    //             }
    //         }

    //         if ($email !== $oldData->email) {
    //             $cekData = $this->_db->table('_users_tb')->where(['email' => $email])->get()->getRowObject();
    //             if ($cekData) {
    //                 $response = new \stdClass;
    //                 $response->status = 400;
    //                 $response->message = "Email sudah terdaftar.";
    //                 return json_encode($response);
    //             }
    //         }

    //         $data = [
    //             'email' => $email,
    //             'fullname' => $nama,
    //             'no_hp' => $nohp,
    //             'nip' => $nip,
    //             'alamat' => $alamat,
    //             'is_active' => $status,
    //             'updated_at' => date('Y-m-d H:i:s'),
    //         ];
    //         $dir = FCPATH . "uploads/user";

    //         if ($filenamelampiran != '') {
    //             $lampiran = $this->request->getFile('file');
    //             $filesNamelampiran = $lampiran->getName();
    //             $newNamelampiran = _create_name_foto($filesNamelampiran);

    //             if ($lampiran->isValid() && !$lampiran->hasMoved()) {
    //                 $lampiran->move($dir, $newNamelampiran);
    //                 $data['image'] = $newNamelampiran;
    //             } else {
    //                 $response = new \stdClass;
    //                 $response->status = 400;
    //                 $response->message = "Gagal mengupload gambar.";
    //                 return json_encode($response);
    //             }
    //         }

    //         $this->_db->transBegin();
    //         try {
    //             $this->_db->table('_users_tb')->where('uid', $oldData->uid)->update($data);
    //         } catch (\Exception $e) {
    //             unlink($dir . '/' . $newNamelampiran);
    //             $this->_db->transRollback();
    //             $response = new \stdClass;
    //             $response->status = 400;
    //             $response->message = "Gagal menyimpan gambar baru.";
    //             return json_encode($response);
    //         }

    //         if ($this->_db->affectedRows() > 0) {
    //             try {
    //                 unlink($dir . '/' . $oldData->image);
    //             } catch (\Throwable $th) {
    //             }
    //             $this->_db->transCommit();
    //             $response = new \stdClass;
    //             $response->status = 200;
    //             $response->message = "Data berhasil diupdate.";
    //             $response->redirect = base_url('a/setting/pengguna/data');
    //             return json_encode($response);
    //         } else {
    //             unlink($dir . '/' . $newNamelampiran);
    //             $this->_db->transRollback();
    //             $response = new \stdClass;
    //             $response->status = 400;
    //             $response->message = "Gagal mengupate data";
    //             return json_encode($response);
    //         }
    //     }
    // }
}
