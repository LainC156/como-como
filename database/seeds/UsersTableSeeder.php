<?php

use App\User;
use App\Role;
use App\Patient;
use App\Payment;
use App\Nutritionist;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * dates: Carbon::parse('2000-01-01')
     *
     * @return void
     */
    public function run()
    {
        $patient_role = Role::where('name', 'patient')->first();
        $nutritionist_role = Role::where('name', 'nutritionist')->first();
        //$admin_role = Role::where('name', 'admin')->first();
        /* first patient */
        $user = new User();
        $user->name = 'Giovanni';
        $user->last_name = 'Trejo Abasolo';
        $user->email = 'gtaa7x@gmail.com';
        $user->identificator = 'TEAG93120HPLRBV';
        $user->password = bcrypt('12345');
        $user->account_type = '3';
        $user->save();
        $patient = new Patient;
        $patient->id = $user->id;
        $patient->user_id = $user->id;
        $patient->birthdate = Carbon::parse('1993-12-08');
        $patient->save();
        $user->roles()->attach($patient_role);
        $user->update();
        $user_payment = new Payment();
        $user_payment->user_id = $user->id;
        $user_payment->save();
        $user_payment->user()->associate($user->id);
        $user_payment->update();
        /* first nutritionist */
        $user = new User();
        $user->name = 'María del Pilar';
        $user->last_name = 'Pozos Parra';
        $user->email = 'maripozos@gmail.com';
        $user->identificator = 'curpmaripozos';
        $user->password = bcrypt('secret');
        $user->account_type = '2';
        $user->save();
        $nutritionist = new Nutritionist;
        $nutritionist->id = $user->id;
        $nutritionist->user_id = $user->id;
        $nutritionist->save();
        $nutritionist->patient()->save( $patient );
        $user->roles()->attach($nutritionist_role);
        $user->update();
        $user_payment = new Payment();
        $user_payment->user_id = $user->id;
        $user_payment->save();
        $user_payment->user()->associate($user->id);
        $user_payment->update();
        /* patients with no nutritionist */
        $user = new User();
        $user->name = 'Juan';
        $user->last_name = 'Sánchez Pérez';
        $user->email = 'prueba1@gmail.com';
        $user->identificator = 'SAPJ831201HPLRBV';
        $user->password = bcrypt('12345');
        $user->account_type = '3';
        $user->save();
        $patient = new Patient;
        $patient->id = $user->id;
        $patient->user_id = $user->id;
        $patient->save();
        $user->roles()->attach($patient_role);
        $user->update();
        $user_payment = new Payment();
        $user_payment->user_id = $user->id;
        $user_payment->save();
        $user_payment->user()->associate($user->id);
        $user_payment->update();

        $user = new User();
        $user->name = 'María';
        $user->last_name = 'Hernández Hernández';
        $user->email = 'prueba2@gmail.com';
        $user->identificator = 'HEHM871002HPLRBV';
        $user->password = bcrypt('12345');
        $user->account_type = '3';
        $user->save();
        $patient = new Patient;
        $patient->id = $user->id;
        $patient->user_id = $user->id;
        $patient->save();
        $user->roles()->attach($patient_role);
        $user->update();
        $user_payment = new Payment();
        $user_payment->user_id = $user->id;
        $user_payment->save();
        $user_payment->user()->associate($user->id);
        $user_payment->update();
    }
}
