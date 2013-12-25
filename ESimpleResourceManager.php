<?php
/**
 * @link http://github.com/2amigos/resource-manager
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group, LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

/**
 * ESimpleResourceManager class.
 *
 * @author Alexander Kochetov <creocoder@gmail.com>
 * @author Timur Ruziev <resurtm@gmail.com>
 */
class ESimpleResourceManager extends EResourceManager
{
	const DEFAULT_DIR = 'uploads';

	private $_basePath;
	private $_baseUrl;

	/**
	 * @param CUploadedFile $file
	 * @param string $name
	 * @param array $options
	 * @return boolean
	 */
	public function saveFile($file, $name, $options = array())
	{
		$path = $this->getBasePath() . DIRECTORY_SEPARATOR . $name;
		@mkdir(dirname($path), 0777, true);

		return $file->saveAs($path);
	}

	/**
	 * @param string $name
	 * @return string
	 */
	public function getFilePath($name)
	{
		return $this->getBasePath() . DIRECTORY_SEPARATOR . $name;
	}

	/**
	 * @param string $name
	 * @return string
	 */
	public function getFileUrl($name)
	{
		return $this->getBaseUrl() . '/' . $name;
	}

	/**
	 * @param string $name
	 * @return boolean
	 */
	public function getIsFileExist($name)
	{
		return file_exists($this->getFilePath($name));
	}

	/**
	 * @return string
	 */
	public function getBasePath()
	{
		if ($this->_basePath === null) {
			$this->setBasePath(
				dirname(Yii::app()->getRequest()->getScriptFile()) . DIRECTORY_SEPARATOR . self::DEFAULT_DIR
			);
		}

		return $this->_basePath;
	}

	/**
	 * @param string $value
	 */
	public function setBasePath($value)
	{
		$this->_basePath = rtrim($value, DIRECTORY_SEPARATOR);
	}

	/**
	 * @return string
	 */
	public function getBaseUrl()
	{
		if($this->_baseUrl === null) {
			$this->setBaseUrl(Yii::app()->getRequest()->getBaseUrl() . '/' . self::DEFAULT_DIR);
		}

		return $this->_baseUrl;
	}

	/**
	 * @param string $value
	 */
	public function setBaseUrl($value)
	{
		$this->_baseUrl = rtrim($value, '/');
	}
}
