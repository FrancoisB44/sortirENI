<?php


namespace App\Data;


use App\Entity\Campus;
use App\Entity\Event;
use App\Entity\Status;
use App\Entity\User;
use Couchbase\UserSettings;
use Symfony\Component\Security\Core\User\UserInterface;

class SearchData
{

    /**
     * @var string
     */
    public $textSearch = '';

    /**
     * @var Campus
     */
    public $campusSearch;

//    /**
//     * @return User
//     */
//    public function getUserSearch(): User
//    {
//        return $this->userSearch;
//    }
//
//    /**
//     * @param User $userSearch
//     */
//    public function setUserSearch(User $userSearch): void
//    {
//        $this->userSearch = $userSearch;
//    }

    /**
     * @var User
     */
    public $userSearch;

    /**
     * @var Status
     */
    public $statusSearch;

    /**
     * @var \DateTime
     */
    public $dateStartSearch;

    /**
     * @var \DateTime
     */
    public $dateEndSearch;

    /**
     * @var Users
     */
    public $participantSearch;




}