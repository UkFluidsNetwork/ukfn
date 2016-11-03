<?php
use Illuminate\Database\Migrations\Migration;

class AlterTagsCategory extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tags', function ($table) {
            $table->string('category', 255)->nullable()->after('tagtype_id');
        });
        // populate techniques
        DB::table('tags')->insert(
            [
                [
                    'name' => 'Analytical',
                    'tagtype_id' => 3,
                    'category' => '',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Numerical',
                    'tagtype_id' => 3,
                    'category' => null,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Experimental',
                    'tagtype_id' => 3,
                    'category' => null,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ]
        ]);
        // populate applications
        DB::table('tags')->insert(
            [
                [
                    'name' => 'Culture',
                    'tagtype_id' => 2,
                    'category' => 'Bio-medical',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Delivery',
                    'tagtype_id' => 2,
                    'category' => 'Bio-medical',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Diagnosis',
                    'tagtype_id' => 2,
                    'category' => 'Bio-medical',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Health impacts',
                    'tagtype_id' => 2,
                    'category' => 'Bio-medical',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Treatment',
                    'tagtype_id' => 2,
                    'category' => 'Bio-medical',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Biofuels',
                    'tagtype_id' => 2,
                    'category' => 'Energy',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Fossil fuels',
                    'tagtype_id' => 2,
                    'category' => 'Energy',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Hydrogen',
                    'tagtype_id' => 2,
                    'category' => 'Energy',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Nuclear',
                    'tagtype_id' => 2,
                    'category' => 'Energy',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Renewables',
                    'tagtype_id' => 2,
                    'category' => 'Energy',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Built environment',
                    'tagtype_id' => 2,
                    'category' => 'Environment',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Carbon capture & sequestration',
                    'tagtype_id' => 2,
                    'category' => 'Environment',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Hazards & safety',
                    'tagtype_id' => 2,
                    'category' => 'Environment',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Noise & vibration',
                    'tagtype_id' => 2,
                    'category' => 'Environment',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Pollution',
                    'tagtype_id' => 2,
                    'category' => 'Environment',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Sensors',
                    'tagtype_id' => 2,
                    'category' => 'Environment',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Waste',
                    'tagtype_id' => 2,
                    'category' => 'Environment',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Chemicals & materials',
                    'tagtype_id' => 2,
                    'category' => 'Manufacturing',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Food & drink',
                    'tagtype_id' => 2,
                    'category' => 'Manufacturing',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Hi-tech',
                    'tagtype_id' => 2,
                    'category' => 'Manufacturing',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Pharmaceutical',
                    'tagtype_id' => 2,
                    'category' => 'Manufacturing',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Metals',
                    'tagtype_id' => 2,
                    'category' => 'Manufacturing',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Astrophysical',
                    'tagtype_id' => 2,
                    'category' => 'Natural world',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Climate change',
                    'tagtype_id' => 2,
                    'category' => 'Natural world',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Coastal',
                    'tagtype_id' => 2,
                    'category' => 'Natural world',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Cryosphere',
                    'tagtype_id' => 2,
                    'category' => 'Natural world',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Geological',
                    'tagtype_id' => 2,
                    'category' => 'Natural world',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Mass movement',
                    'tagtype_id' => 2,
                    'category' => 'Natural world',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Oceans',
                    'tagtype_id' => 2,
                    'category' => 'Natural world',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Rivers & estuaries',
                    'tagtype_id' => 2,
                    'category' => 'Natural world',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Space weather',
                    'tagtype_id' => 2,
                    'category' => 'Natural world',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Weather & climate',
                    'tagtype_id' => 2,
                    'category' => 'Natural world',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Drying',
                    'tagtype_id' => 2,
                    'category' => 'Processing',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Fouling & cleaning',
                    'tagtype_id' => 2,
                    'category' => 'Processing',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Automotive',
                    'tagtype_id' => 2,
                    'category' => 'Transport',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Aviation',
                    'tagtype_id' => 2,
                    'category' => 'Transport',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Marine',
                    'tagtype_id' => 2,
                    'category' => 'Transport',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Rail',
                    'tagtype_id' => 2,
                    'category' => 'Transport',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Space',
                    'tagtype_id' => 2,
                    'category' => 'Transport',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'moderated' => date("Y-m-d H:i:s")
                ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tags', function ($table) {
            $table->dropColumn('category');
        });
    }
}
