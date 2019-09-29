<?php

class Urls extends CI_Model
{
	public function insert($url, $url_reduced)
	{
		$data = array(
			'url' => "$url",
			'url_short' => "$url_reduced"
		);

		$this->db->insert('urls', $data);
	}

	public function searchShortUrl($url)
	{
		$query = $this->db->get_where('urls', array('url' => "$url"), 1);
		$result = $query->row_array();

		return $result["url_short"];
	}

	public function searchUrl($url_short)
	{
		$query = $this->db->get_where('urls', array('url_short' => $url_short), 1);
		$result = $query->row_array();

		return $result["url"];
	}
}
