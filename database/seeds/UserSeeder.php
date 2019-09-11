<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = require(__DIR__ . '/../data/userxSeed1.php');
        echo 'lokoko' . PHP_EOL;

        \App\Modules\Adminx\Models\Userx::truncate();
        foreach ($datas as $data ){
            for ($i=0; $i<100; $i++){
                $user = new \App\Modules\Adminx\Models\Userx();
                $user->setScenario('createByAdmin');
                $user->name = $data['name'] . "_$i";
                $user->email = $data['email'] . "_$i";
                $user->password = '1234567890';
                if (!$user->save()){
                    echo $user->exeptionMessage . PHP_EOL;
                    exit(0);
                }
                echo $i . PHP_EOL;
            }
        }
      //  echo var_dump($data);

        //
    }
}
