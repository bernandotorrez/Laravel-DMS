<?php

namespace App\Repository\Eloquent\Repo;

use App\Models\User;
use App\Repository\Eloquent\Interfaces\UserRepositoryInterface;
use App\Repository\Eloquent\BaseRepository;
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

    /**
     * @param $id
     * 
     * @param array $attributes
     * 
     * @return Collection 
     */
    public function update(int $id, array $attributes): Collection {
        $update = User::where('id', $id)->update($attributes);
        
        return $update;
    }

    /**
     * @param $id
     * 
     * @return Collection 
     */
    public function delete(int $id): Collection {
        $delete = User::where('id', $id)->update(array('status' => 0));

        return $delete;
    }
}