<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InsertSampleRecords extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // insert into tb role
        DB::table('role')->insert([
            ['role_name' => 'admin'],
            ['role_name' => 'QA Leaders'],
            ['role_name' => 'QA coordinators'],
            ['role_name' => 'Staffs']
        ]);

        // Insert default value into department table
        DB::table('department')->insert([
            ['dept_name' => 'Academic'],
            ['dept_name' => 'Support'],
            ['dept_name' => 'Marketing'],
            ['dept_name' => 'IT'],
            ['dept_name' => 'HR'],
            ['dept_name' => 'Finance']
        ]);

        // insert into tb users
        DB::table('users')->insert([
            [
                'fullName' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => 1,
                'role_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'fullName' => 'QA Leaders',
                'email' => 'qaleaders@gmail.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => 1,
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'fullName' => 'QA coordinators 1',
                'email' => 'qacoordinators1@gmail.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => 2,
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'fullName' => 'QA coordinators 2',
                'email' => 'qacoordinators2@gmail.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => 3,
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'fullName' => 'QA coordinators 3',
                'email' => 'qacoordinators3@gmail.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => 4,
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'fullName' => 'Staffs 1',
                'email' => 'staff1@gmail.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => 2,
                'role_id' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'fullName' => 'Staffs 2',
                'email' => 'staff2@gmail.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => 3,
                'role_id' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'fullName' => 'Staffs 3',
                'email' => 'staff3@gmail.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => 4,
                'role_id' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        // insert into tb category
        DB::table('categories')->insert([
            [
                'category_name' => 'Communication',
                'description' => 'Improving communication within and between teams, departments, and levels of the organization can enhance productivity, efficiency, and teamwork.'
            ],
            [
                'category_name' => 'Leadership',
                'description' => 'Developing leadership skills and empowering employees can improve morale, job satisfaction, and overall performance.'
            ],
            [
                'category_name' => 'Training and Development',
                'description' => 'Providing employees with ongoing training and development opportunities can enhance their skills, knowledge, and abilities, and ultimately benefit the organization.'
            ],
            [
                'category_name' => 'Customer Service',
                'description' => 'Focusing on improving customer service can enhance customer satisfaction, retention, and loyalty.'
            ],
            [
                'category_name' => 'Process Improvement',
                'description' => 'Streamlining and optimizing business processes can increase efficiency, reduce waste, and improve quality.'
            ],
            [
                'category_name' => 'Innovation',
                'description' => 'Encouraging innovation and creativity can lead to new ideas, products, and services that can help the organization stay competitive and relevant.'
            ],
            [
                'category_name' => 'Diversity, Equity, and Inclusion',
                'description' => 'Promoting diversity, equity, and inclusion within the organization can improve morale, attract and retain talent, and enhance the organization\'s reputation.'
            ],
            [
                'category_name' => 'Technology',
                'description' => 'Embracing new technologies and tools can enhance efficiency, collaboration, and overall performance.'
            ],
            [
                'category_name' => 'Performance Management',
                'description' => 'Establishing clear performance metrics and processes for feedback and recognition can help employees understand expectations and improve their performance.'
            ],
            [
                'category_name' => 'Workplace Culture',
                'description' => 'Fostering a positive and supportive workplace culture can improve employee satisfaction, productivity, and retention.'
            ],
        ]);

        // insert into tb topics
        // DB::table('topics')->insert([
        //     [
        //         'topic_name' => 'Academic',
        //         'category_id' => 1,
        //         'firstClosureDate' => '2021-03-07',
        //         'finalClosureDate' => '2021-03-07',
        //     ],
        //     [
        //         'topic_name' => 'Support',
        //         'category_id' => 2,
        //         'firstClosureDate' => '2021-03-07',
        //         'finalClosureDate' => '2021-03-07',
        //     ],
        //     [
        //         'topic_name' => 'Marketing',
        //         'category_id' => 3,
        //         'firstClosureDate' => '2021-03-07',
        //         'finalClosureDate' => '2021-03-07',
        //     ],
        //     [
        //         'topic_name' => 'IT',
        //         'category_id' => 4,
        //         'firstClosureDate' => '2021-03-07',
        //         'finalClosureDate' => '2021-03-07',
        //     ],
        //     [
        //         'topic_name' => 'HR',
        //         'category_id' => 5,
        //         'firstClosureDate' => '2021-03-07',
        //         'finalClosureDate' => '2021-03-07',
        //     ],
        //     [
        //         'topic_name' => 'Finance',
        //         'category_id' => 6,
        //         'firstClosureDate' => '2021-03-07',
        //         'finalClosureDate' => '2021-03-07',
        //     ],
        // ]);

        // insert into tb idea posts
        // DB::table('idea_posts')->insert([
        //     [
        //         'title' => 'Academic 1',
        //         'content' => 'Academic',
        //         'user_id' => 1,
        //         'topic_id' => 1,
        //         'created_at' => now(),
        //     ],

        //     [
        //         'title' => 'Academic 2',
        //         'content' => 'lorem ipsum dolor sit amet more text here',
        //         'user_id' => 2,
        //         'topic_id' => 2,
        //         'created_at' => now(),
        //     ],

        //     [
        //         'title' => 'Academic 3',
        //         'content' => 'lorem ipsum dolor sit amet more text here',
        //         'user_id' => 1,
        //         'topic_id' => 1,
        //         'created_at' => now(),
        //     ],

        //     [
        //         'title' => 'Academic 4',
        //         'content' => 'lorem ipsum dolor sit amet more text here',
        //         'user_id' => 3,
        //         'topic_id' => 3,
        //         'created_at' => now(),
        //     ],
        // ]);
    }
}
