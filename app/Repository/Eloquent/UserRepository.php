<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param User $model
    */
   public function __construct(User $model)
   {
       parent::__construct($model);
   }

   /**
    * @return Collection
    */
   public function all(): Collection
   {
       return $this->model->all();    
   }

   /**
    * @param $email
    * @return int
    */
   public function findEmail(string $email): int {
       $checkEmail = User::select('email')->where('email', $email)->count();

       return $checkEmail;
   }

   public function getEmail(string $email): Collection
   {
       $where = ['email' => $email, 'status' => '1'];
       $getEmail = User::select('email', 'password')->where($where)->get();

       return $getEmail;
   }
}