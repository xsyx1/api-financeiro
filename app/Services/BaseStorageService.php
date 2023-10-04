<?php

namespace App\Services;


class BaseStorageService
{
    /**
     * @var \Storage
     */
    private $storage;

    public function __construct()
    {
        $this->storage = app(\Storage::class);
    }

    public function drive($name = null)
    {
        return $this->storage::drive($name);
    }

    public function disk($name = null)
    {
        if (is_null($name)) {
            $name = $this->getDefaultDriver();
        }

        return $this->storage::disk($name);
    }

    public function cloud()
    {
        return $this->storage::cloud();
    }

    public function createLocalDriver($config)
    {
        return $this->storage::createLocalDriver($config);
    }

    public function createFtpDriver($config)
    {
        return $this->storage::createFtpDriver($config);
    }

    public function createS3Driver($config)
    {
        return $this->storage::createS3Driver($config);
    }

    public function createRackspaceDriver($config)
    {
        return $this->storage::createRackspaceDriver($config);
    }

    public function getDefaultDriver()
    {
        return $this->storage::getDefaultDriver();
    }

    public function getDefaultCloudDriver()
    {
        return $this->storage::getDefaultCloudDriver();
    }

    public function extend($driver, $callback)
    {
        return $this->storage->extend($driver, $callback);
    }

    public function exists($path)
    {
        return $this->storage::exists($path);
    }

    public function get($path)
    {
        return $this->storage->get($path);
    }

    public function put($path, $contents, $visibility = null)
    {
        return $this->storage::put($path, $contents, $visibility);
    }

    public function putFile($path, $file, $visibility = null)
    {
        return $this->storage::putFile($path, $file, $visibility);
    }

    public function putFileAs($path, $file, $name, $visibility = null)
    {
        return $this->storage::putFileAs($path, $file, $name, $visibility);
    }

    public function getVisibility($path)
    {
        return $this->storage::getVisibility($path);
    }

    public function setVisibility($path, $visibility)
    {
        $this->storage::setVisibility($path, $visibility);
    }

    public function prepend($path, $data, $separator = '')
    {
        return $this->storage::prepend($path, $data, $separator);
    }

    public function append($path, $data, $separator = '')
    {
        return $this->storage::append($path, $data, $separator);
    }

    public function delete($paths)
    {
        return $this->storage::delete($paths);
    }

    public function copy($from, $to)
    {
        return $this->storage::copy($from, $to);
    }

    public function move($from, $to)
    {
        return $this->storage::move($from, $to);
    }

    public function size($path)
    {
        return $this->storage::size($path);
    }

    public function mimeType($path)
    {
        return $this->storage::mimeType($path);
    }

    public function lastModified($path)
    {
        return $this->storage::lastModified($path);
    }

    public function url($path)
    {
        return $this->storage::url($path);
    }

    public function files($directory = null, $recursive = false)
    {
        return $this->storage::files($directory, $recursive);
    }

    public function allFiles($directory = null)
    {
        return $this->storage::allFiles($directory);
    }

    public function directories($directory = null, $recursive = false)
    {
        return $this->storage::directories($directory, $recursive);
    }

    public function allDirectories($directory = null)
    {
        return $this->storage::allDirectories($directory);
    }

    public function makeDirectory($path)
    {
        return $this->storage::makeDirectory($path);
    }

    public function deleteDirectory($directory)
    {
        return $this->storage::deleteDirectory($directory);
    }

    public function getDriver()
    {
        return $this->storage::getDriver();
    }
}
