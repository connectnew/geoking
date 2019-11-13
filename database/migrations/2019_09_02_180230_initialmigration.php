<?php

use App\Traits\Blueprints\BlueprintCreatedAndUpdatedByForeignKeys;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitialMigration extends Migration
{
    use BlueprintCreatedAndUpdatedByForeignKeys;

    private function getAccountDomain(int $id, string $title, string $description): array
    {
        $now = Carbon::now();
        $userId = Config::get('app.system_user_id');

        return [
            'id' => $id,
            'created_by' => $userId,
            'updated_by' => $userId,
            'title' => $title,
            'description' => $description
        ];
    }

    private function getAccountType(int $id, string $title): array
    {
        $now = Carbon::now();
        $userId = Config::get('app.system_user_id');

        return [
            'id' => $id,
            'created_by' => $userId,
            'updated_by' => $userId,
            'title' => $title
        ];
    }

    private function getUser(int $id, string $firstname, string $lastname, string $email, string $password = '1'): array
    {
        $now = Carbon::now();
        $userId = Config::get('app.system_user_id');

        return [
            'id' => $id,
            'created_by' => $userId,
            'updated_by' => $userId,
            'first_name' => $firstname,
            'last_name' => $lastname,
            'email' => $email,
            'password' => Hash::make($password),
            'image_url' => ''
        ];
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dictionary_boolean', function (Blueprint $table) {
            $table->boolean('id')->unsigned()->primary();
            $table->string('title', 5);
        });

        DB::table('dictionary_boolean')->insert([
            ['id' => 0, 'title' => 'false'],
            ['id' => 1, 'title' => 'true']
        ]);

        // insert `system` user
        DB::table('users')->insert([
            $this->getUser(Config::get('app.system_user_id'), 'System', 'User', 'system@geoking.com')
        ]);

        Schema::create('account_types', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title', 100);
            $table->timestamps();
            $table->softDeletes();

            self::addCreatedAndUpdatedBy($table);
        });

        DB::table('account_types')->insert([
            $this->getAccountType(1, 'One-Location Business'),
            $this->getAccountType(2, 'Multi-Location Business'),
            $this->getAccountType(3, 'Marketing Agency')
        ]);

        Schema::create('account_domains', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title', 100);
            $table->string('description', 255);
            $table->timestamps();
            $table->softDeletes();

            self::addCreatedAndUpdatedBy($table);
        });

        DB::table('account_domains')->insert([
            $this->getAccountDomain(1, 'Transport', 'Airport Terminals, Metro stations, Bus stations, Trains stations, Taxi stops, Parkings, other'),
            $this->getAccountDomain(2, 'Retail', 'Retail Banks, Fashion shops, Electronics stores, Automotive, Gyms, Petrol stations, large formats, Rent a car, Homecare, '),
            $this->getAccountDomain(3, 'Food and Beverage', 'QSR, Coffee shops, Delis, Restaurants, Catering, Supermarkets, Groceries, Street food, dine-ins, canteens, ice-cream parlors, or another form provider of food to the public.'),
            $this->getAccountDomain(4, 'Healthcare', 'Clinics, Hospital, Dentists, GPs, Labs, emergencies, Pharmacies, Seniors homes, Vets, Emergencies, Health providers, Specialists, Kine, oncology, nutrionists, psys, opticians, homecare, radiology, other.'),
            $this->getAccountDomain(5, 'Entertainment', 'Parcs, Cinemas, Theater, Events, Stadiums, Musuems, Historical sites, Tourism, Wildlife, Marina, Fauna, other'),
            $this->getAccountDomain(6, 'Hospitality', 'Hotels, Beauty parlors,  Motels, Lounges, Resorts, Compounds, Residencial units, B&B, other.'),
            $this->getAccountDomain(7, 'Self-Service', 'ATM, Charging stations, Self-Service Banking, Vending machines, other'),
            $this->getAccountDomain(8, 'Public Service', 'Police stations, Fire stations,Voting stations, Ministries, Gov Agencies, Municipalities, Embassies, other'),
            $this->getAccountDomain(9, 'Education', 'Schools, Universities, Training centers, Institutes, Kindergardens, Libraries, Business schools,other')
        ]);

        Schema::create('accounts', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('type_id');
            $table->unsignedInteger('domain_id');
            $table->string('name', 255);
            $table->string('website', 255);
            $table->string('phone', 255);
            $table->string('address', 255);

            $table->foreign('type_id')
                ->references('id')
                ->on('account_types')
                ->onDelete('restrict');

            $table->foreign('domain_id')
                ->references('id')
                ->on('account_domains')
                ->onDelete('restrict');

            self::addCreatedAndUpdatedBy($table);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('account_users', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('account_id');
            $table->unsignedInteger('user_id');

            $table->foreign('account_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('restrict');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('groups', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title', 255);
            $table->unsignedInteger('account_id');

            $table->foreign('account_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('restrict');

            self::addCreatedAndUpdatedBy($table);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('locations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('account_id');
            $table->string('title', 255);
            $table->string('phone', 255);
            $table->string('website', 255);
            $table->string('country', 255);
            $table->string('address', 255);
            $table->string('street', 255);
            $table->string('city', 255);
            $table->string('state', 255);
            $table->string('zip', 100);
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 10, 8);

            $table->foreign('account_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('restrict');

            self::addCreatedAndUpdatedBy($table);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('location_groups', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('location_id');
            $table->unsignedInteger('group_id');

            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('restrict');

            $table->foreign('group_id')
                ->references('id')
                ->on('groups')
                ->onDelete('restrict');

            self::addCreatedAndUpdatedBy($table);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('business_categories', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title', 255);

            self::addCreatedAndUpdatedBy($table);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('location_business_categories', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('location_id');
            $table->unsignedInteger('business_category_id');

            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('restrict');

            $table->foreign('business_category_id')
                ->references('id')
                ->on('business_categories')
                ->onDelete('restrict');

            self::addCreatedAndUpdatedBy($table);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('service_areas', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title', 255);

            self::addCreatedAndUpdatedBy($table);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('location_service_areas', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('location_id');
            $table->unsignedInteger('service_area_id');

            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('restrict');

            $table->foreign('service_area_id')
                ->references('id')
                ->on('service_areas')
                ->onDelete('restrict');

            self::addCreatedAndUpdatedBy($table);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('dictionary_boolean');
        Schema::dropIfExists('account_types');
        Schema::dropIfExists('account_domains');
        Schema::dropIfExists('accounts');
        Schema::dropIfExists('account_users');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('location_groups');
        Schema::dropIfExists('business_categories');
        Schema::dropIfExists('location_business_categories');
        Schema::dropIfExists('service_areas');
        Schema::dropIfExists('location_service_areas');
        Schema::enableForeignKeyConstraints();
    }
}
