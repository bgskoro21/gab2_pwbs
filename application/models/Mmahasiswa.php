<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Mmahasiswa extends CI_Model {

	// buat method untuk tampil data
    function get_data(){
        // Untuk berbagi API kita tidak disarankan untuk memberikan struktur tabel sebenrnya untuk itu kita harus membuat alias di masing" field
        $this->db->select("id AS id_mhs, npm AS npm_mhs, nama AS nama_mhs, telepon AS telepon_mhs, jurusan AS jurusan_mhs");
        // jika ingin mengambil salah satu field saja, jika tidak ditulis maka dianggap mengambil seluruh data
        // $this->db->select('npm');
        // Untuk mengambil seluruh data dari table mahasiswa
        $this->db->from('tb_mahasiswa');
        // untuk melakukan pengurutan data berdasarkan npm dengan aturan ascending,parameter dua bersifat opsional
        $this->db->order_by('npm','asc');

        // untuk melakukan query sql untuk mengambil data dan mengembalikan hasil
        $query = $this->db->get()->result();
        // mengembalikan data
        return $query;
    }

    // function query delete data
    function delete_data($token){
        // cek apakah npm ada atau tidak
        $this->db->select('npm');
        $this->db->from("tb_mahasiswa");
        // teknik enkripsi
        $this->db->where("TO_BASE64(npm) = '$token'");
        // eksekusi query delete data
        $query = $this->db->get()->result();
        // jika npm ditemukan
        if(count($query) == 1){
            // hapus data mahasiswa
            $this->db->where("TO_BASE64(npm) = '$token'");
            $this->db->delete("tb_mahasiswa");
            $hasil = 1;
        }
        // jika tidak ditemukan
        else{
            // kirim nilai hasil = 0
            $hasil = 0;
        }

        // kirim variabel hasil ke controller
        return $hasil;
    }

    // function save_data untuk menjalankan query post
    function save_data($npm, $nama, $telepon, $jurusan,$token){
        // cek apakah npm ada atau tidak
        $this->db->select('npm');
        $this->db->from("tb_mahasiswa");
        // teknik enkripsi
        $this->db->where("TO_BASE64(npm) = '$token'");
        // eksekusi query delete data
        $query = $this->db->get()->result();
        // jika npm tidak ditemukan
        if(count($query) == 0){
            // proses memasukkan data ke dalam array
            $data = array(
                'npm' => $npm,
                'nama' => $nama,
                'telepon' => $telepon,
                'jurusan' => $jurusan
            );

            // melakukan query simpan
            $this->db->insert('tb_mahasiswa',$data);
            $hasil = 0;
        }
        // jika npm ditemukan artinya data sudah ada 
        else{
            $hasil = 1;
        }

        return $hasil;
    }
    
}
