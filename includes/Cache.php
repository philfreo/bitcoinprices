<?php

class Cache {

	private $memcache;
	private $active = false;
	private $prefix = '';

	// Make singleton
	private static $instance;
	private function __construct() {
		$this->memcache = new Memcache;
		$this->active = @$this->memcache->connect('localhost', 11211);
	}

	public static function getInstance() {
		if (!self::$instance)
			self::$instance = new self();
		return self::$instance;
	}

	public function setPrefix($prefix) {
		$this->prefix = $prefix;
	}

	public function set($key, $val, $expire_in = 0) {
		if (!$this->active) return false;
		return $this->memcache->set($this->prefix.$key, $val, MEMCACHE_COMPRESSED, $expire_in);
	}

	public function get($key) {
		if (!$this->active) return false;
		return $this->memcache->get($this->prefix.$key);
	}

	public function delete($key) {
		if (!$this->active) return false;
		return $this->memcache->delete($this->prefix.$key);
	}

	public function flush() {
		if (!$this->active) return false;
		$this->memcache->flush();
	}

	/**
	 * Increment a key's value and return new value. If key doesn't exist,
	 * this will initialize its value to 0 and then increment.
	 * @return int
	 * @param string $key
	 */
	public function increment($key) {
		if (!$this->active) return false;
		if ($this->get($this->prefix.$key) == "")
			$this->set($this->prefix.$key, 0);
		return (int) $this->memcache->increment($this->prefix.$key);
	}

}
