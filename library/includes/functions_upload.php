<?php

if (!defined('BB_ROOT')) die(basename(__FILE__));

class upload_common
{
	var $cfg = array(
		'max_size'    => 0,
		'max_width'   => 0,
		'max_height'  => 0,
		'allowed_ext' => array(),
		'upload_path' => '',
		'up_allowed' => false,
	);
	var $file = array(
		'name'        => '',
		'type'        => '',
		'size'        => 0,
		'tmp_name'    => '',
		'error'       => UPLOAD_ERR_NO_FILE,
	);
	var $orig_name    = '';
	var $file_path    = '';      // Stored file path
	var $file_ext     = '';
	var $file_ext_id  = '';
	var $file_size    = '';
	var $ext_ids      = array(); // array_flip($bb_cfg['file_id_ext'])
	var $errors       = array();
	var $img_types    = array(
		IMAGETYPE_GIF => 'gif',
		IMAGETYPE_JPEG => 'jpg',
		IMAGETYPE_PNG => 'png',
		IMAGETYPE_BMP => 'bmp',
	);

	function init ($cfg = array(), $post_params = array(), $uploaded_only = true, $disable_resizer = false)
	{
		global $bb_cfg, $lang;

		$this->cfg = array_merge($this->cfg, $cfg);
		$this->file = $post_params;
		$file_error = $this->file['error'];

		// Check upload allowed
		if (!$this->cfg['up_allowed'])
		{
			$this->errors[] = $lang['UPLOAD_ERROR_COMMON_DISABLED'];
			return false;
		}

		// Handling errors while uploading
		if (isset($file_error) && ($file_error != UPLOAD_ERR_OK))
		{
			if (isset($lang['UPLOAD_ERRORS'][$file_error]))
			{
				$this->errors[] = $lang['UPLOAD_ERROR_COMMON'] . '<br><br>' . $lang['UPLOAD_ERRORS'][$file_error];
			}
			else
			{
				$this->errors[] = $lang['UPLOAD_ERROR_COMMON'];
			}
			return false;
		}
		unset($file_error);
		// file_exists
		if (!file_exists($this->file['tmp_name']))
		{
			$this->errors[] = "Uploaded file not exists: {$this->file['tmp_name']}";
			return false;
		}
		// size
		if (!$this->file_size = filesize($this->file['tmp_name']))
		{
			$this->errors[] = "Uploaded file is empty: {$this->file['tmp_name']}";
			return false;
		}
		if ($this->cfg['max_size'] && $this->file_size > $this->cfg['max_size'])
		{
			$this->errors[] = sprintf($lang['UPLOAD_ERROR_SIZE'], humn_size($this->cfg['max_size']));
			return false;
		}
		// is_uploaded_file
		if ($uploaded_only && !is_uploaded_file($this->file['tmp_name']))
		{
			$this->errors[] = "Not uploaded file: {$this->file['tmp_name']}";
			return false;
		}
		// get ext
		$this->ext_ids = array_flip($bb_cfg['file_id_ext']);
		$file_name_ary = explode('.', $this->file['name']);
		$this->file_ext = strtolower(end($file_name_ary));

		// img
		if ($this->cfg['max_width'] || $this->cfg['max_height'])
		{
			if ($img_info = getimagesize($this->file['tmp_name']))
			{
				list($width, $height, $type, $attr) = $img_info;

				// redefine ext
				if (!$width || !$height || !$type || !isset($this->img_types[$type]))
				{
					$this->errors[] = $lang['UPLOAD_ERROR_FORMAT'];
					return false;
				}
				$this->file_ext = $this->img_types[$type];

				// width & height
				if (($this->cfg['max_width'] && $width > $this->cfg['max_width']) || ($this->cfg['max_height'] && $height > $this->cfg['max_height']))
				{
					if ($disable_resizer)
					{
						$this->errors[] = sprintf($lang['UPLOAD_ERROR_DIMENSIONS'], $this->cfg['max_width'], $this->cfg['max_height']);
						return false;
					}

					// уменьшаем изображение если оно больше положенного
					require(CLASS_DIR . 'SimpleImage.php');
					for ($i = 0, $max_try = 3; $i <= $max_try; $i++)
					{
						try
						{
							$image = new \abeautifulsite\SimpleImage($this->file['tmp_name'], $width, $height);
							$image->quality = 100; // Качество изображения (%)
							$image->auto_orient();
							$image->resize($this->cfg['max_width'], $this->cfg['max_height']);
							$image->save($this->file['tmp_name']);
							break;
						}
						catch (\Exception $e)
						{
							if ($i == $max_try)
							{
								$this->errors[] = sprintf($lang['UPLOAD_ERROR_DIMENSIONS'], $this->cfg['max_width'], $this->cfg['max_height']);
								return false;
							}
						}
					}
				}
			}
			else
			{
				$this->errors[] = $lang['UPLOAD_ERROR_NOT_IMAGE'];
				return false;
			}
		}
		// check ext
		if ($uploaded_only && (!isset($this->ext_ids[$this->file_ext]) || !in_array($this->file_ext, $this->cfg['allowed_ext'], true)))
		{
			$this->errors[] = sprintf($lang['UPLOAD_ERROR_NOT_ALLOWED'], htmlCHR($this->file_ext));
			return false;
		}
		$this->file_ext_id = $this->ext_ids[$this->file_ext];

		return true;
	}

	function store ($mode = '', $params = array())
	{
		if ($mode == 'avatar')
		{
			delete_avatar($params['user_id'], $params['avatar_ext_id']);
			$file_path = get_avatar_path($params['user_id'], $this->file_ext_id);
			return $this->_move($file_path);
		}
		else if ($mode == 'attach')
		{
			$file_path = get_attach_path($params['topic_id']);
			return $this->_move($file_path);
		}
		else
		{
			trigger_error("Invalid upload mode: $mode", E_USER_ERROR);
		}
	}

	function _move ($file_path)
	{
		$dir = dirname($file_path);
		if (!file_exists($dir))
		{
			if (!bb_mkdir($dir))
			{
				$this->errors[] = "Cannot create dir: $dir";
				return false;
			}
		}
		if (!@rename($this->file['tmp_name'], $file_path))
		{
			if (!@copy($this->file['tmp_name'], $file_path))
			{
				$this->errors[] = 'Cannot copy tmp file';
				return false;
			}
			@unlink($this->file['tmp_name']);
		}
		@chmod($file_path, 0664);

		return file_exists($file_path);
	}
}
