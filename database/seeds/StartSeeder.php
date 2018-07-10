<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class StartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 10; $i++){
            $student = \App\User::create([
                'name' => "Mahasiswa ".$i,
                'email' => "mahasiswa".$i."@presence.com",
                'password' => bcrypt('12345678'),
            ]);

            $student->profile()->create([
                'born_date' => "1945-08-17",
                "gender" => array_random(["L","P"]),
                "number_id" => rand(100000, 999999)
            ]);

            $student->card()->create([
                'key' => rand(100000, 999999)
            ]);
        }

        for($i = 1; $i <= 10; $i++){
            $lecture = \App\User::create([
                'name' => "Dosen ".$i,
                'email' => "dosen".$i."@presence.com",
                'role' => "lecturer",
                'password' => bcrypt('12345678'),
            ]);

            $lecture->profile()->create([
                'born_date' => "1945-08-17",
                "gender" => array_random(["L","P"]),
                "number_id" => rand(100000, 999999)
            ]);

            $lecture->card()->create([
                'key' => rand(100000, 999999)
            ]);
        }

        DB::table('users')->insert([
            'name' => "Administrator",
            'email' => 'admin@presence.com',
            'password' => bcrypt('12345678'),
            'role' => 'admin',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        for($i = 1; $i <= 10; $i++){
            DB::table('rooms')->insert([
                'name' => "Ruang ".$i,
                'key' => rand(100000, 999999),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]); 
        }

        DB::table('curriculum')->insert([
            'name' => "Kurikulum KTSP",
            'status' => "0",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('curriculum')->insert([
            'name' => "Kurikulum 2013",
            'status' => "1",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        for($i = 1; $i <= 10; $i++){        
            DB::table('courses')->insert([
                'code' => rand(100000, 999999),
                'curriculum_id' => array_random([0,1]),
                'name' => array_random(['Sistem Informasi', 'Teknik Komputer', 'Jaringan Komputer', 'Pemrograman Komputer']),
                'sks' => rand(1,4),
                'category' => array_random(["W", "P"]),
                'group' => array_random(['MPK','MKK','MKB','MBB']),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
        
        $start = 2013;
        for($i = 1; $i <= 10; $i++){
            $name = "";
            $status = "0";
            if($i%2 == 1){
                $name .= "Genap ".$start."/".($start+1);
                $start++;
            }
            else {
                $name .= "Ganjil ".$start."/".($start+1);
            }
            if($i == 10){
                $status = "1";
            }

            DB::table('periods')->insert([
                'name' => $name,
                'status' => $status
            ]);
        }

        for($i = 1; $i <= 10; $i++){
            $course = \App\Course::find(rand(1,10));
            $words = explode(" ", $course['name']);
            $acronym = "";            

            foreach ($words as $w) {
                $acronym .= $w[0];
            }
            $newclass = \App\Classes::insert([
                'name' => $acronym,
                'course_id' => $course['id'],
                'lecture_id' => rand(1,10),
                'periode_id' => rand(1,10),
                'room_id' => rand(1,10),
                'day' => rand(0,6),
                'start' => (10+$i).":00:00",
                'end' => (10+$i).":50:00"
            ]);            
        }

        for($i = 1; $i <= 10; $i++){
            $student = [];
            for($x = 1; $x <= 10; $x++){
                if(rand(1,20)%2 == 0){
                    array_push($student, $x);
                }
            }

            \App\Classes::find($i)->students()->sync($student);
        }
    }
}
