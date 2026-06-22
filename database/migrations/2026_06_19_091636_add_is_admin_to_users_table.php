<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    /**
     * Add admin column to users table
     */
    public function up(): void
    {

        Schema::table('users', function (Blueprint $table) {

            $table->boolean('is_admin')
                ->default(false)
                ->after('password');

        });

    }


    /**
     * Remove admin column from users table
     */
    public function down(): void
    {

        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn('is_admin');

        });

    }

};