    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
         * Run the migrations.
         */
        public function up(): void
        {
            Schema::create('services', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('desc');
                $table->string('img')->nullable();
                $table->boolean('push');
                $table->date('push_date'); //for i will active it after 5 days
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('services');
        }
    };
