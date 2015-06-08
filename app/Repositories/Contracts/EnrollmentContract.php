<?php
/**
 * Created by PhpStorm.
 * User: michaelkantor
 * Date: 6/6/15
 * Time: 3:09 AM
 */

namespace App\Repositories\Contracts;

interface EnrollmentContract extends EloquentRepositoryInterface{

    public function onEnrollment(array $data);
}