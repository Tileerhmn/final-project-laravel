<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_borrowings', function (Blueprint $table) {
            $table->id();
            $table->string('book_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign("book_id")->references("isbn")->on("books");
            $table->foreign("user_id")->references("id")->on("users");

            $table->timestamp("borrowed_at")->useCurrent();
            $table->timestamp("returned_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('book_borrowings');
    }
};
