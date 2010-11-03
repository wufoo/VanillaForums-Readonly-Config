<?php if (!defined('APPLICATION')) exit();

/**
 * Sets config values at application startup.
 *
 * @package default
 * @author Timothy S Sabat
 */
class ReadOnlyConfig {
	
	/**
	 * Sets in-memory configuration settings.
	 *
	 * @return void
	 * @author Timothy S Sabat
	 */
	public function setConfigVars() {
		$config = new ExampleConfig();
		SaveToConfig('Database.Host', $config->getDbHost(),FALSE);
		SaveToConfig('Database.User', $config->getDbUser(),FALSE);
		SaveToConfig('Database.Password', $config->getDbPassword(),FALSE);
		SaveToConfig('Garden.Errors.MasterView', 
			($config->getLocation() == 'localhost' || $config->getLocation() == 'dev') ? 'deverror.master.php' : 'error.master.php');
	}

}

ReadOnlyConfig::setConfigVars();

/**
 * This is an example configuration class you could create to provide variable connection strings based on server.
 *
 * @package default
 * @author Timothy S Sabat
 */
class ExampleConfig {
	
	private $location;
	private $host;
	private $user;
	private $password;
	
	public function __construct() {
		$this->setLocation();
	}
	
	private function setLocation() {
		//set instance in env at server startup
		switch ($_SERVER['instance']) {
			case 'prod':
				$this->location = 'prod';
				$this->setDbVals('mydomain.com:6969', 'frank', 'beans');
				break;
			case 'dev':
				$this->location = 'dev';
				$this->setDbVals('mydevdomain.com:6060', 'kibbles', 'bits');
				break;
			default:
				$this->location = 'local';
				$this->setDbVals('localhost:6060', 'root', 'root');
				break;
		}
	}
	
	private function setDbVals($host, $user, $password) {
		$this->host = $host;
		$this->user = $user;
		$this->password = $password;
	}
	/* -------------------------------
			  GETTERS
	------------------------------- */
	
	public function getDbHost() {
		return $this->host;
	}
	
	public function getDbUser() {
		return $this->user;
	}
	
	public function getDbPassword() {
		return $this->password;
	}
	
	public function getLocation() {
		return $this->location;
	}
	
}