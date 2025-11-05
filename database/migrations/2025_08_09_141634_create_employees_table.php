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

            $table->string('profile_photo')->nullable();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->enum('suffix', ['Sr.', 'Jr.', 'Other'])->nullable();
            $table->string('email')->nullable();
            $table->string('username');
            $table->string('phone_number');
            $table->string('password');
            $table->string('job_position');
            $table->date('contract_start');
            $table->date('contract_end');

            $table->enum('employment_type',['full-time', 'part-time', 'contractual']);
            $table->date('birthdate');
            $table->enum('gender', ['male','female']);
            $table->enum('marital_status',['single','married','widowed']);
            $table->enum('blood_type', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->nullable();

//            current address
            $table->string('country')->default('Philippines');
            $table->string('region_name');
            $table->string('province_name');
            $table->string('zip');
            $table->string('city_name');
            $table->string('barangay_name');
            $table->string('street');
            $table->string('house_number')->nullable();

//            address on id
            $table->string('id_country')->default('Philippines');
            $table->string('id_region');
            $table->string('id_province');
            $table->string('id_zip');
            $table->string('id_city');
            $table->string('id_barangay');
            $table->string('id_street');
            $table->string('id_house_number')->nullable();

            $table->string('bank_account_number');
            $table->string('sss_number');
            $table->string('phil_health_number');
            $table->string('pag_ibig_number');
            $table->string('tin_number');

            $table->json('uploaded_documents')->nullable();
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

