<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace houdunwang\cookie\build;

use houdunwang\config\Config;
use houdunwang\crypt\Crypt;

/**
 * Cookie 管理组件
 * Class Cookie
 * @package hdphp\cookie
 */
class Base {
	protected $items = [ ];

	public function __construct() {
		$this->items = $_COOKIE;
	}

	/**
	 * 获取
	 *
	 * @param string $name
	 *
	 * @return mixed
	 */
	public function get( $name ) {
		if ( isset( $this->items[ $name ] ) ) {
			return $this->items[ $name ];
		} else if ( $this->has( $name ) ) {
			return Crypt::decrypt( $this->items[ Config::get( 'cookie.prefix' ) . '##' . $name ], Config::get( 'cookie.key' ) );
		}
	}

	/**
	 * 获取所有
	 * @return array
	 */
	public function all() {
		$data = [ ];
		foreach ( $this->items as $name => $value ) {
			$data[ $name ] = $this->get( $name );
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
	 * @param string $domain 有效域名
	 */
	public function set( $name, $value, $expire = 0, $path = '/', $domain = '' ) {
		$expire = $expire ? time() + $expire : $expire;
		$name   = Config::get( 'cookie.prefix' ) . '##' . $name;
		setcookie( $name, Crypt::encrypt( $value, Config::get( 'cookie.key' ) ), $expire, $path, $domain );

	}

	/**
	 * 删除
	 *
	 * @param string $name 名称
	 *
	 * @return bool
	 */
	public function del( $name ) {
		return setcookie( $name, '', 1 );
	}

	/**
	 * 检测
	 *
	 * @param string $name 名称
	 *
	 * @return bool
	 */
	public function has( $name ) {
		return isset( $this->items[ Config::get( 'cookie.prefix' ) . '##' . $name ] );
	}

	/**
	 * 删除所有
	 * @return bool
	 */
	public function flush() {
		foreach ( $this->items as $key => $value ) {
			setcookie( $key, '', 1 );
		}

		return true;
	}
}