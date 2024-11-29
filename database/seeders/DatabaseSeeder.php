<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Level;
use App\Models\Position;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use App\Models\HSE\potentialHazardsInWorkplace_master;
use App\Models\HSE\personalProtectiveEquipment_master;
use App\Models\HSE\workEquipments_master;
use App\Models\HSE\additionalworkpermits_master;
use App\Models\HSE\firehazardcontrol_master;
use App\Models\HSE\scaffoldingRiskControl_master ;
use App\Models\HSE\approver;
use App\Models\HSE\hseLocation;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Permissions
         Permission::create(['name' => 'view role']);
         Permission::create(['name' => 'create role']);
         Permission::create(['name' => 'update role']);
         Permission::create(['name' => 'delete role']);

         Permission::create(['name' => 'view permission']);
         Permission::create(['name' => 'create permission']);
         Permission::create(['name' => 'update permission']);
         Permission::create(['name' => 'delete permission']);

         Permission::create(['name' => 'view user']);
         Permission::create(['name' => 'create user']);
         Permission::create(['name' => 'update user']);
         Permission::create(['name' => 'delete user']);

         Permission::create(['name' => 'view department']);
         Permission::create(['name' => 'create department']);
         Permission::create(['name' => 'update department']);
         Permission::create(['name' => 'delete department']);

         Permission::create(['name' => 'view position']);
         Permission::create(['name' => 'create position']);
         Permission::create(['name' => 'update position']);
         Permission::create(['name' => 'delete position']);

         Permission::create(['name' => 'view level']);
         Permission::create(['name' => 'create level']);
         Permission::create(['name' => 'update level']);
         Permission::create(['name' => 'delete level']);         

         Permission::create(['name' => 'view user dashboard hse']);
         Permission::create(['name' => 'create form hse']);
         Permission::create(['name' => 'review form hse']);
         Permission::create(['name' => 'approve form hse']);
         Permission::create(['name' => 'view security dashboard hse']);
         Permission::create(['name' => 'view all form hse']);
         Permission::create(['name' => 'edit location hse']);
         Permission::create(['name' => 'edit approver hse']);
         Permission::create(['name' => 'job evaluation hse']);
         

         //create departements

        Department::create(['department_name' => 'Engineering & Maintainance']);
        Department::create(['department_name' => 'Finance Admin']);
        Department::create(['department_name' => 'HCD']);
        Department::create(['department_name' => 'Manufacturing']);
        Department::create(['department_name' => 'QM & HSE']);
        Department::create(['department_name' => 'R&D']);
        Department::create(['department_name' => 'Sales & Marketing']);
        Department::create(['department_name' => 'Supply Chain']);
        Department::create(['department_name' => 'Secret']);

         //create Level
         Level::create(['level_name' => 'I']);
         Level::create(['level_name' => 'II']);
         Level::create(['level_name' => 'III']);
         Level::create(['level_name' => 'IV']);
         Level::create(['level_name' => 'V']);
         Level::create(['level_name' => 'VI']);
         Level::create(['level_name' => 'VII']);
         Level::create(['level_name' => 'Developer']);

          // department finance and admin
        Position::create(['position_name' => 'Developer','level_id' => 8,'department_id' => 9 ]);
        Position::create(['position_name' => 'General Manager','level_id' => 7,'department_id' => 1 ]);
        Position::create(['position_name' => 'Department Head Finance','level_id' => 6,'department_id' =>2 ]);
        Position::create(['position_name' => 'Assistant Manager MIS','level_id' => 5,'department_id' =>2 ]);
        Position::create(['position_name' => 'Manager Accounting & Tax','level_id' => 5,'department_id' =>2 ]);
        Position::create(['position_name' => 'Manager Bussiness Opr. Control','level_id' => 5,'department_id' => 2]);
        Position::create(['position_name' => 'IT Support','level_id' => 3,'department_id' =>2 ]);
        Position::create(['position_name' => 'Web Developer','level_id' => 4,'department_id' =>2 ]);
        Position::create(['position_name' => 'Supervisor - MIS ','level_id' => 4,'department_id' =>2 ]);

        // department suppply chain
        Position::create(['position_name' => 'Department Head Supply Chain','level_id' => 6,'department_id' =>8 ]);
        Position::create(['position_name' => 'Manager - Logistic','level_id' => 6,'department_id' =>8]);
        Position::create(['position_name' => 'Manager - PPIC','level_id' => 6,'department_id' =>8 ]);
        Position::create(['position_name' => 'Manager - Purchasing','level_id' => 6,'department_id' =>8 ]);
        Position::create(['position_name' => 'Supervisor - Export','level_id' => 5,'department_id' =>8 ]);


        // Create Roles
        $superAdminRole = Role::create(['name' => 'super-admin']); //as super-admin
        $userRole = Role::create(['name' => 'user']);
        $hseRole = Role::create(['name' => 'hse']);
        $emRole = Role::create(['name' => 'engineering manager']);
        $aoRole = Role::create(['name' => 'pic location']);
        $securityRole = Role::create(['name' => 'security']);

        // Lets give all permission to super-admin role.
        $allPermissionNames = Permission::pluck('name')->toArray();

        $superAdminRole->givePermissionTo($allPermissionNames);

        // Let's give few permissions to admin role.
        $hseRole->givePermissionTo($allPermissionNames);
        
        $emRole->givePermissionTo(['approve form hse', 'job evaluation hse']);
        
        $aoRole->givePermissionTo(['approve form hse']);
        
        $securityRole->givePermissionTo(['view security dashboard hse']);
        
        $userRole->givePermissionTo(['view user dashboard hse', 'create form hse']);


        // Let's Create User and assign Role to it.

        $superAdminUser = User::firstOrCreate([
                    'email' => 'superadmin@gmail.com',
                ], [
                    'name' => 'Super Admin',
                    'username' => 'super',
                    'company_department' => 'PT Sinar Meadow International Indonesia',
                    'nik' => 'AG1111',
                    'email' => 'superadmin@gmail.com',
                    'password' => Hash::make ('password'),
                    'email_verified_at' => now(),
                    'position_id' => 1,
                    'department_id' => 1,
                ]);

        $superAdminUser->assignRole($superAdminRole);


        $hseUser = User::firstOrCreate([
            'email' => 'hse@gmail.com',
        ], [
            'name' => 'HSE Admin',
            'username' => 'HSE',
            'company_department' => 'PT Sinar Meadow International Indonesia',
            'email' => 'hse@gmail.com',
            'password' => Hash::make ('password'),
            'email_verified_at' => now(),
            'position_id' => 1,
            'department_id' => 1,
        ]);

        $hseUser->assignRole($hseRole);


        $emUser = User::firstOrCreate([
            'email' => 'engineering.manager@gmail.com',
        ], [
            'name' => 'Engineering Manager',
            'username' => 'Engineering Manager',
            'company_department' => 'PT Sinar Meadow International Indonesia',
            'email' => 'engineering.manager@gmail.com',
            'password' => Hash::make ('password'),
            'email_verified_at' => now(),
            'position_id' => 1,
            'department_id' => 1,
        ]);

        $emUser->assignRole($emRole);


        $aoUser = User::firstOrCreate([
            'email' => 'area.owner@gmail.com',
        ], [
            'name' => 'PIC Location',
            'username' => 'PIC Location',
            'company_department' => 'PT Sinar Meadow International Indonesia',
            'email' => 'pic.location@gmail.com',
            'password' => Hash::make ('password'),
            'email_verified_at' => now(),
            'position_id' => 1,
            'department_id' => 1,
        ]);

        $aoUser->assignRole($aoRole);


        $securityUser = User::firstOrCreate([
            'email' => 'security@gmail.com',
        ], [
            'name' => 'Security',
            'username' => 'Security',
            'company_department' => 'PT Sinar Meadow International Indonesia',
            'email' => 'security@gmail.com',
            'password' => Hash::make ('password'),
            'email_verified_at' => now(),
            'position_id' => 1,
            'department_id' => 1,
        ]);

        $securityUser->assignRole($securityRole);


        $userUser = User::firstOrCreate([
            'email' => 'user@gmail.com',
        ], [
            'name' => 'User',
            'username' => 'User',
            'company_department' => 'PT Sinar Meadow International Indonesia',
            'email' => 'user@gmail.com',
            'password' => Hash::make ('password'),
            'email_verified_at' => now(),
            'position_id' => 1,
            'department_id' => 1,
        ]);

        $userUser->assignRole($userRole);


        $names = [
            ["Djarot Hendrawan", "M0182"],
            ["Syaiful Syahrizal", "AE1270"],
            ["Linda Rianty", "T0930"],
            ["Putri Wulandari", "X1017"],
            ["Danu Purboyo", "U0955"],
            ["Dimas Supriyadi", "AC1166"],
            ["Rainita Darmadi", "AD1214"],
            ["Andika Suhendar", "AD1227"],
            ["Edi Tri Maryanto", "D0436"],
            ["Jimmy Ferdinand", "S0905"],
            ["Reginald Iskandar", "Q0858"],
            ["Billy Fernando", "AG1345"],
            ["Sangudin", "U0947"],
            ["Suwanto", "H0689"],
            ["Muchammad Arif Fathoni", "U0942"],
            ["Maria Muyarni", "Q0881"]

        ];
        foreach ($names as $name) {
            $user = User::firstOrCreate([
                'email' => strtolower(str_replace(' ', '.', $name[0]) . '@gmail.com'),
            ], [
                'name' => $name[0],
                'username' => $name[0],
                'nik' => $name[1],
                'company_department' => 'PT Sinar Meadow International Indonesia',
                'email' => strtolower(str_replace(' ', '.', $name[0]) . '@gmail.com'),
                'password' => Hash::make ('password'),
                'email_verified_at' => now(),
                'position_id' => 1,
                'department_id' => 1,
            ]);
    
            $user->assignRole($aoRole);
        }

        
        // Create data potential hazards master
        $potentialHazardsInWorkplace_master_datas = ["Mudah Terbakar", "Gas Beracun", "Bising", "Benda Berat", "Ledakan", "Listrik", "Ketinggian", "Lantai Licin", "Temperatur Tinggi", "Bahan Kimia", "Ruang Tertutup"];
        foreach ($potentialHazardsInWorkplace_master_datas as $item) {
            potentialHazardsInWorkplace_master::create(
                [
                    'name' => $item
                ]
            );
        }

        // masukin data personal protective equipment master 
        $personalprotectiveequipment_master_datas = ["Safety Helmet", "Goggles (Impact)", "Goggles (Chemical)", "Face Shield (Chemical)", "Face Shield (Welding)", "Face Shield (Grinding)","Respirator","Dust Mask","Safety Body Harness","Apron (Hot & Welding)","Safety Shoes (Impact)","Rubber / PVC Shoes","Ear Plug","Ear Muff","Cotton Gloves","Rubber/PVC","Leather Gloves"];
        foreach ($personalprotectiveequipment_master_datas as $item) {
            personalProtectiveEquipment_master::create(
                [
                    'name' => $item
                ]
            );
        }

        // masukin data work equipment master 
        $workEquipments_master_datas = ["Power Tools", "Tangga (Ladder)" , "Bahan Kimia", "Hand Tools", "Stagger (Scaffolds)", "Tabung Gas & Fittings", "Welding Set", "Alat angkat & Angkut", "Air Compressor", "Gerinda / Cutting Tools"];
        foreach ($workEquipments_master_datas as $item) {
            workEquipments_master::create(
                [
                    'name' => $item
                ]
            );
        }

        // masukin data work equipment master 
        $additionalworkpermits_master_datas  = ["Ijin Pekerjaan Panas", "Ijin Kerja Di Ruang Terbatas", "Ijin Kerja Di Ketinggian", "Menggunakan Scaffolding"];
        foreach ($additionalworkpermits_master_datas as $item) {
            additionalworkpermits_master::create(
                [
                    'name' => $item
                ]
            );
        }

        // masukin data fire hazard control master 
        $firehazardcontrol_master_datas  = ["Fire Blanket", "Alat Pemadam Api Ringan (APAR)", "Hydrant"];
        foreach ($firehazardcontrol_master_datas as $item) {
            firehazardcontrol_master::create(
                [
                    'name' => $item
                ]
            );
        }

        // masukin data scaffolding risk control master 
        $scaffoldingRiskControl_master_datas  = [
            "Bracing tidak bengkok / retak / karat",
            "Kondisi frame tidak bengkok / retak / karat",
            "Kondisi Cat Walk atau Plank tidak bengkok / retak / karat",
            "Kondisi join pin tidak bengkok / retak / karat",
            "Tidak terdapat material / cairan di dekat tempat penyimpanan yang berpotensi mengakibatkan karat pada frame / bagian lain",
            "Penyimpanan scaffolding tidak terpapar langsung dengan hujan / panas secara terus menerus",
            "Tumpukan frame / bagian lain saat disimpan tidak mengakibatkan kerusakan / perubahaan bentuk",
            "Bracing terpasang pada frame",
            "Koneksi bracing dengan frame dalam kondisi aman / terkunci",
            "Semua bagian frame terkunci seluruhnya dengan join pin",
            "Cat Walk / Plank terpasang pada frame",
            "Scaffolding didirikan oleh petugas yang berkompeten",
            "Minimal 2 tumpuk frame harus menggunakan railing atau pekerja menggunakan Safety body harness",
            "Pada saat bekerja harus menggunakan barikade, untuk mencegah orang melewati kolong frame",
            "Frame harus terikat di srtuktur yang kuat",
            "Kaki frame tidak boleh berada pada struktur yang tidak stabil / lembek / mudah patah / pecah"
        ];
        foreach ($scaffoldingRiskControl_master_datas as $item) {
            scaffoldingRiskControl_master::create(
                [
                    'name' => $item
                ]
            );
        }


        // masukin data approver 
        $approver_datas  = ["HSE", "Engineering Manager", "PIC Location"];
        foreach ($approver_datas as $index => $item) {
            approver::create(
                [
                    'name' => $item,
                    'level' =>$index+1,
                    'role_id' =>$index+5,
                    'role_name' =>strtolower($item)
                ]
            );
        }
        
        
        // masukin data hse location 
        $approver_datas  = [
            ["All Plant SMII", "Suwanto"],
            ["Batch Refinery", "Dimas Supriyadi"],
            ["Coal Boiler", "Jimmy Ferdinand"],
            ["Compressor Frick P2 dan P3", "Djarot Hendrawan"],
            ["Compressor P1 dan Pastry", "Djarot Hendrawan"],
            ["Conveyor Palletizing", "Djarot Hendrawan"],
            ["Deodorizations", "Dimas Supriyadi"],
            ["Engineering Office", "Jimmy Ferdinand"],
            ["Engineering Workshop", "Jimmy Ferdinand"],
            ["Fat Blend Tanks", "Dimas Supriyadi"],
            ["Filling Room P1", "Djarot Hendrawan"],
            ["Hidrogen Torpedo", "Dimas Supriyadi"],
            ["Human Capital Office", "Syaiful Syahrizal"],
            ["Hydrant Pump House", "Billy Fernando"],
            ["Hydrogenation", "Dimas Supriyadi"],
            ["Kantin Karyawan", "Syaiful Syahrizal"],
            ["Klinik Karyawan", "Billy Fernando"],
            ["Koperasi Karyawan", "Syaiful Syahrizal"],
            ["Lantai 1 Office PA1", "Linda Rianty"],
            ["Lantai 2 Office PA1", "Putri Wulandari"],
            ["Lantai 3 Office PA1", "Danu Purboyo"],
            ["Liquid Line", "Djarot Hendrawan"],
            ["Manufacturing Office", "Dimas Supriyadi"],
            ["Meeting Room Finance", "Rainita Darmadi"],
            ["Meeting Room Grand", "Syaiful Syahrizal"],
            ["Meeting Room Mother Choice", "Putri Wulandari"],
            ["Mezzanine Utility", "Jimmy Ferdinand"],
            ["NWB", "Dimas Supriyadi"],
            ["Office Pulo Ayang 2", "Syaiful Syahrizal"],
            ["PABX Puloayang 1", "Jimmy Ferdinand"],
            ["Packing Room Mezzanine Pastry", "Djarot Hendrawan"],
            ["Packing Room P1", "Djarot Hendrawan"],
            ["Packing Room P1", "Djarot Hendrawan"],
            ["Packing Room P2", "Djarot Hendrawan"],
            ["Packing Room P2 dan P3", "Djarot Hendrawan"],
            ["Packing Room P3", "Djarot Hendrawan"],
            ["Panel Room P2 dan P3", "Andika Suhendar"],
            ["Parkir Mobil PA1", "Suwanto"],
            ["Parkir Motor PA1", "Suwanto"],
            ["Pastry Line", "Djarot Hendrawan"],
            ["Pompa Banjir PA1", "Suwanto"],
            ["Pompa Banjir PA2", "Suwanto"],
            ["Power House SMII 1", "Jimmy Ferdinand"],
            ["Power House SMII 2", "Jimmy Ferdinand"],
            ["QM Lab Lt. 1", "Edi Tri Maryanto"],
            ["QM Lab Lt. 2", "Edi Tri Maryanto"],
            ["R Maintenance Engineering lt 2", "Jimmy Ferdinand"],
            ["RnD Office", "Maria Muyarni"],
            ["Robotic Palletizer dan Conveyor", "Djarot Hendrawan"],
            ["Robotic Palletizing", "Djarot Hendrawan"],
            ["Security Post 3", "Suwanto"],
            ["Security Post 4", "Suwanto"],
            ["Security Post 5", "Suwanto"],
            ["Security Post 1", "Suwanto"],
            ["Security Post 2", "Suwanto"],
            ["Server Room PA1", "Andika Suhendar"],
            ["Server Room PA2", "Andika Suhendar"],
            ["STP", "Billy Fernando"],
            ["Supply Chain Ground Office", "Sangudin"],
            ["Supply Chain Sky Office", "Sangudin"],
            ["Tank Yard 1T", "Sangudin"],
            ["Tank Yard 40T", "Sangudin"],
            ["Test Bakery", "Reginald Iskandar"],
            ["TPS Limbah B3", "Billy Fernando"],
            ["TPS Non B3", "Billy Fernando"],
            ["Warehouse Cool Room 16", "Sangudin"],
            ["Warehouse Cool Room 25", "Sangudin"],
            ["Warehouse G01", "Sangudin"],
            ["Warehouse G02", "Sangudin"],
            ["Warehouse G03", "Sangudin"],
            ["Warehouse Packaging", "Suwanto"],
            ["Warehouse Sparepart", "Sangudin"],
            ["Weigh Blend Tanks", "Dimas Supriyadi"],
            ["Weighbridge Office", "Muchammad Arif Fathoni"],
            ["WWTP Biological", "Billy Fernando"],
            ["WWTP Physical", "Billy Fernando"]            
        ];
        foreach ($approver_datas as $item) {
            $nik = User::where('name', $item[1])
            ->pluck("nik")
            ->first();
            hseLocation::create(
                [
                    'name' => $item[0],
                    'pic' =>$item[1],
                    'nik' =>$nik
                ]
            );
        }
        
    }

}
