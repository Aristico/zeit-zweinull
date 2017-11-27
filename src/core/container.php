<?php
/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 19.11.17
 * Time: 19:34
 */

namespace App\core;


use PDO;
use App\entry\entryRevisionRepository;
use App\entry\entrySnapshotRepository;
use App\entry\entryRepository;
use App\user\userScheduleRepository;
use App\time\timeOperations;
use App\user\userBalance;
use App\user\userScheduleVersions;


class container
{
    private $blueprint = [];
    private $instances = [];

    public function __construct()
    {

        $this->blueprint = [
            "pdo" => function () {
                $pdo = new PDO('mysql:host=localhost:3307;dbname=time;charset=utf8',
     'tm_user',
      'unkCWsQ56omQi56H');

            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            return $pdo;
            },
            "entryRepository" => function () {
                $entryRepository = new entryRepository($this->make("pdo"),
                                                       $this->make("timeOperations"),
                                                       $this->make("userScheduleVersions"));
                return $entryRepository;
            },
            "entryRevisionRepository" => function () {
                $entryRevisionRepository = new entryRevisionRepository($this->make("pdo"));
                return $entryRevisionRepository;
            },
            "entrySnapshotRepository" => function () {
                $entrySnapshotRepository = new entrySnapshotRepository($this->make("pdo"));
                return $entrySnapshotRepository;
            },
            "timeOperations" => function () {
                $timeOperations = new timeOperations();
                return $timeOperations;
            },
            "userScheduleRepository" => function () {
                $userData = new userScheduleRepository($this->make("pdo"));
                return $userData;
            },
            "userScheduleVersions" => function () {
                $userData = new userScheduleVersions($this->make("pdo"));
                return $userData;
            },
            "userBalance" => function () {
                $userBalance = new userBalance($this->make("entryRepository"),
                                            $this->make("entrySnapshotRepository"),
                                            $this->make("timeOperations"));
                return $userBalance;
            }

        ];
    }

    public function make($name) {
        if (!empty($this->instances[$name])) {
            return $this->instances[$name];

        }

        if (isset($this->blueprint[$name])) {
            $this->instances[$name] = $this->blueprint[$name]();
            return $this->instances[$name];
        }
    }
}