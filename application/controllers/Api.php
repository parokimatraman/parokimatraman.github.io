<?php
	class Api extends CI_Controller{
		public function __construct(){
	        parent:: __construct();
	        $this->load->model('M_api', 'api');
	    }

	    public function limit_words($string, $word_limit){
	      	$words = explode(" ",$string);
	      	return implode(" ",array_splice($words,0,$word_limit));
	  	}

		public function load_more_berita(){
			$limit = strip_tags(str_replace("'", "", $this->input->post('limit')));
			$jenis = strip_tags(str_replace("'", "", $this->input->post('jenis')));
			$url_berita = strip_tags(str_replace("'", "", $this->input->post('url_berita')));
			$berita = '';
			$sisa = '';
			if($jenis == 'Berita' && $url_berita == ''){
				$berita = $this->api->get_more_berita($limit);
				$sisa = $this->api->get_more_berita($limit+6);
			}else if($jenis == 'Kategori Berita' && $url_berita != ''){
				$berita = $this->api->get_more_berita_kategori($limit,$url_berita);
				$sisa = $this->api->get_more_berita_kategori($limit+6,$url_berita);
			}else if($jenis == 'Tanggal Berita' && $url_berita != ''){
				$param = explode(',', $url_berita);
				$berita = $this->api->get_more_berita_tanggal($limit,date('m', strtotime($param[0])),$param[1]);
				$sisa = $this->api->get_more_berita_tanggal($limit+6,$param[0],$param[1]);
			}

			// $berita = $this->api->get_more_berita($limit);
			// $sisa = $this->api->get_more_berita($limit+6);
			if($sisa->num_rows() > 0){
				$sisa2 = 1;
			}else{
				$sisa2 = 0;
			}
			// $sisa2 = count($sisa);
			$data_berita = array();
			foreach ($berita->result_array() as $a) {
				$data_berita[] = '<div class="col-12 col-md-6">
                                        <div class="single-blog-post mb-50">
                                            <div class="post-thumbnail">
                                                <a href="'.base_url().'berita/'.$a['url'].'"><img src="'.base_url().'assets/uploads/berita/'.$a['thumb'].'" alt=""></a>
                                            </div>
                                            <div class="post-content">
                                                <a href="'.base_url().'berita/'.$a['url'].'" class="post-title">
                                                    <h4>'.$a['title'].'</h4>
                                                </a>
                                                <div class="post-meta d-flex">
                                                    <a href="#"><i class="fa fa-user" aria-hidden="true"></i> '.$a['user'].'</a>
                                                    <a href="#"><i class="fa fa-calendar" aria-hidden="true"></i> '.date('d M, Y', strtotime($a['tanggal_berita'])).'</a>
                                                </div>
                                                <p class="post-excerpt">'.$this->limit_words($a['desc'],10).'...</p>
                                            </div>
                                        </div>
                                    </div>'; 
			}

			$data = array(
				'berita' => $data_berita,
				'sisa' => $sisa2
			);
			echo json_encode($data);
		}

		public function load_more_pengumuman(){
			$limit = strip_tags(str_replace("'", "", $this->input->post('limit')));
			$jenis = strip_tags(str_replace("'", "", $this->input->post('jenis')));
			$url_pengumuman = strip_tags(str_replace("'", "", $this->input->post('url_pengumuman')));
			$pengumuman = '';
			$sisa = '';
			if($jenis == 'Pengumuman' && $url_pengumuman == ''){
				$pengumuman = $this->api->get_more_pengumuman($limit);
				$sisa = $this->api->get_more_pengumuman($limit+6);
			}else if($jenis == 'Tanggal Pengumuman' && $url_pengumuman != ''){
				$param = explode(',', $url_pengumuman);
				$pengumuman = $this->api->get_more_pengumuman_tanggal($limit,date('m', strtotime($param[0])),$param[1]);
				$sisa = $this->api->get_more_pengumuman_tanggal($limit+6,$param[0],$param[1]);
			}

			if($sisa->num_rows() > 0){
				$sisa2 = 1;
			}else{
				$sisa2 = 0;
			}
			
			$data_pengumuman = array();
			foreach ($pengumuman->result_array() as $a) {
				$data_pengumuman[] = '<div class="col-12 col-md-6">
                                        <div class="single-blog-post mb-50">
                                            <div class="post-thumbnail">
                                                <a href="'.base_url().'pengumuman/'.$a['url'].'"><img src="'.base_url().'assets/uploads/pengumuman/'.$a['thumb'].'" alt=""></a>
                                            </div>
                                            <div class="post-content">
                                                <a href="'.base_url().'pengumuman/'.$a['url'].'" class="post-title">
                                                    <h4>'.$a['title'].'</h4>
                                                </a>
                                                <div class="post-meta d-flex">
                                                    <a href="#"><i class="fa fa-user" aria-hidden="true"></i> '.$a['user'].'</a>
                                                    <a href="#"><i class="fa fa-calendar" aria-hidden="true"></i> '.date('d M, Y', strtotime($a['tanggal_pengumuman'])).'</a>
                                                </div>
                                                <p class="post-excerpt">'.$this->limit_words($a['content'],10).'...</p>
                                            </div>
                                        </div>
                                    </div>'; 
			}

			$data = array(
				'pengumuman' => $data_pengumuman,
				'sisa' => $sisa2
			);
			echo json_encode($data);
		}

		public function load_more_renungan(){
			$limit = strip_tags(str_replace("'", "", $this->input->post('limit')));
			$jenis = strip_tags(str_replace("'", "", $this->input->post('jenis')));
			$url_renungan = strip_tags(str_replace("'", "", $this->input->post('url_renungan')));
			$renungan = '';
			$sisa = '';
			if($jenis == 'Renungan' && $url_renungan == ''){
				$renungan = $this->api->get_more_renungan($limit);
				$sisa = $this->api->get_more_renungan($limit+6);
			}else if($jenis == 'Tanggal Renungan' && $url_renungan != ''){
				$param = explode(',', $url_renungan);
				$renungan = $this->api->get_more_renungan_tanggal($limit,date('m', strtotime($param[0])),$param[1]);
				$sisa = $this->api->get_more_renungan_tanggal($limit+6,$param[0],$param[1]);
			}

			if($sisa->num_rows() > 0){
				$sisa2 = 1;
			}else{
				$sisa2 = 0;
			}
			
			$data_renungan = array();
			foreach ($renungan->result_array() as $a) {
				$data_renungan[] = '<div class="col-12 col-md-6">
                                        <div class="single-blog-post mb-50">
                                            <div class="post-thumbnail">
                                                <a href="'.base_url().'renungan-harian/'.date('Y-m-d', strtotime($a['tanggal'])).'"><img src="'.base_url().'assets/uploads/renungan/'.$a['image'].'" alt=""></a>
                                            </div>
                                            <div class="post-content">
                                                <a href="'.base_url().'renungan-harian/'.date('Y-m-d', strtotime($a['tanggal'])).'" class="post-title">
                                                    <h4>'.$a['ayat'].'</h4>
                                                </a>
                                                <div class="post-meta d-flex">
                                                    <a href="#"><i class="fa fa-user" aria-hidden="true"></i> '.$a['user'].'</a>
                                                    <a href="#"><i class="fa fa-calendar" aria-hidden="true"></i> '.date('d M, Y', strtotime($a['tanggal'])).'</a>
                                                </div>
                                                <p class="post-excerpt">'.$this->limit_words($a['penjelasan'],10).'...</p>
                                            </div>
                                        </div>
                                    </div>'; 
			}

			$data = array(
				'renungan' => $data_renungan,
				'sisa' => $sisa2
			);
			echo json_encode($data);
		}

		public function load_more_album(){
			$limit = strip_tags(str_replace("'", "", $this->input->post('limit')));
			
			$album = $this->api->get_more_album($limit);
			$sisa = $this->api->get_more_album($limit+8);
			if($sisa->num_rows() > 0){
				$sisa2 = 1;
			}else{
				$sisa2 = 0;
			}
			// $sisa2 = count($sisa);
			$data_album = array();
			foreach ($album->result_array() as $a) {
				$data_album[] = '<div class="col-12 col-md-3 col-lg-3">
                                        <div class="about-us-content">
                                        	<center>
                                        		<a href="'.base_url().'album/'.$a['url'].'"><img src="'.base_url().'assets/img/icon.png" alt="">
	                                           	 	<div class="about-text text-center">
	                                           	 		<h6>'.$a['name'].'</h6>
	                                           	 	</div>
                                           	 	</a>
                                        	</center>
                                        </div>
                                    </div>'; 
			}

			$data = array(
				'album' => $data_album,
				'sisa' => $sisa2
			);
			echo json_encode($data);
		}

		public function load_more_foto_detail(){
			$limit = strip_tags(str_replace("'", "", $this->input->post('limit')));
			$url = strip_tags(str_replace("'", "", $this->input->post('url')));
			$foto = $this->api->get_more_foto($limit, $url);
			$sisa = $this->api->get_more_foto($limit+15, $url);
			if($sisa->num_rows() > 0){
				$sisa2 = 1;
			}else{
				$sisa2 = 0;
			}
			// $sisa2 = count($sisa);
			$data_foto = array();
			foreach ($foto->result_array() as $a) {
				$data_foto[] = '        <div class="single-gallery-area container mb-30">
                                        	<center>
                                        		<a href="'.base_url().'assets/uploads/album/'.$a['url'].'/'.$a['foto'].'">
                                        		<img src="'.base_url().'assets/uploads/album/'.$a['url'].'/'.$a['foto'].'" alt="">
                                           	 	</a>
                                        	</center>
                                        </div>'; 
			}

			$data = array(
				'foto' => $data_foto,
				'sisa' => $sisa2
			);
			echo json_encode($data);	
		}
	}
?>