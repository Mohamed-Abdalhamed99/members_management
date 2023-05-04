<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\VideoLibrary;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_library', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedInteger('size')->nullable();
            $table->text('path');
            $table->double('time_duration');
            $table->enum('addition_method', [VideoLibrary::EMBED, VideoLibrary::UPLOADED]);
            $table->enum('third_party_name', [VideoLibrary::YOUTUBE, VideoLibrary::VIMEO])->nullable();
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
        Schema::dropIfExists('');
    }
};
