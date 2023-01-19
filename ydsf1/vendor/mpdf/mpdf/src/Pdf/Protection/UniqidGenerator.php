<?php

namespace Mpdf\Pdf\Protection;

class UniqidGenerator
{

	/**
	 * @return string
	 */
	public function generate()
	{
		$chars = 'ABCDEF1234567890';
		$id = '';

		for ($i = 0; $i < 32; $i++) {
			$id .= $chars[rand(0, 15)];
		}

		return md5($id);
	}
}
