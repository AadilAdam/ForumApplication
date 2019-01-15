<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Support\Facades\DB as DB;

class AddRepliesCountToThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('threads', function (Blueprint $table) {
            $table->unsignedInteger('replies_count')->after('channel_id')->default(0);
        });

        DB::table('threads')->where(['id' => 1])->update(['replies_count' => 2]);
        DB::table('threads')->where(['id' => 5])->update(['replies_count' => 1]);
        DB::table('threads')->where(['id' => 4])->update(['replies_count' => 2]);
        DB::table('threads')->where(['id' => 7])->update(['replies_count' => 1]);
        DB::table('threads')->where(['id' => 50])->update(['replies_count' => 2]);
        DB::table('threads')->where(['id' => 51])->update(['replies_count' => 1]);
        DB::table('threads')->where(['id' => 53])->update(['replies_count' => 4]);
        DB::table('threads')->where(['id' => 54])->update(['replies_count' => 2]);
        DB::table('threads')->where(['id' => 55])->update(['replies_count' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('threads', function (Blueprint $table) {
            $table->dropColumn('replies_count');
        });
    }
}
