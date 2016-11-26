<?php
use Illuminate\Database\Migrations\Migration;

class PopulateSig extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('sigs')->insert(
            [
                ['name' => "Aeroacoustics", 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
                ['name' => "Biologically active fluids", 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
                ['name' => "Boundary layers in complex rotating systems", 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
                ['name' => "Challenges in cardiovascular flow modelling", 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
                ['name' => "Drop dynamics", 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
                ['name' => "Droplet and flow interactions with bio-inspired and smart surfaces", 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
                ['name' => "Experimental flow diagnostics (xFD)", 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
                ['name' => "Flow instability, modelling and control", 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
                ['name' => "Fluid dynamics of liquid crystalline materials", 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
                ['name' => "Fluid mechanics of cleaning and decontamination", 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
                ['name' => "Fluid mechanics of the eye", 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
                ['name' => "Granular flows in the environment and industry", 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
                ['name' => "Low-energy ventilation", 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
                ['name' => "Marine hydrodynamics", 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
                ['name' => "Multicore and Manycore Algorithms to Tackle Turbulent flows (MUMATUR)", 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
                ['name' => "Multiphase flows and transport phenomena", 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
                ['name' => "Multi-scale and non-continuum flows", 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
                ['name' => "Multi-scale processes in geophysical fluid dynamics", 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
                ['name' => "Next generation time-stepping strategies for computer simulations of multi-scale fluid flows ", 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
                ['name' => "Non-Newtonian fluid mechanics", 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
                ['name' => "Particulate matter filtration flows in automotive and marine applications", 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
                ['name' => "Turbulent free shear flows", 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
                ['name' => "Turbulent skin-friction drag reduction", 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
                ['name' => "Urban fluid mechanics", 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
                ['name' => "User's forum for National Wind Tunnel Facility", 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
                ['name' => "Wave-structure interaction", 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")]
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
