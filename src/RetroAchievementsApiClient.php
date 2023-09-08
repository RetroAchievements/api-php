<?php

/**
 * Class RetroAchievementsApiClient
 */
class RetroAchievementsApiClient
{
    const API_URL = 'https://retroachievements.org/api/';

    const API_VERSION = 1;

    /**
     * @var string
     */
    public $ra_user;

    /**
     * @var string
     */
    public $ra_api_key;

    /**
     * RetroAchievementsApiClient constructor.
     *
     * @param string $user
     * @param string $api_key
     */
    public function __construct($user, $api_key)
    {
        $this->ra_user = $user;
        $this->ra_api_key = $api_key;
    }

    /**
     * @return string
     */
    private function AuthQS()
    {
        return "?z=" . $this->ra_user . "&y=" . $this->ra_api_key;
    }

    /**
     * @param string $target
     * @param string $params
     * @return bool|null|string
     */
    private function GetRAURL($target, $params = "")
    {
        try {
            return file_get_contents(self::API_URL . $target . self::AuthQS() . "&$params");
        } catch (Exception $e) {
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function GetTopTenUsers()
    {
        return json_decode(self::GetRAURL('API_GetTopTenUsers.php'));
    }

    /**
     * @param int $gameID
     * @return mixed
     */
    public function GetGameInfo($gameID)
    {
        return json_decode(self::GetRAURL("API_GetGame.php", "i=$gameID"));
    }

    /**
     * @param int $gameID
     * @return mixed
     */
    public function GetGameInfoExtended($gameID)
    {
        return json_decode(self::GetRAURL("API_GetGameExtended.php", "i=$gameID"));
    }

    /**
     * @return mixed
     */
    public function GetConsoleIDs()
    {
        return json_decode(self::GetRAURL('API_GetConsoleIDs.php'));
    }

    /**
     * @param int $consoleID
     * @return mixed
     */
    public function GetGameList($consoleID)
    {
        return json_decode(self::GetRAURL("API_GetGameList.php", "i=$consoleID"));
    }

    /**
     * @param string $user
     * @param int    $count
     * @param int    $offset
     * @return mixed
     */
    public function GetFeedFor($user, $count, $offset = 0)
    {
        return json_decode(self::GetRAURL("API_GetFeed.php", "u=$user&c=$count&o=$offset"));
    }

    /**
     * @param string $user
     * @return mixed
     */
    public function GetUserRankAndScore($user)
    {
        return json_decode(self::GetRAURL("API_GetUserRankAndScore.php", "u=$user"));
    }

    /**
     * @param string $user
     * @param string $gameIDCSV
     * @return mixed
     */
    public function GetUserProgress($user, $gameIDCSV)
    {
        $gameIDCSV = preg_replace('/\s+/', '', $gameIDCSV);    //	Remove all whitespace
        return json_decode(self::GetRAURL("API_GetUserProgress.php", "u=$user&i=$gameIDCSV"));
    }

    /**
     * @param string $user
     * @param int    $count
     * @param int    $offset
     * @return mixed
     */
    public function GetUserRecentlyPlayedGames($user, $count, $offset = 0)
    {
        return json_decode(self::GetRAURL("API_GetUserRecentlyPlayedGames.php", "u=$user&c=$count&o=$offset"));
    }

    /**
     * @param string $user
     * @param int    $numRecentGames
     * @return mixed
     */
    public function GetUserSummary($user, $numRecentGames)
    {
        return json_decode(self::GetRAURL("API_GetUserSummary.php", "u=$user&g=$numRecentGames&a=5"));
    }

    /**
     * @param string $user
     * @param int    $gameID
     * @return mixed
     */
    public function GetGameInfoAndUserProgress($user, $gameID)
    {
        return json_decode(self::GetRAURL("API_GetGameInfoAndUserProgress.php", "u=$user&g=$gameID"));
    }

    /**
     * @param string $user
     * @param int    $dateInput
     * @return mixed
     */
    public function GetAchievementsEarnedOnDay($user, $dateInput)
    {
        return json_decode(self::GetRAURL("API_GetAchievementsEarnedOnDay.php", "u=$user&d=$dateInput"));
    }

    /**
     * @param string $user
     * @param int    $dateStart
     * @param int    $dateEnd
     * @return mixed
     */
    public function GetAchievementsEarnedBetween($user, $dateStart, $dateEnd)
    {
        $dateFrom = strtotime($dateStart);
        $dateTo = strtotime($dateEnd);
        return json_decode(self::GetRAURL("API_GetAchievementsEarnedBetween.php", "u=$user&f=$dateFrom&t=$dateTo"));
    }
}

;
