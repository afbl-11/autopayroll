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
        Schema::create('employees', function (Blueprint $table) {
            $table->string('employee_id')->primary();

            $table->string('company_id')->nullable();
            $table->foreign('company_id')
                ->references('company_id')
                ->on('companies')
                ->onDelete('cascade');

            $table->integer('schedule_id')->nullable();
            $table->foreign('schedule_id')
                ->references('schedule_id')
                ->on('schedules')
                ->onDelete('cascade');

            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('username');
            $table->string('phone_number');
            $table->string('password');
            $table->string('job_position');
            $table->date('contract_start');
            $table->date('contract_end');

            $table->enum('employment_type',['fulltime', 'part-time', 'contractual']);
            $table->date('birthdate');
            $table->enum('gender', ['male','female']);
            $table->enum('marital_status',['single','married','widowed']);
            $table->enum('blood_type', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->nullable();
            $table->string('religion');

            $table->string('country');
            $table->string('region');
            $table->string('province');
            $table->string('zip');
            $table->string('city');
            $table->string('barangay');
            $table->string('street');
            $table->string('house_number')->nullable();

            $table->string('bank_account_number');
            $table->string('sss_number');
            $table->string('phil_health_number');
            $table->string('pag_ibig_number');
            $table->string('tin_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};

