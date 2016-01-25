<?php

/**
 *
 *@file        Db.class.php
 *@author      xieyoujiang
 *@Data        2016年1月25日
 *@language    PHP
 *@E-mail      xie_youjiang@163.com
 *@copyright(c) 扬州格佳科技有限公司
 *
 */
class DbOperator
{

	private static $db = null;

	public static function getInstance ()
	{
		try
		{
			if ( self::$db == null )
			{
				self::$db = new PDO ( "mysql:host=" . localhost . ";dbname=" . test, root, root, array (
						PDO::ATTR_PERSISTENT => true 
				) );
				
				self::$db->setAttribute ( PDO::ATTR_CASE, PDO::CASE_UPPER );
			
			}
			
			return self::$db;
		}
		catch ( Exception $e )
		{
			die ( "数据库连接失败！" . $e->getMessage () );
		}
	
	}

	function __destruct ()
	{
		$db = null;
	}

	/**
	 * 次函数主要是以集合的形式返回，或插入集合数据。
	 * 
	 * @param unknown $strSql        	
	 * @param unknown $array        	
	 */
	public static function executeArraySql ( $strSql, $array )
	{
		try
		{
			$nRet = DbOperator::getInstance ()->beginTransaction ();
			
			if ( $nRet == true )
			{
				$stms = DbOperator::getInstance ()->prepare ( $strSql );
					
				foreach ( $array as $value )
				{
					$nRet = $stms->execute ( $value );
				}
			}
			
			$nRet = DbOperator::getInstance ()->commit ();
			
			return $nRet;
		
		}
		catch ( PDOException $e )
		{
			print "Error: " . $e->getMessage () . "<br/>";
			die ();
		}
	
	}

	/**
	 * 次函数主要是用来指定条件查询
	 * 
	 * @param unknown $strSql        	
	 * @param unknown $array
	 *        	查询参数
	 */
	public static function executeSql ( $strSql, $array )
	{
		try
		{
			$stms = DbOperator::getInstance ()->prepare ( $strSql );
			
			$bRet = $stms->execute ( $array );
			
			return $bRet;
		
		}
		catch ( PDOException $e )
		{
			print "Error: " . $e->getMessage () . "<br/>";
			die ();
		}
	}

	public static function querySql ( $strSql, $array )
	{
		try
		{
			$stms = DbOperator::getInstance ()->prepare ( $strSql );
			
			$stms->execute ( $array );
			
			$rs = $stms->fetch ();
			
			return $rs;
		
		}
		catch ( PDOException $e )
		{
			print "Error: " . $e->getMessage () . "<br/>";
			die ();
		}
	}
	
	public static function queryAll( $strSql )
	{
		try
		{
			$stms = DbOperator::getInstance ()->prepare ( $strSql );
				
			$stms->execute ();
				
			$rs = $stms->fetchAll ();
				
			return $rs;
		
		}
		catch ( PDOException $e )
		{
			print "Error: " . $e->getMessage () . "<br/>";
			die ();
		}
	}
}

?>