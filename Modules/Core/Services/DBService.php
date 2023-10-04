<?php

namespace Modules\Core\Services;

use Illuminate\Support\Facades\DB;

class DBService extends DB
{
	public static function connection($name = null)
	{
		return parent::connection($name);
	}

	public static function purge($name = null)
	{
		parent::purge($name);
	}

	public static function disconnect($name = null)
	{
		parent::disconnect($name);
	}

	public static function reconnect($name = null)
	{
		return parent::reconnect($name);
	}

	public static function getDefaultConnection()
	{
		return parent::getDefaultConnection();
	}

	public static function setDefaultConnection($name)
	{
		parent::setDefaultConnection($name);
	}

	public static function supportedDrivers()
	{
		return parent::supportedDrivers();
	}

	public static function availableDrivers()
	{
		return parent::availableDrivers();
	}

	public static function extend($name, $resolver)
	{
		parent::extend($name, $resolver);
	}

	public static function getConnections()
	{
		return parent::getConnections();
	}

	public static function getSchemaBuilder()
	{
		return parent::getSchemaBuilder();
	}

	public static function useDefaultQueryGrammar()
	{
		parent::useDefaultQueryGrammar();
	}

	public static function useDefaultSchemaGrammar()
	{
		parent::useDefaultSchemaGrammar();
	}

	public static function useDefaultPostProcessor()
	{
		parent::useDefaultPostProcessor();
	}

	public static function table($table)
	{
		return parent::table($table);
	}

	public static function query()
	{
		return parent::query();
	}

	public static function raw($value)
	{
		return parent::raw($value);
	}

	public static function selectOne($query, $bindings = array(), $useReadPdo = true)
	{
		return parent::selectOne($query, $bindings, $useReadPdo);
	}

	public static function selectFromWriteConnection($query, $bindings = array())
	{
		return parent::selectFromWriteConnection($query, $bindings);
	}

	public static function select($query, $bindings = array(), $useReadPdo = true)
	{
		return parent::select($query, $bindings, $useReadPdo);
	}

	public static function cursor($query, $bindings = array(), $useReadPdo = true)
	{
		return parent::cursor($query, $bindings, $useReadPdo);
	}

	public static function bindValues($statement, $bindings)
	{
		parent::bindValues($statement, $bindings);
	}

	public static function insert($query, $bindings = array())
	{
		return parent::insert($query, $bindings);
	}

	public static function update($query, $bindings = array())
	{
		return parent::update($query, $bindings);
	}

	public static function delete($query, $bindings = array())
	{
		return parent::delete($query, $bindings);
	}

	public static function statement($query, $bindings = array())
	{
		return parent::statement($query, $bindings);
	}

	public static function affectingStatement($query, $bindings = array())
	{
		return parent::affectingStatement($query, $bindings);
	}

	public static function unprepared($query)
	{
		return parent::unprepared($query);
	}

	public static function prepareBindings($bindings)
	{
		return parent::prepareBindings($bindings);
	}

	public static function transaction($callback, $attempts = 1)
	{
		return parent::transaction($callback, $attempts);
	}

	public static function beginTransaction()
	{
		parent::beginTransaction();
	}

	public static function commit()
	{
		parent::commit();
	}

	public static function rollBack()
	{
		parent::rollBack();
	}

	public static function transactionLevel()
	{
		return parent::transactionLevel();
	}

	public static function pretend($callback)
	{
		return parent::pretend($callback);
	}

	public static function logQuery($query, $bindings, $time = null)
	{
		parent::logQuery($query, $bindings, $time);
	}

	public static function listen($callback)
	{
		parent::listen($callback);
	}

	public static function isDoctrineAvailable()
	{
		return parent::isDoctrineAvailable();
	}

	public static function getDoctrineColumn($table, $column)
	{
		return parent::getDoctrineColumn($table, $column);
	}

	public static function getDoctrineSchemaManager()
	{
		return parent::getDoctrineSchemaManager();
	}

	public static function getDoctrineConnection()
	{
		return parent::getDoctrineConnection();
	}

	public static function getPdo()
	{
		return parent::getPdo();
	}

	public static function getReadPdo()
	{
		return parent::getReadPdo();
	}

	public static function setPdo($pdo)
	{
		return parent::setPdo($pdo);
	}

	public static function setReadPdo($pdo)
	{
		return parent::setReadPdo($pdo);
	}

	public static function setReconnector($reconnector)
	{
		return parent::setReconnector($reconnector);
	}

	public static function getName()
	{
		return parent::getName();
	}

	public static function getConfig($option)
	{
		return parent::getConfig($option);
	}

	public static function getDriverName()
	{
		return parent::getDriverName();
	}

	public static function getQueryGrammar()
	{
		return parent::getQueryGrammar();
	}

	public static function setQueryGrammar($grammar)
	{
		parent::setQueryGrammar($grammar);
	}

	public static function getSchemaGrammar()
	{
		return parent::getSchemaGrammar();
	}

	public static function setSchemaGrammar($grammar)
	{
		parent::setSchemaGrammar($grammar);
	}

	public static function getPostProcessor()
	{
		return parent::getPostProcessor();
	}

	public static function setPostProcessor($processor)
	{
		parent::setPostProcessor($processor);
	}

	public static function getEventDispatcher()
	{
		return parent::getEventDispatcher();
	}

	public static function setEventDispatcher($events)
	{
		parent::setEventDispatcher($events);
	}

	public static function pretending()
	{
		return parent::pretending();
	}

	public static function getFetchMode()
	{
		return parent::getFetchMode();
	}

	public static function getFetchArgument()
	{
		return parent::getFetchArgument();
	}

	public static function getFetchConstructorArgument()
	{
		return parent::getFetchConstructorArgument();
	}

	public static function setFetchMode($fetchMode, $fetchArgument = null, $fetchConstructorArgument = array())
	{
		return parent::setFetchMode($fetchMode, $fetchArgument, $fetchConstructorArgument);
	}

	public static function getQueryLog()
	{
		return parent::getQueryLog();
	}

	public static function flushQueryLog()
	{
		parent::flushQueryLog();
	}

	public static function enableQueryLog()
	{
		parent::enableQueryLog();
	}

	public static function disableQueryLog()
	{
		parent::disableQueryLog();
	}

	public static function logging()
	{
		return parent::logging();
	}

	public static function getDatabaseName()
	{
		return parent::getDatabaseName();
	}

	public static function setDatabaseName($database)
	{
		return parent::setDatabaseName($database);
	}

	public static function getTablePrefix()
	{
		return parent::getTablePrefix();
	}

	public static function setTablePrefix($prefix)
	{
		parent::setTablePrefix($prefix);
	}

	public static function withTablePrefix($grammar)
	{
		return parent::withTablePrefix($grammar);
	}

}
