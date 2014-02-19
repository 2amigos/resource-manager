Resource manager extension for Yii 1
====================================

This extension allows you to manage resources. Currently supports two possible scenarios:

- Resources to save/or saved on a server's folder.
- Resources to save/or saved on an Amazon S3 bucket.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```sh
php composer.phar require 2amigos/resource-manager "*"
```

or add

```json
"2amigos/resource-manager": "*"
```

to the require section of your `composer.json` file.

Configuring
-----------

Once the extension is installed, simply modify your application configuration as follows:

```php
return array(
	'components' => array(
		'resourceManager' => 'EAmazonS3ResourceManager',
		'key' => 'YOUR-AWS-ACCESS-KEY-HERE',
		'secret' => 'YOUR-AWS-ACCESS-SECRET-HERE',
		'bucket' => 'YOUR-AWS-BUCKET-NAME-HERE',
		'region' => 'AWS-REGION-NAME-HERE',
	),
);
```

Done. Now you can use our component to save some data to the Amazon S3 storage.

Usage
-----

Here's possible code of your view:

```php
<?php echo CHtml::beginForm('', 'post', array('enctype' => 'multipart/form-data')); ?>
	<?php echo CHtml::fileField('user-photo'); ?>
	<?php echo CHtml::submitButton('Upload new image'); ?>
<?php echo CHtml::endForm(); ?>
```

And this is how could look your controller code for processing the uploaded file:

```php
$userPhoto = CUploadedFile::getInstanceByName('user-photo');
if ($userPhoto !== null) {
	if (!Yii::app()->getComponent('resourceManager')->saveFile($userPhoto, $userPhoto->getName())) {
		throw new CHttpException(500, 'Sorry, unable to upload your profile photo.');
	}
	Yii::app()->getUser()->setFlash('userPhotoUpdated', 'Great, your profile photo has been updated!');
	$this->refresh();
}
$this->render('userPhotoForm');
```

Notes
-----

Looking for a version for the Yii 2? There is a dedicated repository for it:
[2amigos/yii2-resource-manager-component](http://github.com/2amigos/yii2-resource-manager-component).

> [![2amigOS!](http://gravatar.com/avatar/55363394d72945ff7ed312556ec041e0.png)](http://2amigos.us)
<i>Web development has never been so fun!</i>
[www.2amigos.us](http://2amigos.us)
