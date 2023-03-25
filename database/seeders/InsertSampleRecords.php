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
            ['role_name' => 'QA Managers'],
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


        $departments = range(1, 6);
        $avt = range(2, 25);

        // insert into tb users
        DB::table('users')->insert([
            [
                'fullName' => 'Victoria Montgomery',
                'email' => 'qaleaders@gmail.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => 1,
                'role_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],
            [
                'fullName' => 'Nathaniel Harrison',
                'email' => 'qacoordinators1@gmail.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => 2,
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],
            [
                'fullName' => 'Elizabeth Fitzgerald',
                'email' => 'qacoordinators2@gmail.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => 3,
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],
            [
                'fullName' => 'Benjamin Kensington',
                'email' => 'qacoordinators3@gmail.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => 4,
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],
            [
                'fullName' => 'Gabrielle Winchester',
                'email' => 'staff1@gmail.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => 2,
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],
            [
                'fullName' => 'Theodore Sinclair',
                'email' => 'staff2@gmail.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => 3,
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],
            [
                'fullName' => 'Isabella Harrington',
                'email' => 'staff3@gmail.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => 4,
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],
            [
                'fullName' => 'Maximilian Jefferson',
                'email' => 'staff4@gmail.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => 4,
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],
            [
                'fullName' => 'Alexandra Kensington',
                'email' => 'staff5@gmail.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => 4,
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],

            [
                'fullName' => 'Elizabeth Townsend',
                'email' => 'elizabethtownsend@email.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => $departments[array_rand($departments)],
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],

            [
                'fullName' => 'Alexander Harrison',
                'email' => 'alexanderharrison@email.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => $departments[array_rand($departments)],
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],

            [
                'fullName' => 'Samantha Fitzgerald',
                'email' => 'samanthafitzgerald@email.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => $departments[array_rand($departments)],
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],

            [
                'fullName' => 'Benjamin Whitmore',
                'email' => 'benjaminwhitmore@email.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => $departments[array_rand($departments)],
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],

            [
                'fullName' => 'Gabrielle Sinclair',
                'email' => 'gabriellesinclair@email.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => $departments[array_rand($departments)],
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],

            [
                'fullName' => 'Theodore Anderson',
                'email' => 'theodoreanderson@email.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => $departments[array_rand($departments)],
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],

            [
                'fullName' => 'Isabella Montgomery',
                'email' => 'isabellamontgomery@email.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => $departments[array_rand($departments)],
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],

            [
                'fullName' => 'Nathaniel Hartman',
                'email' => 'nathanielhartman@email.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => $departments[array_rand($departments)],
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],

            [
                'fullName' => 'Charlotte McLeod',
                'email' => 'charlottemcleod@email.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => $departments[array_rand($departments)],
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],

            [
                'fullName' => 'Maximilian Mercer',
                'email' => 'maximilianmercer@email.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => $departments[array_rand($departments)],
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],

            [
                'fullName' => 'Penelope Donovan',
                'email' => 'penelopedonovan@email.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => $departments[array_rand($departments)],
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],

            [
                'fullName' => 'Nicholas Atwood',
                'email' => 'nicholasatwood@email.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => $departments[array_rand($departments)],
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],

            [
                'fullName' => 'Victoria Blackburn',
                'email' => 'victoriablackburn@email.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => $departments[array_rand($departments)],
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],

            [
                'fullName' => 'Frederick Tate',
                'email' => 'fredericktate@email.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => $departments[array_rand($departments)],
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],

            [
                'fullName' => 'Annabelle Greene',
                'email' => 'annabellegreene@email.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => $departments[array_rand($departments)],
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],

            [
                'fullName' => 'Harrison Langley',
                'email' => 'harrisonlangley@email.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => $departments[array_rand($departments)],
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],

            [
                'fullName' => 'Lillian Banks',
                'email' => 'lillianbanks@email.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => $departments[array_rand($departments)],
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],

            [
                'fullName' => 'Timothy Bradford',
                'email' => 'timothybradford@email.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => $departments[array_rand($departments)],
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],

            [
                'fullName' => 'Alexandra Barrett',
                'email' => 'alexandrabarrett@email.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => $departments[array_rand($departments)],
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],

            [
                'fullName' => 'Christopher Gallagher',
                'email' => 'christophergallagher@email.com',
                'password' => Hash::make('12345678'),
                'password_changed' => 1,
                'dept_id' => $departments[array_rand($departments)],
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'avt' . array_rand($avt) . '.png',
            ],
        ]);


        // insert into tb category
        // DB::table('categories')->insert([
        //     [
        //         'category_name' => 'Communication',
        //         'description' => 'Improving communication within and between teams, departments, and levels of the organization can enhance productivity, efficiency, and teamwork.'
        //     ],
        //     [
        //         'category_name' => 'Leadership',
        //         'description' => 'Developing leadership skills and empowering employees can improve morale, job satisfaction, and overall performance.'
        //     ],
        //     [
        //         'category_name' => 'Training and Development',
        //         'description' => 'Providing employees with ongoing training and development opportunities can enhance their skills, knowledge, and abilities, and ultimately benefit the organization.'
        //     ],
        //     [
        //         'category_name' => 'Customer Service',
        //         'description' => 'Focusing on improving customer service can enhance customer satisfaction, retention, and loyalty.'
        //     ],
        //     [
        //         'category_name' => 'Process Improvement',
        //         'description' => 'Streamlining and optimizing business processes can increase efficiency, reduce waste, and improve quality.'
        //     ],
        //     [
        //         'category_name' => 'Innovation',
        //         'description' => 'Encouraging innovation and creativity can lead to new ideas, products, and services that can help the organization stay competitive and relevant.'
        //     ],
        //     [
        //         'category_name' => 'Diversity, Equity, and Inclusion',
        //         'description' => 'Promoting diversity, equity, and inclusion within the organization can improve morale, attract and retain talent, and enhance the organization\'s reputation.'
        //     ],
        //     [
        //         'category_name' => 'Technology',
        //         'description' => 'Embracing new technologies and tools can enhance efficiency, collaboration, and overall performance.'
        //     ],
        //     [
        //         'category_name' => 'Performance Management',
        //         'description' => 'Establishing clear performance metrics and processes for feedback and recognition can help employees understand expectations and improve their performance.'
        //     ],
        //     [
        //         'category_name' => 'Workplace Culture',
        //         'description' => 'Fostering a positive and supportive workplace culture can improve employee satisfaction, productivity, and retention.'
        //     ],
        // ]);
    }
}
