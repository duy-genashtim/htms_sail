<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('extension_name')->nullable();
            $table->string('nick_name')->nullable();
            $table->string('job_title');
            $table->string('email')->unique();
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('marital_status')->comment('(Sample values: Married/Partnered, Single, Others)');
            $table->string('country');
            $table->string('time_zone')->default('+08:00');
            $table->string('member_category')->comment('(Sample values: N/A, PWD, Refugee, etc.)');
            $table->text('address');
            $table->string('phone_number');
            $table->string('personal_email')->nullable();
            $table->string('core_folder')->nullable();
            $table->date('hire_date')->nullable();
            $table->boolean('current_status')->comment('(boolean - active, inactive)');
            $table->timestamps();
            // email must be existed in user- no need
            // $table->foreign('email')->references('email')->on('users');
        });

         // Set the auto-increment starting value
        //  Genashtim was founded in 2008
        DB::statement('ALTER TABLE employees AUTO_INCREMENT = 2008;');

        Schema::create('emergency_contact_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('full_name');
            $table->string('relationship');
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });

        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('mancom_id')->nullable();
            $table->unsignedBigInteger('head_id')->nullable();
            $table->boolean('current_status')->comment('(boolean - active, inactive)');
            $table->boolean('is_mancom')->default(false);
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('departments')->onDelete('set null');
            $table->foreign('mancom_id')->references('id')->on('employees')->onDelete('set null');
            $table->foreign('head_id')->references('id')->on('employees')->onDelete('set null');
        });

        Schema::create('work_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('employment_status')->comment('(Sample values: full-time, part-time, contract)');
            $table->string('employee_type')->comment('(Sample values: permanent, temporary, intern)');
            $table->string('company_name')->nullable();
            $table->string('job_title');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->text('description')->nullable();
            // $table->boolean('is_currently')->default(false);
            // $table->string('position_level')->comment('(Sample values: member, sub-manager, manager)');
            // $table->boolean('is_main_department')->default(false);
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
        });

        Schema::create('employee_department', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('department_id');
            // $table->date('start_date')->nullable();
            // $table->date('end_date')->nullable();
            $table->boolean('is_main_department')->default(false);
            // $table->string('department_level')->comment('(Sample values: member, sub-manager, manager)');
            $table->timestamps();

            $table->primary(['employee_id', 'department_id']);
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        });

        Schema::create('employee_performance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->date('performance_dates');
            $table->string('performance_scores');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable(); // Ensures referential integrity with the users table
            $table->string('email');
            $table->string('action'); // e.g., 'create', 'update', 'delete'
            $table->text('description')->nullable(); // Detailed description of the activity
            $table->text('detail_log'); // To store detail of old activity in json
            $table->timestamps(); // 'created_at' and 'updated_at' columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_performance');
        Schema::dropIfExists('employee_department');
        Schema::dropIfExists('work_history');
        Schema::dropIfExists('emergency_contact_information');
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('employees');

    }
};
