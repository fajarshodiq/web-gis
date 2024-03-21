<?php

namespace App\Controllers;

use App\Models\DataModel;

class Form extends BaseController
{
    protected $DataModel;
    public function __construct()
    {
        $this->DataModel = new DataModel();
    }

    public function index()
    {
        return redirect()->to('/form/datasanggar');
    }

	public function datasanggar()
	{
		$Query = new DataModel();
		$data = [
			'title' => "Aplikasi Web Gis Codeigniter 4",
			'appname' => "Web GIS Sebaran Sanggar Tari",
			'heading' => "Dashboard",
			'data' => $Query->getSanggar(),
			// 'sd' => $Query->countsanggar("SD"),
			// 'smp' => $Query->countsanggar("SMP"),
			// 'sma' => $Query->countsanggar("SMA"),
			// 'smk' => $Query->countsanggar("SMK")
		];
		return view('datasanggar', $data);
	}

    public function createdata()
    {
        $data = [
            'title' => "Input Data",
            'appname' => "WEBGIS - CI",
            'heading' => "Input Data Sanggar Tari",
            'validation' => \Config\Services::validation()
        ];

        return view('createdata', $data);
    }

    public function simpan()
    {
        if (!$this->validate([
            'nama_sanggar' => [
                'rules' => 'required|is_unique[sanggar.nama_sanggar]',
                'errors' => [
                    'required' => 'Nama Sanggar Wajib Di isi',
                    'is_unique' => 'Nama Sanggar Telah Terdaftar'
                ]
            ],
            'nama_pimpinan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Pimpinan Sanggar Wajib Di isi'
                ]
            ],
            'foto_sanggar' => [
                'rules' => 'max_size[foto_sanggar,1024]|is_image[foto_sanggar]|mime_in[foto_sanggar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Gambar Tidak Boleh Diatas 1024 Kb',
                    'is_image' => 'Pastikan kamu upload gambar',
                    'mine_in' => 'Format gambar hanya .jpg .jpeg dan .png'
                ]
            ],
            'no_telp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan Isi Nomor Telepon'
                ]
            ],
            'latitude' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan Tentukan Lokasi Latitude Sanggar'
                ]
            ],
            'longitude' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan Tentukan Lokasi Longitude Sanggar'
                ]
            ],
            'checkbox' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan Centang Kolom Dan Pastikan Data Sudah Benar'
                ]
            ]
        ])) {
            return redirect()->to('/form/createdata')->withInput();
        }


        $FileFoto = $this->request->getFile('foto_sanggar');
        if ($FileFoto == "") {
            $NamaFile = "default.png";
        } else {
            $NamaFile = $FileFoto->getRandomName();
            $FileFoto->move('img/sanggar', $NamaFile);
        }

        $slug = url_title($this->request->getVar('nama_sanggar'), '-', TRUE);

        $this->DataModel->save([
            'nama_sanggar' => $this->request->getVar('nama_sanggar'),
            'slug' => $slug,
            'nama_pimpinan' => $this->request->getVar('nama_pimpinan'),
            'foto_sanggar' => $NamaFile,
            'deskripsi' => $this->request->getVar('deskripsi'),
            'website' => $this->request->getVar('website'),
            'no_telp' => $this->request->getVar('no_telp'),
            'latitude' =>  $this->request->getVar('latitude'),
            'longitude' =>  $this->request->getVar('longitude')
        ]);

        // d($this->request->getVar());

        session()->setFlashdata('pesan', 'Data Sanggar Berhasil Di Simpan.');
        return redirect()->to('/form/datasanggar');
    }

    public function hapus($id)
    {
        $Sanggar = $this->DataModel->find($id);
        if ($Sanggar['foto_sanggar'] == "default.png") {
            $this->DataModel->delete($id);
        } else {
            unlink('img/sanggar/' . $Sanggar['foto_sanggar']);
            $this->DataModel->delete($id);
        }

        session()->setFlashdata('pesan', 'Data Sanggar Berhasil Di Hapus');
        return redirect()->to('/form/datasanggar');
    }

    public function update($slug)
    {
        // session();
        $Sanggar = $this->DataModel->getSanggar($slug);
        $data = [
            'title' => "Update : " . $Sanggar['nama_sanggar'],
            'appname' => "WEBGIS - CI",
            'heading' => "Update Sanggar",
            'data' => $Sanggar,
            'validation' => \Config\Services::validation()
            // 'sd' => $this->DataModel->countsanggar("SD"),
            // 'smp' => $this->DataModel->countsanggar("SMP"),
            // 'sma' => $this->DataModel->countsanggar("SMA"),
            // 'smk' => $this->DataModel->countsanggar("SMK")
        ];

        return view('updateSanggar', $data);
    }

    public function prosesupdate($slug)
    {
        if (!$this->validate([
            'nama_sanggar' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama sanggar Wajib Di isi'
                ]
            ],
            'nama_pimpinan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Pimpinan Wajib Di isi'
                ]
            ],
            'foto_sanggar' => [
                'rules' => 'max_size[foto_sanggar,1024]|is_image[foto_sanggar]|mime_in[foto_sanggar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Gambar Tidak Boleh Diatas 1024 Kb',
                    'is_image' => 'Pastikan kamu upload gambar',
                    'mine_in' => 'Format gambar hanya .jpg .jpeg dan .png'
                ]
            ],
            'latitude' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan Tentukan Lokasi Latitude sanggar'
                ]
            ],
            'longitude' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan Tentukan Lokasi Longitude sanggar'
                ]
            ],
            'checkbox' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan Centang Kolom Dan Pastikan Data Sudah Benar'
                ]
            ]
        ])) {
            return redirect()->to('/form/update/' . $slug)->withInput();
        }
        $datalama = $this->DataModel->getsanggar($slug);
        if ($this->request->getFile('foto_sanggar') == "") {
            $NamaFile = $datalama['foto_sanggar'];
        } else {
            if ($datalama['foto_sanggar'] == "default.png") {
                $getFile = $this->request->getFile('foto_sanggar');
                $NamaFile = $getFile->getRandomName();
                $getFile->move('img/sanggar/', $NamaFile);
            } else {
                unlink('img/sanggar/' . $datalama['foto_sanggar']);
                $getFile = $this->request->getFile('foto_sanggar');
                $NamaFile = $getFile->getRandomName();
                $getFile->move('img/sanggar/', $NamaFile);
            }
        }

        $this->DataModel->save([
            'id' => $this->request->getPost('id'),
            'nama_sanggar' => $this->request->getPost('nama_sanggar'),
            'nama_pimpinan' => $this->request->getPost('nama_pimpinan'),
            'foto_sanggar' => $NamaFile,
            'Deskripsi' => $this->request->getPost('deskripsi'),
            'website' => $this->request->getPost('website'),
            'no_telp' => $this->request->getVar('no.telp'),
            'no_telp' => $this->request->getPost('no_telp'),
            'latitude' => $this->request->getPost('latitude'),
            'longitude' => $this->request->getPost('longitude')
        ]);
        session()->setFlashdata('pesan', 'sanggar Berhasil Di Update');
        return redirect()->to(base_url('form/datasanggar'));
        d($this->request->getPost());
    }
	//--------------------------------------------------------------------

}
