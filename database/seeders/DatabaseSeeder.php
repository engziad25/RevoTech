<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // يمكنك اختيار أحد الخيارين:

        // الخيار 1: تشغيل الكل (إذا كنت تريد إدخال البيانات لأول مرة)
        // $this->call([
        //     CategorySeeder::class,
        //     BrandSeeder::class,
        //     ProductSeeder::class,
        //     AdminUserSeeder::class,
        // ]);

        // الخيار 2: تشغيل Seeder محدد (إذا كنت تريد إضافة بيانات معينة فقط)
        $this->call(AdminUserSeeder::class); // فقط أضف المستخدم admin
    }
}