<?php

namespace App\Http\Controllers;

use App\Cms\Status;
use App\Repositories\BarberRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ServiceRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use DB;
use Faker;

class DummyController extends Controller
{
    protected $barber;
    protected $customer;
    protected $product;
    protected $service;

    public function __construct(BarberRepository $barberRepository, ServiceRepository $serviceRepository,
                                CustomerRepository $customerRepository, ProductRepository $productRepository)
    {
        $this->barber = $barberRepository;
        $this->customer = $customerRepository;
        $this->product = $productRepository;
        $this->service = $serviceRepository;
    }

    public function barber()
    {
        DB::beginTransaction();
        try {
            $faker = Faker\Factory::create();;
            $faker->addProvider(new \Faker\Provider\Lorem($faker));
            $faker->addProvider(new \Faker\Provider\es_ES\PhoneNumber($faker));
            $faker->addProvider(new \Faker\Provider\Payment($faker));
            for ($i = 0; $i < 50; $i++) {
                $pass = generateStrongPassword();
                $name = $faker->firstName;
                $lastName = $faker->lastName;
                $data['name'] = $name;
                $data['first_surname'] = $lastName;
                $data['second_surname'] = $pass;
                $data['phone'] = $faker->phoneNumber;
                $data['mobile'] = $faker->phoneNumber;
                do {
                    $email = $faker->safeEmail;
                } while ($this->barber->existEmail($email));
                $data['email'] = $email;
                $data['password'] = bcrypt($pass);
                $data['curp'] = $faker->creditCardNumber;
                $range1 = $faker->numberBetween($min = 100000, $max = 900000);
                $range2 = $faker->numberBetween($min = 100000, $max = 900000);
                $data['nss'] = $range1 . $range2;
                $data['rfc'] = $faker->swiftBicNumber;
                $range = $faker->numberBetween($min = 1, $max = 20);

                if ($range % 2 == 0) {
                    $range = $faker->numberBetween($min = 1, $max = 9);
                    for ($i = 1; $i < $range; $i++) {
                        $data['alergias'] = $faker->word . ", ";
                    }
                }

                $this->barber->store($data);
            }
            DB::commit();
        } catch (QueryException $queryException) {
            DB::rollBack();
            dd($queryException->getMessage());
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function customer()
    {
        DB::beginTransaction();
        try {
            $faker = Faker\Factory::create();;

            $faker->addProvider(new \Faker\Provider\es_ES\PhoneNumber($faker));
            $faker->addProvider(new \Faker\Provider\Lorem($faker));
            for ($i = 0; $i < 200; $i++) {
                $pass = generateStrongPassword();
                $name = $faker->firstName;
                $lastName = $faker->lastName;
                $data['name'] = $name;
                $data['first_surname'] = $lastName;
                $data['second_surname'] = $pass;
                $data['phone'] = $faker->phoneNumber;
                $data['mobile'] = $faker->phoneNumber;
                $data['favorite_beverage'] = $faker->word;
                $birth_date = $faker->dateTimeBetween($startDate = '-30 years', $endDate = '-25 years', $timezone = null);
                $data['birth_date'] = $birth_date;
                do {
                    $email = $faker->safeEmail;
                } while ($this->customer->existEmail($email));
                $data['email'] = $email;
                $data['password'] = bcrypt($pass);
                $this->customer->store($data);
            }
            DB::commit();
        } catch (QueryException $queryException) {
            DB::rollBack();
            dd($queryException->getMessage());
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }


    public function product()
    {
        DB::beginTransaction();
        try {
            $faker = Faker\Factory::create();;

            $faker->addProvider(new \Faker\Provider\Barcode($faker));
            $faker->addProvider(new \Faker\Provider\Lorem($faker));
            $faker->addProvider(new \Faker\Provider\Image($faker));
            $faker->addProvider(new \Faker\Provider\Company($faker));

            $faker->addProvider(new \Faker\Provider\Commerce($faker));


            for ($i = 0; $i < 150; $i++) {
                $data['create_user'] = 1;
                $data['update_user'] = 1;
                $data['status_id'] = Status::ACTIVE;
                $data['codebar'] = $faker->ean13;
                $data['name'] = $faker->productName(2);// \Faker::Commerce.product_name;
                $data['photo'] = $faker->imageUrl(48, 48, 'cats', true, 'Faker');
                $this->product->store($data);
            }
            DB::commit();
        } catch (QueryException $queryException) {
            DB::rollBack();
            dd($queryException->getMessage());
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }


    public function services()
    {
        DB::beginTransaction();
        try {
            $faker = Faker\Factory::create();;

            $faker->addProvider(new \Faker\Provider\Barcode($faker));
            $faker->addProvider(new \Faker\Provider\Lorem($faker));
            $faker->addProvider(new \Faker\Provider\Image($faker));
            $faker->addProvider(new \Faker\Provider\Company($faker));

            $faker->addProvider(new \Faker\Provider\Commerce($faker));


            for ($i = 0; $i < 150; $i++) {
                $range=$faker->numberBetween($min = 2, $max = 245);
                $data['person_id'] = $range;
                $data['status_id'] = Status::ACTIVE;
                $data['name'] = $faker->productName(2);

                $data['unit_price'] = $faker->numberBetween($min = 110, $max = 499);
                $data['cost'] = $data['unit_price'] - $faker->numberBetween($min = 50, $max = 80);;
                $data['length_minutes'] = $faker->numberBetween($min = 30, $max = 90);
                $data['photo'] = $faker->imageUrl(48, 48, 'cats', true, 'Faker');

                $this->service->store($data);
            }
            DB::commit();
        } catch (QueryException $queryException) {
            DB::rollBack();
            dd($queryException->getMessage());
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }
}
