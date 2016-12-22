<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace houdunwang\cookie;

use houdunwang\config\Config;
use houdunwang\crypt\Crypt;

/**
 * Cookie 管理组件
 * Class Cookie
 * @package hdphp\cookie
 */
class Cookie {
	/**
	 * 获取
	 *
	 * @param string $name
	 *
	 * @return mixed
	 */
	public static function get( $name ) {
		if ( isset( $_COOKIE[ $name ] ) ) {
			return Crypt::decrypt( $_COOKIE[ $name ], Config::get( 'cookie.secureKey' ) );
		}
	}

	/**
	 * 获取所有
	 * @return array
	 */
	public static function all() {
		$data = [ ];
		foreach ( $_COOKIE as $name => $value ) {
			$data[ $name ] = self::get( $name );
		}

		return $data;
	}

	/**
	 * 设置
	 *
	 * @param string $name 名称
	 * @param mixed $value 值
	 * @param int $expire 过期时间
	 * @param string $path 有效路径
	 * @param null $domain 有效域名
	 */
	public static function set( $name, $value, $expire = 0, $path = '/', $domain = null ) {
		$expire = $expire ? time() + $expire : $expire;
		setcookie( $name, Crypt::encrypt( $value, Config::get( 'cookie.secureKey' ) ), $expire, $path, $domain );
	}

	/**
	 * 删除
	 *
	 * @param string $name 名称
	 *
	 * @return bool
	 */
	public static function del( $name ) {
		return setcookie( $name, '', 1 );
	}

	/**
	 * 检测
	 *
	 * @param string $name 名称
	 *
	 * @return bool
	 */
	public static function has( $name ) {
		return isset( $_COOKIE[ $name ] );
	}

	/**
	 * 删除所有
	 * @return bool
	 */
	public static function flush() {
		foreach ( $_COOKIE as $key => $value ) {
			setcookie( $key, '', 1 );
		}

		return true;
	}
}