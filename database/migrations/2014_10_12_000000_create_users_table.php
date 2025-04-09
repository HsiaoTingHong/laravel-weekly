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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('使⽤者名稱');
            $table->string('email')->unique()->comment('電⼦郵件');
            $table->string('password')->comment('密碼');
            $table->boolean('is_admin')->default(false)->comment('是否為管理者');
            $table->integer('age')->nullable()->comment('年齡');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
