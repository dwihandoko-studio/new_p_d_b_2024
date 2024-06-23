<?php

namespace App\Controllers\Pan\Laporan;

use App\Controllers\BaseController;
use App\Models\Pan\Laporan\BaModel;
use Config\Services;
use App\Libraries\Profilelib;
use App\Libraries\Ppdb\Sek\Riwayatlib;
use App\Libraries\Ppdb\Notificationlib;
use App\Libraries\Apilib;
use App\Libraries\Uuid;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use setasign\Fpdi\TcpdfFpdi;

class Ba extends BaseController
{
    var $folderImage = 'masterdata';
    private $_db;
    private $model;

    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }

    public function getAll()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->userSekolah();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $request = Services::request();
        $datamodel = new BaModel($request);


        $lists = $datamodel->get_datatables($user->data->id);
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            // $row[] = $no;
            // $action = '<div class="btn-group">
            //                 <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
            //                 <div class="dropdown-menu" style="">
            //                     <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->peserta_didik_id . '\', \'' . str_replace("'", "", $list->nama) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
            //                     <a class="dropdown-item" href="javascript:actionResetPassword(\'' . $list->peserta_didik_id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\');"><i class="bx bx-key font-size-16 align-middle"></i> &nbsp;Reset Password</a>
            //                     <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->peserta_didik_id . '\', \'' . str_replace("'", "", $list->nama)  . '\');"><i class="bx bx-trash font-size-16 align-middle"></i> &nbsp;Hapus</a>
            //                     <div class="dropdown-divider"></div>
            //                 </div>
            //             </div>';
            $action = '<a href="javascript:actionDownload(\'' . $list->id_perubahan . '\');" class="btn btn-xs btn-primary waves-effect waves-light"><i class="las la-eye font-size-16 align-middle me-2" style="font-size: 1.5rem !important;"></i> DETAIL</a>';

            $row[] = $action;
            $row[] = "BA.{$list->id}/PD/PPDB/2024";
            $row[] = $list->nama_pengaju;
            $row[] = $list->status_pengaju;
            $row[] = $list->perubahan_pengaju;

            $data[] = $row;
        }
        $output = [
            "draw" => $request->getPost('draw'),
            "recordsTotal" => $datamodel->count_all($user->data->id),
            "recordsFiltered" => $datamodel->count_filtered($user->data->id),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function index()
    {
        return redirect()->to(base_url('pan/laporan/ba/data'));
    }

    public function data()
    {
        $data['title'] = 'DATA BERITA ACARA';
        $Profilelib = new Profilelib();
        $user = $Profilelib->userSekolah();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;
        $refSekolah = $this->_db->table('dapo_sekolah')->select("status_sekolah_id")->where('sekolah_id', $user->data->sekolah_id)->get()->getRowObject();
        if (!$refSekolah) {
            redirect()->to(base_url('pan/home'));
        }
        if ((int)$refSekolah->status_sekolah_id == 1) {
            $data['sekNegeri'] = true;
            $data['sekSwasta'] = false;
        } else {
            $data['sekNegeri'] = false;
            $data['sekSwasta'] = true;
        }

        return view('pan/laporan/ba/index', $data);
    }

    public function download_berita_acara()
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
                $user = $Profilelib->userSekolah();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Session expired";
                    return json_encode($response);
                }

                $id = htmlspecialchars($this->request->getVar('id'), true);

                $data = $this->_db->table('riwayat_perubahan_data a')
                    ->select("a.*, b.nama as nama_panitia")
                    ->join('_users_profile_sekolah b', 'a.user_id = b.user_id')
                    ->where('a.id_perubahan', $id)->get()->getRowObject();

                if (!$data) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data perubahan tidak ditemukan";
                    return json_encode($response);
                }

                $htmlPengaju = '<table border="0">
                            <tr>
                                <td>Nama</td>
                                <td colspan="2">: <b>{{ nama_pengaju }}</b></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td colspan="2">: {{ status_pengaju }}</td>
                            </tr>
                        </table>';

                $htmlPeserta = '<table>
                            <tr>
                                <td>Nama Peserta</td>
                                <td colspan="2">: {{ nama_peserta }}</td>
                            </tr>
                            <tr>
                                <td>Nomor Peserta</td>
                                <td colspan="2">: <b>{{ nomor_peserta }}</b></td>
                            </tr>
                            <tr>
                                <td>NISN Peserta</td>
                                <td colspan="2">: {{ nisn_peserta }}</td>
                            </tr>
                            <tr>
                                <td>Nama Sekolah Asal</td>
                                <td colspan="2">: {{ nama_sekolah_asal }}</td>
                            </tr>
                            <tr>
                                <td>Jalur PPDB</td>
                                <td colspan="2">: {{ jalur_ppdb }}</td>
                            </tr>
                        </table>';

                $htmlPerubahan = '<table border="1" style="padding: 5px;">';
                $htmlPerubahan .= '<tr><td>Atribut</td><td>Data Lama</td><td>Data Baru</td></tr>';

                $dataLama = json_decode($data->data_lama);
                $dataBaru = json_decode($data->data_baru);

                if ($data->perubahan_pengaju === "domisili") {
                    if ($dataLama->kab_peserta !== $dataBaru->kab_peserta) {
                        $kabupatenNameL = getNameKabupaten($dataLama->kab_peserta);
                        $kabupatenNameB = getNameKabupaten($dataBaru->kab_peserta);
                        $htmlPerubahan .= '
                            <tr>
                                <td>Kabupaten</td>
                                <td>' . $kabupatenNameL . '</td>
                                <td>' . $kabupatenNameB . '</td>
                            </tr>
                        ';
                    }
                    if ($dataLama->kec_peserta !== $dataBaru->kec_peserta) {
                        $kecamatanNameL = getNameKecamatan($dataLama->kec_peserta);
                        $kecamatanNameB = getNameKecamatan($dataBaru->kec_peserta);
                        $htmlPerubahan .= '
                            <tr>
                                <td>Kecamatan</td>
                                <td>' . $kecamatanNameL . '</td>
                                <td>' . $kecamatanNameB . '</td>
                            </tr>
                        ';
                    }
                    if ($dataLama->kel_peserta !== $dataBaru->kel_peserta) {
                        $kelurahanNameL = getNameKelurahan($dataLama->kel_peserta);
                        $kelurahanNameB = getNameKelurahan($dataBaru->kel_peserta);
                        $htmlPerubahan .= '
                            <tr>
                                <td>Kelurahan</td>
                                <td>' . $kelurahanNameL . '</td>
                                <td>' . $kelurahanNameB . '</td>
                            </tr>
                        ';
                    }
                    if ($dataLama->dusun_peserta !== $dataBaru->dusun_peserta) {
                        $dusunNameL = getNameDusun($dataLama->dusun_peserta);
                        $dusunNameB = getNameDusun($dataBaru->dusun_peserta);
                        $htmlPerubahan .= '
                            <tr>
                                <td>Dusun</td>
                                <td>' . $dusunNameL . '</td>
                                <td>' . $dusunNameB . '</td>
                            </tr>
                        ';
                    }
                    if ($dataLama->lat_long_peserta !== $dataBaru->lat_long_peserta) {
                        $latLongL = explode(",", $dataLama->lat_long_peserta);
                        $latLongB = explode(",", $dataBaru->lat_long_peserta);
                        $htmlPerubahan .= '
                            <tr>
                                <td>Lintang</td>
                                <td>' . $latLongL[0] . '</td>
                                <td>' . $latLongB[0] . '</td>
                            </tr>
                            <tr>
                                <td>Bujur</td>
                                <td>' . $latLongL[1] . '</td>
                                <td>' . $latLongB[1] . '</td>
                            </tr>
                        ';
                    }
                    if ($dataLama->jarak_domisili !== $dataBaru->jarak_domisili) {
                        $jarakL = round($dataLama->jarak_domisili, 3);
                        $jarakB = round($dataBaru->jarak_domisili, 3);
                        $htmlPerubahan .= '
                            <tr>
                                <td>Jarak Domisili</td>
                                <td>' . $jarakL . 'Km</td>
                                <td>' . $jarakB . 'Km</td>
                            </tr>
                        ';
                    }
                } else {
                    if ($dataLama->kab_peserta !== $dataBaru->kab_peserta) {
                        $kabupatenNameL = getNameKabupaten($dataLama->kab_peserta);
                        $kabupatenNameB = getNameKabupaten($dataBaru->kab_peserta);
                        $htmlPerubahan .= '
                            <tr>
                                <td>Kabupaten</td>
                                <td>$kabupatenNameL</td>
                                <td>$kabupatenNameB</td>
                            </tr>
                        ';
                    }
                }

                $htmlPerubahan .= '</table>';

                $penutup = 'Berdasarkan dokumen ';
                if ($data->perubahan_pengaju === "domisili") {
                    $penutup .= 'kependudukan ';
                } else {
                    $penutup .= 'prestasi ';
                }
                $penutup .= "yang dimiliki, pengajuan perbaikan data {$data->perubahan_pengaju} disetujui oleh Panitia PPDB {$dataLama->nama_sekolah_tujuan} (NPSN: {$dataLama->npsn_sekolah_tujuan}).";

                $tglPerbaikan = "Lampung Tengah, " . tgl_indo($data->created_at);

                $bottom = '<table>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Orang Tua/Wali</td>
                            <td>&nbsp;</td>
                            <td>Panitia PPDB</td>
                            <td rowspan="5"><img src="https://qrcode.esline.id/generate?data=https://ppdb.lampungtengahkab.go.id/home/qrcode?ba={{ id_perubahan }}" style="width: 80px;" alt="Logo"></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>{{ nama_pengaju }}</td>
                            <td>&nbsp;</td>
                            <td>{{ nama_panitia }}</td>
                        </tr>
                    </table>';

                $htmlPengaju = str_replace('{{ nama_pengaju }}', $data->nama_pengaju, $htmlPengaju);
                $htmlPengaju = str_replace('{{ status_pengaju }}', $data->status_pengaju, $htmlPengaju);

                $htmlPeserta = str_replace('{{ nomor_peserta }}', $dataLama->kode_pendaftaran, $htmlPeserta);
                $htmlPeserta = str_replace('{{ nama_peserta }}', $dataLama->nama_peserta, $htmlPeserta);
                $htmlPeserta = str_replace('{{ nisn_peserta }}', $dataLama->nisn_peserta, $htmlPeserta);
                $htmlPeserta = str_replace('{{ nama_sekolah_asal }}', $dataLama->nama_sekolah_asal . " (NPSN: " . $dataLama->npsn_sekolah_asal . ")", $htmlPeserta);
                $htmlPeserta = str_replace('{{ jalur_ppdb }}', $dataLama->via_jalur, $htmlPeserta);

                $bottom = str_replace('{{ nama_pengaju }}', ucwords(strtolower($data->nama_pengaju)), $bottom);
                $bottom = str_replace('{{ nama_panitia }}', ucwords(strtolower($data->nama_panitia)), $bottom);
                $bottom = str_replace('{{ id_perubahan }}', $data->id_perubahan, $bottom);

                $pdf = new TcpdfFpdi('P', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);

                // Load HTML content
                $pdf->AddPage();
                // $pdf->SetFont('times', 'B', 12);
                $pdf->SetFont('times', 'B', 12);
                // $pdf->MultiCell(180, 10, $kop, 0, 'C', false, 1, 20, null, true, 0, true);
                // $pdf->MultiCell(180, 10, '<hr />', 0, 'C', false, 1, 20, null, true, 0, true);
                // $pdf->Cell(200, 10, 'KARTU AKUN PPDB KAB. LAMPUNG TENGAH TAHUN 2024/2025', 0, 1, 'C');
                $pdf->Ln(10);
                $pdf->MultiCell(180, 1, '<u>Berita Acara Layanan Perbaikan Data</u>', 0, 'C', false, 1, 20, null, true, 0, true);
                $pdf->SetFont('times', 'N', 12);
                $nomorSurat = "Nomor Pelayanan: BA.{$data->id}/PD/PPDB/2024";
                $pdf->MultiCell(180, 1, $nomorSurat, 0, 'C', false, 1, 20, null, true, 0, true);
                // $pdf->MultiCell(180, 5, '<h4>TAHUN PELAJARAN 2024/2025</h4>', 0, 'C', false, 1, 20, null, true, 0, true);
                $pdf->Ln(10);
                $pdf->MultiCell(180, 10, $htmlPengaju, 0, 'L', false, 1, 20, null, true, 0, true);
                $pdf->Ln(5);
                $centerContent = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Telah mengajukan perubahan data {$data->perubahan_pengaju} peserta atas nama: ";
                $pdf->MultiCell(180, 10, $centerContent, 0, 'L', false, 1, 20, null, true, 0, true);
                $pdf->Ln(4);
                $pdf->MultiCell(180, 10, $htmlPeserta, 0, 'L', false, 1, 20, null, true, 0, true);
                $pdf->Ln(4);
                $pdf->MultiCell(180, 10, 'Data yang diajukan perbaikan :', 0, 'L', false, 1, 20, null, true, 0, true);
                $pdf->MultiCell(180, 10, $htmlPerubahan, 0, 'L', false, 1, 20, null, true, 0, true);
                $pdf->Ln(4);
                $pdf->MultiCell(180, 5, $penutup, 0, 'L', false, 1, 20, null, true, 0, true);
                $pdf->Ln(10);
                $pdf->MultiCell(180, 5, $tglPerbaikan, 0, 'C', false, 1, 20, null, true, 0, true);
                $pdf->MultiCell(180, 10, $bottom, 0, 'C', false, 1, 20, null, true, 0, true);
                // $pdf->Ln(20);
                // $pdf->MultiCell(70, 20, "OPERATOR {$pd->nama_sekolah_asal}", 0, 'L', false, 1, 130, null, true, 0, true);
                // $pdf->Ln(10);
                // $pdf->MultiCell(70, 20, $user->data->nama, 0, 'L', false, 1, 130, null, true, 0, true);

                // $pdf->WriteHTML($html);

                // Output PDF
                $dir = FCPATH . "uploads/temp";
                $filename = 'Berita_acara_perubahan_data_' . $data->id . '.pdf';
                $fileName = $dir . '/' . $filename;
                $pdf->Output($fileName, 'F'); // Generate and save to temporary file

                sleep(2);

                $fileContent = file_get_contents($fileName);
                $base64Data = base64_encode($fileContent);
                // unlink($fileName); // Delete the temporary file

                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Berita Acara Berhasil Didownload.";
                $response->data = $base64Data;
                $response->filename = $filename;
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
