<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Reduce extends CI_Controller
{
	public function index()
	{
		if(isset($this->uri->segments[1]))
			$link = $this->uri->segments[1];

		if (empty($link) || $link == "reduce") {
			$this->reduceBegin();
		} else {
			$this->redirectTo($link);
		}
	}

	private function reduceBegin()
	{
		$this->load->model('Urls');

		$url_to_reduce = $this->input->post('url_to_reduce');

		if (empty($url_to_reduce)) {
			$this->load->view('reduce');
		} else {
			$url_reduced = $this->reduceUrl($url_to_reduce);
			$data['domain'] = $this->config->base_url() . $url_reduced;
			$data['url_reduced'] = $url_reduced;


			$this->load->view('reduce');
			$this->load->view('answer', $data);
		}
	}

	private function reduceUrl($url)
	{
		$url_reduced = $this->Urls->searchShortUrl($url);

		if(empty($url_reduced)) {
			$url_reduced = mb_substr(md5($url),0,5);
			$this->insertUrl($url, $url_reduced);
		}

		return $url_reduced;
	}

	private function insertUrl($url, $url_reduced)
	{
		$this->Urls->insert($url, $url_reduced);
	}

	public function redirectTo($url_short)
	{
		$this->load->model('Urls');
		$url = $this->Urls->searchUrl($url_short);

		if(empty($url)){
			show_404();
		}
		 else {
		 	redirect($url, 'auto', '302');
		 }
	}
}
