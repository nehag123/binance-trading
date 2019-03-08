<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *	CodeIgniter Amazon S3 library in PHP by zairwolf
 * 
 *	Source: https://github.com/zairwolf/CodeIgniter-AmazonS3/blob/master/S3.php
 *
 *	Author: Hai Zheng @ https://www.linkedin.com/in/zairwolf/
 *
 */

require 'aws-sdk/vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
class S3{
	public $s3hd	= false;
	protected $CI;

	public function __construct(){
		$this->CI =& get_instance();
		//initialize s3 connection
		$this->CI->config->load('s3config');
		/*if(!$this->s3hd) $this->s3hd = S3Client::factory(array(
			'key'	=> $this->CI->config->item('s3key'),
			'secret'	=> $this->CI->config->item('s3secret'),
			'region' => 'eu-west-2',
			'version' => '2006-03-01'
		));*/


		if(!$this->s3hd) $this->s3hd = S3Client::factory(array(
			'region' => 'us-west-1',
			'version' => '2006-03-01',
			'credentials' => array(
				'key'    => $this->CI->config->item('s3key'),
				'secret' => $this->CI->config->item('s3secret'),
			)
		));
	}

	public function url($name, $expire = '+1 day'){
		return $this->s3hd->getObjectUrl($this->CI->config->item('s3bucket'), $name, $expire);
	}

	public function read($name, $Bucket = false){
		if(!$Bucket) $Bucket = $this->CI->config->item('s3bucket');
		
		if(!$this->exist($name, $Bucket)) return false;
		
		$info = $this->s3hd->getObject(array(
		    'Bucket'       => $Bucket,
		    'Key'          => $name,
		));
		return $info['Body'];
	}
	
	public function del($name, $Bucket = false){
		if(!$Bucket) $Bucket = $this->CI->config->item('s3bucket');
		$info = $this->s3hd->deleteObject(array(
		    'Bucket'       => $Bucket,
		    'Key'          => $name,
		));
		return $info;
	}
	
	public function exist($name, $Bucket = false){
		if(!$Bucket) $Bucket = $this->CI->config->item('s3bucket');
		return $this->s3hd->doesObjectExist($Bucket, $name);
	}

	public function upload($name, $file, $Bucket = false){
		if(!$Bucket) $Bucket = $this->CI->config->item('s3bucket');
		$result = $this->s3hd->putObject(array(
		    'Bucket'       => $Bucket,
		    'Key'          => $name,
		    'SourceFile'   => $file,
		    //'StorageClass' => 'REDUCED_REDUNDANCY',
		));

		$this->s3hd->waitUntil('ObjectExists', array(
		    'Bucket' => $Bucket,
		    'Key'    => $name,
		));
		return $result;
	}
	
	public function write($name, $info, $Bucket = false){
		if(!$Bucket) $Bucket = $this->CI->config->item('s3bucket');
		$result = $this->s3hd->upload($Bucket, $name, $info);

		$this->s3hd->waitUntil('ObjectExists', array(
		    'Bucket' => $Bucket,
		    'Key'    => $name,
		));
		return $result;
	}
	
  public function  getObjectOfFiles($Bucket,$keyname)
  {  
        
	try {
	    // get data.
		$objects = $this->s3hd->ListObjectsV2(array(
			"Bucket" => $Bucket,
			"Prefix" => $keyname
		)); 

	    // Print the URL to the object.
		return $objects['Contents'];
	} catch (S3Exception $e) {
	    echo $e->getMessage() . PHP_EOL;
	}
	  
}	

	public function copyFile($src, $target, $Bucket = false){
		if(!$Bucket) $Bucket = $this->CI->config->item('s3bucket');
		$info = $this->s3hd->copyObject(array(
		    'Bucket'       => $Bucket,
		    'CopySource'   => $Bucket.'/'.$src,
		    'Key'          => $target,
		));
		return $info;
	}

	public function getIterator($prefix , $Bucket = false ) {
		echo $prefix;
		if(!$Bucket) $Bucket = $this->CI->config->item('s3bucket');
		$objects = $this->s3hd->getIterator('ListObjects', array(
				    'Bucket' => $Bucket,
				    'Prefix' => $prefix,
				  ));
     
     
		return $objects;
	}
	
  


}
