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
        redirect("app/investasi");
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

    public function cetak()
    {
        $this->load->view('cetak');
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

    public function get_pegawai()
    {
        $nip = $this->input->post('nip');
        $nama = $this->db->get_where('pegawai', array('nip'=>$nip))->row()->nama;
        echo $nama;
    }

    

}
