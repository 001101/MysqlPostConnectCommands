<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */

namespace Piwik\Plugins\MysqlPostConnectCommands;
/**
 *
 */
class MysqlPostConnectCommands extends \Piwik\Plugin
{
    public function getListHooksRegistered()
    {
        return array(
            'CronArchive.init.finish' => 'sendPostConnectQueries'
        );
    }

    public function sendPostConnectQueries($siteIds)
    {
      //get the current db settings
      $dbConfig = \Piwik\Db::getDatabaseConfig();
      //if its MySQL
      if($dbConfig['adapter'] == 'PDO\MYSQL'){
        $settings = new Settings();
        $queries = $settings->globalEnabled->getValue();
        foreach (explode(PHP_EOL,$queries) as $query) {
          \Piwik\Db::query($query);
        }
      }
    }
}

