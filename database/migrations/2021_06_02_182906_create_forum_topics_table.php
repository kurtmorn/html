<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_topics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->integer('home_page_priority');
            $table->boolean('is_staff_only_viewing')->default(false);
            $table->boolean('is_staff_only_posting')->default(false);
            $table->timestamps();
        });

        DB::table('forum_topics')->insert([
            [
                'name' => 'Information & Announcements',
                'description' => 'Important news such as new features, ideas to talk about, events and server events will be posted here.',
                'home_page_priority' => 255,
                'is_staff_only_viewing' => false,
                'is_staff_only_posting' => true,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'name' => 'Avasquare Central',
                'description' => 'This is the general discussion for Avasquare. You should post topics relating to Avasquare here.',
                'home_page_priority' => 100,
                'is_staff_only_viewing' => false,
                'is_staff_only_posting' => false,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'name' => 'Off Topic',
                'description' => 'If there\'s no other subforum that suits the content you want to post, post it here!',
                'home_page_priority' => 90,
                'is_staff_only_viewing' => false,
                'is_staff_only_posting' => false,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'name' => 'Marketplace',
                'description' => 'Are you interested in advertising or selling your items? This is the place for you!',
                'home_page_priority' => 80,
                'is_staff_only_viewing' => false,
                'is_staff_only_posting' => false,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'name' => 'Space Discussion',
                'description' => 'This is the place for all your space discussions, be it declarations of war on other spaces or simple instructions on serving a customer their coffee in your Cafe space.',
                'home_page_priority' => 70,
                'is_staff_only_viewing' => false,
                'is_staff_only_posting' => false,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'name' => 'Website Suggestions',
                'description' => 'Do you have an idea for Avasquare? Post your suggestions here.',
                'home_page_priority' => 60,
                'is_staff_only_viewing' => false,
                'is_staff_only_posting' => false,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'name' => 'Technical Support',
                'description' => 'If you have questions relating to your account, you can seek assistance in this sub-forum.',
                'home_page_priority' => 50,
                'is_staff_only_viewing' => false,
                'is_staff_only_posting' => false,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'name' => 'Admin Discussion',
                'description' => 'This is the place for admins to communicate with eachother.',
                'home_page_priority' => 40,
                'is_staff_only_viewing' => true,
                'is_staff_only_posting' => true,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forum_topics');
    }
}
