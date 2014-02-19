<?php
/**
 * @link http://github.com/2amigos/resource-manager
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group, LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

use \Aws\S3\Enum\CannedAcl;
use \Aws\S3\S3Client;

use \Guzzle\Service\Resource\Model;

/**
 * Amazon S3 storage resource manager implementation.
 *
 * @author Alexander Kochetov <creocoder@gmail.com>
 * @author Timur Ruziev <resurtm@gmail.com>
 * @link http://2amigos.us/
 *
 * @property S3Client instance.
 */
class EAmazonS3ResourceManager extends CApplicationComponent implements IResourceManager
{
	/**
	 * @var string Amazon S3 access key.
	 */
	public $key;
	/**
	 * @var string Amazon S3 access secret.
	 */
	public $secret;
	/**
	 * @var string Amazon S3 bucket name where data should be stored at.
	 */
	public $bucket;
	/**
	 * @var string Amazon S3 region where data should be located at.
	 */
	public $region;
	/**
	 * @var S3Client instance.
	 */
	private $_client;

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		foreach (array('key', 'secret', 'bucket', 'region') as $property) {
			if ($this->$property === null) {
				throw new CException(strtr(
					'"{class}" class cannot be initialized. "${property}" property was not set.',
					array('{class}' => __CLASS__, '{property}' => $property)
				));
			}
		}

		parent::init();
	}

	/**
	 * @inheritdoc
	 */
	public function saveFile($file, $name, $options = array())
	{
		$defaultOptions = array(
			'Bucket' => $this->bucket,
			'Key' => $name,
			'ACL' => CannedAcl::PUBLIC_READ,
		);
		if ($file instanceof CUploadedFile) {
			$defaultOptions['SourceFile'] = $file->getTempName();
		} else {
			$defaultOptions['Body'] = $file;
		}

		/** @var Model $result */
		$result = $this->getClient()->putObject(array_merge($defaultOptions, $options));

		return $result->hasKey('ObjectURL') &&
			is_string($result->get('ObjectURL')) &&
			strlen($result->get('ObjectURL')) > 0;
	}

	/**
	 * @inheritdoc
	 */
	public function deleteFile($name)
	{
		/** @var Model $result */
		$result = $this->getClient()->deleteObject(array(
			'Bucket' => $this->bucket,
			'Key' => $name,
		));

		return $result['DeleteMarker'];
	}

	/**
	 * @inheritdoc
	 */
	public function getFileUrl($name)
	{
		return $this->getClient()->getObjectUrl($this->bucket, $name);
	}

	/**
	 * @inheritdoc
	 */
	public function getIsFileExists($name)
	{
		return $this->getClient()->doesObjectExist($this->bucket, $name);
	}

	/**
	 * Returns the Amazon S3 client instance.
	 * @return S3Client instance.
	 */
	public function getClient()
	{
		if ($this->_client === null) {
			$this->_client = S3Client::factory(array(
				'key' => $this->key,
				'secret' => $this->secret,
				'region' => $this->region,
			));
		}

		return $this->_client;
	}
}
