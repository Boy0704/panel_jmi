<?php 
defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Api extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Notif_model');
    }

	public function index_get()
	{
		$id = $this->get('id');
        $kontak = array(
        	"nama" => "By dsf",
        	"jk" => "sdff"
        );
        $this->response($kontak, 502);
	}

	public function login_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);

        $this->db->where('no_telp', $decoded_data->username);
        $this->db->where('password', $decoded_data->password);
        $user = $this->db->get('member');
        if ($user->num_rows() > 0) {
            $users = $user->row(); 

            $this->db->where('token', $decoded_data->token);
            $cek_token = $this->db->get('member');
            if ($cek_token->num_rows() > 0) {
                $this->db->where('token', $decoded_data->token);
                $this->db->update('member', array('token' => ''));
            }

            $this->db->where('id_member', $users->id_member);
            $this->db->update('member', array('token'=>$decoded_data->token));
            $condition = array(
                'id_user' => $users->id_member,
                'nama' => $users->nama,
                'username' => $users->no_telp,
                'password' => $users->password,
                'jenis_akun' => ($users->is_agen == 'y') ? 'Agen' : 'Member' ,
                'foto' => "",
                'token' => $users->token
            );
            // if ($users->status_login == '1') {
            //     $this->db->where('id_user', $users->id_user);
            //     $this->db->update('users', array('status_login'=>'2'));
            //     $message = array(
            //         'kode' => '200',
            //         'message' => 'berhasil',
            //         'data' => [$condition]
            //     );
            // } else {
            //     $condition = array('data'=>"kosong");
            //     $message = array(
            //         'kode' => '404',
            //         'message' => 'Akun anda sedang login diperangkat lain',
            //         'data' => [$condition]
            //     );
            // }
            $message = array(
                'kode' => '200',
                'message' => 'berhasil',
                'data' => [$condition]
            );
            
        } else {
            $condition = array('data'=>"kosong");
            $message = array(
                'kode' => '404',
                'message' => 'Akun login tidak di temukan !',
                'data' => [$condition]
            );
        }

        $this->response($message, 200);
        
    }

    public function logout_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);

        $this->db->where('id_user', $decoded_data->id_user);
        $update = $this->db->update('users', array('status_login'=>'1'));
        if ($update) {
            $condition = array('status_login'=>'1');
            $message = array(
                'kode' => '200',
                'message' => 'berhasil',
                'data' => [$condition]
            );
        } else {
            $condition = array('data'=>"kosong");
            $message = array(
                'kode' => '404',
                'message' => 'gagal !',
                'data' => [$condition]
            );
        }

        $this->response($message, 200);
    }

    public function register_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);
        $cek_username = $this->db->get_where('member', ['no_telp' => $decoded_data->username]);
        if ($cek_username->num_rows() > 0) {
            $message = array(
                'kode' => '200',
                'message' => 'No Telp '.$decoded_data->username.' sudah ada!',
                'data' => [$condition]
            );

            $this->response($message, 200);
            exit();
        }
        $data = array(
            'nama' => $decoded_data->nama,
            'no_rekening' => $decoded_data->no_rekening,
            'kota' => $decoded_data->kota,
            'agen_ref' => $decoded_data->agen_ref,
            'no_telp' => $decoded_data->username,
            'password' => $decoded_data->password,
            'created_at' => get_waktu(),
        );
        $user = $this->db->insert('member', $data);
        $condition = array('daftar'=>'berhasil');
        $message = array(
            'kode' => '200',
            'message' => 'Pendaftaran Berhasil Silahkan Login !',
            'data' => [$condition]
        );

        $this->response($message, 200);
        
    }
    
    public function total_pay_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);

        $total_inv = 0;
        $total_pemasukan = 0;


        $sql1 = $this->db->query("SELECT sum(jumlah_investasi) as total FROM transaksi_investasi WHERE id_member='$decoded_data->id_member' and konfirmasi='y' ")->row();
        $sql2 = $this->db->query("SELECT sum(jumlah) as total FROM transfer WHERE id_member='$decoded_data->id_member'")->row();
        if ($sql1->total > 0) {
            $total_inv = $sql1->total;
            $total_pemasukan = $sql2->total;
        }

        if ($sql1) {
            $message = array(
                'kode' => '200',
                'message' => 'berhasil',
                'total_inv' => number_format($total_inv),
                'total_pemasukan' => number_format($total_pemasukan)
            );
        } else {
            $condition = array('data'=>"kosong");
            $message = array(
                'kode' => '404',
                'message' => 'gagal',
                'total_inv' => $total_inv,
                'total_pemasukan' => $total_pemasukan
            );
        }

        $this->response($message, 200);
    }
    
    public function get_transaksi_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);

        $data = array();

        $sql = "
            SELECT
                a.tanggal,
                a.kat,
                a.keterangan,
                a.nilai,
                a.created_at 
            FROM
                (
                SELECT
                    id_member AS id,
                    tanggal_transfer as tanggal,
                    'keluar' AS kat,
                    plan AS keterangan,
                    jumlah_investasi AS nilai,
                    created_at 
                FROM
                    transaksi_investasi where konfirmasi='y' and id_member='$decoded_data->id_member' UNION
                SELECT
                    id_member AS id,
                    tanggal,
                    'masuk' AS kat,
                    keterangan,
                    jumlah AS nilai,
                    created_at 
                FROM
                    transfer 
                    where id_member='$decoded_data->id_member'
                ) AS a 
            ORDER BY
                a.created_at DESC
        ";
        $query = $this->db->query($sql)
        $dt = $this->db->query($sql)->result();
        foreach ($dt as $rw) {
            array_push($data, array(
                'jenis' => $rw->kat,
                'judul' => $rw->keterangan,
                'tanggal' => $rw->created_at,
                'nominal' => number_format($rw->nilai)
            ));
        }

        if ($query->num_rows() > 0) {
            $message = array(
                'kode' => '200',
                'message' => 'berhasil',
                'data' => $data
            );
        } else {
            $condition = array('data'=>"kosong");
            $message = array(
                'kode' => '200',
                'message' => 'gagal',
                'data' => $condition
            );
        }

        $this->response($message, 200);
    }
    

    public function edit_profil_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);

        $image = $decoded_data->foto;
        $namafoto = time() . '-' . rand(0, 99999) . ".jpg";
        $path = "image/user/" . $namafoto;
        file_put_contents($path, base64_decode($image));

        $this->db->where('id_user', $decoded_data->id_user);
        $update =  $this->db->update('users', array(
            'nama' => $decoded_data->nama,
            'username' => $decoded_data->username,
            'password' => ($decoded_data->password == '') ? $decoded_data->password_old : $decoded_data->password,
            'foto' => ($decoded_data->foto == '') ? $decoded_data->foto_old : $namafoto,
        ));
        if ($update) {
            $condition = array('id_user'=>$decoded_data->id_user);
            $message = array(
                'kode' => '200',
                'message' => 'berhasil',
                'data' => [$condition]
            );
        } else {
            $condition = array('data'=>"kosong");
            $message = array(
                'kode' => '404',
                'message' => 'gagal !',
                'data' => [$condition]
            );
        }

        $this->response($message, 200);
    }

    

   




}

/* End of file Api.php */
/* Location: ./application/controllers/Api.php */