<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Notif_model');
    }

    public function topup_investasi($id_member)
    {
        if ($_POST) {

            if ($_POST['jumlah_investasi'] == '' OR $_POST['jumlah_investasi'] == '0') {
                ?>
                <script type="text/javascript">
                    WebAppInterface.showToast("Total transfer tidak boleh 0");
                    WebAppInterface.redirect();
                </script>
                <?php
                exit;
            }

            $gambar = upload_gambar_biasa('bukti_tf_', 'image/bukti/', 'jpg|jpeg|png', 10000, 'bukti_transfer');
            if ($_FILES['bukti_transfer']['name'] != '') {
                $_POST['bukti_transfer'] = $gambar;
            }
            $_POST['id_member'] = $id_member;
            $_POST['created_at'] = get_waktu();
            $simpan = $this->db->insert('transaksi_investasi', $_POST);
            if ($simpan) {
                ?>
                <script type="text/javascript">
                    WebAppInterface.showToast("Data berhasil disimpan, silahkan tunggu konfirmasi admin !");
                    WebAppInterface.redirect();
                </script>
                <?php
            } else {

            }


        } else {
            $data = array (
                'judul_page' => 'Topup Investasi',
                'konten' => 'transaksi/topup_inv',
            );
        $this->load->view('v_index', $data);
        }
    }

    public function agen($id,$n)
    {
        $this->db->where('id_member', $id);
        $this->db->update('member', array('is_agen'=>$n));
        redirect("app/member");
    }


    public function simulasi_investasi()
    {
        $data = array (
            'judul_page' => 'Simulasi Investasi',
            'konten' => 'transaksi/simulasi',
        );
        $this->load->view('v_index', $data);
    }

    public function kartu_member()
    {
        $this->load->view('kartu_member');
    }

    public function member()
    {
        $data = array (
            'judul_page' => 'Data Member',
            'konten' => 'member/view',
        );
        $this->load->view('v_index', $data);
    }

    public function hapus_member($id_member)
    {
        $this->db->where('id_member', $id_member);
        $this->db->delete('member');
        ?>
        <script type="text/javascript">
            alert("Data member berhasil dihapus !");
            window.location="<?php echo base_url() ?>app/member"
        </script>
        <?php
    }

    public function hapus_investasi($id_investasi)
    {
        $this->db->where('id_transaksi', $id_investasi);
        $this->db->delete('transaksi_investasi');
        ?>
        <script type="text/javascript">
            alert("Data berhasil dihapus !");
            window.location="<?php echo base_url() ?>app/investasi"
        </script>
        <?php
    }

    public function investasi()
    {
        $data = array (
            'judul_page' => 'Data Investasi',
            'konten' => 'transaksi/investasi_masuk',
        );
        $this->load->view('v_index', $data);
    }

    public function konfirmasi_inv($id,$n)
    {
        $this->db->where('id_transaksi', $id);
        $this->db->update('transaksi_investasi', array('konfirmasi'=>$n));
        
        // generate jadwal transfer
        if ($n == 'y') {

            $this->db->where('id_transaksi', $id);
            $cek_jadwal = $this->db->get('jadwal_transfer');
            if ($cek_jadwal->num_rows() > 0) {
                // code...
            } else {
                $this->db->where('id_transaksi', $id);
                $dt_trans = $this->db->get('transaksi_investasi')->row();

                if ($dt_trans->plan == 'mingguan') {
                    $waktu = 32;
                    $persen = 0.08;
                } elseif($dt_trans->plan == 'bulanan') {
                    $waktu = 12;
                    $persen = 0.25;
                }

                $jml_trf = ($dt_trans->jumlah_investasi - $dt_trans->kode_unik) * $persen;
                $tgl1 = $dt_trans->tanggal_transfer;
                $xx = 7;
                $x_bln = 1;
                $no = 1;
                for ($i=1; $i <= $waktu ; $i++) { 

                    if ($dt_trans->plan == 'mingguan') {
                        $jadwal_transfer = date('Y-m-d', strtotime('+'.$xx.' days', strtotime($tgl1)));
                    } elseif($dt_trans->plan == 'bulanan') {
                        $jadwal_transfer = date('Y-m-d', strtotime('+'.$x_bln.' month', strtotime($tgl1)));
                    }
                    
                    
                    // log_data($no.' '.$jml_trf.' '.$tgl2);

                    $this->db->insert('jadwal_transfer', array(
                        'id_transaksi' => $dt_trans->id_transaksi,
                        'no_transaksi' => $dt_trans->no_transaksi,
                        'id_member' => $dt_trans->id_member,
                        'nominal' => $jml_trf,
                        'nama' => get_data('member','id_member',$dt_trans->id_member,'nama'),
                        'jadwal_transfer' => $jadwal_transfer,
                        'ke' => $no
                    ));

                    if ($dt_trans->plan == 'mingguan') {
                        $xx = $xx+7;
                    } elseif($dt_trans->plan == 'bulanan') {
                        $x_bln = $x_bln+1;
                    }
                    
                    $no++;
                }
            }

            
        }



        redirect("app/investasi");
    }

    public function detail_transaksi($no_transaksi)
    {
        $this->load->view('page_lain/detail_transaksi');
    }

    public function edit_profil($id_member)
    {
        if ($_POST) {
            $this->db->where('id_member', $id_member);
            $this->db->update('member', $_POST);
            ?>
            <script type="text/javascript">
                WebAppInterface.showToast("Data Berhasil diupdate !");
            </script>
            <?php
        } else {
            $this->load->view('page_lain/edit_profil');    
        }
        
    }

    public function reward($id_member)
    {
        $this->load->view('page_lain/reward');
    }

    public function jaringan_member($id_member)
    {
        $cek = $this->db->get_where('member', ['id_member'=> $id_member ]);
        if ($cek->row()->is_agen == 't') {
            ?>
            <script type="text/javascript">
                WebAppInterface.showToast("Maaf kamu bukan agen !");
            </script>
            <?php
        } else {
            $this->load->view('page_lain/jaringan_member');
        }

    }

    public function pengembangan()
    {
        $this->session->set_flashdata('message', alert_biasa('Menu masih dalam tahap pengembangan !','warning'));
        redirect('app','refresh');
    }

    public function api_login()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);

        $condition = array(
            'password' => sha1($decoded_data->password),
            'no_telp' => $decoded_data->no_telp,
            //'token' => $decoded_data->token
        );
        $message = array(
            'code' => '200',
            'message' => 'found',
            'data' => [$condition]//$condition
        );

        echo json_encode($message);
    }

    public function cetak_rekap()
    {
        if ($_POST) {
            $tanggal = $this->input->post('tanggal');
            $data['tanggal'] = $tanggal;
            $this->load->view('cetak/cetak', $data);
        } else {
            $data = array (
                'judul_page' => 'Cetak',
                'konten' => 'cetak/cetak_rekap',
            );
            $this->load->view('v_index', $data);
        }
    }

    public function daftar_member($no_telp_agen)
    {
        if ($_POST) {
            $this->db->where('no_telp', $this->input->post('no_telp'));
            $cek = $this->db->get('member');

            if ($cek->num_rows() > 0) {
                ?>
                <script type="text/javascript">
                    alert("No Telp Sudah Ada");
                    window.location="<?php echo base_url() ?>app/daftar_member/<?php echo $no_telp_agen ?>";
                </script>
                <?php
            } else {
                $this->db->insert('member', $_POST);

                ?>
                <script type="text/javascript">
                    alert("Pendaftaran berhasil, silahkan kamu login");
                    window.location="https://play.google.com/store/apps/details?id=com.apps.jmi"
                </script>
                <?php
            }
        } else {
            $this->load->view('page_lain/daftar_member');
        }

        
    }
    

    public function hasil($value='')
    {
        if ($this->session->userdata('level') == '') {
            redirect('login');
        }
        
        $data = array(
            'konten' => 'hasil',
            'judul_page' => 'Hasil Perhitungan',
        );
        $this->load->view('v_index', $data);
    }
	
	public function index()
	{
        if ($this->session->userdata('level') == '') {
            redirect('login');
        }
        
		$data = array(
			'konten' => 'home_admin',
            'judul_page' => 'Dashboard',
		);
		$this->load->view('v_index', $data);
    }

    public function transfer_now($no_transaksi,$ke)
    {
        $this->db->where('no_transaksi', $no_transaksi);
        $this->db->where('ke', $ke);
        if ($this->db->get('transfer')->num_rows() > 0) {
            // code...
        } else {
            $this->db->where('no_transaksi', $no_transaksi);
            $this->db->where('ke', $ke);
            $data = $this->db->get('jadwal_transfer')->row();

            $insert = [
                'no_transaksi'=> $data->no_transaksi,
                'id_member'=> $data->id_member,
                'keterangan'=> "transfer masuk",
                'tanggal'=> date('Y-m-d'),
                'jam'=> date('H:i:s'),
                'jumlah' => $data->nominal,
                'ke' => $data->ke,
                'created_at' => get_waktu()
            ];
            $this->db->insert('transfer', $insert);
            ?>
            <script type="text/javascript">
                alert("Data berhasil diupdate");
                window.location="<?php echo base_url() ?>transfer/index/<?php echo $no_transaksi ?>";
            </script>
            <?php
        }
    }

    public function transfer_hari_semua()
    {
        $this->db->where('jadwal_transfer', date('Y-m-d'));
        foreach ($this->db->get('jadwal_transfer')->result() as $rw) {
            $this->db->where('no_transaksi', $rw->no_transaksi);
            $this->db->where('ke', $rw->ke);
            if ($this->db->get('transfer')->num_rows() > 0) {
                // code...
            } else {

                $insert = [
                    'no_transaksi'=> $rw->no_transaksi,
                    'id_member'=> $rw->id_member,
                    'keterangan'=> "transfer masuk",
                    'tanggal'=> date('Y-m-d'),
                    'jam'=> date('H:i:s'),
                    'jumlah' => $rw->nominal,
                    'ke' => $rw->ke,
                    'created_at' => get_waktu()
                ];
                $this->db->insert('transfer', $insert);
            }
        }
        ?>
        <script type="text/javascript">
            alert("Data berhasil diupdate");
            window.location="<?php echo base_url() ?>app";
        </script>
        <?php

    }

    

}
