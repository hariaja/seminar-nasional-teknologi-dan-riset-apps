<?php

namespace App\Repositories\User;

use LaravelEasyRepository\Repository;

interface UserRepository extends Repository
{
  public function getReviewerOnly();
  public function getAdminOnly();
  public function getPemakalahOnly();
  public function getReviewerWhereNotSelected();
  public function getUserExceptAdmin();
  public function getUserWhereHasTransaction();
  public function changeStatusUser(int $id);
  public function deleteUserAvatar(int $id);
}
