<?php


namespace App\Data;


use App\Entity\Campus;
use App\Entity\Status;
use App\Entity\User;

class SearchData
{

    /**
     * @var string
     */
    public $textSearch = '';

    /**
     * @var Campus[]
     */
    public $campusSearch =[];

    /**
     * @var User
     */
    public $userSearch = [];

    /**
     * @var Status
     */
    public $statusSearch = [];

    /**
     * @var \DateTime
     */
    public $dateStartSearch;

    /**
     * @var \DateTime
     */
    public $dateRegistrationSearch;




}